<?php

namespace App\Http\Livewire\PlanDocuments;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\DocumentType;
use App\Models\PlanDocument;
use Livewire\WithFileUploads;
use App\Models\MultiDocUpload;

class CreatePlanDocument extends Component
{
    use Actions, WithFileUploads;
    protected $listeners = ['addPlanDocument'];
    public $project, $projectPlan;
    public $inputs = [], $progress = 0;
    public $fetchDropdownData = [], $openPlanDocumentModal = false;
    public function addPlanDocument()
    {
        $this->resetExcept(['project','projectPlan']);
        $this->openPlanDocumentModal = true;
        $this->inputs[] = [
            'title' => '',
            'document_type_id' => '',
            'department_id' => '',
            'plan_document' => '',
        ];
        $this->fetchDropdownData['document_types'] = DocumentType::all();
    }
    public function addMore()
    {
        $this->inputs[] = [
            'title' => '',
            'document_type_id' => '',
            'department_id' => '',
            'plan_document' => '',
        ];
    }
    public function deleteRow($key)
    {
        unset($this->inputs[$key]);
    }
    public function closeCreatePlanDocModel()
    {
        $this->resetExcept(['project','projectPlan']);
    }
    public function store()
    {
        foreach ($this->inputs as $key => $input) {
            $input['temp_path'] = $input['plan_document']->getRealPath();
            $input['filePath'] = file_get_contents($input['temp_path']);
            $input['fileSize'] = $input['plan_document']->getSize();
            $input['filExt'] = $input['plan_document']->getClientOriginalExtension();
            $input['mimeType'] = $input['plan_document']->getMimeType();
            $input['base64_file'] = base64_encode($input['filePath']);
            $this->inputs[$key] = $input;
            $insert = [
                'title' => $input['title'],
                'plan_id' => $this->projectPlan->id,
                'document_type_id' => $input['document_type_id'],
                'project_creation_id' => $this->project->id,
                'department_id' => $this->project->department_id,
                'plan_document' => $input['base64_file']
            ];
            PlanDocument::create($insert);
            // Delete the temporary file
            if ($input['temp_path'] || file_exists($input['temp_path'])) {
                unlink($input['temp_path']);
            }
        }
        $this->openPlanDocumentModal = false;
        $this->resetExcept(['project','projectPlan']);
        $this->emit('refreshPlanDocument');
    }
    public function render()
    {
        return view('livewire.plan-documents.create-plan-document');
    }
}
