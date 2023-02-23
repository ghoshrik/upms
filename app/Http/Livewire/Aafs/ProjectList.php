<?php

namespace App\Http\Livewire\Aafs;

use Livewire\Component;

class ProjectList extends Component
{

    public $formOpen=false,$updateDataTableTracker;
    protected $listeners = ['openForm' => 'formOCControl'];
    public function formOCControl()
    {
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitle', ($this->formOpen)?'Create new':'List');
        $this->updateDataTableTracker = rand(1,1000);
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1,1000);
        $assets = ['chart', 'animation'];
        $this->emit('changeTitle', 'Designation');
        return view('livewire.aafs.project-list',compact('assets'));
    }
}
