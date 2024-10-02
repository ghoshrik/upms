<?php

namespace App\Http\Livewire\Project\Plan;

use Livewire\Component;
use App\Models\ProjectCreation;

class ProjectPlan extends Component
{
    protected $listeners = ['refreshPlanTableData' => 'render'];
    public $selectedProjectId,$projectPlans, $project;

    // public function mount()
    // {
    //     $this->project = ProjectCreation::where('id', $this->selectedProjectId)->first();
    //     $this->projectPlans = $this->project->plans;
    // }
    public function addPlan()
    {
        $this->emit('openAddPlan');
    }
    public function addPlanDocument($planId)
    {
        $this->emit('openEntryForm',['formType'=> 'plan_document', 'id'=> $planId  , 'project_id' =>  $this->project->id ]);
    }
    public function render()
    {
        $this->project = ProjectCreation::where('id', $this->selectedProjectId)->first();
        $this->projectPlans = $this->project->plans;
        return view('livewire.project.plan.project-plan');
    }
}
