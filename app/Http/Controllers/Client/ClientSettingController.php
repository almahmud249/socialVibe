<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientUpdateRequest;
use App\Models\Timezone;
use App\Repositories\Client\ClientSettingRepository;
use App\Repositories\ClientRepository;
use App\Repositories\CountryRepository;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;

class ClientSettingController extends Controller
{
    protected $repo;

    protected $client;

    protected $country;

    public function __construct(ClientSettingRepository $repo, ClientRepository $client, CountryRepository $country)
    {
        $this->repo    = $repo;
        $this->client  = $client;
        $this->country = $country;
    }

    public function billingDetails(Request $request)
    {
        $data = [
            'client' => $this->client->find(auth()->user()->client_id),
        ];

        return view('backend.client.setting.billing_details', $data);
    }

    public function storeBillingDetails(Request $request, $id)
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
            $this->repo->billingDetailsupdate($request, $id);
            Toastr::success(__('update_successful'));

            return back();
        } catch (Exception $e) {
            Toastr::error(__('something_went_wrong_please_try_again'));

            return back();
        }
    }

    public function generalSettings(Request $request)
    {
        $id   = auth()->user()->client_id;
        $data = [
            'client'     => $this->client->find($id),
            'countries'  => $this->country->all(),
            'time_zones' => Timezone::all(),
        ];

        return view('backend.client.setting.general', $data);
    }

    public function api(Request $request)
    {
        return view('backend.client.setting.api');
    }

    public function update_api(Request $request)
    {
        if (isDemoMode()) {
            Toastr::error(__('this_function_is_disabled_in_demo_server'));

            return back();
        }

        $result = $this->repo->update($request);
        if ($result->status) {
            return redirect()->route($result->redirect_to)->with($result->redirect_class, $result->message);
        }

        return back()->with($result->redirect_class, $result->message);
    }

    public function updateGeneralSettings(ClientUpdateRequest $request, $id)
    {
        if (isDemoMode()) {
            Toastr::error(__('this_function_is_disabled_in_demo_server'));

            return back();
        }
        try {
            $this->client->update($request->all(), $id);
            Toastr::success(__('update_successful'));

            return redirect()->route('client.general.settings');
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            if (config('app.debug')) {
                dd($e->getMessage());
            }

            return back()->withInput();
        }
    }

    public function aiWriterSetting()
    {
        return view('backend.client.setting.ai_writer_setting');
    }

    public function AIReplyStatus(Request $request)
    {
        if (isDemoMode()) {
            $data = [
                'status'  => false,
                'message' => __('this_function_is_disabled_in_demo_server'),
            ];

            return response()->json($data);
        }
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|boolean',
        ]);

        return $this->client->AIReplyStatus($request);
    }
}
