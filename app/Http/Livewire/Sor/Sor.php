<?php

namespace App\Http\Livewire\Sor;

use Livewire\Component;

class Sor extends Component
{
    public $formOpen = false ,$editFormOpen = false,$sorUpdateTrack;
    protected $listeners = ['openForm' => 'formOCControl'];

    public function mount()
    {
        $this->sorUpdateTrack = rand(1, 1000);
    }

    public function formOCControl($isEditFrom = false, $editId = null)
    {
        if ($isEditFrom) {
            $this->editFormOpen = !$this->editFormOpen;
            $this->emit('changeSubTitel', ($this->editFormOpen) ? 'Edit' : 'List');
            if ($editId != null) {
                $this->emit('editSorRow',$editId);
            }
            return;
        }
        $this->editFormOpen = false;
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
    }

    public function render()
    {
        $this->emit('changeTitel', 'SOR');
        $assets = ['chart', 'animation'];
        return view('livewire.sor.sor',compact('assets'));
    }
}
