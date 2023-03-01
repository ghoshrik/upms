<?php

namespace App\Http\Livewire\Tender;

use Livewire\Component;

class Tenders extends Component
{
    public $formOpen = false,$updateDataTableTracker;
    protected $listeners = ['openForm' => 'formOCControl'];
    public $titel = 'Tenders';
    public $subTitel='List';
    public function formOCControl()
    {
        $this->formOpen = !$this->formOpen;
        // $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
        // $this->isFromOpen = !$this->isFromOpen;
        $this->subTitel =  ($this->formOpen) ? 'Create' : 'List';
        $this->updateDataTableTracker = rand(1,1000);
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1,1000);
        // $this->emit('changeTitel', trans('cruds.vendors.menu_title'));
        $assets = ['chart', 'animation'];
        return view('livewire.tender.tenders',compact('assets'));
    }
}
