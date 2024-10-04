<?php

namespace App\Http\Livewire\Project;

use App\Models\Department;
use App\Models\Group;
use App\Models\Office;
use App\Models\ProjectCreation as ProjectCreationModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class ProjectCreation extends Component
{
    use Actions;
    public $formOpen = false;
    public $openedFormType = false, $isFromOpen, $subTitle = "List", $selectedIdForEdit, $errorMessage, $title,$update_title;
    protected $projectTypes = [];
    public $name, $department_id, $created_by, $site, $selectedProjectId,$selectedProjectPlanId;

    public $groups;

    protected $listeners = [
            'openEntryForm' => 'fromEntryControl', 
            'showError' => 'setErrorAlert', 
            'refreshProjectList' => 'loadProjects',
            'assignUserDetails'=>'UserDetails',
            'officeId'=>'officeDetails'
        ];

    protected $rules = [
        'name' => 'required|string',
        'department_id' => 'required|exists:departments,id',
    ];

    public function mount()
    {
        // $this->loadProjects();

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
                break;
            case 'plan':
                $this->subTitle = 'Plan';
                $this->selectedProjectId = $data['id'];
                break;
            case 'plan_document':
                $this->subTitle = 'Plan Document';
                $this->selectedProjectId = $data['project_id'];
                $this->selectedProjectPlanId = $data['id'];
                $this->isFromOpen = true;
                break;
            default:
                $this->subTitle = 'List';
                break;
        }
        if (isset($data['id'])) {
            if ($this->openedFormType == 'edit'){
                $this->emit('editProjectCreation', $data['id']);
            }
        }
    }

    public function loadProjectForEdit($id)
    {
        $project = ProjectCreationModel::findOrFail($id);
        $this->selectedIdForEdit = $project->id;
        $this->name = $project->name;
        $this->site = $project->site;
        $this->department_id = $project->department_id;
        $this->created_by = $project->created_by;
    }

    public function saveProject()
    {
        $this->validate();

        if ($this->openedFormType === 'edit') {
            $project = ProjectCreationModel::findOrFail($this->selectedIdForEdit);
            $project->update([
                'name' => $this->name,
                'site' => $this->site,
                'department_id' => $this->department_id,
            ]);
            $this->notification()->success('Project Updated', 'Project details were updated successfully!');
        } else {
            ProjectCreationModel::create([
                'name' => $this->name,
                'site' => $this->site,
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
        $this->site = '';
        $this->selectedIdForEdit = null;
    }
    public $offices;
    public function UserDetails($id)
    {
        $this->groups= Group::where('department_id',Auth::user()->department_id)->get();
        $this->emit('GroupsLists',$this->groups);
    }

    public function officeDetails($id)
    {
        $this->offices = Office::where('group_id',$id)->get();
        $this->emit('officeLists',$this->offices);
    }

    public function render()
{
    $this->title = 'Projects';
    $departments = Department::all();

    // Use paginate() instead of get() to enable pagination
    $this->projectTypes = ProjectCreationModel::where('department_id', Auth::user()->department_id)
        ->where('created_by', Auth::user()->id)
        ->with('department')
        ->paginate(25); // Adjust the number to the desired items per page

    return view('livewire.project.project-creation', [
        'projectTypes' => $this->projectTypes,
        'departments' => $departments,
    ]);
}

}
