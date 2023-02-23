<?php

namespace App\Http\Livewire\Office\DataTable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Office;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class OfficeTable extends DataTableComponent
{
    protected $model = Office::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            // Column::make("Id", "id")
            //     ->sortable(),
            Column::make("Office name", "office_name")
                ->sortable(),
            Column::make("Department Name", "getDepartmentName.department_name")
                ->sortable(),
            Column::make("Dist Name", "getDistrictName.district_name")
                ->sortable(),
            // Column::make("In area", "In_area")
            //     ->sortable(),
            // Column::make("Rural block Name", "rural_block_code")
            //     ->sortable(),
            // Column::make("Gp Name", "gp_code")
            //     ->sortable(),
            // Column::make("Urban Name", "getUrban.urban_body_name")
            //     ->sortable(),
            // Column::make("Ward Name", "ward_code")
            //     ->sortable(),
            Column::make("Office address", "office_address")
                ->sortable(),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }
    public function builder(): Builder
    {
        return Office::query()
                    ->where('offices.department_id', Auth::user()->department_id);
    }
}
