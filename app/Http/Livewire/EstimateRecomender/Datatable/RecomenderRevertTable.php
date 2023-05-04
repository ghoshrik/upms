<?php

namespace App\Http\Livewire\EstimateRecomender\Datatable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Esrecommender;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class RecomenderRevertTable extends DataTableComponent
{
    // protected $model = Esrecommender::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Estimate no", "estimate_id")
                ->searchable()
                ->sortable(),
            Column::make("DESCRIPTION", "SOR.sorMasterDesc")
                ->searchable()
                ->sortable(),
            Column::make("TOTAL AMOUNT", "total_amount")
                ->format(fn ($row) => round($row, 10, 2))
                ->sortable(),
            Column::make("Status", "SOR.getEstimateStatus.status")
                ->sortable()
                ->format(fn ($row) => '<span class="badge bg-success fs-6">' . $row . '</span>')
                ->html(),
            Column::make("Remarks","estimate_id")
                ->format(fn($value, $row, Column $column) => view('livewire.components.data-table-view.estimate-recomender.revert-estimate-remarks')->withValue($value)),
            Column::make("Actions", "estimate_id")
                ->format(
                    fn ($value, $row, Column $column) => view('livewire.action-components.estimate-recomender.verify-table-buttons')->withValue($value)
                )
        ];
    }
    public function view($estimate_id)
    {
        $this->emit('openVerifiedEstimateViewModal', $estimate_id);
    }
    public function modify($id)
    {
        $this->emit('openForm', ['formType'=>'modify', 'id'=>$id]);
    }
    public function revert($estimate_id)
    {
        $this->emit('openRevertModal',['estimate_id'=>$estimate_id,'revart_from'=>'ER']);
    }
    public function builder(): Builder
    {
        return Esrecommender::query()
            ->join('estimate_user_assign_records', 'estimate_user_assign_records.estimate_id', '=', 'estimate_recomender.estimate_id')
            ->join('sor_masters', 'sor_masters.estimate_id', '=', 'estimate_recomender.estimate_id')
            ->where('operation', 'Total')
            ->where('estimate_user_assign_records.assign_user_id', '=', Auth::user()->id)
            // ->where('estimate_user_assign_records.estimate_user_type', '=', 3)
            // ->where('sor_masters.is_verified','=',0);
            ->where([['estimate_user_assign_records.status', '=', 7], ['estimate_user_assign_records.is_done', '=', 0]]);
        // ->groupBy('estimate_id.estimate_id');
    }
}
