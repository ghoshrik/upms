<?php

namespace App\Http\Livewire\Milestone;

use App\Models\MileStone;
use Livewire\Component;

class MilestoneLists extends Component
{
    public $formOpen = false;
    protected $listeners = ['openForm' => 'formOCControl'];


    public function mileStoneView($id)
    {
        dd($id);
    }

    public function formOCControl()
    {
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
    }
    public function render()
    {
        $mileStone = MileStone::select('project_id')->groupBy('project_id')->get();
        $this->emit('changeTitle', 'Milestone');
        $assets = ['chart', 'animation'];
        return view('livewire.milestone.milestone-lists',compact('assets','mileStone'));
    }
}
