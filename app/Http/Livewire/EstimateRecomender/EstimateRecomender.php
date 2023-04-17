<?php

namespace App\Http\Livewire\EstimateRecomender;

use App\Models\EstimateUserAssignRecord;
use App\Models\SorMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use WireUi\Traits\Actions;

class EstimateRecomender extends Component
{
    use Actions;
    public $formOpen = false, $modifyFormOpen = false, $updateDataTableTracker, $selectedEstTab = 1, $counterData = [];
    protected $listeners = ['openForm' => 'fromEntryControl','refreshData' => 'mount','showError'=>'setErrorAlert'];
    public $openedFormType= false,$isFromOpen,$subTitel = "List",$selectedIdForEdit,$errorMessage,$titel;
    public function mount()
    {
        $this->draftData();
    }
    public function draftData()
    {
        $this->selectedEstTab = '';
        $this->selectedEstTab = 1;
        $this->dataCounter();
    }
    public function verifiedData()
    {
        $this->selectedEstTab = '';
        $this->selectedEstTab = 2;
        $this->dataCounter();
    }
    public function revertedData()
    {
        $this->selectedEstTab = '';
        $this->selectedEstTab = 3;
        $this->dataCounter();
        // $this->notification()->error(
        //     $title = 'Estimate Revert is under devlopment'
        // );
    }

    public function dataCounter()
    {
        $this->counterData['totalPendingDataCount'] = EstimateUserAssignRecord::where(function($query){
            $query->where('status',2)
            ->orWhere('status',4)
            ->orWhere('status',6)
            ->orWhere('status',7)
            ->orWhere('status',9);
        })
        ->where(function($query){
            $query->where('user_id',Auth::user()->id)
            ->orWhere('assign_user_id',Auth::user()->id);
        })
        ->count();
        $this->counterData['pendingDataCount'] = EstimateUserAssignRecord::where(function($query){
            $query->where('status',2)
            ->orWhere('status',4)
            ->orWhere('status',6);
        })
        ->where(function($query){
            $query->where('user_id',Auth::user()->id)
            ->orWhere('assign_user_id',Auth::user()->id);
        })
        ->where('is_done',0)
        ->count();
        $this->counterData['forwardedDataCount'] =  DB::table('estimate_user_assign_records as t1')
        ->select(DB::raw('count(t1.status)'))
        ->where('t1.status', 2)
        ->where('t1.user_id', 2003)
        ->where('t1.created_at', function ($query) {
            $query->selectRaw('max(t2.created_at)')
                ->from('estimate_user_assign_records as t2')
                ->where('t2.status', 2)
                ->whereColumn('t2.estimate_id', 't1.estimate_id');
        })
        ->count();
        $this->counterData['revertedDataCount'] = EstimateUserAssignRecord::where('status',7)
        ->where('assign_user_id',Auth::user()->id)
        ->where('is_done',0)
        ->count();
    }
    public function fromEntryControl($data='')
    {
        $this->openedFormType = is_array($data) ? $data['formType']:$data;
        $this->isFromOpen = !$this->isFromOpen;
        switch ($this->openedFormType) {
            case 'modify':
                $this->subTitel = 'Modify';
                break;
            default:
                $this->subTitel = 'List';
                break;
        }
        if(isset($data['id'])){
            // $this->selectedIdForEdit = $data['id'];
            $this->emit('modifyEstimateRow',$data['id']);
        }
        $this->updateDataTableTracker = rand(1, 1000);
    }
    public function setErrorAlert($errorMessage)
    {
       $this->errorMessage = $errorMessage;
    }
    public function formOCControl($isModifyFrom = false, $eidtId = null)
    {
        if ($isModifyFrom) {
            $this->modifyFormOpen = !$this->modifyFormOpen;
            $this->emit('changeSubTitel', ($this->modifyFormOpen) ? 'Modify' : 'List');
            if ($eidtId != null) {
                $this->emit('modifyEstimateRow', $eidtId);
            }
            return;
        }
        $this->modifyFormOpen = false;
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');

    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        $this->titel= 'Estimate Recomender';
        return view('livewire.estimate-recomender.estimate-recomender');
    }
}
