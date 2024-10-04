<?php

namespace App\Http\Livewire\Project\Plan;

use App\Models\Plan;
use Livewire\Component;
use App\Models\DocumentType;
use App\Models\PlanDocument;
use App\Models\ProjectCreation;

class ProjectWisePlans extends Component
{
    protected $listeners = ['openProjectWisePlan'];
    public $openProjectPlan = false;
    public $project,$plans,$planDocuments,$documentTypes;
    public function openProjectWisePlan($id)
    {
        $this->reset();
        $this->project = ProjectCreation::where('id',$id)->first();
        $this->plans = $this->project->plans;
        $this->openProjectPlan = !$this->openProjectPlan;
    }
    public function closeProjectPlan()
    {
        $this->reset();
    }
    public function viewDocuments()
    {
        $this->documentTypes = DocumentType::leftJoin('plan_documents', function ($join) {
            $join->on('plan_documents.document_type_id', '=', 'document_types.id')
            ->where('plan_documents.project_creation_id', $this->project->id);
        })->selectRaw('document_types.name AS name, COUNT(plan_documents.*) AS document_count')
        ->groupByRaw('document_types.name')
        ->orderByRaw('document_types.name')->get();
    }
    public function viewProjectPlans()
    {
        $this->openProjectWisePlan($this->project->id);
    }
    public function downloadPlanDocuments($id)
    {
        $getPlanDocument = PlanDocument::where('id', $id)->first();
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
        return view('livewire.project.plan.project-wise-plans');
    }
}
