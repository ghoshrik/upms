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
                ->searchable()
                ->sortable(),
            Column::make("DESCRIPTION", "SOR.sorMasterDesc")
                ->searchable()
                ->sortable(),
            Column::make("TOTAL AMOUNT", "total_amount")
                ->format(fn ($row) => round($row, 10, 2))
                ->sortable(),
            Column::make("Actions", "estimate_id")
            ->format(
                fn($value, $row, Column $column) => view('livewire.action-components.estimate-prepare.action-buttons')->withValue($value))
        ];
    }

    public function edit($id)
    {
        $this->emit('openForm', true, $id);
    }
    public function view($estimate_id)
    {
        $this->emit('openModal', $estimate_id);
    }
    public function forward($estimate_id)
    {
        $this->emit('openForwardModal',$estimate_id);
    }
    public function builder(): Builder
    {
        return EstimatePrepare::query()
            ->where('operation', 'Total');
            // ->where('created_by',Auth::user()->id);
        // ->groupBy('estimate_id.estimate_id');
    }
}
