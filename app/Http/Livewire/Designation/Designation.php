<?php

namespace App\Http\Livewire\Designation;

use Livewire\Component;

class Designation extends Component
{
    public $updateMode = false;
    public $formOpen=false,$editFormOpen = false,$updatedDataTableTracker;
    protected $listeners = ['openForm' => 'formOCControl'];

    public function mount()
    {
        $this->updatedDataTableTracker = rand(1,1000);
    }
    public function formOCControl($isEditFrom = false, $editId = null)
    {
        if ($isEditFrom) {
            $this->editFormOpen = !$this->editFormOpen;
            $this->emit('changeSubTitel', ($this->editFormOpen) ? 'Edit' : 'List');
            if ($editId != null) {
                $this->emit('editDesignationRow',$editId);
            }
            return;
        }
        $this->editFormOpen = false;
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitle', ($this->formOpen)?'Create new':'List');
        $this->updatedDataTableTracker = rand(1,1000);
    }
    public function render()
    {
        $assets = ['chart', 'animation'];
        $this->emit('changeTitle', 'Designation');
        return view('livewire.designation.designation',compact('assets'));
    }
}
