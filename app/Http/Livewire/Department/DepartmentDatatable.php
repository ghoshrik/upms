<?php

namespace App\Http\Livewire\Department;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Department;

class DepartmentDatatable extends DataTableComponent
{
    protected $model = Department::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Department name", "department_name")
                ->sortable(),
            Column::make("Actions", "id")
                ->view('components.data-table-components.buttons.edit'),

        ];
    }
    public function edit($Id)
    {
        return $this->emit('openForm',true,$Id);
    }
}
