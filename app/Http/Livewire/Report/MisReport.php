<?php

namespace App\Http\Livewire\Report;

use Livewire\Component;
use App\Models\SorMaster;
use App\Models\DynamicSorHeader;
use Illuminate\Support\Facades\DB;
use App\Models\SanctionLimitMaster;
use App\Models\Department;

class MisReport extends Component
{
    public $titel, $errorMessage, $subTitel = "List";
    protected $listeners = ['openEntryForm' => 'fromEntryControl', 'showError' => 'setErrorAlert'];
    public $projectDtls = [], $sorMasters = [] ,$departments=[] ,$SanctionLimitMasterdetails=[];


    public function setErrorAlert($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
    public function mount()
    {
        $this->projectDtls = SorMaster::select('departments.department_name', 'departments.department_code', 'estimate_statuses.status', 'sor_masters.estimate_id', 'sor_masters.sorMasterDesc', 'estimate_prepares.*')
            ->join('estimate_statuses', 'sor_masters.status', '=', 'estimate_statuses.id')
            ->join('departments', 'sor_masters.dept_id', '=', 'departments.id')
            ->join('estimate_prepares', 'estimate_prepares.estimate_id', '=', 'sor_masters.estimate_id')
            ->orWhere('estimate_prepares.operation', '=', 'Total')
            ->get();
        $this->sorMasters = DynamicSorHeader::DepartmentWiseSorReports()->get();



        $this->departments = SanctionLimitMaster::select('department_id', 'departments.department_name', DB::raw('count(*) as sanction_limit_count'))
        ->join('departments', 'sanction_limit_masters.department_id', '=', 'departments.id')
        ->groupBy('department_id', 'departments.department_name')
        ->get();


        // $this->SanctionLimitMasterdetails = SanctionLimitMaster::select('*')
        // ->join('departments', 'sanction_limit_masters.department_id', '=', 'departments.id')
        // ->where('sanction_limit_masters.department_id', $this->departments['department_id'])
        // ->get();

        //  dd( $this->departments);
    }
    public function render()
    {
        
        $assets = ['chart', 'animation'];
        $this->titel = 'Mis Reports';
       

        return view('livewire.report.mis-report', compact('assets'));
    }
}