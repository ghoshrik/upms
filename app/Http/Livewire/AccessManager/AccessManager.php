<?php

namespace App\Http\Livewire\AccessManager;

use Livewire\Component;

class AccessManager extends Component
{
    public $formOpen=false,$editFormOpen=false;
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
        $this->emit('changeTitel', 'Access Manager');
        $assets = ['chart', 'animation'];
        return view('livewire.access-manager.access-manager',compact('assets'));
    }
}
