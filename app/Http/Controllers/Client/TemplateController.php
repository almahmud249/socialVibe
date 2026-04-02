<?php

namespace App\Http\Controllers\Client;

use App\DataTables\Client\TemplateDataTable;
use App\Http\Controllers\Controller;
use App\Http\Resources\TemplateResource;
use App\Repositories\Client\TemplateRepository;
use App\Traits\RepoResponse;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TemplateController extends Controller
{
    use RepoResponse;

    protected $repo;

    public function __construct(TemplateRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(TemplateDataTable $templateDataTable)
    {
        return $templateDataTable->render('backend.client.ai_writer.template.index');
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
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
            'title'       => 'required',
            'description' => 'required',
            'prompt'      => 'required',
        ]);
        DB::beginTransaction();
        try {
            $requestData = array_merge($request->all(), ['client_id' => Auth::user()->client_id]);
            $this->repo->store($requestData);
            DB::commit();

            return response()->json([
                'status'  => true,
                'success' => __('update_successful'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['status' => false, 'error' => __('something_went_wrong_please_try_again')]);
        }
    }

    public function edit($id)
    {
        if (isDemoMode()) {
            Toastr::error(__('this_function_is_disabled_in_demo_server'));

            return back();
        }
        $data = [
            'template' => $this->repo->find($id),
        ];

        return view('backend.client.ai_writer.template.edit', $data);
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
            'title'       => 'required',
            'description' => 'required',
            'prompt'      => 'required',
        ]);
        try {
            $this->repo->update($request->all(), $id);

            return response()->json([
                'status'  => true,
                'success' => __('update_successful'),
                'route'   => route('client.templates.index'),
            ]);
        } catch (Exception $e) {
            $data = [
                'status'  => 'danger',
                'message' => __('something_went_wrong_please_try_again'),
                'title'   => __('error'),
            ];

            return response()->json($data);
        }
    }

    public function delete($id): \Illuminate\Http\JsonResponse
    {
        if (isDemoMode()) {
            $data = [
                'status' => false,
                'error'  => __('this_function_is_disabled_in_demo_server'),
                'title'  => 'error',
            ];

            return response()->json($data);
        }
        try {
            $this->repo->destroy($id);
            Toastr::success(__('delete_successful'));
            $data = [
                'status'    => 'success',
                'message'   => __('delete_successful'),
                'title'     => __('success'),
                'is_reload' => true,
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
}
