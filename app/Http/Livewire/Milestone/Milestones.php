<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use Livewire\Component;

class Milestones extends Component
{
    public $formOpen = false,$viewMode = false,$updateDataTableTracker,$milestones,$createButtonOn;
    protected $listeners = ['openForm' => 'formOCControl','mileStoneRow'=>'milestoneViewController'];
    public $openedFormType= false,$isFromOpen,$subTitel = "List",$selectedIdForEdit,$errorMessage,$titel = "Milestones";

    public function milestoneViewController($value)
    {
        $this->emit('changeSubTitel', ($this->subTitel) ? 'Create new' : 'View');
        $this->emit('changeTitel',($this->titel) ? 'UPMS':'MileStone');
        $this->emit('CloseButton',(!$this->createButtonOn));

        $this->viewMode = !$this->viewMode;
        // $this->milestones = $value;
        // $this->emit('ApprovedMilestone',$value);
        $this->milestones = Milestone::where('project_id',$value)->where('milestone_id',0)
        ->with('childrenMilestones')
        ->get();
        // dd($this->milestones);
    }

    public function fromEntryControl($data='')
    {
        // dd($data);
        $this->openedFormType = is_array($data) ? $data['formType']:$data;
        $this->isFromOpen = !$this->isFromOpen;
        switch ($this->openedFormType) {
            case 'create':
                $this->subTitel = 'Create';
                break;
            case 'edit':
                $this->subTitel = 'Edit';
                break;
            default:
                $this->subTitel = 'List';
                break;
        }
        if(isset($data['id'])){
            $this->selectedIdForEdit = $data['id'];
        }
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1,1000);
        $assets = ['chart', 'animation'];
        return view('livewire.milestone.milestones',compact('assets'));
    }
}
