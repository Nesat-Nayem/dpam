<?php

namespace App\DataTables;

use App\Models\GrandChildCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class GrandChildCategoryDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function($query){
                $editBtn = "<a href='".route('admin.grand-child-category.edit', $query->id)."' class='btn btn-primary'><i class='far fa-edit'></i></a>";
                $deleteBtn = "<a href='".route('admin.grand-child-category.destroy', $query->id)."' class='btn btn-danger ml-2 delete-item'><i class='far fa-trash-alt'></i></a>";

                return $editBtn.$deleteBtn;
            })
            ->addColumn('status', function($query){
                if($query->status == 1){
                    $button = '<label class="custom-switch mt-2">
                        <input type="checkbox" checked name="custom-switch-checkbox" data-id="'.$query->id.'" class="custom-switch-input change-status" >
                        <span class="custom-switch-indicator"></span>
                    </label>';
                }else {
                    $button = '<label class="custom-switch mt-2">
                        <input type="checkbox" name="custom-switch-checkbox" data-id="'.$query->id.'" class="custom-switch-input change-status">
                        <span class="custom-switch-indicator"></span>
                    </label>';
                }
                return $button;
            })
            ->addColumn('category', function($query){
                return $query->category->name;
            })
            ->addColumn('sub_category', function($query){
                return $query->subCategory->name;
            })
            ->addColumn('child_category', function($query){
                return $query->childCategory->name;
            })
            ->rawColumns(['status', 'action'])
            ->setRowId('id');
    }

    public function query(GrandChildCategory $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('grandchildcategory-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('category'),
            Column::make('sub_category'),
            Column::make('child_category'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'GrandChildCategory_' . date('YmdHis');
    }
}
