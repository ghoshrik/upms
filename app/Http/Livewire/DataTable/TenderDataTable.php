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
            Column::make(trans('cruds.tenders.fields.project_id'), "project_no")
                ->sortable(),
            Column::make(trans('cruds.tenders.fields.tender_id'), "tender_id")
                ->sortable(),
            Column::make(trans('cruds.tenders.fields.tender_title'), "tender_title")
                ->sortable(),
            Column::make(trans('cruds.tenders.fields.tender_amount'), "tender_amount")
                ->sortable(),
            Column::make(trans('cruds.tenders.fields.date_of_pub'), "publish_date")
                ->sortable(),
            Column::make(trans('cruds.tenders.fields.date_of_close'), "close_date")
                ->sortable(),
            Column::make(trans('cruds.tenders.fields.num_bider'), "bidder_name")
                ->sortable(),
            Column::make(trans('cruds.tenders.fields.tender_category'), "tender_category")
                ->sortable(),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }
}
