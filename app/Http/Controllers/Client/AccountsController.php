<?php

namespace App\Http\Controllers\Client;

use App\DataTables\Client\AccountsListDataTable;
use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Traits\FacebookAccountTrait;
use App\Traits\ImageTrait;
use App\Traits\InstagramAccountTrait;
use App\Traits\LinkedInAccountTrait;
use App\Traits\ThreadsAccountTrait;
use App\Traits\TikTokAccountTrait;
use App\Traits\TwitterAccountTrait;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class AccountsController extends Controller
{
    use FacebookAccountTrait,InstagramAccountTrait,LinkedInAccountTrait, TikTokAccountTrait, TwitterAccountTrait, ImageTrait, ThreadsAccountTrait;

    public function index(Request $request, AccountsListDataTable $dataTable)
    {
        $data = [
            'plat_form' => $request->plat_form ?: 'facebook',
        ];

        return $dataTable->with($data)->render('backend.client.accounts.index', $data);
    }

    //    public function create(Request $request): Redirector|RedirectResponse|Application|null
    //    {
    //        $data = $request->all();
    //        if (isset($data['plat_form']) && $data['plat_form'] != 'facebook') {
    //            if ($data['plat_form'] == 'instagram') {
    //                if (! setting('is_instagram_activated')) {
    //                    abort(403);
    //                }
    //                $url = $this->instagramAuthUrl();
    //            } elseif ($data['plat_form'] == 'linkedin') {
    //                if (! setting('is_linkedin_activated')) {
    //                    abort(403);
    //                }
    //                $url = $this->linkedInAuthUrl();
    //            } elseif ($data['plat_form'] == 'twitter') {
    //                if (! setting('is_x_activated')) {
    //                    abort(403);
    //                }
    //                $url = $this->twitterAuthUrl();
    //            }
    //        } else {
    //            if (! setting('is_facebook_activated')) {
    //                abort(403);
    //            }
    //            $url = $this->facebookAuthUrl();
    //        }
    //
    //        return redirect($url);
    //    }

    public function create(Request $request): Redirector|RedirectResponse|Application|null
    {
        $data = $request->all();

        $url  = match ($data['plat_form']) {
            'facebook'  => setting('is_facebook_activated') ? $this->facebookAuthUrl() : null,
            'instagram' => setting('is_instagram_activated') ? $this->instagramAuthUrl() : null,
            'linkedin'  => setting('is_linkedin_activated') ? $this->linkedInAuthUrl() : null,
            'twitter'   => setting('is_x_activated') ? $this->twitterAuthUrl() : null,
            'tiktok'    => setting('is_tiktok_activated') ? $this->tiktokAuthUrl() : null,
            'threads'   => setting('is_threads_activated') ? $this->threadsAuthUrl() : null,
            'default'   => null
        };
        if (! $url) {
            abort(403);
        }

        return redirect($url);
    }

    public function callback(Request $request, $plat_form): RedirectResponse
    {
        if ($plat_form == 'facebook' && $request->code) {
            $oauth_access_token = $this->fbAccessToken($request->code);
            $access_token       = $oauth_access_token['access_token'];
            $pages              = $this->fbPages($access_token);
            $this->saveFbPages($pages);
        } elseif ($plat_form == 'instagram') {
            $oauth_access_token = $this->instagramAccessToken($request->code);
            $access_token       = $oauth_access_token['access_token'];
            $pages              = $this->instagramPages($access_token);
            $this->saveinstagramPages($pages);
        } elseif ($plat_form == 'linkedin') {
            if ($request->has('error')) {
                $message = $request->input('error_description', $request->input('error'));
                Toastr::error('LinkedIn auth failed: '.$message);

                return redirect()->route('client.accounts.index', ['plat_form' => $plat_form]);
            }

            $oauth_access_token = $this->linkedInAccessToken($request->code);
            if (! isset($oauth_access_token['access_token'])) {
                $oauthError = $oauth_access_token['error_description']
                    ?? $oauth_access_token['message']
                    ?? $oauth_access_token['error']
                    ?? 'access_token missing from LinkedIn response';

                Toastr::error('LinkedIn token failed: '.$oauthError);

                return redirect()->route('client.accounts.index', ['plat_form' => $plat_form]);
            }
            $access_token       = $oauth_access_token['access_token'];
            $profile            = $this->linkedInProfile($access_token);
            $this->savelinkedInProfile($profile + $oauth_access_token);

            // Get and save pages
            $pages = $this->linkedInPages($access_token);
            $this->saveLinkedInPages($pages, $access_token);

        } elseif ($plat_form == 'twitter') {
            $oauth_access_token = $this->twitterAccessToken($request->code);
            $access_token       = $oauth_access_token['access_token'];
            $profile            = $this->twitterProfile($access_token);
            $this->saveTwitterProfile($profile + $oauth_access_token);
        } elseif ($plat_form == 'tiktok') {
            $oauth_access_token = $this->tiktokAccessToken($request->code);
            $access_token       = $oauth_access_token['access_token'];
            $profile            = $this->tiktokUserProfile($access_token);
            $this->saveTikTokProfile($profile + $oauth_access_token);
        } elseif ($plat_form == 'threads') {
            $oauth_access_token = $this->threadsAccessToken($request->code);
            $access_token       = $oauth_access_token['access_token'];
            $profile            = $this->threadsUserProfile($access_token);
            $this->saveThreadsProfile($profile + $oauth_access_token);
        }

        Toastr::success(__('accounts_save_successfully'));

        return redirect()->route('client.accounts.index', ['plat_form' => $plat_form]);
    }

    public function statusChange(Request $request): JsonResponse
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
            $id              = $request['id'];

            $account         = SocialAccount::find($id);
            $account->status = $request['status'];
            $account->save();
            $data            = [
                'status'  => 200,
                'message' => __('update_successful'),
                'title'   => 'success',
            ];

            return response()->json($data);
        } catch (Exception $e) {
            $data = [
                'status'  => 400,
                'message' => __('something_went_wrong_please_try_again'),
                'title'   => 'error',
            ];

            return response()->json($data);
        }
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
            SocialAccount::destroy($id);
            $data = [
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
}
