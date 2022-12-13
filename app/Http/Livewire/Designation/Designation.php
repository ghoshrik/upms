<?php

namespace App\Http\Livewire\Designation;

use Livewire\Component;

class Designation extends Component
{
    public $updateMode = false;
    public $formOpen=false;
    protected $listeners = ['openForm' => 'formOCControl'];
    public function formOCControl()
    {
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitle', ($this->formOpen)?'Create new':'List');
    }
    public function render()
    {
        $assets = ['chart', 'animation'];
        $this->emit('changeTitle', 'Designation');
        return view('livewire.designation.designation',compact('assets'));
    }
}
