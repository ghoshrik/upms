<?php

namespace App\Http\Livewire\AccessManager\Datatable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\AccessMaster;

class AccessManagerDatatable extends DataTableComponent
{
    protected $model = AccessMaster::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            // Column::make("Id", "id")
            //     ->sortable(),
            Column::make("Department id", "getDepartmentName.department_name")
                ->sortable(),
            Column::make("Designation id", "getDesignationName.designation_name")
                ->sortable(),
            Column::make("Access type id", "getAccessTypeName.access_name")
                ->sortable(),
            Column::make("Office id", "getOfficeName.office_name")
                ->sortable(),
            Column::make("User id", "getUserName.emp_name")
                ->sortable(),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }
}
