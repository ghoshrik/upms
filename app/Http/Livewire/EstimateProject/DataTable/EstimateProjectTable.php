<?php

namespace App\Http\Livewire\EstimateProject\DataTable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use App\Models\EstimatePrepare;
use App\Models\SorMaster;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class EstimateProjectTable extends DataTableComponent
{
    protected $model = EstimatePrepare::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            // Column::make("Id", "id")
            //     ->sortable(),
            Column::make("Estimate no", "estimate_id")
                ->sortable()
                ->searchable(),
            Column::make("DESCRIPTION", "SOR.sorMasterDesc")
                ->sortable()
                ->searchable(),
            Column::make("TOTAL AMOUNT", "total_amount")
                ->format(fn ($row) => round($row, 10, 2))
                ->sortable(),

            Column::make("Actions", "estimate_id")->view('components.data-table-components.buttons.edit'),
        ];
    }
    public function edit($id)
    {
        $this->emit('openForm', true, $id);
    }
    public function builder(): Builder
    {
        return EstimatePrepare::query()
            ->where('operation', 'Total')->where('estimate_no', '!=', NULL);
        // ->groupBy('estimate_id.estimate_id');
    }
}
