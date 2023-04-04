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
            Column::make("Office Level", "level_no")
                ->format(function ($value, $column, $row) {
                    switch ($value) {
                        case 1:
                            return '<span class="badge bg-primary text-dark">Level 1 Office </span>';
                            break;
                        case 2:
                            return '<span class="badge bg-soft- secondary">Level 2 Office </span>';
                            break;
                        case 3:
                            return '<span class="badge bg-soft-success">Level 3 Office </span>';
                            break;
                        case 4:
                            return '<span class="badge bg-soft-info">Level 4 Office </span>';
                            break;
                        case 5:
                            return '<span class="badge bg-soft-warning">Level 5 Office </span>';
                            break;
                        default:
                            return '<span class="badge bg-soft-dark">Level 6 Office</span>';
                    }

                    // if ($value == 1) {
                    //     return '<span class="badge bg-primary text-dark">Level 1 Office </span>';
                    // } elseif ($value == 2) {
                    //     return '<span class="badge bg-soft- secondary">Level 2 Office </span>';
                    // } elseif ($value == 3) {
                    //     return '<span class="badge bg-soft-success">Level 3 Office </span>';
                    // } elseif ($value == 4) {
                    //     return '<span class="badge bg-soft-info">Level 4 Office </span>';
                    // } elseif ($value == 5) {
                    //     return '<span class="badge bg-soft-warning">Level 5 Office </span>';
                    // } else {
                    //     return '<span class="badge bg-soft-dark">Level 6 Office</span>';
                    // }
                })
                ->html()
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
