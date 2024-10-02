<?php

namespace App\Http\Livewire\Project\Plan;

use App\Models\Plan;
use Livewire\Component;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CreateProjectPlan extends Component
{
    use Actions;
    protected $listeners = ['openAddPlan'];
    public $modal = false, $project, $title;

    public function openAddPlan()
    {
        $this->modal = !$this->modal;
    }
    public function store()
    {
        DB::beginTransaction();

        try {
            $insert = [
                'title' => $this->title,
                'project_creation_id' => $this->project->id,
                'department_id' => $this->project->department_id,
                'created_by' => Auth::user()->id,
            ];

            Plan::create($insert);
            $this->resetExcept('project');
            $this->emit('refreshPlanTableData');
            $this->notification()->success('Project Updated', 'Project details were updated successfully!');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->notification()->error('Error', 'There was an error updating the project: ' . $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.project.plan.create-project-plan');
    }
}
