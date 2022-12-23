<?php

namespace App\Http\Livewire\EstimateRecomender;

use Livewire\Component;

class EstimateRecomender extends Component
{
    public $formOpen = false, $editFormOpen = false,$updateDataTableTracker,$selectedTab = 1,$counterData=[];
    protected $listeners = ['openForm' => 'formOCControl'];
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
        $this->emit('changeTitel', 'Estimate Recomender');
        return view('livewire.estimate-recomender.estimate-recomender');
    }
}
