<?php

namespace App\Http\Livewire\DataTable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;

class UsersTable extends DataTableComponent
{
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Name", "name")
                ->sortable(),
            Column::make("Username", "username")
                ->sortable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Emp id", "emp_id")
                ->sortable(),
            Column::make("Emp name", "emp_name")
                ->sortable(),
            Column::make("Designation id", "designation_id")
                ->sortable(),
            Column::make("Department id", "department_id")
                ->sortable(),
            Column::make("Office id", "office_id")
                ->sortable(),
            Column::make("User type", "user_type")
                ->sortable(),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }
}
