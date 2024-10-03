<?php

namespace App\Http\Livewire\Project\Plan;

use Livewire\Component;
use App\Models\ProjectCreation;
use WireUi\Traits\Actions;
class ProjectPlan extends Component
{
    use Actions;
    public $selectedProjectId, $project;
    public $formOpen = false;
    protected $listeners = ['refreshPlanTableData' => 'render', 'openEntryForm' => 'fromEntryControl', 'showError' => 'setErrorAlert'];
    public $openedFormType = false, $isFromOpen, $subTitel = "List", $errorMessage, $title;
    protected $projectPlans = [];
    protected $rules = [
        'name' => 'required|string|max:255',
    ];
    public function addPlan()
    {
        $this->emit('openAddPlan');
    }
    public function addPlanDocument($planId)
    {
        $this->emit('openEntryForm', ['formType' => 'plan_document', 'id' => $planId, 'project_id' => $this->project->id]);
    }
    public function fromEntryControl($data = '')
    {
        $this->openedFormType = is_array($data) ? $data['formType'] : $data;
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
        if (isset($data['id'])) {
            // dd($data['id']);
            $this->emit('openAddPlan', $data['id']);
        }
    }
    public function deleteplan($id)
    {
        $plan = $this->project->plans()->find($id);
        if ($plan) {
            try {
                $plan->delete();
                $this->notification()->success('Deleted successfully');
            } catch (\Exception $e) {
                $this->notification()->error('Delete References first!');
            }
        } else {
            $this->notification()->error('Plan not found. Not deleted.');
        }
        $this->emit('refreshPlanTableData');
    }




    public function render()
    {
        $this->project = ProjectCreation::where('id', $this->selectedProjectId)->first();
        $this->projectPlans = $this->project->plans()->paginate(25);
        return view('livewire.project.plan.project-plan', [
            'projectPlans' => $this->projectPlans,
            'project' => $this->project,
        ]);
    }

}
