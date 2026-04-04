<?php

namespace App\Traits;

use App\Models\SocialAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait ThreadsAccountTrait
{
    use ImageTrait;

    private $threads_base_url = 'https://graph.threads.net/';

    public function threadsAuthUrl(): string
    {
        $scopes   = ['threads_basic', 'threads_content_publish', 'threads_manage_insights'];
        $base_url = 'https://threads.net/oauth/authorize';

        $params   = [
            'client_id'     => setting('threads_client_id'),
            'redirect_uri'  => route('client.accounts.callback', ['plat_form' => 'threads']),
            'scope'         => implode(',', $scopes),
            'response_type' => 'code',
        ];

        return $base_url.'?'.http_build_query($params);
    }

    public function threadsAccessToken($code)
    {
        $url                       = $this->threads_base_url.'oauth/access_token';

        $params                    = [
            'client_id'     => setting('threads_client_id'),
            'client_secret' => setting('threads_client_secret'),
            'code'          => $code,
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => route('client.accounts.callback', ['plat_form' => 'threads']),
        ];

        $response                  = Http::post($url, $params)->json();

        $params                    = [
            'client_secret' => setting('threads_client_secret'),
            'grant_type'    => 'th_exchange_token',
            'access_token'  => $response['access_token'],
        ];

        $final_response            = Http::get($this->threads_base_url.'/access_token', $params)->json();
        $final_response['user_id'] = $response['user_id'];

        return $final_response;
    }

    public function threadsUserProfile($access_token)
    {
        $url = $this->threads_base_url.'v1.0/me';

        return Http::withToken($access_token)
            ->get($url, ['fields' => 'id,name,threads_profile_picture_url'])
            ->json();
    }

    public function saveThreadsProfile($userData): bool
    {
        $now  = now();

        SocialAccount::where('account_id', $userData['id'])->delete();

        $data = [
            'uid'                    => Str::uuid(),
            'platform_id'            => $userData['id'],
            'subscription_id'        => optional(auth()->user()->activeSubscription)->id,
            'user_id'                => auth()->id(),
            'admin_id'               => auth()->id(),
            'account_id'             => $userData['id'],
            'name'                   => $userData['name'],
            'account_information'    => json_encode($userData),
            'status'                 => 1,
            'is_official'            => 1,
            'is_connected'           => 1,
            'account_type'           => 2,
            'details'                => 'threads',
            'token'                  => $userData['access_token'],
            'access_token_expire_at' => $userData['expires_in'],
            'image'                  => json_encode($this->getContentOfImage($userData['threads_profile_picture_url'])),
            'created_at'             => $now,
            'updated_at'             => $now,
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

    public function uploadThreadsMedia($file_path, $access_token, $total_media, $text, $user_id)
    {
        $is_video = $this->isValidVideoUrl($file_path);
        $media_type = !$file_path ? 'TEXT' : ($is_video ? 'VIDEO' : 'IMAGE');

        $data = [
            'text'       => $text,
            'media_type' => $media_type,
        ];

        if ($file_path) {
            $data['is_carousel_item'] = $total_media > 1;
            if ($is_video) {
                $data['video_url'] = $file_path;
            } else {
                $data['image_url'] = $file_path;
            }
        }

        $url = "https://graph.threads.net/v1.0/{$user_id}/threads";

        $response = Http::withToken($access_token)
            ->post($url, $data)
            ->json();

        return $response;
    }



    public function createThreadsContainer(array $media_ids, $access_token, $text, $user_id)
    {
        if (count($media_ids) === 1) {
          
            $data = [
                'media_type' => 'IMAGE', 
                'text'       => $text,
                'image_url'  => null,
                'video_url'  => null,
            ];

            return ['id' => $media_ids[0]];
        }

        $data = [
            'media_type' => 'CAROUSEL',
            'text'       => $text,
            'children'   => $media_ids,
        ];

        $url = "https://graph.threads.net/v1.0/{$user_id}/threads";

        return Http::withToken($access_token)
            ->post($url, $data)
            ->json();
    }

    public function handleThreadsPost($account, $post)
    {
        try {
            $token   = $account->token;
            $user_id = $account->platform_id;

            $text = $post->content . ' ' . $post->link;
            $relativeImages = $post->images ?? [];
            $images = collect($relativeImages)->map(function ($path) {
                return url('public/' . ltrim($path, '/'));
            })->toArray();

            $media_container_ids = [];

            // If there are images, upload them first
            if (!empty($images)) {
                foreach ($images as $url) {
                    $response = $this->uploadThreadsMedia($url, $token, count($images), $text, $user_id);
                    if (!empty($response['id'])) {
                        $media_container_ids[] = $response['id'];
                    }
                }

                if (empty($media_container_ids)) {
                    return ['status' => false, 'message' => 'Media upload failed.', 'url' => ''];
                }

                // Wait for each media to finish processing
                foreach ($media_container_ids as $id) {
                    $processing = true;
                    while ($processing) {
                        $status = Http::withToken($token)
                            ->get("https://graph.threads.net/v1.0/{$id}?fields=status")
                            ->json();

                        if (($status['status'] ?? '') === 'FINISHED') {
                            $processing = false;
                        } else {
                            sleep(3);
                        }
                    }
                }

                // Create post container from uploaded media
                $post_container = $this->createThreadsContainer($media_container_ids, $token, $text, $user_id);
            } else {
                // Text-only post
                $post_container = Http::withToken($token)
                    ->post("https://graph.threads.net/v1.0/{$user_id}/threads", [
                        'text'       => $text,
                        'media_type' => 'TEXT',
                    ])
                    ->json();
            }

            if (empty($post_container['id'])) {
                return ['status' => false, 'message' => 'Post container creation failed.', 'url' => ''];
            }

            // Publish the post
            $publish = Http::withToken($token)
                ->post("https://graph.threads.net/v1.0/{$user_id}/threads_publish", [
                    'creation_id' => $post_container['id'],
                ])
                ->json();

            return [
                'status'  => true,
                'message' => 'Threads post published.',
                'url'     => 'https://www.threads.net/' . ($publish['id'] ?? ''),
            ];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage(), 'url' => ''];
        }
    }



  
    private function preparePublicUrl($imageUrl)
    {
        if ($this->isValidHttpsUrl($imageUrl)) {
            return $imageUrl; // Already public
        }

        $filename = 'thread_' . uniqid() . '.jpg';
        $uploadPath = public_path('uploads/' . $filename);
        file_put_contents($uploadPath, file_get_contents($imageUrl));

        return asset('uploads/' . $filename);
    }
  
    private function isValidHttpsUrl($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) && str_starts_with($url, 'https://');
    }
  
    private function isValidVideoUrl($url): bool
    {
        try {
            if (!$url) {
                return false;
            }

            $streamOpts = [
                'ssl' => [
                    'verify_peer'      => false,
                    'verify_peer_name' => false,
                ],
            ];

            $headers = @get_headers($url, 1, stream_context_create($streamOpts));
            if (!$headers || (!isset($headers['Content-Type']) && !isset($headers['content-type']))) {
                return false;
            }

            $contentType = $headers['Content-Type'] ?? $headers['content-type'];

            // Some servers return an array of content types
            if (is_array($contentType)) {
                $contentType = end($contentType);
            }

            $videoMimeTypes = [
                'video/mp4',
                'video/quicktime',
                'video/x-msvideo',
                'video/x-matroska',
                'video/webm',
            ];

            return in_array(strtolower($contentType), $videoMimeTypes);
        } catch (\Exception $e) {
            return false;
        }
    }

  
}
