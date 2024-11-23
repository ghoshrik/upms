<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use App\Models\Department;
use WireUi\Traits\Actions;
use App\Models\DocumentType;
use App\Models\ProjectCreation;
use Illuminate\Support\Facades\Auth;

class CreateProject extends Component
{
    use Actions;
    public $name;
    public $site;
    public $department_id;
    protected $listeners = ['editProjectCreation'];
    public $project_id;
    public $mandetory_docs_list;
    public $selectedDocs =  [];
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
    $project = ProjectCreation::with('documentTypes')->findOrFail($id);
    $this->project_id = $project->id;
    $this->name = $project->name;
    $this->site = $project->site;
    $this->department_id = $project->department_id;
    $this->selectedDocs = $project->documentTypes->pluck('id')->toArray();
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
            $project->documentTypes()->sync($this->selectedDocs);
            $this->notification()->success(
                $title = "Project updated successfully!"
            );
            $this->reset();
            $this->emit('openEntryForm');
        } else {
            $project = ProjectCreation::create([
                'name' => $this->name,
                'site' => $this->site,
                'department_id' => $this->department_id,
                'created_by' => Auth::user()->id,
            ]);
            $project->documentTypes()->attach($this->selectedDocs);
            $this->notification()->success(
                $title = "Project created successfully!"
            );
            $this->reset();
            $this->emit('openEntryForm');
        }
    }


    public function render()
    {
        $departments = Department::all();
        $this->mandetory_docs_list = DocumentType::all();
        return view('livewire.project.create-project', [
            'departments' => $departments,
            'mandetory_docs_list' => $this->mandetory_docs_list,
        ]);
    }
}
