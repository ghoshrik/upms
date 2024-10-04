<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use App\Models\ProjectCreation;
use Illuminate\Support\Facades\Auth;

class UserProjects extends Component
{
    protected $listeners = ['openEntryForm' => 'fromEntryControl'];
    public $openedFormType = false, $isFromOpen, $subTitle = "List", $selectedIdForEdit, $errorMessage, $title, $update_title;
    public $projects;
    public function fromEntryControl($data = '')
    {
        $this->openedFormType = is_array($data) ? $data['formType'] : $data;
        $this->isFromOpen = !$this->isFromOpen;
        switch ($this->openedFormType) {
            case 'create':
                $this->subTitle = 'Create';
                break;
            case 'edit':
                $this->subTitle = 'Edit';
                break;
            default:
                $this->subTitle = 'List';
                break;
        }
        if (isset($data['id'])) {
        }
    }
    public function openEstimate(ProjectCreation $id)
    {
        return redirect()->route('estimate-project-show', ['id' => $id]);
    }
    public function openProjectPlans($id)
    {
        $this->emit('openProjectWisePlan', ['id' => $id]);
    }
    public function render()
    {
        $this->title = 'Projects';
        // $this->projects = ProjectCreation::where('department_id', Auth::user()->department_id)->with('department')->get();
        $this->projects = Auth::user()->projects;
        return view('livewire.project.user-projects');
    }
}