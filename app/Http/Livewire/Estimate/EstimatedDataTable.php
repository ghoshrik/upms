<?php

namespace App\Http\Livewire\Estimate;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use App\Models\EstimatePrepare;

class EstimatedDataTable extends DataTableComponent
{
    protected $model = EstimatePrepare::class;

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
            Column::make("Estimate Total","total_amount")
            ->sortable(),
            // Column::make("Row index", "row_index")
            //     ->sortable(),
            // Column::make("Sor item number", "sor_item_number")
            //     ->sortable(),
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
}
