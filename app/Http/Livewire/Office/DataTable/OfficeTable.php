<?php

namespace App\Http\Livewire\Office\DataTable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Office;

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
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Office name", "office_name")
                ->sortable(),
            Column::make("Department id", "department_id")
                ->sortable(),
            Column::make("Dist code", "dist_code")
                ->sortable(),
            Column::make("In area", "In_area")
                ->sortable(),
            Column::make("Rural block code", "rural_block_code")
                ->sortable(),
            Column::make("Gp code", "gp_code")
                ->sortable(),
            Column::make("Urban code", "urban_code")
                ->sortable(),
            Column::make("Ward code", "ward_code")
                ->sortable(),
            Column::make("Office address", "office_address")
                ->sortable(),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }
}
