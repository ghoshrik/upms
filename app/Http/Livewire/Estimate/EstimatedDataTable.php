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
use Rappasoft\LaravelLivewireTables\Views\Filter;

class EstimatedDataTable extends DataTableComponent
{
    // protected $model = EstimatePrepare::class;

    public function configure(): void
    {
        $this->setPrimaryKey('estimate_id');
    }

    public function columns(): array
    {

        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Estimate no", "estimate_id")
                ->sortable(),
            Column::make("DESCRIPTION", "SOR.sorMasterDesc")
            ->sortable(),
            Column::make("TOTAL AMOUNT", "total_amount")
            ->sortable(),

            Column::make("Actions", "estimate_id")->view('components.data-table-components.buttons.edit'),
        ];
    }

    public function edit($id)
    {
        $this->emit('openForm',true,$id);
    }
    public function builder(): Builder
    {
        return EstimatePrepare::query()
        ->where('operation','Total');
        // ->groupBy('estimate_id.estimate_id');
    }
}
