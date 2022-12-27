<?php

namespace App\Http\Livewire\Milestone;

use Livewire\Component;

class MilestoneLists extends Component
{
    public $formOpen = false;
    protected $listeners = ['openForm' => 'formOCControl'];
    public function formOCControl()
    {
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
    }
    public function render()
    {
        $this->emit('changeTitle', 'Milestone');
        $assets = ['chart', 'animation'];
        return view('livewire.milestone.milestone-lists',compact('assets'));
    }
}
