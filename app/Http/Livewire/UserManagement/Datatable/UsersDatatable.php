<?php

namespace App\Http\Livewire\UserManagement\Datatable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;

class UsersDatatable extends DataTableComponent
{
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            // Column::make("Id", "id")
            //     ->sortable(),
            // Column::make("Name", "name")
            //     ->sortable(),
            Column::make("Username", "username")
                ->sortable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Emp id", "emp_id")
                ->sortable(),
            Column::make("Emp name", "emp_name")
                ->sortable(),
            Column::make("Designation id", "getDesignationName.designation_name")
                ->sortable(),
            Column::make("Department id", "getDepartmentName.department_name")
                ->sortable(),
            Column::make("Office id", "getOfficeName.office_name")
                ->sortable(),
            Column::make("User type", "getUserType.type")
                ->sortable(),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }
}
