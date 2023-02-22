<?php

namespace App\Http\Livewire\Aoc;

use Livewire\Component;

class Aocs extends Component
{

    public $formOpen = false,$titel,$subTitel;
    protected $listeners = ['openForm' => 'formOCControl'];
    public function formOCControl()
    {
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
    }
    public function render()
    {
        $assets = ['chart', 'animation'];
        return view('livewire.aoc.aocs',compact('assets'));
    }
}
