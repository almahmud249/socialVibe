<?php

namespace App\Http\Controllers\Client;

use App\DataTables\Client\PostDataTable;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostSchedule;
use App\Models\SocialAccount;
use App\Repositories\Client\PostTemplateRepository;
use App\Repositories\Client\TemplateRepository;
use App\Traits\FacebookAccountTrait;
use App\Traits\ImageTrait;
use App\Traits\InstagramAccountTrait;
use App\Traits\LinkedInAccountTrait;
use App\Traits\ThreadsAccountTrait;
use App\Traits\TikTokAccountTrait;
use App\Traits\TwitterAccountTrait;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    use FacebookAccountTrait, ImageTrait, InstagramAccountTrait, LinkedInAccountTrait, ThreadsAccountTrait, TikTokAccountTrait, TwitterAccountTrait;

    protected $postTemplate;

    protected $aiTemplateRepo;

    public function __construct(PostTemplateRepository $postTemplate, TemplateRepository $aiTemplateRepo)
    {
        $this->postTemplate   = $postTemplate;
        $this->aiTemplateRepo = $aiTemplateRepo;
    }

    public function index(PostDataTable $dataTable, $type)
    {
        $data = [
            'type' => $type,
        ];

        return $dataTable->with($data)->render('backend.client.post.index', $data);
    }

    public function create(): Factory|View|array|RedirectResponse|Application
    {
        try {
            $profiles = SocialAccount::where('status', 1)->get();
            $data     = [];

            foreach ($profiles as $profile) {
                $data[] = [
                    'id'    => $profile->id,
                    'text'  => $profile->name.' - '.ucfirst($profile->details),
                    'image' => getFileLink('original_image', @$profile->image['images']),
                ];
            }

            $data     = [
                'post_templates' => $this->postTemplate->all(),
                'ai_templates'   => $this->aiTemplateRepo->all(),
                'profiles'       => $data,
            ];

            return view('backend.client.post.create', $data);
        } catch (Exception $e) {
            Toastr::error($e->getMessage());

            return back();
        }
    }

    public function store(Request $request): JsonResponse
    {
        ini_set('max_execution_time', -1);
        if (isDemoMode()) {
            $data = [
                'status' => false,
                'error'  => __('this_function_is_disabled_in_demo_server'),
                'title'  => 'error',
            ];

            return response()->json($data);
        }
        $request->validate([
            'profile_id'        => 'required',
            'profile_id.*'      => 'required|exists:social_accounts,id',
            'description'       => 'required_without:images',
            'images'            => 'required_without:description',
            'time_post'         => 'required_if:when_post,2',
            'interval_per_post' => 'required_if:when_post,2',
            'repost_frequency'  => 'required_if:when_post,2',
            'repost_until'      => 'required_if:when_post,2',
            'day_time_post'     => 'required_if:when_post,3',
        ]);

        DB::beginTransaction();
        try {
            $social_account = SocialAccount::whereIn('id', $request->profile_id)->get();
            $images         = [];
            $has_video      = false;
          

            if ($request->hasFile('images') && is_array($request->images)) {
                foreach ($request->images as $image) {
                    $extension = strtolower($image->getClientOriginalExtension());

                    $isInstagram = collect($social_account)->contains(function ($acc) {
                        return $acc->details === 'instagram';
                    });

                    if ($isInstagram) {
                        // Special handling for Instagram (aspect ratio enforcement)
                        $filename  = now()->format('YmdHis') . '_original_post' . rand(1, 999) . '.' . $extension;

                        $directory = public_path('images');
                        File::ensureDirectoryExists($directory, 0755, true);

                        $path = $directory . '/' . $filename;

                        $img = Image::make($image)->orientate();
                        $width = $img->width();
                        $height = $img->height();
                        $aspectRatio = $width / $height;

                        // Instagram aspect ratio must be between 0.8 and 1.91
                        if ($aspectRatio < 0.8 || $aspectRatio > 1.91) {
                            $targetWidth = 1080;
                            $targetHeight = 1350;

                            $img->resize($targetWidth, null, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            })->resizeCanvas($targetWidth, $targetHeight, 'center', false, '#ffffff'); // pad with white
                        }

                        $img->save($path, 85);
                        $images[] = url("public/images/{$filename}");
                    } else {
                        // Default image saving for other platforms
                        $type     = $image->getMimeType();
                        $images[] = $this->saveImage($image, 'post')['images']['original_image'];
                    }
                }
            }
          
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
                'title'             => $request->title,
                'client_id'         => auth()->user()->client_id,
                'user_id'           => auth()->id(),
                'content'           => $request->description,
                'link'              => $request->link,
                'platform_response' => null,
                'is_scheduled'      => (bool) $request->schedule_at,
                'is_draft'          => false,
                'status'            => $status,
                'post_type'         => 0,
                'images'            => $images,
                'when_post'         => $request->when_post,
            ];
            $post           = Post::create($data);
            $post->accounts()->sync($request->profile_id);
            $this->insertSchedule($request->all(), $post);
            $response       = [];

            $status         = false;
            if ($request->when_post == 1) {
                foreach ($social_account as $account) {
                    $response = match ($account->details) {
                        'facebook'  => ['facebook' => $this->handlePost($account, $post, $has_video)],
                        'instagram' => ['instagram' => $this->instagramHandlePost($account, $post)],
                        'tiktok'    => ['tiktok' => $this->handleTikTokPost($account, $post)],
                        'twitter'   => ['twitter' => $this->twitterFeed($account, $post)],
                        'linkedin'  => ['linkedin' => $this->linkedInFeed($account, $post)],
                        'threads'   => ['threads' => $this->handleThreadsPost($account, $post)],
                        default     => [],
                    };

                    $platform = array_key_first($response);
                    $status   = $response[$platform]['status'] ?? false;
                }

                $post->status            = $status;
                $post->platform_response = $response;
                $post->save();
            }

            DB::commit();

            return response()->json([
                'success' => __('Post created successfully'),
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function insertSchedule($data, $post): bool
    {
        $dates = [];
        if ($post->when_post == 2) {
            $start_date = Carbon::parse($data['time_post']);
            if ($data['repost_frequency'] > 0) {
                $end_date = Carbon::parse($data['repost_until']);
                $periods  = CarbonPeriod::create($start_date, $data['repost_frequency'].' days', $end_date);
                foreach ($periods as $period) {
                    $dates[] = $period->format('Y-m-d H:i:s');
                }
            } else {
                $dates[] = $start_date;
            }
        } elseif ($post->when_post == 3) {
            foreach ($data['day_time_post'] as $time_post) {
                $dates[] = Carbon::parse($time_post)->format('Y-m-d H:i:s');
            }
            $data['interval_per_post'] = 0;
            $data['repost_frequency']  = 0;
        }
        $rows  = [];
        $now   = now();
        foreach ($dates as $date) {
            $rows[] = [
                'post_id'          => $post->id,
                'start_time'       => $date,
                'interval'         => getArrayValue('interval_per_post', $data, 0),
                'repost_frequency' => getArrayValue('repost_frequency', $data, 0),
                'social_accounts'  => json_encode(array_unique($post->accounts->pluck('details')->toArray())),
                'created_at'       => $now,
                'updated_at'       => $now,
            ];
        }
        if (count($rows) > 0) {
            PostSchedule::insert($rows);
        }

        return true;
    }

    public function destroy($id): JsonResponse
    {
        if (isDemoMode()) {
            $data = [
                'status'  => false,
                'message' => __('this_function_is_disabled_in_demo_server'),
                'title'   => 'error',
            ];

            return response()->json($data);
        }
        try {
            $post   = Post::find($id);
            $images = $post->images;
            array_unshift($images, 'test');
            $this->deleteImage($images);
            PostSchedule::where('post_id', $post->id)->delete();
            $post->delete();
            $data   = [
                'status'  => 'success',
                'message' => __('delete_successful'),
                'title'   => __('success'),
            ];

            return response()->json($data);
        } catch (Exception $e) {
            $data = [
                'status'  => 'danger',
                'message' => $e->getMessage(),
                'title'   => 'error',
            ];

            return response()->json($data);
        }
    }

    public function calendar()
    {
        $data = [
            'schedules' => PostSchedule::join('posts', 'posts.id', 'post_schedules.post_id')->whereDate('start_time', '>=', Carbon::now())
                ->selectRaw('post_id,title,FROM_UNIXTIME(UNIX_TIMESTAMP(start_time)) as start,FROM_UNIXTIME(UNIX_TIMESTAMP(start_time)) as end')
                ->get()->toArray(),
        ];

        return view('backend.client.post.calendar', $data);
    }
}
