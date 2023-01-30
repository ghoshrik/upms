<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use Livewire\Component;

class Milestones extends Component
{

    public $formOpen = false,$viewMode = false,$updateDataTableTracker,$milestones,$titel,$subTitel,$createButtonOn;
    protected $listeners = ['openForm' => 'formOCControl','mileStoneRow'=>'milestoneViewController'];

    public function milestoneViewController($value)
    {
        $this->emit('changeSubTitel', ($this->subTitel) ? 'Create new' : 'View');
        $this->emit('changeTitel',($this->titel) ? 'UPMS':'MileStone');
        $this->emit('CloseButton',(!$this->createButtonOn));

        $this->viewMode = !$this->viewMode;
        $this->milestones = Milestone::where('milestone_id',0)->where('project_id',$value)
        ->with('childrenMilestones')
        ->get();
        $this->emit('testTree',$this->milestones);

    }
    public function formOCControl()
    {
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1,1000);
        $this->emit('changeTitle', 'Milestone');
        $assets = ['chart', 'animation'];
        return view('livewire.milestone.milestones',compact('assets'));
    }
}
