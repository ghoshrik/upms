<?php

namespace App\Http\Livewire\Department;

use Livewire\Component;

class Department extends Component
{
    public $formOpen = false,$updateDataTableTracker;
    protected $listeners = ['openForm' => 'formOCControl'];
    public function formOCControl()
    {
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
        $this->updateDataTableTracker = rand(1,1000);
    }
    public function render()
    {
        $this->emit('changeTitel', 'Department');
        $assets = ['chart', 'animation'];
        return view('livewire.department.department',compact('assets'));
    }
}
