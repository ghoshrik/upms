<?php

namespace App\Http\Livewire\VendorRegs;

use Livewire\Component;

class VendorList extends Component
{
    public $formOpen = false,$updateDataTableTracker;
    protected $listeners = ['openForm' => 'formOCControl'];
    public function formOCControl()
    {
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
        $this->updateDataTableTracker = rand(1,1000);
    }
    public function mount()
    {
        $this->updateDataTableTracker = rand(1,1000);
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1,1000);
        $this->emit('changeTitel', trans('cruds.vendors.menu_title'));
        $assets = ['chart', 'animation'];
        return view('livewire.vendor-regs.vendor-list',compact('assets'));
    }
}
