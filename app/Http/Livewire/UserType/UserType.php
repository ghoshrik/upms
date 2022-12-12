<?php

namespace App\Http\Livewire\UserType;

use Livewire\Component;

class UserType extends Component
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
        $this->emit('changeTitel', 'User Type');
        $assets = ['chart', 'animation'];
        return view('livewire.user-type.user-type', compact('assets'));
    }
}
