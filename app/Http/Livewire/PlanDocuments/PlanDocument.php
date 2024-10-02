<?php

namespace App\Http\Livewire\PlanDocuments;

use App\Models\Plan;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\PlanDocument as PlanDocumentModel;
use App\Models\MultiDocUpload;
use App\Models\ProjectCreation;

class PlanDocument extends Component
{
    use Actions;
    protected $listeners = ['refreshPlanDocument' => 'render'];
    public $project, $projectPlan, $selectedProjectId, $selectedProjectPlanId;
    public $planDocuments = [],$planDocumentById;
    public function addPlanDocument()
    {
        $this->emit('addPlanDocument');
    }
    public function view($id)
    {
        $getPlanDocument = PlanDocumentModel::where('id', $id)->first();
        $decoded = base64_decode($getPlanDocument->plan_document);
        $fileName = $getPlanDocument->title . ".pdf";
        file_put_contents($fileName, $decoded);
        header('Content-Description: SOR Document ');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        return response()->download($fileName)->deleteFileAfterSend(true);
        // $this->planDocumentById = $decoded;
    }
    public function render()
    {
        $this->project = ProjectCreation::where('id', $this->selectedProjectId)->first();
        $this->projectPlan = Plan::where('id',$this->selectedProjectPlanId)->where('project_creation_id',$this->selectedProjectId)->first();
        $this->planDocuments = $this->projectPlan->planDocuments;
        return view('livewire.plan-documents.plan-document');
    }
}
