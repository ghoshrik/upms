<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Office;
use App\Models\User;
use App\Models\UsersHasRoles;
use App\Models\UserType;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use WireUi\Traits\Actions;

use function PHPUnit\Framework\isEmpty;

class CreateUser extends Component
{
    use Actions;
    public $dropDownData = [], $newUserData = [],$selectLevel;

    protected $rules = [
        'newUserData.email' => 'required|unique:users,email',
        // 'newUserData.emp_id'=>'required|numeric'
        'newUserData.username' => 'required|string',
        'newUserData.emp_name' => 'required|string',
        'newUserData.department_id' => 'required|integer',
        'newUserData.mobile' => 'required|numeric|min:10',

    ];
    protected $messages = [
        'newUserData.email.required' => 'Email Field is required',
        'newUserData.email.unique' => 'The email address is already in use.',
        'newUserData.username.required' => 'username is required',
        'newUserData.username.string' => 'username must be string',
        'newUserData.emp_name.required' => 'employee name is required',
        'newUserData.emp_name.string' => 'error',
        'newUserData.department_id.required' => 'please select department',
        'newUserData.department_id.integer' => 'do not format',
        'newUserData.mobile.required' => 'The mobile number is required',
        'newUserData.mobile.numeric' => 'The mobile number must be a number',
        'newUserData.mobile.min' => 'The mobile number must be exactly 10 digits long',
        'newUserData.office_id.required' => 'The office name must be required',
        'newUserData.office_id.integer' => 'data mismatch',
        'selectLevel.required' => 'The Office level must be required',

        // 'selectLevel.'
    ];
    public function booted()
    {
        // if($newUserData.office_id)
        if (Auth::user()->user_type == 3) {
            $this->rules =  Arr::collapse([$this->rules, [
                'newUserData.office_id' => 'required|integer',
                'selectLevel' => 'required|unique'
            ]]);
        }
        // if (Auth::user()->user_type == 3) {
    }

    public function mount()
    {
        $this->newUserData = [
            'emp_name' => '',
            'emp_id' => '',
            'department_id' => '',
            'designation_id' => '',
            'office_id' => '',
            'username' => '',
            'password' => '',
            'confirm_password' => '',
            'mobile' => '',
            'email' => '',
            'level' => '',
        ];
        if (Auth::user()->user_type == 2) {
            $this->getDropdownData('DEPT');
        }
        if (Auth::user()->user_type == 3) {
            $this->getDropdownData('LEVEL');
        }
        if (Auth::user()->user_type == 4) {
            $this->getDropdownData('DES');
        }
    }
    public function getDropdownData($lookingFor)
    {
        try {
            if ($lookingFor === 'DES') {
                $this->dropDownData['designations'] = Designation::all();
            } elseif ($lookingFor === 'DEPT') {
                if (Auth::user()->department_id) {
                    $this->dropDownData['departments'] = Department::where('id', Auth::user()->department_id)->get();
                } else {
                    $this->dropDownData['departments'] =  Department::all();
                }
            } elseif ($lookingFor === 'LEVEL') {
                $this->dropDownData['level'] = true;
            } else {
                // $this->allUserTypes = UserType::where('parent_id', Auth::user()->user_type)->get();
            }
        } catch (\Throwable $th) {
            session()->flash('serverError', $th->getMessage());
        }
    }
    public function fetchLevelWiseOffice()
    {
        if($this->selectLevel)
        {
            $this->dropDownData['offices'] = Office::where([['department_id', Auth::user()->department_id],['level',$this->selectLevel]])->get();
        }
    }
    public function store()
    {
        // $this->validate();
        try {
            unset($this->newUserData['confirm_password']);
            $userType =  UserType::where('parent_id', Auth::user()->user_type)->first();
            if (isset($userType)) {
                $this->newUserData['user_type'] = $userType['id'];
                $this->newUserData['department_id'] = (Auth::user()->user_type==2)? $this->newUserData['department_id'] : Auth::user()->department_id;
                $this->newUserData['designation_id'] = ($this->newUserData['designation_id'] == '') ? Auth::user()->designation_id : $this->newUserData['designation_id'];
                $this->newUserData['office_id'] = ($this->newUserData['office_id'] == '')? Auth::user()->office_id : $this->newUserData['office_id'];
                $this->newUserData['email'] = $this->newUserData['email'];
                $this->newUserData['mobile'] = $this->newUserData['mobile'];
                // $this->newUserData['password'] = Hash::make($this->newUserData['password']);
                $this->newUserData['password'] = Hash::make('password');
                $newUserDetails = User::create($this->newUserData);
                // $newUserDetails = true;
                if ($newUserDetails) {
                    if (Auth::user()->user_type != 4) {
                        $assignRoleDetails = $newUserDetails->syncRoles([$userType->type]);
                        UsersHasRoles::create([
                            'user_id' => $assignRoleDetails->id,
                            'role_id' => $assignRoleDetails->roles[0]->id
                        ]);
                        // dd($newUserDetails,Auth::user()->user_type,$userType->type);
                    }
                    $this->notification()->success(
                        $title = 'Success',
                        $description =  trans('cruds.user-management.create_msg')
                    );
                    $this->reset();
                    $this->emit('openEntryForm');
                    return;
                }
            }
            $this->notification()->error(
                $title = 'Error !!!',
                $description = 'Something went wrong.'
            );
        } catch (\Throwable $th) {
            dd($th->getMessage());
            $this->emit('showError', $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.user-management.create-user');
    }
}
