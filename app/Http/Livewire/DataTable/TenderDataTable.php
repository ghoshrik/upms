<?php

namespace App\Http\Livewire\DataTable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Tender;

class TenderDataTable extends DataTableComponent
{
    protected $model = Tender::class;

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
            Column::make("Tender id", "tender_id")
                ->sortable(),
            Column::make("Tender title", "tender_title")
                ->sortable(),
            Column::make("Publish date", "publish_date")
                ->sortable(),
            Column::make("Close date", "close_date")
                ->sortable(),
            Column::make("Bidder name", "bidder_name")
                ->sortable(),
            Column::make("Tender category", "tender_category")
                ->sortable(),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }
}
