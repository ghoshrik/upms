<?php

namespace App\Http\Livewire\MisReport\Users;

use Livewire\Component;
use App\Models\Group;
use App\Models\Department;
use App\Models\DepartmentCategory;
use App\Models\Office;

class UserMisReport extends Component
{
    public $groupCounts;
    public $departments;
    public $departmentCategories;
    public $offices;

    public function mount()
    {

        // $this->departments = Department::join('groups', 'departments.id', '=', 'groups.department_id')
        // ->select('departments.id', 'departments.department_name')
        // ->selectRaw('COUNT(groups.id) as group_count')
        // ->groupBy('departments.id')
        // ->havingRaw('COUNT(groups.id) > 0')
        // ->get();

        $this->departmentSummary = Department::leftJoin('groups', 'departments.id', '=', 'groups.department_id')
        ->leftJoin('offices', 'groups.id', '=', 'offices.group_id')
        ->select('departments.id as department_id', 'departments.department_name')
        ->selectRaw('COUNT(DISTINCT groups.id) as group_count')
        ->selectRaw('COUNT(offices.id) as office_count')
        ->groupBy('departments.id', 'departments.department_name')
        ->havingRaw('COUNT(groups.id) > 0')
        ->get();

        $this->groupOfficeCounts = Group::leftJoin('offices', 'groups.id', '=', 'offices.group_id')
        ->select('groups.id as group_id', 'groups.group_name', 'groups.department_id')
        ->selectRaw('COUNT(offices.id) as office_count')
        ->groupBy('groups.id', 'groups.group_name', 'groups.department_id')
        ->get();


        $this->departments = $this->departmentSummary->map(function ($department) {
            $department->groups = $this->groupOfficeCounts->where('department_id', $department->department_id);
            return $department;
        });


        // dd( $this->departments );

    }



    public function render()
    {
        return view('livewire.mis-report.users.user-mis-report', [
            'departmentss' => $this->departments,


        ]);
    }
}
