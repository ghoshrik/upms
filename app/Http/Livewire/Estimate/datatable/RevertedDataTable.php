<?php

namespace App\Http\Livewire\Estimate\Datatable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\EstimatePrepare;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class RevertedDataTable extends DataTableComponent
{
    public function configure(): void
    {
        $this->setPrimaryKey('estimate_id');
        // $this->setDebugEnabled();
    }

    public function columns(): array
    {

        return [
            // Column::make("Id", "id")
            //     ->sortable(),
            Column::make("Estimate no", "estimate_id")
                ->searchable()
                ->sortable(),
            Column::make("DESCRIPTION", "SOR.sorMasterDesc")
                ->searchable()
                ->sortable(),
            Column::make("TOTAL AMOUNT", "total_amount")
                ->format(fn ($row) => round($row, 10, 2))
                ->sortable(),
            Column::make("Status","SOR.getEstimateStatus.status")
                ->sortable()
                ->format( fn($row) => '<span class="badge bg-soft-warning text-dark fs-6">'.$row.'</span>')
                    ->html(),
            Column::make("Actions", "estimate_id")
            ->format(
                fn($value, $row, Column $column) => view('livewire.action-components.estimate-prepare.reverted-table-buttons')->withValue($value))
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
        ->join('estimate_user_assign_records','estimate_user_assign_records.estimate_id','=','estimate_prepares.estimate_id')
        ->join('sor_masters','sor_masters.estimate_id','=','estimate_prepares.estimate_id')
        ->where('estimate_user_assign_records.estimate_user_type','=',2)
        ->where('sor_masters.status',3)
        ->where('operation', 'Total')
            ->where('created_by',Auth::user()->id);
        // ->groupBy('estimate_id.estimate_id');
    }
}
