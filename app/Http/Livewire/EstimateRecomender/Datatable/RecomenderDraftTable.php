<?php

namespace App\Http\Livewire\EstimateRecomender\Datatable;

use App\Models\Esrecommender;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\EstimatePrepare;
use App\Models\SorMaster;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class RecomenderDraftTable extends DataTableComponent
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
            Column::make("Estimator Cost", "total_amount")
                ->format(fn ($row) => round($row, 10, 2))
                ->sortable(),
            Column::make("Recomender Cost", "estimate_id")
                ->format(fn($value, $row, Column $column) => view('livewire.components.data-table-view.estimate-recomender.recomender-cost')->withValue($value))
                ->sortable(),
            Column::make("Status","SOR.getEstimateStatus.status")
                ->sortable()
                ->format( fn($row) => '<span class="badge bg-primary fs-6">'.$row.'</span>')
                ->html(),
            Column::make("Remarks","comments"),
            Column::make("Actions", "estimate_id")
            ->format(
                fn($value, $row, Column $column) => view('livewire.action-components.estimate-recomender.draft-table-buttons')->withValue($value))
        ];
    }
    public $buttonGroupOpen = false;
    public function buttonGroup($estimate_id)
    {
        $this->buttonGroupOpen = !$this->buttonGroupOpen;
        // $this->emit('openButton',$estimate_id);
        // dd($this->emit('openButton',$estimate_id));
    }
    public function modify($id)
    {
        $this->emit('openForm', ['formType'=>'modify', 'id'=>$id]);
    }
    public function view($estimate_id)
    {
        $checkForView = SorMaster::select('status')->where('estimate_id',$estimate_id)->first();
        if($checkForView['status'] == 2)
        {
            $this->emit('openModal', $estimate_id);
        }else{
            $this->emit('openVerifiedEstimateViewModal', $estimate_id);
        }

    }
    public function verify($estimate_id)
    {
        $this->emit('openVerifyModal', $estimate_id);
    }
    public function approveEstimate($estimate_id)
    {
        $this->emit('openApproveModal', $estimate_id);
    }
    public function revert($estimate_id)
    {
        $this->emit('openRevertModal',['estimate_id'=>$estimate_id,'revart_from'=>'ER']);
    }
    public function fwd($estimate_id)
    {
        $this->emit('openForwdModal',['estimate_id'=>$estimate_id,'forwd_from'=>'ER']);
    }
    public function builder(): Builder
    {
        return EstimatePrepare::query()
        // $a= EstimatePrepare::query()
            ->join('estimate_user_assign_records','estimate_user_assign_records.estimate_id','=','estimate_prepares.estimate_id')
            ->join('sor_masters','sor_masters.estimate_id','=','estimate_prepares.estimate_id')
            ->where('operation', 'Total')
            ->where(function($query){
                $query->where('estimate_user_assign_records.user_id',Auth::user()->id)
                ->orWhere('estimate_user_assign_records.assign_user_id',Auth::user()->id);
            })
            // ->where('estimate_user_assign_records.estimate_user_type','=',3)
            ->where('sor_masters.is_verified','=',0)
            ->where(function($query){
                $query->where('sor_masters.status',2)
                ->orWhere('sor_masters.status',4)
                ->orWhere('sor_masters.status',6);
            })
            ->where('estimate_user_assign_records.is_done',0);
            // dd($a->get());
    }
}
