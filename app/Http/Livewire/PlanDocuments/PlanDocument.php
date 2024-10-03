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
    protected $listeners = ['refreshPlanDocument' => 'render', 'openEntryForm' => 'fromEntryControl', 'showError' => 'setErrorAlert'];
    public $project, $projectPlan, $selectedProjectId, $selectedProjectPlanId;
    public $openedFormType = false, $isFromOpen, $subTitel = "List", $errorMessage;
    protected $planDocuments = [], $planDocumentById;
    public function addPlanDocument()
    {
        $this->emit('addPlanDocument');
    }
    public function fromEntryControl($data = '')
    {
        $this->openedFormType = is_array($data) ? $data['formType'] : $data;
        $this->isFromOpen = !$this->isFromOpen;
        switch ($this->openedFormType) {
            case 'create':
                $this->subTitel = 'Create';
                break;
            case 'edit':
                $this->subTitel = 'Edit';
                break;
            default:
                $this->subTitel = 'List';
                break;
        }
        if (isset($data['id'])) {
            // dd($data['id']);
            $this->emit('addPlanDocument', $data['id']);
        }
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

    public function deletePlanDoc($planDocumentId)
    {
        $this->project = ProjectCreation::find($this->selectedProjectId);
        if ($this->project) {
            $plan = $this->project->plans()->find($this->selectedProjectPlanId);
            if ($plan) {
                $planDocument = $plan->planDocuments()->find($planDocumentId);
                if ($planDocument) {
                    $planDocument->delete();
                    $this->notification()->success('Plan document deleted successfully!');
                } else {
                    $this->notification()->error('Plan document not found.');
                }
            } else {
                $this->notification()->error('Plan not found.');
            }
        } else {
            $this->notification()->error('Project not found.');
        }
    }

    public function render()
    {
        $this->project = ProjectCreation::find($this->selectedProjectId);
        $this->projectPlan = Plan::where('id', $this->selectedProjectPlanId)
            ->where('project_creation_id', $this->selectedProjectId)
            ->first();
        if ($this->projectPlan) {
            $this->planDocuments = $this->projectPlan->planDocuments()->paginate(10);
        } else {
            $this->planDocuments = collect();
        }

        return view('livewire.plan-documents.plan-document', [
            'planDocuments' => $this->planDocuments,
        ]);
    }
}
