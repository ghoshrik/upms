<?php

namespace App\Http\Livewire\Aafs\Datatable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\AAFS;

class AAFSDatatable extends DataTableComponent
{
    protected $model = AAFS::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make(trans('cruds.aafs_project.fields.proj_id'), "project_id")
                ->sortable(),
            Column::make(trans('cruds.aafs_project.fields.Govt_id'), "Go_id")
                ->sortable(),
            Column::make(trans('cruds.aafs_project.fields.go_date'), "go_date")
                ->sortable(),
            // Column::make("Support data", "support_data")
            //     ->sortable(),
            // Column::make("Status", "status")
            //     ->sortable(),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }
}
