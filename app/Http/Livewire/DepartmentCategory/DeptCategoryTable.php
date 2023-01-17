<?php

namespace App\Http\Livewire\DepartmentCategory;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\SorCategoryType;

class DeptCategoryTable extends DataTableComponent
{
    protected $model = SorCategoryType::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Department id", "department.department_name")
                ->sortable(),
            Column::make("Dept category name", "dept_category_name")
                ->sortable(),
            // Column::make("Actions", "id")->view('components.data-table-components.buttons.edit'),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }
    public function edit($Id)
    {
        return $this->emit('openForm',true,$Id);
    }

}
