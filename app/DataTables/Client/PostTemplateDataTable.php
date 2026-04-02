<?php

namespace App\DataTables\Client;

use App\Models\Post;
use App\Models\PostTemplate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PostTemplateDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
			->addColumn('action', function ($postTemplate) {
				return view('backend.client.post.template.action', compact('postTemplate'));
			})->setRowId('id');
    }

    public function query(): QueryBuilder
    {
        $model = PostTemplate::where('user_id', auth()->id());

        return $model
            ->latest()
            ->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->setTableAttribute('style', 'width:99.8%')
            ->footerCallback('function ( row, data, start, end, display ) {

                $(".dataTables_length select").addClass("form-select form-select-lg without_search mb-3");
                selectionFields();
            }')
            ->parameters([
                'dom'        => 'Blfrtip',
                'buttons'    => [
                    [],
                ],
                'lengthMenu' => [[10, 25, 50, 100, 250], [10, 25, 50, 100, 250]],
                'language'   => [
                    'searchPlaceholder' => __('search'),
                    'lengthMenu'        => '_MENU_ '.__('post_template_per_page'),
                    'search'            => '',
                ],
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('id')->data('DT_RowIndex')->title('#')->searchable(false),
            Column::make('title')->title(__('title')),
            Column::make('sort_description')->title(__('description')),
            Column::computed('action')->addClass('action-card text-end')->title(__('action'))
                ->exportable(false)
                ->printable(false)
                ->searchable(false),
        ];
    }

    protected function filename(): string
    {
        return 'subscriber_'.date('YmdHis');
    }
}
