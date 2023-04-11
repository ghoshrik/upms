<?php

namespace App\Http\Livewire\AssignToAnotherOffice;

use App\Models\Role;
use App\Models\User;
use App\Models\Office;
use Livewire\Component;
use App\Models\Designation;
use Illuminate\Support\Facades\Auth;

class AssignToAnotherOfficeCreate extends Component
{
    public $dropDownData = [], $newAccessData = [];
    public function mount()
    {
        $this->newAccessData = [
            'designation_id' => null,
            'users_id' => [],
            'roles_id' => [],
        ];
        $this->getDropdownData('designations');
    }
    public function getUsers()
    {
        $this->dropDownData['users'] = User::select('users.id', 'users.emp_name','users.ehrms_id','users.designation_id','users.office_id','users.mobile','users.email')->join('user_types', 'users.user_type', '=', 'user_types.id')
            ->where([['user_types.parent_id', Auth::user()->user_type], ['users.department_id', Auth::user()->department_id], ['users.designation_id', $this->newAccessData['designation_id']]])->get();
    }
    public function assignOffice($userId)
    {
        $this->emit('openAssignModel', $userId);
        // $this->newAccessData['users_id']= $userId;
        // $this->getDropdownData('roles');
        // $this->openAssignModal = true;
    }
    public function getDropdownData($lookingFor)
    {
        try {
            switch ($lookingFor) {
                case 'designations':
                    $this->dropDownData['designations'] = Designation::all();
                    break;
                case 'OFC':
                    $this->dropDownData['offices'] = Office::where('id', Auth::user()->office_id)->get();
                    break;
                case 'roles':
                    $this->dropDownData['roles'] = Role::join('roles_order','roles.id','=','roles_order.role_id')->where('roles_order.parent_id','>',3)->get();
                    break;
                default:
                    // $this->allUsers = User::select('users.id','users.emp_name')->join('user_types', 'users.user_type', '=', 'user_types.id')
                    // ->where([['parent_id', Auth::user()->user_type], ['department_id', Auth::user()->department_id]])->get();
                    break;
            }
        } catch (\Throwable $th) {
            session()->flash('serverError', $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.assign-to-another-office.assign-to-another-office-create');
    }
}
