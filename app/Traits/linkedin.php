<?php

namespace App\Integrations;

use App\Enums\PlatformNameEnum;
use App\Enums\SocialAccountSourceTypeEnum;
use App\Enums\SocialNetworkTypeEnum;
use App\Interface\SocialIntegration;
use App\Models\MediaLibrary;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class LinkedinIntegration extends SocialIntegration
{
    private string $author;

    private string $visibility;

    private array $header;

    public Client $gazzle;

    public function __construct(private readonly array $config)
    {
        $this->gazzle = new Client(['http_errors' => false]);
        $this->header = [
            'LinkedIn-Version'          => $this->config['version'],
            'X-Restli-Protocol-Version' => $this->config['protocol'],
            'Content-Type'              => 'application/json',
        ];
    }

    private function initializeUpload($upload_type, $api_key, $payload = [])
    {
        $response = $this->gazzle->request('POST',
            $this->config['base_url'].'/'.$upload_type.'?action=initializeUpload&oauth2_access_token='.$api_key,
            [
                'headers' => [
                    'LinkedIn-Version'          => $this->config['version'],
                    'X-Restli-Protocol-Version' => $this->config['protocol'],
                ],
                'json'    => [
                    'initializeUploadRequest' => [
                        'owner' => $this->author,
                    ] + $payload,
                ],
            ]
        );

        $data     = json_decode($response->getBody()->getContents());

        return $data->value;
    }

    private function startUpload($upload_url, $media, $api_key)
    {
        $response = $this->gazzle->request('PUT', $upload_url, [
            'headers' => [
                'Authorization'             => 'Bearer '.$api_key,
                'LinkedIn-Version'          => $this->config['version'],
                'X-Restli-Protocol-Version' => $this->config['protocol'],
                'Content-Type'              => 'application/octet-stream',
            ],
            'body'    => filter_var($media, FILTER_VALIDATE_URL) ? file_get_contents($media) : Storage::get($media),
        ]);

        return $response;
    }

    private function finalizeUpload($upload_type, $video_urn, $e_tag, $api_key)
    {
        $response = $this->gazzle->request('POST', $this->config['base_url'].'/'.$upload_type.'?action=finalizeUpload',
            [
                'headers' => [
                    'Authorization'             => 'Bearer '.$api_key,
                    'LinkedIn-Version'          => $this->config['version'],
                    'X-Restli-Protocol-Version' => $this->config['protocol'],
                ],
                'json'    => [
                    'finalizeUploadRequest' => [
                        'video'           => $video_urn,
                        'uploadToken'     => '',
                        'uploadedPartIds' => $e_tag,
                    ],
                ],
            ]
        );

        return $response;
    }

    public function uploadImage($account, $post_content)
    {
        $uploadInfo = $this->initializeUpload('images', $account->api_key);
        $uploadRes  = $this->startUpload($uploadInfo->uploadUrl, $post_content['media'], $account->api_key);

        if ($uploadRes->getStatusCode() === 201) {
            return [
                'altText' => '',
                'id'      => $uploadInfo->image,
            ];
        }

        return [];
    }

    public function uploadVideo($account, $post_content)
    {
        $uploadInfo = $this->initializeUpload('videos', $account->api_key, [
            'fileSizeBytes'   => $post_content['file_size'],
            'uploadCaptions'  => false,
            'uploadThumbnail' => false,
        ]);

        $uploadRes  = $this->startUpload($uploadInfo->uploadInstructions[0]->uploadUrl, $post_content['media'], $account->api_key);
        $response   = $this->finalizeUpload('videos', $uploadInfo->video, $uploadRes->getHeader('ETag'), $account->api_key);

        if ($response->getStatusCode() === 200) {
            return [
                'media' => [
                    'title' => '',
                    'id'    => $uploadInfo->video,
                ],
            ];
        }

        return [];
    }

    public function feed($account, $content, int $try = 0): array
    {
        try {
            contentMediaSave($content);
            $content->load(['contentVariants' => function ($q) {
                $q->where('platform', PlatformNameEnum::Linkedin->value);
            }]);

            if (! $content->contentVariants->isEmpty()) {
                $variant = $content->contentVariants[0];
            }

            $mainContent   = $variant ?? $content;
            $postContent   = [
                'text'    => $mainContent->text,
                'comment' => $mainContent->comment,
                'link'    => $mainContent->link,
            ];

            $this->setAuthorAndVisibility($account->account_id, $account->type);

            $data          = [
                'author'                    => $this->author,
                'commentary'                => ! empty($postContent['link']) ? $this->removeFirstUrl($postContent['text']) : $postContent['text'],
                'visibility'                => $this->visibility,
                'distribution'              => $this->config['distribution'],
                'lifecycleState'            => $this->config['lifecycleState'],
                'isReshareDisabledByAuthor' => $this->config['isReshareDisabledByAuthor'],
            ];

            $media_library = MediaLibrary::whereIn('id', $mainContent->medias)->get();
            if (count($media_library) > 1) {
                foreach ($media_library as $media) {
                    $url                  = getMediaUrl($media->file);
                    $postContent          = $postContent + getRemoteFileInfo($url);
                    $postContent['media'] = $media->file;
                    if (getMediaType($media->file) == 'Image') {
                        $data['content']['multiImage']['images'][] = $this->uploadImage($account, $postContent);
                    }
                }
            } else {
                foreach ($media_library as $media) {
                    $url                  = getMediaUrl($media->file);
                    $postContent          = $postContent + getRemoteFileInfo($url);
                    $postContent['media'] = $media->file;
                    if (getMediaType($media->file) == 'Image') {
                        $data['content']['media'] = $this->uploadImage($account, $postContent);

                    } elseif (getMediaType($media->file) == 'Video') {
                        $data['content']['media'] = $this->uploadVideo($account, $postContent);

                    }
                }
            }

            if (! empty($postContent['link'])) {
                $metas                      = $this->getImageFromUrl($postContent['link']);
                $title                      = $metas['title']       ?? $postContent['link'];
                $description                = $metas['description'] ?? $postContent['link'];

                $data['content']['article'] = [
                    'source'      => $postContent['link'],
                    'title'       => $title,
                    'description' => $description,
                ];

                if (! empty($metas['linkImage'])) {
                    $mediaInfo                               = $this->uploadImage($account, ['media' => $metas['linkImage']]);
                    $data['content']['article']['thumbnail'] = $mediaInfo['media']['id'];
                }
            }

            $res           = $this->gazzle->request(
                'POST',
                $this->config['base_url'].'/posts?oauth2_access_token='.$account->api_key,
                [
                    'headers' => $this->header,
                    'json'    => $data,
                ]
            );

            if ($res->getStatusCode() == 201) {
                if (! empty($postContent['comment'])) {
                    $id         = urlencode($res->getHeader('x-restli-id')[0]);
                    $commentRes = $this->comment($id, $postContent['comment'], $account->api_key);
                }
                $post_id   = ! empty($res->getHeader('x-restli-id')[0]) ? urlencode($res->getHeader('x-restli-id')[0]) : null;
                $post_link = (bool) empty($post_id) ? "https://www.linkedin.com/feed/update/{$post_id}" : null;
                $send      = $this->createSendPostAttempt($content->id, $account->id, $this->getUserCurrentTime($account->user_id), 'success', urlencode($res->getHeader('x-restli-id')[0]) ?? null, $post_link, null, $commentRes['headers']['x-restli-id'][0] ?? null, $commentRes['error'] ?? null);

                if ($send->status === 'success') {
                    $insight     = $this->getPostInsights($send->post_id, $account->api_key);
                    $insightData = json_decode($insight['data'], true);
                    $send->socialPostInsight()->create([
                        'comment_count' => $insightData['commentsSummary']['aggregatedTotalComments'] ?? 0,
                        'like_count'    => $insightData['likesSummary']['totalLikes']                 ?? 0,
                    ]);
                }
            } else {
                $send = $this->createSendPostAttempt($content->id, $account->id, $this->getUserCurrentTime($account->user_id), 'failed', ! empty($res->getHeader('x-restli-id')[0]) ? urlencode($res->getHeader('x-restli-id')[0]) : null, null, json_decode($res->getBody()->getContents(), true)['message']);
            }

            $count         = $content->attempted_count + 1;
            $content->update([
                'attempted_count' => $count,
                'attempted_at'    => now(),
            ]);

            $logData       = ['post' => $res, 'comment' => $commentRes ?? []];
            $this->setLog(app()->runningInConsole() ? 'linkedin' : 'schedule_linkedin', $logData);
        } catch (Exception $ex) {
            $this->setLog(app()->runningInConsole() ? 'linkedin' : 'schedule_linkedin', ['error' => $ex->getMessage()]);
            $send = $this->createSendPostAttempt($content->id, $account->id, $this->getUserCurrentTime($account->user_id), 'failed', ! empty($res) ? urlencode($res->getHeader('x-restli-id')[0]) : null, null, $ex->getMessage());
        }

        return $send->toArray() ?? [];
    }

    public function sanitizeContent($content): string
    {
        // Remove HTML and PHP tags
        $content = strip_tags($content);

        // Escape special characters
        $content = addslashes($content);

        // Convert special characters to HTML entities
        $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

        // Replace problematic characters (newlines, tabs)
        $content = str_replace(["\n", "\t", "\r"], ' ', $content);

        // Optional: Remove emojis or non-printable characters
        $content = preg_replace('/[^\x20-\x7E]/', '', $content);

        // Trim leading/trailing whitespace
        return trim($content);
    }

    public function getPostData($content): array
    {
        $data = [
            'text'    => $content->text,
            'comment' => $content->comment,
            'link'    => $content->link,
        ];

        if ($content->media_type) {
            $url  = getMediaUrl($content->media);
            $data = $data + getRemoteFileInfo($url);
        }

        return $data;
    }

    public function getImageFromUrl($link): array
    {
        try {
            $metas       = get_meta_tags($link);
            $title       = $metas['twitter:title'] ?? $link;
            $description = $metas['description']   ?? $link;
            $linkImage   = $metas['twitter:image'] ?? null;

            return [
                'title'       => $title,
                'description' => $description,
                'linkImage'   => $linkImage,
            ];
        } catch (Exception $ex) {
            return [
                'title'       => $link,
                'description' => $link,
                'linkImage'   => null,
            ];
        }
    }

    public function getPostInsights($id, $token): array
    {
        $url = "{$this->config['base_url']}/socialActions/{$id}";

        return getApiCall($token, $url, [], $this->header);
    }

    public function setAuthorAndVisibility($account, $type): void
    {
        $userType         = $type == SocialNetworkTypeEnum::Linkedin->value ? 'person' : 'organization';
        $this->author     = "urn:li:{$userType}:{$account}";
        $this->visibility = $type == SocialNetworkTypeEnum::Linkedin->value ? 'CONNECTIONS' : 'PUBLIC';
    }

    public function comment($id, $comment, $token): array
    {
        try {
            $res = $this->gazzle->request(
                'POST',
                $this->config['base_url']."/socialActions/{$id}/comments?oauth2_access_token={$token}",
                [
                    'headers' => $this->header,
                    'json'    => [
                        'actor'   => $this->author,
                        'message' => [
                            'text' => $comment,
                        ],
                    ],
                ]
            );
        } catch (Exception $ex) {
            $this->setLog(
                app()->runningInConsole() ? 'linkedin' : 'schedule_linkedin',
                ['commentError' => $ex->getMessage()]
            );
            $error = $ex->getMessage();
        }

        return [
            'status'  => empty($error) ? $res->getStatusCode() : 404,
            'data'    => empty($error) ? $res->getBody() : '',
            'headers' => empty($error) ? $res->getHeaders() : '',
            'error'   => $error ?? '',
        ];
    }

    public function getPageList($token): string
    {
        $response = Http::withToken($token)->withHeaders([
            'LinkedIn-Version'          => $this->config['version'],
            'X-Restli-Protocol-Version' => $this->config['protocol'],
        ])->get($this->config['organizations']);

        return $response->body();
    }

    public function prepareData($page, $user_id, string $profile = ''): array
    {
        return [
            [
                'user_id'       => $user_id['user_id'],
                'work_space_id' => $user_id['work_space_id'],
                'account_id'    => $page->id,
                'type'          => SocialNetworkTypeEnum::Linkedin->value,
                'source'        => SocialAccountSourceTypeEnum::DIRECT->value,
            ],
            [
                'api_key'                   => $page->token,
                'api_secret'                => $page->refreshToken,
                'type_id'                   => 2,
                'name'                      => $page->name,
                'avatar'                    => ! empty($page->avatar) ? $this->getAvatar(
                    $page->avatar,
                    $this->config['default_avatar'],
                    'linkedin'
                ) : $this->config['default_avatar'],
                'account_status'            => 'pending',
                'auto_reconnect_checked_at' => date('Y-m-d H:i:s', $page->expiresIn),
            ],
        ];
    }

    public function preparePageData($user, $token, $user_id, $avatar = null): array
    {
        return [
            [
                'user_id'       => $user_id['user_id'],
                'work_space_id' => $user_id['work_space_id'],
                'account_id'    => $user['id'],
                'type'          => SocialNetworkTypeEnum::LinkedinCompany->value,
                'source'        => SocialAccountSourceTypeEnum::DIRECT->value,
            ],
            [
                'api_key' => $token,
                'name'    => $user['name'],
                'avatar'  => ! empty($avatar) ? $this->getAvatar(
                    $avatar,
                    $this->config['default_avatar'],
                    'linkedin'
                ) : $this->config['default_avatar'],
            ],
        ];
    }
}
