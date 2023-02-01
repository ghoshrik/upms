<?php

namespace App\Http\Livewire\EstimateProject;

use App\Models\SorMaster;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EstimateProject extends Component
{
    public $formOpen = false, $editFormOpen = false,$updateDataTableTracker,$selectedTab = 1,$counterData=[];
    protected $listeners = ['openForm' => 'formOCControl'];
    public function mount()
    {
        $this->draftData();
    }
    public function draftData()
    {
        $this->selectedTab = '';
        $this->selectedTab = 1;
        $this->dataCounter();
    }
    public function forwardedData()
    {
        $this->selectedTab = '';
        $this->selectedTab = 2;
        $this->dataCounter();
    }
    public function revertedData()
    {
        $this->selectedTab = '';
        $this->selectedTab = 3;
        $this->dataCounter();
    }
    public function dataCounter()
    {
        $this->counterData['totalDataCount'] = SorMaster::join('estimate_user_assign_records','estimate_user_assign_records.estimate_id','=','sor_masters.estimate_id')
        ->where('estimate_user_assign_records.estimate_user_id','=',Auth::user()->id)
        ->where('estimate_user_assign_records.estimate_user_type','=',3)
        ->count();
        $this->counterData['draftDataCount'] = SorMaster::join('estimate_user_assign_records','estimate_user_assign_records.estimate_id','=','sor_masters.estimate_id')
        ->where('estimate_user_assign_records.estimate_user_id','=',Auth::user()->id)
        ->where('estimate_user_assign_records.estimate_user_type','=',3)
        ->where('sor_masters.status','=',1)
        ->count();
        $this->counterData['forwardedDataCount'] =  SorMaster::join('estimate_user_assign_records','estimate_user_assign_records.estimate_id','=','sor_masters.estimate_id')
        ->where('estimate_user_assign_records.estimate_user_id','=',Auth::user()->id)
        ->where('estimate_user_assign_records.estimate_user_type','=',3)
        ->where('sor_masters.status','!=',1)
        ->count();
        $this->counterData['revertedDataCount'] = SorMaster::join('estimate_user_assign_records','estimate_user_assign_records.estimate_id','=','sor_masters.estimate_id')
        ->where('estimate_user_assign_records.estimate_user_id','=',Auth::user()->id)
        ->where('estimate_user_assign_records.estimate_user_type','=',3)
        ->where('sor_masters.status','=',3)
        ->count();
    }
    public function formOCControl($isEditFrom = false, $eidtId = null)
    {
        if ($isEditFrom) {
            $this->editFormOpen = !$this->editFormOpen;
            $this->emit('changeSubTitel', ($this->editFormOpen) ? 'Edit' : 'List');
            if ($eidtId != null) {
                $this->emit('editEstimateRow',$eidtId);
            }
            return;
        }
        $this->editFormOpen = false;
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
        $this->updateDataTableTracker = rand(1,1000);
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1,1000);
        $this->emit('changeTitel', 'Estimate Project');
        $assets = ['chart', 'animation'];
        return view('livewire.estimate-project.estimate-project');
    }
}
