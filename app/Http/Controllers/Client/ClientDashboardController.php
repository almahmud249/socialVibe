<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\SocialAccount;
use App\Models\Timezone;
use App\Models\User;
use App\Repositories\EmailTemplateRepository;
use App\Repositories\UserRepository;
use App\Services\PostStatisticService;
use App\Services\ScheduledPostService;
use App\Services\TodayScheduledPostService;
use App\Traits\SendMailTrait;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientDashboardController extends Controller
{
    use SendMailTrait;

    protected $emailTemplate;

    public function __construct(EmailTemplateRepository $emailTemplate)
    {
        $this->emailTemplate = $emailTemplate;
    }

    public function index(Request $request)
    {
        $client               = auth()->user()->client;
        $activeSubscription   = $client->activeSubscription;
        $total_team           = User::where('client_id', $client->user->client_id)->where('status', 1)->count();
        $total_post           = Post::where('client_id', $client->id)->count();
        $total_scheduled      = Post::where('client_id', $client->id)->where('is_scheduled', 1)->count();
        $total_draft          = Post::where('client_id', $client->id)->where('is_draft', 1)->count();
        $total_public_post    = Post::where('client_id', $client->id)->where('status', 1)->count();
        $total_social_profile = SocialAccount::where('user_id', $client->user->id)->count();
        $today_scheduled_post = app(TodayScheduledPostService::class)->execute($request);
        $scheduled_post       = app(ScheduledPostService::class)->execute($request);
        $post_statistic       = app(PostStatisticService::class)->execute($request);
        if (isDemoMode()) {
            $data = [
                'client'                      => $client,
                'active_subscription'         => $activeSubscription,
                'today_scheduled_post_charts' => [
                    'labels'    => $today_scheduled_post['labels'],
                    'facebook'  => [8, 12, 15, 19, 7, 13, 14, 16, 9, 20, 17, 11, 18, 10, 14, 8, 19, 7, 12, 15, 13, 9, 11, 18, 16],
                    'instagram' => [14, 9, 7, 12, 19, 17, 10, 8, 11, 15, 13, 18, 16, 20, 7, 14, 9, 12, 10, 13, 11, 16, 19, 8, 17],
                    'linkedin'  => [13, 17, 12, 14, 20, 9, 8, 10, 15, 11, 19, 7, 18, 16, 14, 20, 9, 12, 8, 13, 11, 15, 7, 10, 18],
                    'x'         => [7, 11, 9, 14, 19, 17, 10, 8, 12, 15, 13, 18, 16, 20, 7, 14, 9, 12, 10, 13, 11, 16, 19, 8, 17],
                ],
                'scheduled_post_charts'       => [
                    'labels'    => $scheduled_post['labels'],
                    'facebook'  => [8, 12, 15, 19, 7, 13, 14, 16, 9, 20, 17, 11, 18, 10, 14, 8, 19, 7, 12, 15, 13, 9, 11, 18, 16, 10, 20, 17, 14, 8, 6],
                    'instagram' => [14, 9, 7, 12, 19, 17, 10, 8, 11, 15, 13, 18, 16, 20, 7, 14, 9, 12, 10, 13, 11, 16, 19, 8, 17, 15, 7, 20, 18, 9, 7],
                    'linkedin'  => [13, 17, 12, 14, 20, 9, 8, 10, 15, 11, 19, 7, 18, 16, 14, 20, 9, 12, 8, 13, 11, 15, 7, 10, 18, 16, 19, 17, 9, 7, 7],
                    'x'         => [7, 11, 9, 14, 19, 17, 10, 8, 12, 15, 13, 18, 16, 20, 7, 14, 9, 12, 10, 13, 11, 16, 19, 8, 17, 15, 7, 20, 18, 9, 7],
                ],
                'post_statistic_charts'       => [
                    'labels'    => $post_statistic['labels'],
                    'facebook'  => [8, 12, 15, 19, 7, 13, 14, 16, 20, 18, 9, 7],
                    'instagram' => [14, 9, 7, 12, 19, 17, 10, 8, 17, 9, 7, 7],
                    'linkedin'  => [13, 17, 12, 14, 20, 9, 8, 10, 16, 19, 8, 17],
                    'x'         => [7, 11, 9, 14, 19, 17, 10, 8, 15, 13, 9, 11],
                ],
                'usages'                      => [
                    'team'                 => 10,
                    'post'                 => 100,
                    'scheduled_post'       => 10,
                    'draft_post'           => 5,
                    'total_social_profile' => 15,
                    'public_post'          => 30,
                ],
            ];
        } else {
            $data = [
                'client'                      => $client,
                'active_subscription'         => $activeSubscription,
                'today_scheduled_post_charts' => [
                    'labels'    => $today_scheduled_post['labels'],
                    'facebook'  => $today_scheduled_post['facebook'],
                    'instagram' => $today_scheduled_post['instagram'],
                    'linkedin'  => $today_scheduled_post['linkedin'],
                    'x'         => $today_scheduled_post['x'],
                ],
                'scheduled_post_charts'       => [
                    'labels'    => $scheduled_post['labels'],
                    'facebook'  => $scheduled_post['facebook'],
                    'instagram' => $scheduled_post['instagram'],
                    'linkedin'  => $scheduled_post['linkedin'],
                    'x'         => $scheduled_post['x'],
                ],
                'post_statistic_charts'       => [
                    'labels'    => $post_statistic['labels'],
                    'facebook'  => $post_statistic['facebook'],
                    'instagram' => $post_statistic['instagram'],
                    'linkedin'  => $post_statistic['linkedin'],
                    'x'         => $post_statistic['x'],
                ],
                'usages'                      => [
                    'team'                 => $total_team,
                    'post'                 => $total_post,
                    'scheduled_post'       => $total_scheduled,
                    'draft_post'           => $total_draft,
                    'total_social_profile' => $total_social_profile,
                    'public_post'          => $total_public_post,
                ],
            ];
        }

        return view('backend.client.dashboard', $data);
    }

    public function profile(UserRepository $userRepository)
    {
        $user_id = auth()->user()->id;
        $data    = [
            'time_zones' => Timezone::all(),
            'user'       => $userRepository->find($user_id),
        ];

        return view('backend.client.auth.profile', $data);
    }

    public function chat(UserRepository $userRepository)
    {
        $user_id = auth()->user()->id;
        $user    = $userRepository->find($user_id);

        return view('backend.client.chat.index');
    }

    public function profileUpdate(Request $request, UserRepository $userRepository): \Illuminate\Http\JsonResponse
    {

        if (isDemoMode()) {
            $data = [
                'status' => false,
                'error'  => __('this_function_is_disabled_in_demo_server'),
                'title'  => 'error',
            ];

            return response()->json($data);
        }
        $id = auth()->user()->id;
        $request->validate([
            'first_name' => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,'.Request()->id,
            'phone'      => 'required|unique:users,phone,'.Request()->id,

        ]);

        try {
            $userRepository->update($request->all(), auth()->user()->id);
            Toastr::success(__('update_successful'));

            return response()->json([
                'success' => __('update_successful'),
            ]);
        } catch (Exception $e) {
            if (config('app.debug')) {
                dd($e->getMessage());
            }

            return response()->json(['status' => false, 'error' => __('something_went_wrong_please_try_again')]);
        }
    }

    public function passwordChange()
    {
        return view('backend.client.auth.password_change');
    }

    public function passwordUpdate(Request $request, UserRepository $userRepository)
    {

        $request->validate([
            'current_password' => ['required'],
            'password'         => 'required|min:6|max:32|confirmed',
        ]);
        $user = $userRepository->findByEmail(auth()->user()->email);

        if (Hash::check($request->current_password, $user->password)) {
            try {
                $user->password = bcrypt($request->password);
                $user->save();
                Toastr::success(__('successfully_password_changed'));

                return response()->json([
                    'success' => __('successfully_password_changed'),
                    'route'   => route('client.profile.password-change'),
                ]);
            } catch (Exception $e) {
                Toastr::warning(__($e));

                return response()->json(['status' => false, 'error' => __('something_went_wrong_please_try_again')]);
            }
        } else {
            Toastr::warning(__('sorry_old_password_not_match'));

            return response()->json(['status' => false, 'error' => 'sorry_old_password_not_match']);
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
