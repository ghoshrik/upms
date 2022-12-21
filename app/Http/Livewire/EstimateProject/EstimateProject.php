<?php

namespace App\Http\Livewire\EstimateProject;

use Livewire\Component;

class EstimateProject extends Component
{
    public $formOpen = false, $editFormOpen = false;
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
    }
    public function render()
    {
        $this->emit('changeTitel', 'Estimate Project');
        $assets = ['chart', 'animation'];
        return view('livewire.estimate-project.estimate-project');
    }
}
