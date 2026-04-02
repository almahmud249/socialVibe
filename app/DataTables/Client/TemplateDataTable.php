<?php

namespace App\DataTables\Client;

use App\Models\Template;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TemplateDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('title', function ($row) {
                return $row->title;
            })->addColumn('action', function ($template) {
                return view('backend.client.ai_writer.template.action', compact('template'));
            })->addColumn('platform', function ($row) {
                return view('backend.client.ai_writer.template.platform', compact('row'));
            })->addColumn('prompt', function ($row) {
                return $row->prompt;
            })
            ->setRowId('id');

    }

    public function query(): QueryBuilder
    {
        $model = new Template;

        return $model->latest('id')->when(request('search')['value'] ?? false, function ($query, $search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('template_id', 'like', "%$search%")
                ->orWhere('category', 'like', "%$search%");
        })->newQuery();
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
                    'lengthMenu'        => '_MENU_ '.__('template_per_page'),
                    'search'            => '',
                ],
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('id')->data('DT_RowIndex')->title('#')->width(10),
            Column::computed('platform')->title(__('platform')),
            Column::computed('title')->title(__('title')),
            Column::computed('description')->title(__('description')),
            Column::computed('prompt')->title(__('prompt')),
            Column::computed('action')->title(__('action'))
                ->exportable(false)
                ->printable(false)
                ->searchable(false)->addClass('action-card')->width(10),
        ];
    }

    protected function filename(): string
    {
        return 'brand_'.date('YmdHis');
    }
}
