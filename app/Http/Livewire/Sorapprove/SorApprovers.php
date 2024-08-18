<?php

namespace App\Http\Livewire\Sorapprove;

use App\Models\SOR;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithFileUploads;
use App\Models\DynamicSorHeader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SorApprovers extends Component
{

    use Actions, WithFileUploads;
    public $updateDataTableTracker;
    protected $listeners = ['openEntryForm' => 'fromEntryControl', 'showError' => 'setErrorAlert'];
    public $openedFormType = false, $isFromOpen, $subTitel = "List", $titel, $errorMessage;
    public $SorLists = [], $selectedSors = [];

    public function mount()
    {
        //$this->SorLists = SOR::where('department_id', '=', Auth::user()->department_id)->get();
        // $this->SorLists['sorApproverPendingCount'] = DynamicSorHeader::PendingSor();
        // $this->SorLists['sorApprovedCount'] = DynamicSorHeader::ApproveSor();

        // $this->SorLists['sorTargetPage'] = DynamicSorHeader::DeptTargetPages();

        // $user = Auth::user();

        // $categoryCounts = DynamicSorHeader::CategoryCounts($user);
        // dd($categoryCounts);


        
        // dd($this->SorLists['countsWithTable']);
    }

    public function setErrorAlert($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    public function fromEntryControl($data = '')
    {
        $this->openedFormType = is_array($data) ? $data['formType'] : $data;

        switch ($this->openedFormType) {
            case 'create':
                $this->subTitel = 'Create';
                break;
            case 'view':
                $this->subTitel = 'View';
                $this->isFromOpen = true;
                break;
            default:
                $this->subTitel = 'List';
                $this->isFromOpen = false;
                break;
        }

        if (isset($data['id'])) {
            $this->selectedIdForEdit = $data['id'];
        }

        $this->updateDataTableTracker = rand(1, 1000);
    }
    public function render()
    {
        //$this->SorLists = SOR::where('department_id', '=', Auth::user()->department_id)->get();
        $this->updateDataTableTracker = rand(1, 1000);
        $this->titel = trans('cruds.sor-approver.title_singular');
        $assets = ['chart', 'animation'];
        $this->SorLists['sorApproverPendingCount'] = DynamicSorHeader::PendingSor();
        $this->SorLists['sorApprovedCount'] = DynamicSorHeader::ApproveSor();
        $this->SorLists['sorCount'] = DynamicSorHeader::PendingSor();
        $this->SorLists['SORCounts'] = DynamicSorHeader::SorReportsDeptCategory()->get();
        $this->SorLists['countsWithTable'] = DynamicSorHeader::getApprovedCounts(Auth::user()->department_id);
        return view('livewire.sorapprove.sor-approvers', compact('assets'));
    }
}