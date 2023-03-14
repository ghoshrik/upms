<?php

namespace App\Http\Livewire\AssignDeptAdmin;

use App\Models\Department;
use App\Models\User;
use Livewire\Component;
use WireUi\Traits\Actions;

use function PHPSTORM_META\map;

class AssignDepartmentAdminList extends Component
{
    use Actions;
    public $hodUsers,$departments,$selectedUser;
    public function mount()
    {
        $this->hodUsers = User::where('user_type',3)->get();

        $this->selectedUser = collect($this->hodUsers)->filter(function ($user) {
            return $user['department_id'] !== null;
        })->mapWithKeys(function ($user) {
            return [$user['department_id'] => $user['id']];
        })->all();

        // $this->departments = Department::all();
        $this->departments = Department::leftJoin('users', function($join) {
            $join->on('departments.id', '=', 'users.department_id')
                 ->where('users.user_type', '=', 3);
        })
        ->select('departments.id as id', 'departments.department_name', 'users.id as user_id')
        ->get();
    }
    public function assign($department_id)
    {
       $selectUserData =  User::where('id',$this->selectedUser[$department_id]);
       if($selectUserData->where('department_id',null)->first()){
            $selectUserData->update(['department_id'=>$department_id]);
            $this->notification()->success(
                $title = 'User Assign successfully'
            );
            return;
       }
       $this->notification()->error(
        $title = 'User already assigned.'
       );
    }
    public function render()
    {
        return view('livewire.assign-dept-admin.assign-department-admin-list');
    }
}
