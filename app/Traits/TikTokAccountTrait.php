<?php

namespace App\Traits;

use App\Models\SocialAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait TikTokAccountTrait 
{
    use ImageTrait;

    private $tiktok_base_url = 'https://open.tiktokapis.com/v2/';

    public function tiktokAuthUrl(): string
    {
        $scopes   = ['user.info.basic', 'video.upload', 'video.publish'];
        $base_url = 'https://www.tiktok.com/v2/auth/authorize';

        $params   = [
            'client_key'        => setting('tiktok_client_id'),
            'scope'             => implode(',', $scopes),
            'redirect_uri'      => route('client.accounts.callback', ['plat_form' => 'tiktok']),
            'state'             => Str::random(10),
            'response_type'     => 'code',
            'disable_auto_auth' => 1,
        ];

        return $base_url.'?'.http_build_query($params);
    }

    public function tiktokAccessToken($code)
    {
        $url    = $this->tiktok_base_url.'oauth/token/';

        $params = [
            'client_key'    => setting('tiktok_client_id'),
            'client_secret' => setting('tiktok_client_secret'),
            'code'          => $code,
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => route('client.accounts.callback', ['plat_form' => 'tiktok']),
        ];

        return Http::asForm()->post($url, $params)->json();
    }

    public function tiktokUserProfile($access_token)
    {
        $url = $this->tiktok_base_url.'user/info/';

        return Http::withToken($access_token)
            ->get($url, ['fields' => 'avatar_url,display_name'])
            ->json();
    }

    public function saveTikTokProfile($userData): bool
    {
        $user_info = $userData['data']['user'];
        $now       = now();

        SocialAccount::where('account_id', $userData['open_id'])->delete();

        $data      = [
            'uid'                     => Str::uuid(),
            'platform_id'             => $userData['open_id'],
            'subscription_id'         => auth()->user()->activeSubscription->id,
            'user_id'                 => auth()->id(),
            'admin_id'                => auth()->id(),
            'account_id'              => $userData['open_id'],
            'name'                    => $user_info['display_name'],
            'account_information'     => json_encode($user_info),
            'status'                  => 1,
            'is_official'             => 1,
            'is_connected'            => 1,
            'account_type'            => 2,
            'details'                 => 'tiktok',
            'token'                   => $userData['access_token'],
            'access_token_expire_at'  => $userData['expires_in'],
            'refresh_token'           => $userData['refresh_token'],
            'refresh_token_expire_at' => $userData['refresh_expires_in'],
            'image'                   => json_encode($this->getContentOfImage($user_info['avatar_url'])),
            'created_at'              => $now,
            'updated_at'              => $now,
        ];

        DB::table('social_accounts')->insert($data);

        return true;
    }

    // protected function getContentOfImage($url)
    // {
    //     try {
    //         $contents = file_get_contents($url);

    //         if ($contents === false) {
    //             throw new \Exception("Unable to fetch image from URL");
    //         }

    //         $base64 = base64_encode($contents);
    //         $mime   = mime_content_type($url);

    //         return [
    //             'mime' => $mime,
    //             'data' => $base64,
    //         ];
    //     } catch (\Exception $e) {
    //         // Log error and return null or a default image
    //         Log::error('Image fetch failed: ' . $e->getMessage());
    //         return null;
    //     }
    // }

    private function mediaResponse($images, $access_token, $post)
    {
        $headers      = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer '.$access_token,
        ];
        $data         = [
            'test' => 12,
        ];
        $creator_info = Http::withHeaders($headers)->post($this->tiktok_base_url.'post/publish/creator_info/query/', $data)->json();

        $data         = [
            'post_info'   => [
                'title'           => $post->title,
                'description'     => $post->content,
                'disable_comment' => true,
                'privacy_level'   => config('app.env') == 'local' ? $creator_info['data']['privacy_level_options'][2] : $creator_info['data']['privacy_level_options'][0],
                'auto_add_music'  => true,
            ],
            'source_info' => [
                'source' => 'PULL_FROM_URL',
            ],
        ];
        $is_video     = isValidVideoUrl($images[0]);
        if ($is_video) {
            $data['source_info']['video_url'] = static_asset($images[0]);
        } else {
            $data['source_info']['photo_cover_index'] = count($images) > 1 ? 1 : 0;
            foreach ($images as $image) {
                $data['source_info']['photo_images'][] = static_asset($image);
            }
            $data['post_mode']                        = 'DIRECT_POST';
            $data['media_type']                       = 'PHOTO';
        }
        $content      = $is_video ? 'video' : 'content';

        return Http::withHeaders($headers)->post($this->tiktok_base_url."post/publish/$content/init/", $data)->json();
    }

    public function handleTikTokPost($account, $post): array
    {
        try {
            $access_token = $account->token;
            $images       = $post->images;
            $response     = $this->mediaResponse($images, $access_token, $post);
            $video_id     = $response['data']['publish_id'];

            return [
                'status'  => true,
                'message' => 'TikTok post published successfully!',
                'url'     => 'https://www.tiktok.com/@'.$account->name.'/video/'.$video_id,
            ];
        } catch (\Exception $e) {
            return [
                'status'  => false,
                'message' => $e->getMessage(),
                'url'     => '',
            ];
        }
    }
}
