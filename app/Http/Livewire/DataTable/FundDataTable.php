<?php

namespace App\Http\Livewire\DataTable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Fundapprove;

class FundDataTable extends DataTableComponent
{
    protected $model = Fundapprove::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make(trans('cruds.funds.fields.project_id'), "getProjectDetails.estimate_id")
                ->sortable(),
            Column::make(trans('cruds.funds.fields.go_id'), "go_id")
                ->sortable(),
            Column::make(trans('cruds.funds.fields.vendor_id'), "getVendorDetails.comp_name")
                ->sortable(),
            Column::make(trans('cruds.funds.fields.approved_date'), "approved_date")
                ->sortable(),
            Column::make(trans('cruds.funds.fields.amount'), "amount")
                ->sortable(),
            // Column::make(trans('cruds.funds.fields.status'), "status")
            //     ->sortable(),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }
}
