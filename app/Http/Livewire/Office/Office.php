<?php

namespace App\Http\Livewire\Office;

use Livewire\Component;

class Office extends Component
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
        $this->emit('changeTitel', 'Office');
        $assets = ['chart', 'animation'];
        return view('livewire.office.office',compact('assets'));
    }
}
