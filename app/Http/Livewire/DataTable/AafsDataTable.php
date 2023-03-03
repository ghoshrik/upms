<?php

namespace App\Http\Livewire\DataTable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\AAFS;

class AafsDataTable extends DataTableComponent
{
    protected $model = AAFS::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Project id", "project_id")
                ->sortable(),
            Column::make("Go id", "Go_id")
                ->sortable(),
            Column::make("Support data", "support_data")
                ->sortable(),
            Column::make("Status", "status")
                ->sortable(),
            Column::make("Go date", "go_date")
                ->sortable(),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }
}
