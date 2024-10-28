<?php

namespace App\Http\Livewire\Report;

use App\Models\Role;
use App\Models\User;
use App\Models\Office;
use Livewire\Component;
use App\Models\SorMaster;
use App\Models\Department;
use WireUi\Traits\Actions;
use App\Models\SanctionRole;
use App\Models\DynamicSorHeader;
use Illuminate\Support\Facades\DB;
use App\Models\SanctionLimitMaster;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class MisReport extends Component
{
    use Actions;
    public $titel, $errorMessage, $subTitel = "List";
    protected $listeners = ['openEntryForm' => 'fromEntryControl', 'showError' => 'setErrorAlert'];
    public $projectDtls = [], $sorMasters = [], $departments = [], $sanction_roles = [], $sanctionLimitDetails = [], $sanctionLimitRowDetails = [];
    public $sanctionLimit;
    public $showSidebarr = false;
    public $activeTab;
    public $roles = [];
    public $role_id;
    public $permission_name;
    public $permissions = [];

    public $departmentSummaryArray, $groupDetailArray;
    public function setErrorAlert($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }


    public function mount()
    {

        if (Auth::user()->hasRole('State Admin')) {
            $this->activeTab = 'home-tab';
            $departmentSummary = Department::leftJoin('groups', 'departments.id', '=', 'groups.department_id')
                ->leftJoin('offices', 'groups.id', '=', 'offices.group_id')
                ->select(
                    'departments.id as department_id',
                    'departments.department_name',
                    'groups.id as group_id',
                    'groups.group_name'
                )
                ->selectRaw('COUNT(DISTINCT groups.id) as group_count')
                ->selectRaw('COUNT(DISTINCT offices.id) as office_count')
                ->groupBy(
                    'departments.id',
                    'departments.department_name',
                    'groups.id',
                    'groups.group_name'
                )
                ->havingRaw('COUNT(groups.id) > 0')
                ->get();
        } else {
            $this->activeTab = 'user-mis-tab';
            $departmentSummary = Department::leftJoin('groups', 'departments.id', '=', 'groups.department_id')
                ->leftJoin('offices', 'groups.id', '=', 'offices.group_id')
                ->select(
                    'departments.id as department_id',
                    'departments.department_name',
                    'groups.id as group_id',
                    'groups.group_name'
                )
                ->selectRaw('COUNT(DISTINCT groups.id) as group_count')
                ->selectRaw('COUNT(DISTINCT offices.id) as office_count')
                ->where('departments.id', Auth::user()->department_id)
                ->groupBy(
                    'departments.id',
                    'departments.department_name',
                    'groups.id',
                    'groups.group_name'
                )
                ->havingRaw('COUNT(groups.id) > 0')
                ->get();
        }

        $this->roles = Role::whereIn('id', [3, 4, 12, 7, 9])->orderBy('has_level_no')->get();
        $this->sanction_roles = collect();
        $this->permissions = collect([
            'create estimate' => 'Maker',
            'verify estimate' => 'Checker',
            'approve estimate' => 'Approver',
        ]);


        // dd($departmentSummary);
        $this->departmentSummaryArray = [];

        $this->groupDetailArray = [];
        foreach ($departmentSummary as $summary) {
            $departmentId = $summary->department_id;
            $groupId = $summary->group_id;
            $officeCount = Office::where('department_id', $departmentId)
                ->where('group_id', $groupId)
                ->count();
            $officeIds = Office::where('department_id', $departmentId)
                ->where('group_id', $groupId)
                ->pluck('id');
            $userCount = User::where('department_id', $departmentId)
                ->whereIn('office_id', $officeIds)
                ->count();
            if (!isset($this->departmentSummaryArray[$departmentId])) {
                $this->departmentSummaryArray[$departmentId] = [
                    'department_name' => $summary->department_name,
                    'group_count' => 0,
                    'office_count' => 0,
                    'user_count' => 0,
                ];
            }
            $this->departmentSummaryArray[$departmentId]['group_count'] += 1;
            $this->departmentSummaryArray[$departmentId]['office_count'] += $officeCount;
            $this->departmentSummaryArray[$departmentId]['user_count'] += $userCount;
            $this->groupDetailArray[] = [
                'department_name' => $summary->department_name,
                'group_name' => $summary->group_name,
                'total_office_count' => $officeCount,
                'total_user_count' => $userCount,
            ];
        }
        $this->departmentSummaryArray = array_values($this->departmentSummaryArray);
    }

    public function handleClick($id)
    {

        $this->sanctionLimitRowDetails = SanctionLimitMaster::select(
            'sanction_limit_masters.id',
            'sanction_limit_masters.department_id',
            'sanction_limit_masters.min_amount',
            'sanction_limit_masters.max_amount',
            'departments.department_name'
        )
            ->join('departments', 'sanction_limit_masters.department_id', '=', 'departments.id')
            ->where('sanction_limit_masters.id', $id)
            ->first();
        $this->sanctionLimit = SanctionLimitMaster::where('id', $id)->first();
        $this->sanction_roles = $this->sanctionLimit->roles()->with(['role', 'permission'])->get();
        $this->showSidebarr = true;
        $this->activeTab = 'sanction-tab';
    }


    public function confDeleteDialogRolePermission($value): void
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'icon' => 'error',
            'accept' => [
                'label' => 'Yes, Delete it',
                'method' => 'deleteSanctionRolePermission',
                'params' => $value,
            ],
            'reject' => [
                'label' => 'No, cancel',
                // 'method' => 'cancel',
            ],
        ]);
    }
    public function deleteSanctionRolePermission($id)
    {
        SanctionRole::where('id', $id)->delete();
        $this->refreshSanctionRolePermissions();
    }
    public function refreshSanctionRolePermissions()
    {
        $this->sanction_roles = $this->sanctionLimit->roles()->with(['role', 'permission'])->get();
    }
    public function closeSidebar()
    {
        $this->showSidebarr = false;
        $this->activeTab = 'sanction-tab'; // Reset to default tab or any other desired tab
    }


    public function render()
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

        foreach ($this->departments as $department) {
            $departmentId = $department->department_id;

            $this->sanctionLimitDetails = SanctionLimitMaster::select('sanction_limit_masters.*', 'departments.department_name')
                ->join('departments', 'sanction_limit_masters.department_id', '=', 'departments.id')
                ->where('sanction_limit_masters.department_id', $departmentId)
                ->get();
        }

        $assets = ['chart', 'animation'];
        $this->titel = 'Mis Reports';
        return view('livewire.report.mis-report', compact('assets'));
    }
}
