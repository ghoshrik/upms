<?php

namespace App\Http\Livewire\EstimateForwarder\Datatable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Esrecommender;
use App\Services\CommonFunction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class VerifiedEstimateForwardDatatable extends DataTableComponent
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
            Column::make("Remarks", "SOR.userAR.comments")
                ->searchable()
                ->sortable(),
            Column::make("Estimator Cost", "total_amount")
                ->format(fn ($row) => round($row, 10, 2))
                ->sortable(),
            Column::make("Status","SOR.getEstimateStatus.status")
                ->sortable()
                ->format( fn($row) => '<span class="badge bg-primary fs-6">'.$row.'</span>')
                ->html(),
            Column::make("Actions", "estimate_id")
            ->format(
                fn($value, $row, Column $column) => view('livewire.action-components.estimate-forwarder.verify-table-buttons')->withValue($value))
        ];
    }
    public function view($estimate_id)
    {
        $this->emit('openVerifiedEstimateViewModal', $estimate_id);
    }
    public function downloadWord($estimate_id)
    {
         return response()->download(CommonFunction::exportWord($estimate_id,Esrecommender::class))->deleteFileAfterSend(true);
    }
    public function builder(): Builder
    {
        return Esrecommender::query()
            ->join('estimate_user_assign_records','estimate_user_assign_records.estimate_id','=','estimate_recomender.estimate_id')
            ->join('estimate_masters','estimate_masters.estimate_id','=','estimate_recomender.estimate_id')
            ->where('operation', 'Total')
            ->where('estimate_user_assign_records.user_id','=',Auth::user()->id)
            // ->where('estimate_user_assign_records.estimate_user_type','=',8)
            ->where('estimate_user_assign_records.status',8)
            ->where('estimate_masters.is_verified','=',1);
    }
}
