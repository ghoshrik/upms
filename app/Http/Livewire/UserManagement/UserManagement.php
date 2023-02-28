<?php

namespace App\Http\Livewire\UserManagement;

use Livewire\Component;

class UserManagement extends Component
{
    public $formOpen=false,$updateDataTableTracker;
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
        $this->updateDataTableTracker = rand(1,1000);
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
    }
    public function render()
    {
        $this->emit('changeTitel', 'User Managemant');
        $assets = ['chart', 'animation'];
        return view('livewire.user-management.user-management',compact('assets'));
    }
}
