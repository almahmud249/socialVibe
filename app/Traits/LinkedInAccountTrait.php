<?php

namespace App\Traits;

use App\Models\SocialAccount;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

trait LinkedInAccountTrait
{
    private $linkedin_base_url = 'https://api.linkedin.com/';

    public function headers(): array
    {
        return [
            'X-Restli-Protocol-Version' => '2.0.0',
            'LinkedIn-Version' => '202306',
            'Content-Type' => 'application/json',
        ];
    }

    public function linkedInAuthUrl(): string
    {
        $scopes = ['openid', 'profile', 'email', 'w_member_social', 'rw_organization_admin', 'w_organization_social'];
        $base_url = 'https://linkedin.com/oauth/v2/authorization?';
        $params = [
            'response_type' => 'code',
            'client_id' => setting('linkedin_client_id'),
            'redirect_uri' => route('client.accounts.callback', ['plat_form' => 'linkedin']),
            'state' => Str::random(),
            'scope' => implode(' ', $scopes),
        ];

        return $base_url . http_build_query($params);
    }

    public function linkedInAccessToken($code)
    {
        $url = $this->linkedin_base_url . 'oauth/v2/accessToken?';
        $params = [
            'client_id' => setting('linkedin_client_id'),
            'client_secret' => setting('linkedin_client_secret'),
            'redirect_uri' => route('client.accounts.callback', ['plat_form' => 'linkedin']),
            'code' => $code,
            'grant_type' => 'authorization_code',
        ];

        return Http::post($url . http_build_query($params))->json();
    }

    public function linkedInProfile($access_token)
    {
        return Http::withToken($access_token)->withHeaders($this->headers())->get($this->linkedin_base_url . 'v2/userinfo')->json();
    }

    public function savelinkedInProfile($profile): bool
    {
        $now = now();
        SocialAccount::where('account_id', $profile['sub'])->delete();
        $data = [
            'uid' => Str::uuid(),
            'platform_id' => $profile['id_token'],
            'subscription_id' => optional(auth()->user()->activeSubscription)->id,
            'user_id' => auth()->id(),
            'admin_id' => auth()->id(),
            'account_id' => $profile['sub'],
            'name' => $profile['name'] . ' - Profile',
            'account_information' => json_encode($profile),
            'status' => 1,
            'is_official' => 1,
            'is_connected' => 1,
            'account_type' => 0,
            'details' => 'linkedin',
            'token' => $profile['access_token'],
            'image' => $profile['picture'],
            'created_at' => $now,
            'updated_at' => $now,
        ];
        DB::table('social_accounts')->insert($data);

        return true;
    }


    public function linkedInPages(string $access_token): array
    {
        $url = $this->linkedin_base_url .
            'v2/organizationalEntityAcls' .
            '?q=roleAssignee' .
            '&role=ADMINISTRATOR' .
            '&state=APPROVED';

        return Http::withToken($access_token)
            ->withHeaders($this->headers())
            ->get($url)
            ->json();
    }

