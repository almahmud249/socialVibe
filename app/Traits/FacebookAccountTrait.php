<?php

namespace App\Traits;

use App\Models\SocialAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

trait FacebookAccountTrait
{
    private $base_url = 'https://graph.facebook.com/';

    public function facebookAuthUrl(): string
    {
        $scopes        = [
            'pages_manage_posts',
            'pages_show_list',
            'pages_read_user_content',
            'pages_read_engagement',
            'read_insights',
        ];
        $graph_version = setting('facebook_app_version');
        $base_url      = "https://www.facebook.com/$graph_version/dialog/oauth?";
        $params        = [
            'client_id'     => setting('facebook_client_id'),
            'redirect_uri'  => route('client.accounts.callback', ['plat_form' => 'facebook']),
            'scope'         => implode(',', $scopes),
            'response_type' => 'code',
        ];

        return $base_url.http_build_query($params);
    }

    public function fbAccessToken($code)
    {
        $graph_version = setting('facebook_app_version');
        $url           = $this->base_url."$graph_version/oauth/access_token";
        $params        = [
            'client_id'     => setting('facebook_client_id'),
            'client_secret' => setting('facebook_client_secret'),
            'redirect_uri'  => route('client.accounts.callback', ['plat_form' => 'facebook']),
            'code'          => $code,
        ];

        return httpRequest($url, $params);
    }

    public function fbPages($access_token)
    {
        $fields        = 'id,name,username,picture,access_token';
        $graph_version = setting('facebook_app_version');
        $url           = $this->base_url."$graph_version/me/accounts?fields=$fields&access_token=$access_token";
     
        return Http::get($url)->json();
    }

    public function saveFbPages($pages): bool
    {
        $page_data = $pages['data'];
        $data      = [];
        $now       = now();
      
        foreach ($page_data as $page) {
            SocialAccount::where('account_id', $page['id'])->delete();
            $data[] = [
                'uid'                 => Str::uuid(),
                'platform_id'         => $page['id'],
                'subscription_id'     => optional(auth()->user()->activeSubscription)->id,
                'user_id'             => auth()->id(),
                'admin_id'            => auth()->id(),
                'account_id'          => $page['id'],
                'name'                => $page['name'],
                'account_information' => json_encode($page),
                'status'              => 1,
                'is_official'         => 1,
                'is_connected'        => 1,
                'account_type'        => 1,
                'details'             => 'facebook',
                'token'               => $page['access_token'],
                'image'               => $page['picture']['data']['url'],
                'created_at'          => $now,
                'updated_at'          => $now,
            ];
        }
        if (count($data) > 0) {
            DB::table('social_accounts')->insert($data);
        }

        return true;
    }

    public function uploadMedia($filePath, $token, $page_id, $caption = '')
    {
        $graph_version = setting('facebook_app_version');
        $upload_url = $this->base_url . $graph_version . '/' . $page_id . '/photos';

        $is_remote = Str::startsWith($filePath, ['http://', 'https://']);
        $multipart = $is_remote
            ? ['url' => $filePath]
            : ['source' => fopen(public_path($filePath), 'r')];

        $multipart['published'] = false;
        if (!empty($caption)) {
            $multipart['caption'] = $caption;
        }

        $response = Http::withToken($token)
            ->attach(
                isset($multipart['source']) ? 'source' : 'url',
                $is_remote ? $multipart['url'] : $multipart['source'],
                basename($filePath)
            )
            ->post($upload_url, [
                'published' => false,
                'caption' => $caption,
            ]);

        return $response->json();
    }


    public function handlePost($account, $post, $has_video): array
    {
        $post_type = $post->post_type;

        if ($post_type == 1) {

        } else {
            $response = $this->feed($account, $post, $has_video);
            if (arrayCheck('id', $response)) {
                $post_id = $response['id'];
                $url     = 'https://fb.com/'.$post_id;
                $message = 'post created';
                $status  = true;
            } else {
                $url     = '';
                $message = $response['error']['message'];
                $status  = false;
            }
        }

        return [
            'status'  => $status,
            'message' => $message,
            'url'     => $url,
        ];
    }

    public function feed($account, $post, $has_video)
    {
        $token     = $account->token;
        $page_id   = $account->account_id;
        $graph_version = setting('facebook_app_version');
        $api_url   = $this->base_url . $graph_version . '/' . $page_id . '/feed';

        $post_data = [];

        if ($post->content) {
            $post_data['message'] = $post->content;
        }

        if ($post->link && $this->isValidUrl($post->link)) {
            $post_data['link'] = $post->link;
        }

        $mediaFiles = [];
        if (is_array($post->images) && !empty($post->images)) {
            foreach ($post->images as $file) {
                $uploadResponse = $this->uploadMedia($file, $token, $page_id, $post->content);
                if (isset($uploadResponse['id'])) {
                    $mediaFiles[] = ['media_fbid' => $uploadResponse['id']];
                }
            }
        }

        if (!empty($mediaFiles)) {
            $post_data['attached_media'] = $mediaFiles;
        }

        $response = Http::retry(3, 3000)
            ->withToken($token)
            ->post($api_url, $post_data);

        return $response->json();
    }
  
    private function isValidUrl($url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
  
}
