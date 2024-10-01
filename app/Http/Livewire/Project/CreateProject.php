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
    public $department_id;

    protected $rules = [
        'name' => 'required|string',
        'department_id' => 'required|exists:departments,id',
    ];

    // Use the mount function to initialize the department_id
    public function mount()
    {

        $this->department_id = Auth::user()->department_id;
    }

    public function saveProject()
    {
        $this->validate();

        $projectId = rand(100000, 999999);

        ProjectCreation::create([
            'project_id' => $projectId,
            'name' => $this->name,
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

    public function render()
    {
        // Get all departments to display in the dropdown
        $departments = Department::all();

        return view('livewire.project.create-project', [
            'departments' => $departments,
        ]);
    }
}