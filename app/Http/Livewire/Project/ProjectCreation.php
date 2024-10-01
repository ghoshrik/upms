<?php

namespace App\Http\Livewire\Project;

use App\Models\ProjectCreation as ProjectCreationModel;
use App\Models\Department;
use Livewire\Component;
use WireUi\Traits\Actions;

class ProjectCreation extends Component
{
    use Actions;

    public $formOpen = false;
    public $openedFormType = false, $isFromOpen, $subTitle = "List", $selectedIdForEdit, $errorMessage, $title;
    public $projectTypes = [];
    public $name, $department_id, $created_by, $project_id;

    protected $listeners = ['openEntryForm' => 'fromEntryControl', 'showError' => 'setErrorAlert','refreshProjectList' => 'loadProjects'];

    protected $rules = [
        'name' => 'required|string',
        'department_id' => 'required|exists:departments,id',
    ];

    public function mount()
    {
        $this->loadProjects();
        // $this->listeners = ['refreshProjectList' => 'loadProjects'];
    }

    public function loadProjects()
    {
        $this->projectTypes = ProjectCreationModel::with('department')->get();
    }

    public function fromEntryControl($data = '')
    {
        $this->openedFormType = is_array($data) ? $data['formType'] : $data;
        $this->isFromOpen = !$this->isFromOpen;
        $this->resetForm();

        switch ($this->openedFormType) {
            case 'create':
                $this->subTitle = 'Create';
                break;
            case 'edit':
                $this->subTitle = 'Edit';
                if (isset($data['id'])) {
                    $this->loadProjectForEdit($data['id']);
                }
                break;
            default:
                $this->subTitle = 'List';
                break;
        }
    }

    public function loadProjectForEdit($id)
    {
        $project = ProjectCreationModel::findOrFail($id);
        $this->selectedIdForEdit = $project->id;
        $this->name = $project->name;
        $this->department_id = $project->department_id;
        $this->project_id = $project->project_id;
        $this->created_by = $project->created_by;
    }

    public function saveProject()
    {
        $this->validate();

        if ($this->openedFormType === 'edit') {
            $project = ProjectCreationModel::findOrFail($this->selectedIdForEdit);
            $project->update([
                'name' => $this->name,
                'department_id' => $this->department_id,
                // Sl. No and project_id are not updated
            ]);
            $this->notification()->success('Project Updated', 'Project details were updated successfully!');
        } else {
            ProjectCreationModel::create([
                'project_id' => random_int(100000, 999999), // Create new project ID
                'name' => $this->name,
                'department_id' => $this->department_id,
                'created_by' => auth()->id(),
            ]);
            $this->notification()->success('Project Created', 'New project was created successfully!');
        }

        $this->resetForm();
        $this->isFromOpen = false;
        $this->emit('openEntryForm');
    }

    public function deleteProject($id)
    {
        ProjectCreationModel::findOrFail($id)->delete();
        $this->notification()->success('Project Deleted', 'Project was deleted successfully!');
        $this->loadProjects();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->department_id = '';
        $this->created_by = '';
        $this->project_id = '';
        $this->selectedIdForEdit = null;
    }

    public function render()
    {
        $this->title = 'Projects';
        $departments = Department::all(); // Assuming you have a Department model
        $this->projectTypes = ProjectCreationModel::with('department')->get();
        return view('livewire.project.project-creation', [
            'projectTypes' => $this->projectTypes,
            'departments' => $departments,
        ]);
    }
}