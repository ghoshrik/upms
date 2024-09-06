<?php

namespace App\Http\Livewire\DepartmentCategory;

use App\Models\SorCategoryType;
use App\Models\DepartmentCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

class DeptCategoryTable extends DataTableComponent
{
    // protected $model = SorCategoryType::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Department", "department_id")
                ->sortable(),
            Column::make("Dept category name", "dept_category_name")
                ->sortable(),
            Column::make("Volume No", "volume_id")
                ->sortable(),
            Column::make("Total SOR Pages", "target_pages")
                ->sortable(),
            Column::make("Actions", "id")->view('components.data-table-components.buttons.edit'),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }
    public function edit($Id)
    {
        // return $this->emit('openEntryForm', $Id);
        return $this->emit('openEntryForm', ['formType' => 'edit', 'id' => $Id]);
    }
    public function builder(): Builder
    {
        return DepartmentCategory::query()
            ->where('department_categories.department_id', '=', Auth::user()->department_id);
    }
}
