<?php
namespace App\Repositories\Client;
use App\Models\PostTemplate;
class PostTemplateRepository
{
    private $model;

    public function __construct(PostTemplate $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return PostTemplate::latest()->paginate(setting('pagination'));
    }

    public function combo()
    {
        return $this->model->active()->withPermission()->pluck('title', 'id');
    }

    public function activeSegments()
    {
        return PostTemplate::where('status', 1)->withPermission()->get();
    }

    public function store($request)
    {
        return PostTemplate::create($request);
    }

    public function find($id)
    {
        return PostTemplate::find($id);
    }

    public function update($request, $id)
    {
        $segment = PostTemplate::find($id);
        return $segment->update($request);
    }

    public function destroy($id)
    {
        return PostTemplate::destroy($id);
    }

    public function statusChange($request)
    {
        $id = $request['id'];
        return PostTemplate::find($id)->update($request);
    }

}
