<?php

namespace App\Traits;

use App\Models\SocialAccount;
use CURLFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

trait TwitterAccountTrait
{
    private $twitter_base_url = 'https://api.x.com/2';

    public function twitterAuthUrl(): string
    {
        $scopes   = 'tweet.read tweet.write users.read offline.access';
        $base_url = 'https://x.com/i/oauth2/authorize?';
        $params   = [
            'client_id'             => setting('x_client_id'),
            'redirect_uri'          => route('client.accounts.callback', ['plat_form' => 'twitter']),
            'scope'                 => $scopes,
            'response_type'         => 'code',
            'state'                 => Str::random(10),
            'code_challenge'        => 'challenge',
            'code_challenge_method' => 'plain',
        ];

        return $base_url.http_build_query($params);
    }

    public function twitterAccessToken($code)
    {
        $url         = $this->twitter_base_url.'/oauth2/token?';
        $params      = [
            'code'          => $code,
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => route('client.accounts.callback', ['plat_form' => 'twitter']),
            'code_verifier' => 'challenge',
        ];
        $credentials = base64_encode(setting('x_client_id').':'.setting('x_client_secret'));

        return Http::withHeaders([
            'Authorization' => "Basic $credentials",
            'Content-Type'  => 'application/x-www-form-urlencoded',
        ])->post($url.http_build_query($params))->json();
    }

    public function twitterProfile($access_token)
    {
        return Http::withToken($access_token)->get($this->twitter_base_url.'/users/me?user.fields=id,name,profile_image_url')->json();
    }

    public function saveTwitterProfile($profile): bool
    {
        $now  = now();
        SocialAccount::where('account_id', $profile['data']['id'])->delete();
        $data = [
            'uid'                 => Str::uuid(),
            'platform_id'         => $profile['data']['id'],
            'subscription_id'     => optional(auth()->user()->activeSubscription)->id,
            'user_id'             => auth()->id(),
            'admin_id'            => auth()->id(),
            'account_id'          => $profile['data']['id'],
            'name'                => $profile['data']['name'],
            'account_information' => json_encode($profile['data']),
            'status'              => 1,
            'is_official'         => 1,
            'is_connected'        => 1,
            'account_type'        => 1,
            'details'             => 'twitter',
            'token'               => $profile['access_token'],
            'image'               => $profile['data']['profile_image_url'],
            'created_at'          => $now,
            'updated_at'          => $now,
        ];
        DB::table('social_accounts')->insert($data);

        return true;
    }

    public function twitterFeed($account, $post)
    {
        $token        = $account->token;
        $tweet_feed   = '';
        if ($post->content) {
            $tweet_feed .= $post->content;
        }
        if ($post->link) {
            $tweet_feed .= $post->link;
        }

        $api_url      = $this->twitter_base_url.'/tweets';
        if (! empty($postData['link'])) {
            $data['text'] = $post->content.' '.$postData['link'];
        } else {
            $data['text'] = $post->content;
        }
        if ($post->images && count($post->images) > 0) {
            $medias_ids = $this->uploadMediaGetIds($post->images);
            if (! empty($medias_ids) && ! $post->link) {
                $data['media'] = ['media_ids' => $medias_ids];
                //				$data['media_category'] = 'tweet_video';
            }
        }
        $response     = Http::withToken($token)
            ->post($api_url, $data);

        $responseJson = $response->json();

        if (isset($responseJson['data']['id'])) {
            return [
                'status'   => true,
                'response' => __('Posted Successfully'),
                'url'      => 'https://x.com/tweet/status/'.$responseJson['data']['id'],
            ];
        }

        return [
            'status'   => false,
            'response' => @$responseJson['detail'] ?? 'Unauthorized',
        ];
    }

    private function uploadMediaGetIds($medias): array
    {
        $ids = [];
        foreach ($medias as $media) {
            $ids[] = $this->uploadMediaToTwitter($media);
        }

        return $ids;
    }

