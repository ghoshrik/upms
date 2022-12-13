<?php

namespace App\Http\Livewire\Sor;

use Livewire\Component;

class Sor extends Component
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
        $this->emit('changeTitel', 'SOR');
        $assets = ['chart', 'animation'];
        return view('livewire.sor.sor',compact('assets'));
    }
}
