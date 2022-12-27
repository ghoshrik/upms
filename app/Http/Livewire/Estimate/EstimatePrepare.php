<?php

namespace App\Http\Livewire\Estimate;

use App\Models\SORCategory;
use App\Models\SorMaster;
use App\View\Components\AppLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class EstimatePrepare extends Component
{

    public $formOpen = false, $editFormOpen = false,$updateDataTableTracker,$selectedTab = 1,$counterData=[];
    protected $listeners = ['openForm' => 'formOCControl'];
    public function mount()
    {
        $a = SorMaster::with('estimate')->get();
        // dd($a);
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
        $this->counterData['draftDataCount'] = SorMaster::join('estimate_user_assign_records','estimate_user_assign_records.estimate_id','=','sor_masters.estimate_id')
        ->where('estimate_user_assign_records.estimate_user_id','=',Auth::user()->id)
        ->where('estimate_user_assign_records.estimate_user_type','=',2)
        ->where('sor_masters.status','=',1)
        ->count();
        $this->counterData['forwardedDataCount'] =  SorMaster::join('estimate_user_assign_records','estimate_user_assign_records.estimate_id','=','sor_masters.estimate_id')
        ->where('estimate_user_assign_records.estimate_user_id','=',Auth::user()->id)
        ->where('estimate_user_assign_records.estimate_user_type','=',2)
        ->where('sor_masters.status','=',2)
        ->count();
        $this->counterData['revertedDataCount'] = SorMaster::join('estimate_user_assign_records','estimate_user_assign_records.estimate_id','=','sor_masters.estimate_id')
        ->where('estimate_user_assign_records.estimate_user_id','=',Auth::user()->id)
        ->where('estimate_user_assign_records.estimate_user_type','=',2)
        ->where('status','=',3)
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
        $this->emit('changeTitel', 'Estimate Prepare');
        $assets = ['chart', 'animation'];
        return view('livewire.estimate.estimate-prepare', compact('assets'));
    }
}
