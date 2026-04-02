<?php

namespace App\Traits;

use App\Models\SocialAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait InstagramAccountTrait
{
    public function instagramAuthUrl(): string
    {
        $scopes        = [
            'instagram_basic',
            'instagram_content_publish',
            'instagram_manage_insights',
            'pages_show_list',
        ];
        $graph_version = setting('instagram_app_version');
        $base_url      = "https://www.facebook.com/$graph_version/dialog/oauth?";
        $params        = [
            'client_id'     => setting('instagram_client_id'),
            'redirect_uri'  => route('client.accounts.callback', ['plat_form' => 'instagram']),
            'scope'         => implode(',', $scopes),
            'response_type' => 'code',
            'state'         => csrf_token(),
        ];

        return $base_url.http_build_query($params);
    }

    public function instagramAccessToken($code)
    {
        $graph_version = setting('instagram_app_version');
        $url           = "https://graph.facebook.com/$graph_version/oauth/access_token";
        $params        = [
            'client_id'     => setting('instagram_client_id'),
            'client_secret' => setting('instagram_client_secret'),
            'redirect_uri'  => route('client.accounts.callback', ['plat_form' => 'instagram']),
            'code'          => $code,
        ];

        return httpRequest($url, $params);
    }

    public function instagramPages($access_token)
    {
        $fields        = 'connected_instagram_account,name,access_token,picture,instagram_business_account,profile_picture_url';
        $graph_version = setting('instagram_app_version');
        $url           = "https://graph.facebook.com/$graph_version/me/accounts?fields=$fields&access_token=$access_token";

        return Http::get($url)->json();
    }

    public function saveinstagramPages($pages)
    {
        $page_data     = $pages['data'];
        $data          = [];
        $now           = now();
        $graph_version = setting('instagram_app_version');
        foreach ($page_data as $page) {
            if (! arrayCheck('connected_instagram_account', $page)) {
                continue;
            }
            $account_id   = $page['connected_instagram_account']['id'];
            SocialAccount::where('account_id', $account_id)->delete();
            $access_token = $page['access_token'];
            $url          = "https://graph.facebook.com/$graph_version/$account_id?fields=id,biography,has_profile_pic,name,ig_id,profile_picture_url,username&access_token=$access_token";
            $response     = Http::get($url)->json();
            $data[]       = [
                'uid'                 => Str::uuid(),
                'platform_id'         => $response['ig_id'],
                'subscription_id'     => auth()->user()->activeSubscription->id,
                'user_id'             => auth()->id(),
                'admin_id'            => auth()->id(),
                'account_id'          => $account_id,
                'name'                => $response['name'],
                'account_information' => json_encode($page),
                'status'              => 1,
                'is_official'         => 1,
                'is_connected'        => 1,
                'account_type'        => 1,
                'details'             => 'instagram',
                'token'               => $page['access_token'],
                'image'               => $response['has_profile_pic'] ? $response['profile_picture_url'] : '',
                'created_at'          => $now,
                'updated_at'          => $now,
            ];
        }
        if (count($data) > 0) {
            DB::table('social_accounts')->insert($data);
        }

        return true;
    }

    private function checkUploadStatus($token, $media_id): array
    {
        $status      = false;
        $attempted   = 0;
        $isFinished  = false;
        $maxAttempts = 10;

        while (true) {
            try {
                $videoStatus = Http::withToken($token)
                    ->retry(1, 3000)
                    ->get('https://graph.facebook.com/'.$media_id, ['fields' => 'status_code,status']);
            } catch (\Exception $e) {
                dd($e);
            }
            $status     = $videoStatus->json('status_code');
            $isFinished = in_array(strtolower($status), ['finished', 'ok', 'completed', 'ready']);

            if ($isFinished) {
                break;
            }

            $isError    = in_array(strtolower($status), ['error', 'failed']);
            if ($isError) {
                break;
            }

            sleep(5);
        }

        return [
            'is_ready'    => $isFinished,
            'status_code' => $status,
            'status'      => $videoStatus->json('status'),
        ];
    }

    public function instagramUploadMedia($file, $token, $ig_id, $content, $isVideo = false): mixed
    {
        $fileName  = basename($file); 

        $publicUrl = url('public/images/' . $fileName);

        Log::info('Instagram Upload URL', ['url' => $publicUrl]);

        $upload_params = [
            'caption'      => $content,
            'access_token' => $token,
        ];

        if ($isVideo) {
            $upload_params['media_type'] = 'VIDEO';
            $upload_params['video_url']  = $publicUrl;
        } else {
            $upload_params['media_type'] = 'IMAGE';
            $upload_params['image_url']  = $publicUrl;
        }

        $api_url = "https://graph.facebook.com/v22.0/$ig_id/media";
        $upload_response = Http::retry(3, 3000)
            ->asForm() // IMPORTANT: Instagram expects x-www-form-urlencoded
            ->post($api_url, $upload_params);

        Log::info('Instagram Upload Response', $upload_response->json());

        if ($upload_response->failed()) {
            Log::error('Instagram Media Upload Failed', ['response' => $upload_response->body()]);
        }

        return $upload_response->json();
    }





    public function instagramFeed($account, $post)
    {
        $token     = $account->token;
        $ig_id     = $account->account_id;
        $api_url   = "https://graph.facebook.com/v22.0/$ig_id/media";
        $media_ids = [];
        foreach ($post->images as $file) {
            $response = $this->instagramUploadMedia($file, $token, $ig_id, $post->content, false);
            if (isset($response['id'])) {
                $media_ids[] = $response['id'];
            }
        }
        if (count($media_ids) > 1) {
            $upload_params      = [
                'media_type' => 'CAROUSEL',
                'children'   => $media_ids,
                'caption'    => $post->content,
            ];
            $container_response = Http::withToken($token)->retry(3, 3000)->post($api_url, $upload_params)->json();
        } else {
            $container_response['id'] = $media_ids[0];
        }

        if (isset($container_response['id'])) {
            $this->checkUploadStatus($token, $container_response['id']);
            $publish_url      = "https://graph.facebook.com/v22.0/$ig_id/media_publish";
            $publish_response = Http::post($publish_url, [
                'creation_id'  => $container_response['id'],
                'access_token' => $token,
            ])->json();

            return $publish_response;
        }

        return $response;
    }

    public function instagramHandlePost($account, $post): array
    {
        $response = $this->instagramFeed($account, $post);

        if (isset($response['id'])) {
            return [
                'status'  => true,
                'message' => 'Post created successfully!',
                'url'     => 'https://www.instagram.com/p/'.$response['id'],
            ];
        }

        return [
            'status'  => false,
            'message' => $response['error']['message'] ?? 'Something went wrong!',
            'url'     => '',
        ];
    }
}