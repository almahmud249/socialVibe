<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Post;
use App\Models\Setting;
use App\Models\SocialAccount;
use App\Models\Subscription as Subscriptions;
use App\Repositories\ClientRepository;
use App\Repositories\EmailTemplateRepository;
use App\Repositories\PlanRepository;
use App\Repositories\UserRepository;
use App\Services\ActiveSubscriptionService;
use App\Services\TotalClientService;
use App\Services\TotalEarningService;
use App\Traits\SendMailTrait;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    use SendMailTrait;

    protected $emailTemplate;

    protected $clientRepo;

    protected $PackageRepo;

    public function __construct(EmailTemplateRepository $emailTemplate, ClientRepository $clientRepo, PlanRepository $PackageRepo)
    {
        $this->emailTemplate = $emailTemplate;

        $this->clientRepo    = $clientRepo;

        $this->PackageRepo   = $PackageRepo;
    }

    public function index(Request $request)
    {
        $now              = Carbon::now();

        $cron_issue       = false;
        // cron
        $last_cron_run_at = Setting::where('title', 'last_cron_run_at')->first();
        $last_cron_run_at = ($last_cron_run_at) ? $last_cron_run_at->value : $now;
        $to               = Carbon::createFromFormat('Y-m-d H:i:s', $last_cron_run_at);
        $from             = Carbon::createFromFormat('Y-m-d H:i:s', now());
        $diffInMinutes    = $to->diffInMinutes($from);
        if ($diffInMinutes > 10) {
            $cron_issue = true;
        }
        $data             = [
            'cron_issue'                 => $cron_issue,
            'charts'                     => [
                'active_subscriptions' => app(ActiveSubscriptionService::class)->execute($request),
                'earning'              => app(TotalEarningService::class)->execute($request),
                'client'               => app(TotalClientService::class)->execute($request),
            ],
            'best_client'                => $this->clientRepo->bestClient(),
            'packages'                   => $this->PackageRepo->bestSellingPlan(),
            'subscriptions'              => Subscriptions::with('client')->latest()->get(),
            'total_active_subscriptions' => Subscriptions::where('status', 1)->where('expire_date', '>=', $now)->count(),
            'last_month_subscriptions'   => Subscriptions::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->count(),
            'total_earning'              => Subscriptions::whereNotIn('status', [0, 2])->sum('price'),
            'last_month_earning'         => Subscriptions::whereNotIn('status', [0, 2])->whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->sum('price'),
            'total_client'               => Client::all()->count(),
            'last_month_client'          => Client::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->count(),
            'total_profile'              => SocialAccount::all()->count(),
            'total_post'                 => Post::all()->count(),
        ];

        return view('backend.admin.dashboard', $data);
    }

    public function profile(UserRepository $userRepository)
    {
        $user_id = auth()->user()->id;
        $user    = $userRepository->find($user_id);

        return view('backend.admin.auth.profile', compact('user'));
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
            'image'      => 'mimes:jpg,JPG,JPEG,jpeg,png,PNG,webp,WEBP|max:5120',
        ]);

        try {
            $userRepository->update($request->all(), auth()->user()->id);
            Toastr::success(__('update_successful'));

            return response()->json([
                'status'  => true,
                'success' => __('update_successful'),
            ]);
        } catch (Exception $e) {
            if (config('app.debug')) {
                dd($e->getMessage());
            }
            logError('Throwable: ', $e);

            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }
    }
    public function passwordChange()
    {
        return view('backend.admin.auth.password_change');
    }

    public function passwordUpdate(Request $request, UserRepository $userRepository): \Illuminate\Http\JsonResponse
    {
        if (isDemoMode()) {
            $data = [
                'status' => false,
                'error'  => __('this_function_is_disabled_in_demo_server'),
                'title'  => 'error',
            ];

            return response()->json($data);
        }
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
                    'status'  => true,
                    'success' => __('successfully_password_changed'),
                    'route'   => route('user.password-change'),
                ]);
            } catch (Exception $e) {
                Toastr::warning(__($e->getMessage()));

                return response()->json(['status' => false, 'error' => $e->getMessage()]);
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

    public function oneSignalSubscription(Request $request): JsonResponse
    {
        try {
            $token = $request->onesignal_token['current']['id'];
            $ids   = \auth()->user()->onesignal_player_id;
            $ids[] = $token;
            auth()->user()->update([
                'onesignal_player_id'     => array_unique($ids),
                'is_onesignal_subscribed' => 1,
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }
    }
}