    public function saveLinkedInPages(array $pages, string $access_token): bool
    {
        $now = now();

        foreach ($pages['elements'] ?? [] as $page) {
            $orgUrn = $page['organizationalTarget'] ?? null;

            if (!$orgUrn || !Str::contains($orgUrn, 'organization:')) {
                continue;
            }

            $orgId = (int) last(explode(':', $orgUrn));
            $orgDetails = $this->getLinkedInOrganizationDetails($access_token, $orgId);

            SocialAccount::where('account_id', $orgId)->delete();

            DB::table('social_accounts')->insertOrIgnore([
                'uid' => Str::uuid(),
                'platform_id' => $orgUrn,
                'subscription_id' => optional(auth()->user()->activeSubscription)->id,
                'user_id' => auth()->id(),
                'admin_id' => auth()->id(),
                'account_id' => $orgId,
                'name' => $orgDetails['localizedName'] ?? 'LinkedIn Page',
                'account_information' => json_encode([
                    'basic' => $page,
                    'details' => $orgDetails,
                ]),
                'status' => 1,
                'is_official' => 1,
                'is_connected' => 1,
                'account_type' => 1,
                'details' => 'linkedin',
                'token' => $access_token,
                'image' => $orgDetails['logoV2']['original~']['elements'][0]['identifiers'][0]['identifier'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        return true;
    }

    public function getLinkedInOrganizationDetails(string $access_token, int $orgId): array
    {
        $url = $this->linkedin_base_url .
            "v2/organizations/{$orgId}?projection=(id,localizedName,vanityName,logoV2(original~:playableStreams))";

        $response = Http::withToken($access_token)
            ->withHeaders($this->headers())
            ->get($url);

        if ($response->successful()) {
            return $response->json();
        }

        logger()->error('Failed to fetch LinkedIn organization details', [
            'orgId' => $orgId,
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        return [];
    }


    private function apiClient($token)
    {
        return Http::withHeaders($this->headers())->withToken($token)->retry(1, 3000);
    }

    public function linkedInFeed($accounts, $post): array
    {
        $accountsToPost = is_array($accounts) ? $accounts : [$accounts];
        $results = [];

        foreach ($accountsToPost as $account) {
            $token = $account->token;
            $targetType = ((int) $account->account_type === 1) ? 'page' : 'profile';

            try {
                if ($targetType === 'page') {
                    // Fetch admin organization URNs where the token has admin rights
                    $orgUrn = $this->getFirstAdminOrganizationUrn($token);

                    if (!$orgUrn) {
                        $results[] = compact('targetType') + [
                            'status' => false,
                            'message' => 'No admin access to any LinkedIn Page for this token.',
                            'url' => null,
                        ];
                        continue;
                    }
                    $authorUrn = $orgUrn; // e.g. urn:li:organization:123456
                } else {
                    // Use person URN
                    $authorUrn = "urn:li:person:{$account->account_id}";
                }

                // Validate image file
                try {
                    $mediaPath = $this->resolveLinkedInMediaPath($post->images[0] ?? '');
                } catch (\Exception $e) {
                    $results[] = compact('targetType') + [
                        'status' => false,
                        'message' => $e->getMessage(),
                        'url' => null,
                    ];
                    continue;
                }

                // Register upload for the image asset
                $registerBody = [
                    'registerUploadRequest' => [
                        'recipes' => ['urn:li:digitalmediaRecipe:feedshare-image'],
                        'owner' => $authorUrn,
                        'serviceRelationships' => [
                            [
                                'relationshipType' => 'OWNER',
                                'identifier' => 'urn:li:userGeneratedContent',
                            ]
                        ],
                    ],
                ];

                $registerResponse = $this->apiClient($token)
                    ->post($this->linkedin_base_url . 'v2/assets?action=registerUpload', $registerBody)
                    ->json('value');

                $uploadUrl = $registerResponse['uploadMechanism']
                ['com.linkedin.digitalmedia.uploading.MediaUploadHttpRequest']
                ['uploadUrl'];
                $assetUrn = $registerResponse['asset'];

                // Upload image content
                $imageContent = file_get_contents($mediaPath);
                Http::withBody($imageContent, 'application/octet-stream')->put($uploadUrl);

                $text = trim("{$post->title}\n{$post->content}");
                if (empty($text)) {
                    Log::warning('LinkedIn post missing title and content', [
                        'title' => $post->title,
                        'content' => $post->content,
                    ]);
                }

                // Create the LinkedIn post
                $postBody = [
                    'author' => $authorUrn,
                    'lifecycleState' => 'PUBLISHED',
                    'specificContent' => [
                        'com.linkedin.ugc.ShareContent' => [
                            'shareCommentary' => ['text' => $text],
                            'shareMediaCategory' => 'IMAGE',
                            'media' => [
                                [
                                    'status' => 'READY',
                                    'description' => ['text' => $post->title],
                                    'media' => $assetUrn,
                                    'title' => ['text' => $post->title],
                                ]
                            ],
                        ],
                    ],
                    'visibility' => [
                        'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC',
                    ],
                ];

                $response = $this->apiClient($token)
                    ->post($this->linkedin_base_url . 'v2/ugcPosts', $postBody);


                if ($response->status() === 201) {
                    $post_id = urlencode($response->header('x-restli-id'));
                    return [
                        'status' => true,
                        'message' => 'Post Successful',
                        'url' => "https://www.linkedin.com/feed/update/{$post_id}",
                    ];
                } else {
                    $results[] = compact('targetType') + [
                        'status' => false,
                        'message' => $response->json()['message'] ?? 'Unknown error',
                        'url' => null,
                    ];
                }

            } catch (\Exception $e) {
                $results[] = compact('targetType') + [
                    'status' => false,
                    'message' => strip_tags($e->getMessage()),
                    'url' => null,
                ];
            }
        }

        return $results;
    }

    /**
     * Helper to get first organization URN where the token user is an admin.
     */
    private function getFirstAdminOrganizationUrn(string $token): ?string
    {
        $response = Http::withToken($token)
            ->get('https://api.linkedin.com/v2/organizationAcls', [
                'q' => 'roleAssignee',
                'role' => 'ADMINISTRATOR',
                'state' => 'APPROVED',
            ]);

        if (!$response->successful()) {
            return null;
        }

        $elements = $response->json('elements', []);
        if (empty($elements)) {
            return null;
        }

        return $elements[0]['organization'] ?? null;
    }


    protected function resolveLinkedInMediaPath($media)
    {
        if (filter_var($media, FILTER_VALIDATE_URL)) {
            $tmp = tempnam(sys_get_temp_dir(), 'li_media');
            $data = @file_get_contents($media);
            if (!$data) {
                throw new \Exception("Failed to download media from URL: {$media}");
            }
            file_put_contents($tmp, $data);
            return $tmp;
        }

        $path = public_path($media);
        if (!file_exists($path)) {
            // Check without public/ prefix if it already has it
            if (file_exists($media)) {
                return $media;
            }
            throw new \Exception("Local media file not found: {$path}");
        }

        return $path;
    }

    private function isValidLinkedInVideoUrl($url): bool
    {
        return Str::endsWith($url, ['.mp4', '.mov', '.webm']);
    }

    private function getRemoteFileInfo($url): array
    {
        return [
            'file_size' => @filesize(public_path(parse_url($url, PHP_URL_PATH))),
        ];
    }

    public function guzzleRequest()
    {
        return new Client(['http_errors' => false]);
    }

    private function initializeUpload($upload_type, $account_id, $token, $payload = [])
    {
        $body = [
            'initializeUploadRequest' => [
                'owner' => "urn:li:person:{$account_id}",
            ] + $payload,
        ];
        $response = $this->apiClient($token)->post($this->linkedin_base_url . 'rest/' . $upload_type . '?action=initializeUpload', $body)->json();

        return $response['value'];
    }

    private function startUpload($upload_url, $media, $api_key): ResponseInterface
    {
        $headers = $this->headers();
        $headers['Authorization'] = 'Bearer ' . $api_key;
        $headers['Content-Type'] = 'application/octet-stream';

        return $this->guzzleRequest()->request('PUT', $upload_url, [
            'headers' => $headers,
            'body' => file_get_contents($media),
        ]);
    }

    private function finalizeUpload($upload_type, $video_urn, $e_tag, $api_key)
    {
        $headers = $this->headers();
        $headers['Authorization'] = 'Bearer ' . $api_key;
        $body = [
            'finalizeUploadRequest' => [
                'video' => $video_urn,
                'uploadToken' => '',
                'uploadedPartIds' => $e_tag,
            ],
        ];

        return Http::withHeaders($headers)->post($this->linkedin_base_url . 'rest/' . $upload_type . '?action=finalizeUpload', $body);
    }

    public function uploadImage($account, $post_content): array
    {
        $uploadInfo = $this->initializeUpload('images', $account->account_id, $account->token);
        $uploadRes = $this->startUpload($uploadInfo['uploadUrl'], $post_content['media'], $account->token);

        if ($uploadRes->getStatusCode() === 201) {
            return [
                'altText' => '',
                'id' => $uploadInfo['image'],
            ];
        }

        return [];
    }

    public function uploadVideo($account, $post_content): array
    {
        $uploadInfo = $this->initializeUpload('videos', $account->account_id, $account->token, [
            'fileSizeBytes' => $post_content['file_size'],
            'uploadCaptions' => false,
            'uploadThumbnail' => false,
        ]);

        $uploadRes = $this->startUpload($uploadInfo['uploadInstructions'][0]['uploadUrl'], $post_content['media'], $account->token);
        $response = $this->finalizeUpload('videos', $uploadInfo['video'], $uploadRes->getHeader('ETag'), $account->token);

        if ($response->status() === 200) {
            return [
                'title' => '',
                'id' => $uploadInfo['video'],
            ];
        }

        return [];
    }

    public function getImageFromUrl($link): array
    {
        try {
            $metas = get_meta_tags($link);
            $title = $metas['twitter:title'] ?? $link;
            $description = $metas['description'] ?? $link;
            $linkImage = $metas['twitter:image'] ?? null;

            return [
                'title' => $title,
                'description' => $description,
                'linkImage' => $linkImage,
            ];
        } catch (\Exception $ex) {
            return [
                'title' => $link,
                'description' => $link,
                'linkImage' => null,
            ];
        }
    }
}
