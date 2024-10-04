<?php

namespace App\Http\Livewire\EstimateProject;

use Livewire\Component;
use App\Models\SorMaster;
use App\Models\EstimateFlow;
use Illuminate\Http\Request;
use App\Models\ProjectCreation;
use Illuminate\Support\Facades\Auth;
use App\Models\EstimateUserAssignRecord;

class EstimateProject extends Component
{
    public $project_id;
    public $formOpen = false, $editFormOpen = false, $updateDataTableTracker, $selectedTab = 1, $counterData = [];
    protected $listeners = ['openForm' => 'fromEntryControl', 'refreshData' => 'mount', 'showError' => 'setErrorAlert'];
    public $openedFormType = false, $isFromOpen, $subTitel = "List", $selectedIdForEdit, $errorMessage, $titel, $project = '';
    public function mount(ProjectCreation $id)
    {
        $this->project_id = $id->id ?? '';
        if ($this->project_id != '') {
            $this->project = $id;
        }
        $this->draftData();
    }
    public function draftData()
    {
        $this->selectedTab = '';
        $this->selectedTab = 1;
        $this->dataCounter();
    }
    public function forwardedData()
    {
        $this->selectedTab = '';
        $this->selectedTab = 2;
        $this->dataCounter();
    }
    public function revertedData()
    {
        $this->selectedTab = '';
        $this->selectedTab = 3;
        $this->dataCounter();
    }
    public function approvedData()
    {
        $this->selectedTab = '';
        $this->selectedTab = 4;
        $this->dataCounter();
    }
    public function dataCounter()
    {

        $user = Auth::user();
        $roles = $user->roles;

        //        $permissions = $roles->permissions;
        //        dd($permissions);
        //        $permission = $user->hasPermissionTo;
        //        dd($permission);

        //        dd(Auth::user()->id);

        //        $this->counterData['totalDataCount'] = SorMaster::join('estimate_flows','estimate_flows.estimate_id','=','sor_masters.estimate_id')
        //        ->whereNull('sor_masters.approved_at')
        //        ->where('associated_with', Auth::user()->id)
        //        ->count();
        $this->counterData['totalDataCount'] = SorMaster::join('estimate_flows', 'estimate_flows.estimate_id', '=', 'sor_masters.estimate_id')
            ->whereNull('sor_masters.approved_at')
            ->where('associated_with', Auth::user()->id)
            ->count();
        $this->counterData['draftDataCount'] = EstimateFlow::where('user_id', Auth::user()->id)
            ->whereNull('dispatch_at')
            ->count();
        $this->counterData['fwdDataCount'] = EstimateFlow::join('sor_masters', 'sor_masters.estimate_id', '=', 'estimate_flows.estimate_id')
            ->where('estimate_flows.user_id', Auth::user()->id)
            ->whereNotNull('estimate_flows.dispatch_at')
            ->whereNull('sor_masters.is_verified')
            ->count();

        $this->counterData['approveDataCount'] = EstimateFlow::join('sor_masters', 'sor_masters.estimate_id', '=', 'estimate_flows.estimate_id')
            ->where('estimate_flows.user_id', Auth::user()->id)
            ->whereNotNull('estimate_flows.dispatch_at')
            ->where('sor_masters.is_verified', 1)
            ->whereNotNull('sor_masters.approved_at')
            ->count();
        // dd($this->counterData['totalDataCount']);
        // EstimateUserAssignRecord::where('status', 1)
        // ->where('user_id', Auth::user()->id)
        // ->count();

        //        $this->counterData['draftDataCount'] = SorMaster::join('estimate_flows','estimate_flows.estimate_id','=','sor_masters.estimate_id')
        //            ->where(function ($query) {
        //            $query->where('sor_masters.status', 1);
        //        })
        //            ->where('user_id', Auth::user()->id)
        //            ->count();
        //        dd($this->counterData['totalDataCount'],$this->counterData['draftDataCount'] );
        //
        //        $this->counterData['fwdDataCount'] = SorMaster::join('estimate_flows','estimate_flows.estimate_id','=','sor_masters.estimate_id')
        //                                                        ->whereNotNull('estimate_flows.associated_at')
        //                                                        ->where('user_id',Auth::user()->id)
        //                                                        ->count();



        /* $this->counterData['fwdDataCount'] =
            EstimateUserAssignRecord::query()
            ->selectRaw('count(status)')
            ->where('status', 2)
            ->where('user_id', Auth::user()->id)
            ->where('created_at', function ($query) {
                $query->selectRaw('MAX(created_at)')
                    ->from('estimate_user_assign_records as t2')
                    ->whereColumn('estimate_user_assign_records.estimate_id', 't2.estimate_id')
                    ->where('t2.status', 2);
            })
            ->count();
        $this->counterData['revertedDataCount'] = EstimateUserAssignRecord::where('status', 3)
            ->where('assign_user_id', Auth::user()->id)
            ->where('is_done', 0)
            ->count();*/
        $this->counterData['revertedDataCount'] = 0;
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
            // $this->selectedIdForEdit = $data['id'];
            // $this->emit('editEstimateRow',$data['id']);
            $this->emit('editEstimate', $data['id']);
        }
        $this->updateDataTableTracker = rand(1, 1000);
    }
    public function formOCControl($isEditFrom = false, $eidtId = null)
    {
        if ($isEditFrom) {
            $this->editFormOpen = !$this->editFormOpen;
            $this->emit('changeSubTitel', ($this->editFormOpen) ? 'Edit' : 'List');
            if ($eidtId != null) {
                $this->emit('editEstimateRow', $eidtId);
            }
            return;
        }
        $this->editFormOpen = false;
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
    }
    public function openProjectPlans($id = '')
    {
        if ($id != '') {
            $this->emit('openProjectWisePlan', ['id' => $id]);
        }
    }
    public function setErrorAlert($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        $this->titel = 'Project Estimate';
        $assets = ['chart', 'animation'];
        return view('livewire.estimate-project.estimate-project');
    }
}