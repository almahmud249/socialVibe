<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\socialPostResource;
use App\Models\Post;
use App\Models\SocialAccount;
use App\Repositories\Client\PostTemplateRepository;
use App\Repositories\Client\TemplateRepository;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\FacebookAccountTrait;
use App\Traits\ImageTrait;
use App\Traits\InstagramAccountTrait;
use App\Traits\LinkedInAccountTrait;
use App\Traits\TwitterAccountTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{
    use ApiReturnFormatTrait,FacebookAccountTrait, ImageTrait, InstagramAccountTrait, LinkedInAccountTrait, TwitterAccountTrait;

    protected $postTemplate;

    protected $aiTemplateRepo;

    public function __construct(PostTemplateRepository $postTemplate, TemplateRepository $aiTemplateRepo)
    {
        $this->postTemplate   = $postTemplate;
        $this->aiTemplateRepo = $aiTemplateRepo;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $user  = jwtUser();
            $posts = Post::where('user_id', $user->id)->latest()->paginate(10);
            $data  = [
                'post' => socialPostResource::collection($posts),
            ];

            return $this->responseWithSuccess(__('post_retrieved_successfully'), $data);
        } catch (\Exception $e) {
            return $this->responseWithError($e->getMessage(), [], 500);
        }
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $baseRules = [
            'profile_id'       => 'required',
            'profile_id.*'     => 'required|exists:social_accounts,id',
            'description'      => 'required',
            'start_time'       => 'required_if:when_post,2',
            'interval'         => 'required_if:when_post,2',
            'repost_frequency' => 'required_if:when_post,2',
            'end_time'         => 'required_if:when_post,2',
            'time_posts'       => 'required_if:when_post,3',
        ];
        $validator = Validator::make($request->all(), $baseRules);
        if ($validator->fails()) {
            return $this->responseWithError(__('validation_failed'), $validator->errors(), 422);
        }

        DB::beginTransaction();
        try {
            $social_account = SocialAccount::whereIn('id', $request->profile_id)->get();
            $images         = [];
            $has_video      = false;

            // Check if 'images' is in the request and is an array
            if ($request->has('images') && is_array($request->images)) {
                foreach ($request->images as $image) {
                    $type     = $image->getMimeType();
                    $images[] = $this->saveImage($image, 'post')['images']['original_image'];
                }
            }

            // Create the post
            if ($request->when_post == 1) {
                $status = 1;
            } elseif ($request->when_post == 4) {
                $status = 2;
            } elseif ($request->when_post == 2 || $request->when_post == 3) {
                $status = 3;
            } else {
                $status = 0;
            }
            $data           = [
                'uid'               => Str::uuid()->toString(),
                'client_id'         => auth()->user()->client_id,
                'user_id'           => auth()->id(),
                'content'           => $request->description,
                'link'              => $request->link,
                'platform_response' => null,
                'is_scheduled'      => (bool) $request->schedule_at,
                'schedule_time'     => Carbon::parse($request->schedule_at),
                'is_draft'          => false,
                'status'            => $status,
                'post_type'         => 0,
                'images'            => $images,
                'when_post'         => $request->when_post,
                'start_time'        => $request->when_post,
            ];
            if ($request->when_post == 2) {
                $data['start_time']       = Carbon::parse($request->start_time);
                $data['end_time']         = Carbon::parse($request->end_time);
                $data['interval']         = $request->interval;
                $data['repost_frequency'] = $request->repost_frequency;
            } elseif ($request->when_post == 3) {
                $data['specific_times'] = $request->time_posts;
            }
            $post           = Post::create($data);

            $post->accounts()->sync($request->profile_id);
            $response       = [];

            $status         = false;
            if ($request->when_post == 1) {
                foreach ($social_account as $account) {
                    if ($account->details == 'facebook') {
                        $response['facebook'] = $this->handlePost($account, $post, $has_video);
                        $status               = $response['facebook']['status'];
                    } elseif ($account->details == 'instagram') {
                        $response['instagram'] = $this->instagramHandlePost($account, $post);
                        $status                = $response['instagram']['status'];
                    } elseif ($account->details == 'twitter') {
                        try {
                            $response['twitter'] = $this->twitterFeed($account, $post);
                            $status              = $response['twitter']['status'];
                        } catch (Exception $e) {
                            $status = false;
                        }
                    } elseif ($account->details == 'linkedin') {
                        $response['linkedin'] = $this->linkedInFeed($account, $post);
                        $status               = $response['linkedin']['status'];
                    }
                }
            }

            if ($request->when_post == 1) {
                $post->status            = $status;
                $post->platform_response = $response;
                $post->save();
            }

            DB::commit();

            return $this->responseWithSuccess(__('created_successfully'));
        } catch (\Exception $e) {
            return $this->responseWithError($e->getMessage(), [], 500);
        }
    }
}
