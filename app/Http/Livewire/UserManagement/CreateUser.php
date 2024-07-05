<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Office;
use App\Models\States;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use WireUi\Traits\Actions;

class CreateUser extends Component
{
    use Actions;
    public $dropDownData = [], $newUserData = [], $selectLevel;

    protected $rules = [
        'newUserData.email' => 'required|email|unique:users,email',
        // 'newUserData.emp_id'=>'required|numeric'
        'newUserData.username' => 'required|unique:users,username',
        'newUserData.emp_name' => 'required|string',

        'newUserData.mobile' => 'required|numeric|min:10|unique:users,mobile',

    ];
    protected $messages = [
        'newUserData.email.required' => 'Email Field is required',
        'newUserData.email.email' => 'Please enter a valid email address',
        'newUserData.email.unique' => 'The email address is already in use.',

        'newUserData.username.required' => 'username is required',
        'newUserData.username.string' => 'username must be string',
        'newUserData.username.unique' => 'The login Id is already in use.',

        'newUserData.emp_name.required' => 'employee name is required',
        'newUserData.emp_name.string' => 'error',

        'newUserData.department_id.required' => 'please select department',
        'newUserData.department_id.integer' => 'do not format',

        'newUserData.mobile.required' => 'The mobile number is required',
        'newUserData.mobile.numeric' => 'The mobile number must be a number',
        'newUserData.mobile.unique' => 'The mobile number is already in use',
        'newUserData.mobile.min' => 'The mobile number must be exactly 10 digits long',

        'newUserData.office_id.required' => 'The office name must be required',
        'newUserData.office_id.integer' => 'data mismatch',

        'selectLevel.required' => 'The Office level must be required',
        'newUserData.designation_id.required' => 'The designation must be required',
        'newUserData.designation_id.integer' => 'data mismatch',
    ];

    public function booted()
    {
        if (Auth::user()->user_type == 2) {
            $this->rules = Arr::collapse([$this->rules, [
                'newUserData.department_id' => 'required|integer',
            ]]);
        }

        if (Auth::user()->user_type == 3) {
            $this->rules = Arr::collapse([$this->rules, [
                'newUserData.office_id' => 'required|integer',
                'selectLevel' => 'required',
            ]]);
            // dd("asdsad");
        }
        if (Auth::user()->user_type == 4) {
            $this->rules = Arr::collapse([$this->rules, [
                'newUserData.designation_id' => 'required|integer',
            ]]);
        }
    }

    public function mount()
    {
        $this->newUserData = [
            'emp_name' => '',
            'ehrms_id' => '',
            'department_id' => '',
            'designation_id' => '',
            'office_id' => '',
            'username' => '',
            'password' => '',
            'confirm_password' => '',
            'mobile' => '',
            'email' => '',
            'state_code' => '',
            // 'is_active' => 1,
        ];
        if (Auth::user()->user_type == 1) {
            $this->dropDownData['states'] = States::all();
        }
        if (Auth::user()->user_type == 2) {
            $this->getDropdownData('DEPT');
            $this->getDropdownData('DES');
            $this->getDropdownData('LEVEL');
            $this->dropDownData['offices'] = [];
        }
        if (Auth::user()->user_type == 3) {
            $this->getDropdownData('LEVEL');
            $this->getDropdownData('DES');
        }
        if (Auth::user()->user_type == 4) {
            $this->getDropdownData('DES');
        }
    }
    public function getDropdownData($lookingFor)
    {
        try {
            if ($lookingFor === 'DES') {
                $this->dropDownData['designations'] = [];
            } elseif ($lookingFor === 'DEPT') {
                if (Auth::user()->department_id) {
                    $this->dropDownData['departments'] = Department::where('id', Auth::user()->department_id)->get();
                    $this->dropDownData['designations'] = Designation::all();
                } else {
                    $this->dropDownData['departments'] = Department::all();
                    $this->dropDownData['designations'] = Designation::all();
                }
            } elseif ($lookingFor === 'LEVEL') {
                $this->dropDownData['levels'] = [
                    ['name' => 'L1 Level', 'id' => 1],
                    ['name' => 'L2 Level', 'id' => 2],
                    ['name' => 'L3 Level', 'id' => 3],
                    ['name' => 'L4 Level', 'id' => 4],
                    ['name' => 'L5 Level', 'id' => 5],
                    ['name' => 'L6 Level', 'id' => 6],
                ];
                if (Auth::user()->user_type == 2) {
                    $this->dropDownData['levels'] = [
                        ['name' => 'L1 Level', 'id' => 1],
                    ];
                }
            } else {
                // $this->allUserTypes = UserType::where('parent_id', Auth::user()->user_type)->get();
            }
        } catch (\Throwable $th) {
            session()->flash('serverError', $th->getMessage());
        }
    }
    public function fetchLevelWiseOffice()
    {
        $this->dropDownData['offices'] = [];
        if (Auth::user()->getRoleNames()->isNotEmpty() && (Auth::user()->getRoleNames()[0] != 'Super Admin' || Auth::user()->getRoleNames()[0] == 'State Admin')) {
            // Check if the department ID is set
            if (!empty($this->newUserData['department_id'])) {
                // Check if the level is set
                if (!empty($this->selectLevel)) {
                    $this->dropDownData['designations'] = Designation::where('level_no', $this->selectLevel)->get();
                    // Fetch the offices based on the department ID and level
                    $this->dropDownData['offices'] = Office::where([
                        ['department_id', $this->newUserData['department_id']],
                        ['level_no', $this->selectLevel],
                    ])->get();
                }
            } else {
                // Notify the user to select a department first
                $this->notification()->error(
                    $title = 'Error',
                    $description = 'Please Select Department First.'
                );
                $this->reset('selectLevel');
            }
        }

    }
    public function updated($param)
    {
        $this->validateOnly($param);
    }
    public function store()
    {
        // $this->validate();
        // dd($this->newUserData);
        try {
            unset($this->newUserData['confirm_password']);
            $userType = UserType::where('parent_id', Auth::user()->user_type)->first();
            if (isset($userType)) {
                $this->newUserData['user_type'] = 0;
                $this->newUserData['department_id'] = (Auth::user()->user_type == 2) ? $this->newUserData['department_id'] : Auth::user()->department_id;
                $this->newUserData['designation_id'] = ($this->newUserData['designation_id'] == '') ? Auth::user()->designation_id : $this->newUserData['designation_id'];
                $this->newUserData['office_id'] = ($this->newUserData['office_id'] == '') ? Auth::user()->office_id : $this->newUserData['office_id'];
                $this->newUserData['email'] = $this->newUserData['email'];
                $this->newUserData['mobile'] = $this->newUserData['mobile'];
                // $this->newUserData['password'] = Hash::make($this->newUserData['password']);
                $this->newUserData['password'] = Hash::make('password');
                $this->newUserData['state_code'] = Auth::user()->state_code;
                $newUserDetails = User::create($this->newUserData);
                // $newUserDetails = true;
                if ($newUserDetails) {
                    // if (Auth::user()->user_type != 4) {
                    //     $assignRoleDetails = $newUserDetails->syncRoles([$userType->type]);
                    //     UsersHasRoles::create([
                    //         'user_id' => $assignRoleDetails->id,
                    //         'role_id' => $assignRoleDetails->roles[0]->id
                    //     ]);
                    //     // dd($newUserDetails,Auth::user()->user_type,$userType->type);
                    // }
                    $this->notification()->success(
                        $title = 'Success',
                        $description = trans('cruds.user-management.create_msg')
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
            // dd($th->getMessage());
            $this->emit('showError', $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.user-management.create-user');
    }
}
