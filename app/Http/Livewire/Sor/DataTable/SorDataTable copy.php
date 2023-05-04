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
            Column::make("Item Number", "Item_details")
                ->searchable()
                ->sortable(),
            Column::make("Department Name", "getDepartmentName.department_name")
                ->searchable()
                ->sortable(),
            Column::make("Dept Category", "getDeptCategoryName.dept_category_name")
                ->sortable(),
            Column::make("Description", "description")
                ->sortable(),
            Column::make("Unit Name", "getUnitsName.unit_name")
                ->sortable(),
            Column::make("Quantity", "unit")
                ->sortable(),
            Column::make("Cost", "cost")
                ->sortable(),
            Column::make("Version", "version")
                ->sortable(),
            Column::make("Effect from", "effect_from")
                ->format(function ($value) {
                    return $value->format('Y-m-d');
                })
                ->sortable(),

            Column::make("Effect to", "effect_to")
                ->format(function ($value) {
                    return  $value ? $value->format('Y-m-d') : '';
                })
                ->sortable(),
            Column::make("status", "is_approved")
                ->format(function ($value, $column, $row) {
                    if ($value) {
                        return '<span class="badge badge-pill rounded bg-success">Approved</span>';
                    } else {
                        return '<span class="badge badge-pill rounded bg-warning">Pending</span>';
                    }
                })
                ->html()
                ->sortable(),
            Column::make("Actions", "id")->view('livewire.action-components.sor.sor-prepare-table-buttons'),
        ];
    }
    public function sorapproved($value)
    {
        $this->emit('openModel', $value);
    }
    public function edit($id)
    {
        $this->emit('openEntryForm', ['formType' => 'edit', 'id' => $id]);
    }
    public function generatePdf($value)
    {
        $this->emit('sorFileDownload', $value);
    }
    public function builder(): Builder
    {
        return SOR::query()
            ->where([['s_o_r_s.department_id', Auth::user()->department_id], ['s_o_r_s.created_by', Auth::user()->id]]);
    }
}
