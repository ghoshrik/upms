<?php

namespace App\Http\Livewire\MisReport\Users;

use App\Models\Department;
use App\Models\Office;
use App\Models\User;
use Livewire\Component;

class UserMisReport extends Component
{
    public $departmentSummaryArray, $groupDetailArray;
    public function mount()
    {
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
        $departmentSummaryArray = [];
        $groupDetailArray = [];
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
            if (!isset($departmentSummaryArray[$departmentId])) {
                $departmentSummaryArray[$departmentId] = [
                    'department_name' => $summary->department_name,
                    'group_count' => 0,
                    'office_count' => 0,
                    'user_count' => 0,
                ];
            }
            $departmentSummaryArray[$departmentId]['group_count'] += 1;
            $departmentSummaryArray[$departmentId]['office_count'] += $officeCount;
            $departmentSummaryArray[$departmentId]['user_count'] += $userCount;
            $this->groupDetailArray[] = [
                'department_name' => $summary->department_name,
                'group_name' => $summary->group_name,
                'total_office_count' => $officeCount,
                'total_user_count' => $userCount,
            ];
        }
        $this->departmentSummaryArray = array_values($departmentSummaryArray);
    }
    public function render()
    {
        return view('livewire.mis-report.users.user-mis-report', [
            'departmentSummaryArray' => $this->departmentSummaryArray,
            'groupDetailArray' => $this->groupDetailArray,
        ]);
    }
}