    public function uploadMediaToTwitter($media)
    {
        // Twitter API credentials
        $apiKey            = setting('x_api_key');
        $apiSecret         = setting('x_secret_key');
        $accessToken       = setting('x_access_token');
        $accessTokenSecret = setting('x_access_token_secret');

        // Twitter media upload URL
        $uploadUrl = 'https://upload.twitter.com/1.1/media/upload.json';

        // Step 1: Get the absolute media path
        $mediaPath = $this->resolveMediaPath($media);

        if (!file_exists($mediaPath)) {
            throw new \Exception("Media file not found: {$mediaPath}");
        }

        // Step 2: Detect MIME type and file size
        $mimeType = mime_content_type($mediaPath);
        $fileSize = filesize($mediaPath);
        $isVideo  = str_contains($mimeType, 'video');

        // Step 3: Handle small images and videos (direct upload)
        if (!$isVideo || $fileSize < 4 * 1024 * 1024) {
            $params = [
                'media'          => new \CURLFile($mediaPath),
                'media_category' => $isVideo ? 'tweet_video' : 'tweet_image',
                'media_type'     => $mimeType,
            ];

            $response = $this->makeTwitterRequest($uploadUrl, $params, $apiKey, $apiSecret, $accessToken, $accessTokenSecret);

            return $response['media_id_string'] ?? null;
        }

        // Step 4: Handle large video uploads (chunked upload)
        $initParams = [
            'command'        => 'INIT',
            'total_bytes'    => $fileSize,
            'media_type'     => $mimeType,
            'media_category' => 'tweet_video',
        ];

        $initResponse = $this->makeTwitterRequest($uploadUrl, $initParams, $apiKey, $apiSecret, $accessToken, $accessTokenSecret);
        $mediaId = $initResponse['media_id_string'] ?? null;

        if (!$mediaId) {
            return null;
        }

        $chunkSize = 4 * 1024 * 1024; // 4MB
        $file = fopen($mediaPath, 'rb');
        $segmentIndex = 0;

        while (!feof($file)) {
            $chunk = fread($file, $chunkSize);
            $tmpChunk = tempnam(sys_get_temp_dir(), 'tw_chunk');
            file_put_contents($tmpChunk, $chunk);

            $appendParams = [
                'command'       => 'APPEND',
                'media_id'      => $mediaId,
                'segment_index' => $segmentIndex,
                'media'         => new \CURLFile($tmpChunk),
            ];

            $this->makeTwitterRequest($uploadUrl, $appendParams, $apiKey, $apiSecret, $accessToken, $accessTokenSecret);
            unlink($tmpChunk);
            $segmentIndex++;
        }

        fclose($file);

        $finalizeParams = [
            'command'  => 'FINALIZE',
            'media_id' => $mediaId,
        ];

        $this->makeTwitterRequest($uploadUrl, $finalizeParams, $apiKey, $apiSecret, $accessToken, $accessTokenSecret);

        return $mediaId;
    }
  
      protected function resolveMediaPath($media)
    {
        // If it's a full URL, download and return local temp path
        if (filter_var($media, FILTER_VALIDATE_URL)) {
            $tmp = tempnam(sys_get_temp_dir(), 'tw_media');
            $data = @file_get_contents($media);
            if (!$data) {
                throw new \Exception("Failed to download media from URL: {$media}");
            }
            file_put_contents($tmp, $data);
            return $tmp;
        }

        // Otherwise treat it as a path inside /public
        $path = public_path($media);
        if (!file_exists($path)) {
            throw new \Exception("Local media file not found: {$path}");
        }

        return $path;
    }

    // Helper function for Twitter API requests
    public function makeTwitterRequest($url, $params, $apiKey, $apiSecret, $accessToken, $accessTokenSecret)
    {
        $oauthHeader = $this->generateOauthHeader($apiKey, $apiSecret, $accessToken, $accessTokenSecret, $url);

        $ch          = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: '.$oauthHeader]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response    = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    private function generateOauthHeader($consumerKey, $consumerSecret, $apiToken, $apiSecret, $url): string
    {
        $oauthNonce         = base64_encode(openssl_random_pseudo_bytes(32));
        $oauthTimestamp     = time();
        $oauthSignatureKey  = rawurlencode($consumerSecret).'&'.rawurlencode($apiSecret);

        $oauthSignatureData = [
            'oauth_consumer_key'     => $consumerKey,
            'oauth_nonce'            => $oauthNonce,
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp'        => $oauthTimestamp,
            'oauth_token'            => $apiToken,
            'oauth_version'          => '1.0',
        ];

        $baseString         = 'POST&'.rawurlencode($url).'&'.rawurlencode(http_build_query($oauthSignatureData));
        $oauthSignature     = base64_encode(hash_hmac('sha1', $baseString, $oauthSignatureKey, true));

        // Step 2: Compose the OAuth header
        $oauthHeader        = [
            'oauth_consumer_key="'.rawurlencode($consumerKey).'"',
            'oauth_nonce="'.rawurlencode($oauthNonce).'"',
            'oauth_signature="'.rawurlencode($oauthSignature).'"',
            'oauth_signature_method="HMAC-SHA1"',
            'oauth_timestamp="'.rawurlencode($oauthTimestamp).'"',
            'oauth_token="'.rawurlencode($apiToken).'"',
            'oauth_version="1.0"',
        ];

        return 'OAuth '.implode(', ', $oauthHeader);
    }
}
