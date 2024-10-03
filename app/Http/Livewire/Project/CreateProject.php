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
        'site'=> 'required|string',
        'department_id' => 'required|exists:departments,id',
    ];


    public function mount()
    {
        $this->department_id = Auth::user()->department_id;
    }
    public function editProjectCreation($id)
    {



        $project = ProjectCreation::findOrFail($id);
        $this->project_id = $project->id;
        $this->name = $project->name;
        $this->site = $project->site;
        $this->department_id = $project->department_id;
    }
    public function saveProject()
    {
        $this->validate();

        if (!empty($this->project_id)) {


            $project = ProjectCreation::findOrFail($this->project_id);
            $project->update(
                [
                    'name' => $this->name,
                    'site' => $this->site,
                ]
            );
            $this->notification()->success(
                $title = "Project created successfully!",

            );
            $this->reset();
            $this->emit('openEntryForm');
        } else {
            ProjectCreation::create([
                'name' => $this->name,
                'site' => $this->site,
                'department_id' => $this->department_id,
                'created_by' => Auth::user()->id,
            ]);

            $this->notification()->success(
                $title = "Project created successfully!",
            );
            $this->reset();
            $this->emit('openEntryForm');
        }
    }

    public function render()
    {
        $departments = Department::all();

        return view('livewire.project.create-project', [
            'departments' => $departments,
        ]);
    }
}
