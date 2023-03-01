<?php

namespace App\Http\Livewire\DataTable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Aoc;

class AocDataTable extends DataTableComponent
{
    protected $model = Aoc::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Project no", "project_no")
                ->sortable(),
            Column::make("Go id", "go_id")
                ->sortable(),
            Column::make("Vendor id", "vendor_id")
                ->sortable(),
            Column::make("Approved date", "approved_date")
                ->sortable(),
            Column::make("Amount", "amount")
                ->sortable(),
            Column::make("Status", "status")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
