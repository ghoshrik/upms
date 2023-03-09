<?php

namespace App\Http\Livewire\Sor\DataTable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\SOR;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SorDataTable extends DataTableComponent
{
    protected $model = SOR::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            // Column::make("Id", "id")
            //     ->sortable(),
            Column::make("Item Number", "item_details")
                ->searchable()
                ->sortable(),
            Column::make("Department Name", "getDepartmentName.department_name")
                ->searchable()
                ->sortable(),
            Column::make("Dept Category", "getDeptCategoryName.dept_category_name")
                ->sortable(),
            Column::make("Description", "description")
                ->sortable(),
            Column::make("Unit", "unit")
                ->sortable(),
            Column::make("Cost", "cost")
                ->sortable(),
            Column::make("Version", "version")
                ->sortable(),
            Column::make("Effect from", "effect_from")
                ->sortable(),
            Column::make("Effect to", "effect_to")
                ->sortable(),
            // Column::make("IsActive", "IsActive")
            //     ->sortable(),
            Column::make("Actions", "id")->view('components.data-table-components.buttons.edit'),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }
    public function edit($id)
    {
        $this->emit('openForm',['formType'=>'edit','id'=>$id]);
    }
    public function builder(): Builder
    {
        return SOR::query()
                    ->where('s_o_r_s.department_id', Auth::user()->department_id);
    }
}
