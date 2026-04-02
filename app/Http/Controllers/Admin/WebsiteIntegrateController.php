<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\WebsiteIntegrateDataTable;
use App\Http\Controllers\Controller;
use App\Repositories\LanguageRepository;
use App\Repositories\SettingRepository;
use App\Repositories\WebsiteIntegrateRepository;
use App\Traits\ImageTrait;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class WebsiteIntegrateController extends Controller
{
    use ImageTrait;

    protected $language;

    protected $setting;

    protected $integrateRepository;

    public function __construct(WebsiteIntegrateRepository $integrateRepository, SettingRepository $setting, LanguageRepository $language)
    {
        $this->language            = $language;
        $this->setting             = $setting;
        $this->integrateRepository = $integrateRepository;
    }

    public function index(WebsiteIntegrateDataTable $dataTable, Request $request)
    {
        $languages = app('languages');
        $lang      = $request->site_lang ? $request->site_lang : App::getLocale();

        return $dataTable->render('backend.admin.website.integrate.index', compact('languages', 'lang'));
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'title' => 'required',
        ]);
        if (isDemoMode()) {
            $data = [
                'status' => false,
                'error'  => __('this_function_is_disabled_in_demo_server'),
                'title'  => 'error',
            ];

            return response()->json($data);
        }
        DB::beginTransaction();
        try {
            $this->integrateRepository->store($request);
            Toastr::success(__('update_successful'));
            $data = [
                'success' => __('update_successful'),
            ];
            DB::commit();

            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            $data = [
                'error' => $e->getMessage(),
            ];

            return response()->json($data);
        }
    }

    public function integrateContent(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'integrate_title'            => 'required',
            'integrate_description'      => 'required',
            'integrate_action_btn_label' => 'required',
            'integrate_action_btn_url'   => 'required',
        ]);
        if (isDemoMode()) {
            $data = [
                'status' => false,
                'error'  => __('this_function_is_disabled_in_demo_server'),
                'title'  => 'error',
            ];

            return response()->json($data);
        }
        DB::beginTransaction();
        try {
            $this->setting->update($request);
            Toastr::success(__('update_successful'));
            $data = [
                'success' => __('update_successful'),
            ];
            DB::commit();

            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            $data = [
                'error' => $e->getMessage(),
            ];

            return response()->json($data);
        }
    }

    public function edit($id, LanguageRepository $language, Request $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $integrate = $this->integrateRepository->find($id);
            $lang      = $request->lang ?? app()->getLocale();
            $data      = [
                'lang'               => $lang,
                'integrate_language' => $this->integrateRepository->getByLang($id, $lang),
                'integrate'          => $integrate,
            ];

            return view('backend.admin.website.integrate.edit', $data);
        } catch (\Exception $e) {
            Toastr::error('something_went_wrong_please_try_again');

            return back();
        }
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
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
            'title' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $this->integrateRepository->update($request, $id);
            Toastr::success(__('update_successful'));
            DB::commit();

            return response()->json([
                'success' => __('update_successful'),
                'route'   => route('integrate.index'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['status' => false, 'error' => __('something_went_wrong_please_try_again')]);
        }
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
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
            $this->integrateRepository->destroy($id);
            Toastr::success(__('delete_successful'));
            $data = [
                'status'  => 'success',
                'message' => __('delete_successful'),
                'title'   => __('success'),
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            $data = [
                'status'  => 'danger',
                'message' => __('something_went_wrong_please_try_again'),
                'title'   => __('error'),
            ];

            return response()->json($data);
        }
    }

    public function statusChange(Request $request): \Illuminate\Http\JsonResponse
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
            $this->integrateRepository->status($request->all());
            $data = [
                'status'  => 200,
                'message' => __('update_successful'),
                'title'   => 'success',
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            $data = [
                'status'  => 400,
                'message' => __('something_went_wrong_please_try_again'),
                'title'   => 'error',
            ];

            return response()->json($data);
        }
    }
}
