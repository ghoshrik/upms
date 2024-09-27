<?php

namespace App\Http\Livewire\ProjectType;

use Livewire\Component;
use App\Models\Department;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectType as EstimateProjectType;

class ProjectType extends Component
{
    use Actions;
    public $formOpen = false;
    protected $listeners = ['openEntryForm' => 'fromEntryControl', 'showError' => 'setErrorAlert'];
    public $openedFormType = false, $isFromOpen, $subTitle = "List", $selectedIdForEdit, $errorMessage, $title;
    public $projectTypes = [];
    public function fromEntryControl($data = '')
    {
        $this->openedFormType = is_array($data) ? $data['formType'] : $data;
        $this->isFromOpen = !$this->isFromOpen;
        switch ($this->openedFormType) {
            case 'create':
                $this->subTitle = 'Create';
                break;
            case 'edit':
                $this->subTitle = 'Edit';
                break;
            default:
                $this->subTitle = 'List';
                break;
        }
        if (isset($data['id'])) {
            // $this->selectedIdForEdit = $data['id'];
            $this->emit('editProjectType', $data['id']);
        }
    }
    public function deleteProjectType($id)
    {
        DB::beginTransaction();
        try {
            $getProjectType = EstimateProjectType::where('id', $id)->first();
            $getSanctionLimits = $getProjectType->sanctionLimitMasters;
            foreach ($getSanctionLimits as $sanctionLimit) {
                $getSanctionRolePermissions = $sanctionLimit->roles()->get();
                foreach ($getSanctionRolePermissions as $key => $sanctionRolePermission) {
                    $sanctionRolePermission->delete();
                }
                $sanctionLimit->delete();
            }
            $getProjectType->delete();
            DB::commit();
            $this->notification()->success(
                $title = "Deleted successfully"
            );
            $this->reset();
            $this->emit('openEntryForm');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->notification()->error(
                $title = "Failed to delete record",
                $description = $e->getMessage()
            );
            $this->emit('showError', $e->getMessage());
        }
    }
    public function render()
    {
        $this->title = 'Project Types';
        $this->projectTypes = Department::find(Auth::user()->department_id)->projectTypes;
        return view('livewire.project-type.project-type');
    }
}
