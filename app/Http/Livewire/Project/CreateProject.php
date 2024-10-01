<?php

namespace App\Http\Livewire\Project;

use App\Models\ProjectCreation;
use App\Models\Department;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use WireUi\Traits\Actions;

class CreateProject extends Component
{
    use Actions;
    public $name;
    public $site;
    public $department_id;
    protected $listeners = ['editProjectCreation'];
    public $project_id;
    protected $rules = [
        'name' => 'required|string',
        'department_id' => 'required|exists:departments,id',
    ];

    // Use the mount function to initialize the department_id
    public function mount()
    {
        $this->department_id = Auth::user()->department_id;

        if (!empty($this->selectedIdForEdit)) {
            dd(ProjectCreation::find($this->selectedIdForEdit));
        }
    }
    public function editProjectCreation($id)
    {



        $project = ProjectCreation::findOrFail($id);
        $this->project_id = $project->id;
        $this->name = $project->name;
        $this->site = $project->site;
        $this->department_id = $project->department_id;
        // $this->project_id = $project->project_id;
        // $this->created_by = $project->created_by;
    }
    public function saveProject()
    {
        $this->validate();

        if (!empty($this->project_id)) {

            // dd($this->project_id);      
            $project = ProjectCreation::findOrFail($this->project_id);
            $project->update(
                [
                    'name' => $this->name,
                    'site' => $this->site,
                ]
            );
            $this->notification()->success(
                $title = "Project created successfully!",
                // $description = $e->getMessage()
            );
            $this->reset();
            $this->emit('openEntryForm');
        } else {
            ProjectCreation::create([
                // 'project_id' => $projectId,
                'name' => $this->name,
                'site' => $this->site,
                'department_id' => $this->department_id,
                'created_by' => Auth::user()->id,
            ]);

            // session()->flash('message', 'Project created successfully!');
            $this->notification()->success(
                $title = "Project created successfully!",
                // $description = $e->getMessage()
            );
            $this->reset();
            $this->emit('openEntryForm');
        }
    }

    public function render()
    {
        // Get all departments to display in the dropdown
        $departments = Department::all();

        return view('livewire.project.create-project', [
            'departments' => $departments,
        ]);
    }
}
