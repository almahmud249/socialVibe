<?php

namespace App\DataTables\Client;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PostDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('created_at', function ($post) {
                return Carbon::parse($post->created_at)->format('M d, Y h:i A');
            })->addColumn('status', function ($post) {
                return view('backend.client.post.status', compact('post'));
            })->addColumn('accounts', function ($post) {
                return view('backend.client.post.accounts', compact('post'));
            })->addColumn('action', function ($post) {
                return view('backend.client.post.action', compact('post'));
            })->setRowId('id');
    }

    public function query(): QueryBuilder
    {
        $model = Post::where('user_id', auth()->id());

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
                    'lengthMenu'        => '_MENU_ '.__('subscriber_per_page'),
                    'search'            => '',
                ],
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('id')->data('DT_RowIndex')->title('#')->searchable(false),
            Column::computed('title')->title(__('title')),
            Column::make('created_at')->title(__('sent_at')),
            Column::make('status')->title(__('status')),
            Column::computed('accounts')->title(__('profile')),
            Column::computed('action')->addClass('action-card')->title(__('Option'))
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
