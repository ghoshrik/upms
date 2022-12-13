<?php

namespace App\Http\Livewire\Sor\DataTable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\SOR;

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
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Item details", "item_details")
                ->sortable(),
            Column::make("Department id", "department_id")
                ->sortable(),
            Column::make("Dept category id", "dept_category_id")
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
            Column::make("IsActive", "IsActive")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
