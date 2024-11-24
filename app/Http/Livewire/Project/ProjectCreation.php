<?php

namespace App\Http\Livewire\Project;

use App\Models\Group;
use App\Models\Office;
use Livewire\Component;
use App\Models\Department;
use WireUi\Traits\Actions;
use App\Models\DocumentType;
use App\Models\PlanDocument;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectCreation as ProjectCreationModel;

class ProjectCreation extends Component
{
    use Actions;
    public $formOpen = false;
    public $openedFormType = false, $isFromOpen, $subTitle = "List", $selectedIdForEdit, $errorMessage, $title, $update_title, $mandetory_docs_list,$mandatoryDocs,$nonMandatoryDocs;
    public $open_man_docs_Form = false;
    protected $projectTypes = [];
    public $name, $department_id, $created_by, $site, $selectedProjectId, $selectedProjectPlanId, $selectedDocs, $selectedDocsIds = [];

    public $groups;

    protected $listeners = [
        'openEntryForm' => 'fromEntryControl',
        'showError' => 'setErrorAlert',
        'refreshProjectList' => 'loadProjects',
        'assignUserDetails' => 'UserDetails',
        'officeId' => 'officeDetails'
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
            if ($this->openedFormType == 'edit') {
                $this->emit('editProjectCreation', $data['id']);
            }
        }
        if ($this->openedFormType == 'mandocs') {
            if (isset($data['id'])) {
                $this->selectedProjectId = $data['id'];
                $allDocs = DocumentType::all();
                $this->selectedDocs = ProjectCreationModel::where('id', $this->selectedProjectId)
                    ->leftJoin('project_document_type_checklist', 'project_creations.id', '=', 'project_document_type_checklist.project_creation_id')
                    ->select(
                        DB::raw('STRING_AGG(project_document_type_checklist.document_type_id::TEXT, \',\') as document_ids')
                    )
                    ->groupBy('project_creations.id')
                    ->pluck('document_ids')
                    ->first();

                $this->selectedDocsIds = $this->selectedDocs ? explode(',', $this->selectedDocs) : [];
                $uploadedDocsCount = PlanDocument::where('project_creation_id', $this->selectedProjectId)
                    ->select('document_type_id', DB::raw('COUNT(*) as count'))
                    ->groupBy('document_type_id')
                    ->pluck('count', 'document_type_id')
                    ->toArray();
                $this->mandetory_docs_list = $allDocs->map(function ($doc) use ($uploadedDocsCount) {
                    $doc->uploaded_count = $uploadedDocsCount[$doc->id] ?? 0;
                    return $doc;
                });
                $this->mandatoryDocs = $this->mandetory_docs_list->filter(function ($doc) {
                    return in_array($doc->id, $this->selectedDocsIds);
                });
                $this->nonMandatoryDocs = $this->mandetory_docs_list->filter(function ($doc) {
                    return !in_array($doc->id, $this->selectedDocsIds) && $doc->uploaded_count > 0;
                });
            }

            $this->open_man_docs_Form = true;
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
        $this->groups = Group::where('department_id', Auth::user()->department_id)->get();
        $this->emit('GroupsLists', $this->groups);
    }

    public function officeDetails($id)
    {
        $this->offices = Office::where('group_id', $id)->get();
        $this->emit('officeLists', $this->offices);
    }
    public function closeMandocsDrawer()
    {
        $this->open_man_docs_Form = false;
        $this->selectedProjectId = null;
    }

    public function render()
    {
        $this->title = 'Projects';
        $departments = Department::all();

        // Fetch projects with document count
        $this->projectTypes = ProjectCreationModel::where('department_id', Auth::user()->department_id)
            ->where('created_by', Auth::user()->id)
            ->leftJoin('project_document_type_checklist', 'project_creations.id', '=', 'project_document_type_checklist.project_creation_id')
            ->select(
                'project_creations.*',
                DB::raw('COUNT(project_document_type_checklist.document_type_id) as document_count')
            )
            ->groupBy('project_creations.id')
            ->with('department')
            ->paginate(25);

        //  dd($this->projectTypes);

        return view('livewire.project.project-creation', [
            'projectTypes' => $this->projectTypes,
            'departments' => $departments,
        ]);
    }

}
