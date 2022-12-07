<?php

namespace App\Http\Livewire\Estimate;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use App\Models\EstimatePrepare;
use App\Models\SorMaster;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class EstimatedDataTable extends DataTableComponent
{
    protected $model = SorMaster::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {

        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Estimate no", "estimate_id")
                ->sortable(),
            Column::make("DESCRIPTION", "sorMasterDesc"),

            Column::make("ESTIMATE TOTAL", "estimate_id")
                ->format(
                    fn ($value, $row, Column $column) => view('es')->withValue($value)
                ),
            Column::make("status", "status")
                ->sortable(),
            // Column::make("Estimate no", "estimate_no")
            //     ->sortable(),
            // Column::make("Item name", "item_name")
            //     ->sortable(),
            // Column::make("Other name", "other_name")
            //     ->sortable(),
            // Column::make("Qty", "qty")
            //     ->sortable(),
            // Column::make("Rate", "rate")
            //     ->sortable(),
            // Column::make("Total amount", "total_amount")
            //     ->sortable(),
            // Column::make("Percentage rate", "percentage_rate")
            //     ->sortable(),
            // Column::make("Operation", "operation")
            //     ->sortable(),
            // Column::make("Created by", "created_by")
            //     ->sortable(),
            // Column::make("Comments", "comments")
            //     ->sortable(),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
            ButtonGroupColumn::make('Actions')
                ->attributes(function ($row) {
                    return [
                        'class' => 'space-x-2',
                    ];
                })
                ->buttons([
                    LinkColumn::make('Edit') // make() has no effect in this case but needs to be set anyway
                        ->title(fn ($row) => 'Edit ' . $row->name)
                        ->location(fn ($row) => route('designation', $row))
                        ->attributes(function ($row) {
                            return [
                                'target' => '_blank',
                                'class' => 'btn btn-soft-warning'
                            ];
                        }),
                ]),
        ];
    }
    public function builder(): Builder
    {
        $result = SorMaster::query()
            ->join('estimate_user_assign_records', 'estimate_user_assign_records.estimate_id', '=', 'sor_masters.estimate_id')
            ->join('estimate_prepares', 'estimate_prepares.estimate_id', '=', 'sor_masters.estimate_id')
            ->where('estimate_prepares.operation', 'Total')
            ->where('estimate_user_assign_records.estimate_user_id', '=', Auth::user()->id)
            ->where('estimate_user_assign_records.estimate_user_type', '=', 2)
            ->where('sor_masters.status', '=', 1);
            // dd($result->get());
        return $result;
    }
}
