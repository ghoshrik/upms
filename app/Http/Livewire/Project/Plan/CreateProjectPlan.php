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
    public $modal = false, $project, $title, $editplanId;
    protected $rules = [
        'title' => 'required|string|max:255',
    ];
    public function openAddPlan($id = '')
    {
        $this->resetValidation();
        $this->modal = !$this->modal;
        if (!empty($id)) {
            $plan = Plan::find($id);
            if ($plan) {
                $this->editplanId = $id;
                $this->title = $plan->title;
            } else {
                $this->resetInput();
                $this->notification()->error('Error', 'Plan not found!');
            }
        } else {
            $this->resetInput();
        }
    }
    private function resetInput()
    {
        $this->editplanId = null;
        $this->title = '';
    }

    public function store()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            $data = [
                'title' => $this->title,
                'project_creation_id' => $this->project->id,
                'department_id' => $this->project->department_id,
                'created_by' => Auth::user()->id,
            ];
            if ($this->editplanId) {
                $plan = Plan::find($this->editplanId);
                if ($plan) {
                    $plan->update($data);
                    $this->notification()->success('Plan Updated', 'Plan details were updated successfully!');
                } else {
                    throw new \Exception('Plan not found.');
                }
            } else {
                Plan::create($data);
                $this->notification()->success('Plan Created', 'New plan was created successfully!');
            }
            $this->resetExcept('project');


            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->notification()->error('Error', 'There was an error saving the plan: ' . $e->getMessage());
        }
        $this->emit('refreshPlanTableData');
    }

    public function render()
    {
        return view('livewire.project.plan.create-project-plan');
    }
}
