<?php

namespace App\Http\Livewire\MenuManagement;

use Livewire\Component;

class MenuManagement extends Component
{
    public $formOpen = false;
    protected $listeners = ['openForm' => 'formOCControl'];
    public function formOCControl($isEditFrom = false, $eidtId = null)
    {
        if ($isEditFrom) {
            $this->editFormOpen = !$this->editFormOpen;
            $this->emit('changeSubTitel', ($this->editFormOpen) ? 'Edit' : 'List');
            if ($eidtId != null) {
                $this->emit('editEstimateRow', $eidtId);
            }
            return;
        }
        $this->editFormOpen = false;
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
    }
    public function render()
    {
        $this->emit('changeTitel', 'Menu Managemant');
        $assets = ['chart', 'animation'];
        return view('livewire.menu-management.menu-management',compact('assets'));
    }
}
