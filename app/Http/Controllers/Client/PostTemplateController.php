<?php

namespace App\Http\Controllers\Client;

use App\DataTables\Client\PostTemplateDataTable;
use App\Http\Controllers\Controller;
use App\Repositories\Client\PostTemplateRepository;
use App\Traits\FacebookAccountTrait;
use App\Traits\ImageTrait;
use App\Traits\InstagramAccountTrait;
use App\Traits\LinkedInAccountTrait;
use App\Traits\TwitterAccountTrait;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostTemplateController extends Controller
{
    use FacebookAccountTrait, ImageTrait, InstagramAccountTrait, LinkedInAccountTrait, TwitterAccountTrait;

    protected $repo;

    public function __construct(PostTemplateRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(PostTemplateDataTable $dataTable)
    {
        return $dataTable->render('backend.client.post.template.index');
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
            'title'            => 'required',
            'sort_description' => 'required',
            'post_content'     => 'required',
        ]);

        DB::beginTransaction();
        try {
            $requestData = array_merge($request->all(), ['client_id' => Auth::user()->client_id, 'user_id' => Auth::user()->id]);
            $this->repo->store($requestData);
            DB::commit();
            Toastr::success(__('create_successful'));

            return response()->json([
                'success' => __('create_successful'),
                'route'   => route('client.post.template.index'),
            ]);
        } catch (Exception $e) {
            DB::rollback();

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
            'postTemplate' => $this->repo->find($id),
        ];

        return view('backend.client.post.template.edit', $data);
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
            'title'            => 'required',
            'sort_description' => 'required',
            'post_content'     => 'required',
        ]);
        try {
            $this->repo->update($request->all(), $id);

            return response()->json([
                'status'  => true,
                'success' => __('update_successful'),
                'route'   => route('client.post.template.index'),
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
}
