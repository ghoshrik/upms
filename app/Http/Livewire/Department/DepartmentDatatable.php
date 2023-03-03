<?php

namespace App\Http\Livewire\Department;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Department;
use Illuminate\Database\Eloquent\Builder;

class DepartmentDatatable extends DataTableComponent
{
    // protected $model = Department::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id"),
            Column::make("Department name", "department_name")
                ->searchable()
                ->sortable(),
            // Column::make("Actions", "id")
            //     ->view('components.data-table-components.buttons.edit'),

        ];
    }
    public function edit($Id)
    {
        return $this->emit('openForm',true,$Id);
    }
    public function builder(): builder
    {
        return Department::query()
            ->orderBy('id');
        // ->groupBy('estimate_id.estimate_id');
    }
}
