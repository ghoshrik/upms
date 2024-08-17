<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Group;
use App\Models\Office;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        // if (Auth::user()->user_type == 3) {
        //     $this->rules = Arr::collapse([$this->rules, [
        //         'newUserData.office_id' => 'required|integer',
        //         'selectLevel' => 'required',
        //     ]]);
        //     // dd("asdsad");
        // }
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
            'group_id' => '',
            'role_id' => '',
            // 'is_active' => 1,
        ];
        // dd(Auth::user()->hasRole('State Admin'));
        if (Auth::user()->hasRole('State Admin')) {
            $this->getDropdownData('DEPT');
            $this->getDropdownData('DES');
            $this->getDropdownData('Roles');
            // $this->getDropdownData('Groups');
        } elseif (Auth::user()->hasRole('Department Admin')) {
            $this->getDropdownData('DES');
            $this->getDropdownData('Roles');
            $this->getDropdownData('Groups');
        } elseif (Auth::user()->hasRole('Group Admin')) {
            $this->getDropdownData('DES');
            $this->getDropdownData('Roles');
            $this->getDropdownData('OFC');
        }elseif (Auth::user()->hasRole('Office Admin')) {
            $this->getDropdownData('DES');
            $this->getDropdownData('Roles');
            $this->getDropdownData('OFC');
        }
        // if (Auth::user()->user_type == 3) {
        //     $this->getDropdownData('LEVEL');
        //     $this->getDropdownData('DES');
        // }
        // if (Auth::user()->user_type == 4) {
        //     $this->getDropdownData('DES');
        // }
        // dd($this->dropDownData,Auth::user()->user_type);
    }
    public function getDropdownData($lookingFor)
    {
        try {
            if ($lookingFor === 'DES') {
                $this->dropDownData['designations'] = Designation::all();
            } elseif ($lookingFor === 'DEPT') {
                if (Auth::user()->department_id) {
                    $this->dropDownData['departments'] = Department::where('id', Auth::user()->department_id)->get();
                    $this->dropDownData['designations'] = Designation::all();
                } else {
                    $this->dropDownData['departments'] = Department::all();
                    $this->dropDownData['designations'] = Designation::all();
                }
            } elseif ($lookingFor === 'LEVEL') {
                $this->dropDownData['level'] = true;
            } elseif ($lookingFor === 'Groups') {
                $department = Department::find(Auth::user()->department_id);
                $this->dropDownData['groups'] = $department->groups;
                if (!Auth::user()->hasRole('Department Admin')) {
                    $this->dropDownData['offices'] = [];
                }
            } elseif ($lookingFor === 'Roles') {
                if (Auth::user()->hasRole('State Admin')) {
                    $this->dropDownData['roles'] = Role::where('id', 6)->get();
                } elseif (Auth::user()->hasRole('Department Admin')) {
                    $this->dropDownData['roles'] = Role::where('name', 'Group Admin')->get();
                } elseif(Auth::user()->hasRole('Group Admin')) {
                    $this->dropDownData['roles'] = Role::whereIn('name',['Office Admin'])->get();
                } elseif(Auth::user()->hasRole('Office Admin')) {
                    $this->dropDownData['roles'] = Role::whereIn('name',['Chief Engineer','Superintending Engineer','Executive Engineer','Assistant Engineer','Junior Engineer'])->get();
                }
            }elseif($lookingFor === 'OFC'){
                $group = Group::where('id',Auth::user()->group_id)->first();
                $this->newUserData['group_id'] = $group->id;
                $this->dropDownData['offices'] = $group->offices;
                if(Auth::user()->hasRole('Office Admin')){
                    $this->newUserData['office_id'] = Auth::user()->resources->first()->resource_id;
                }
            } else {
                // $this->allUserTypes = UserType::where('parent_id', Auth::user()->user_type)->get();
            }
        } catch (\Throwable $th) {
            session()->flash('serverError', $th->getMessage());
        }
    }
    public function getGroupOffices()
    {
        if ($this->newUserData['group_id'] != '') {
            $group = Group::where('id', $this->newUserData['group_id'])->first();
            $this->dropDownData['offices'] = $group->offices;
        }
    }
    public function fetchLevelWiseOffice()
    {
        if ($this->selectLevel) {
            $this->dropDownData['offices'] = Office::where([['department_id', Auth::user()->department_id], ['level_no', $this->selectLevel]])->get();
        }
    }
    public function updated($param)
    {
        $this->validateOnly($param);
    }
    public function store()
    {

        // dd($this->newUserData);
        $this->validate();
        DB::beginTransaction();
        try {
            unset($this->newUserData['confirm_password']);
            // $userType = UserType::where('parent_id', Auth::user()->user_type)->first();
            if ($this->newUserData['role_id'] != '') {
                // $this->newUserData['user_type'] = $userType['id'];
                $this->newUserData['department_id'] = (Auth::user()->department_id != '' && Auth::user()->department_id != 0) ? Auth::user()->department_id : $this->newUserData['department_id'];
                $this->newUserData['designation_id'] = $this->newUserData['designation_id'];
                // $this->newUserData['office_id'] = ($this->newUserData['office_id'] == '') ? Auth::user()->office_id : $this->newUserData['office_id'];
                $this->newUserData['office_id'] = ($this->newUserData['office_id'] == '') ? 0 : $this->newUserData['office_id'];
                $this->newUserData['group_id'] = ($this->newUserData['group_id'] == '') ? 0 : $this->newUserData['group_id'];
                $this->newUserData['email'] = $this->newUserData['email'];
                $this->newUserData['mobile'] = $this->newUserData['mobile'];
                $this->newUserData['password'] = Hash::make($this->newUserData['password']);
                $newUserDetails = User::create($this->newUserData);
                if ($newUserDetails) {
                    $this->notification()->success(
                        $title = 'Success',
                        $description = trans('cruds.user-management.create_msg')
                    );
                    if($this->newUserData['office_id'] != '' && $this->newUserData['office_id'] != 0){
                        $newUserDetails->resources()->create([
                            'resource_id' => $this->newUserData['office_id'],
                            'resource_type' => 'App\Models\Office',
                        ]);
                    }
                    $role_name = Role::where('id', $this->newUserData['role_id'])->first();
                    // if (Auth::user()->user_type != 4) {
                    $assignRoleDetails = $newUserDetails->syncRoles([$role_name->name]);
                    if ($assignRoleDetails) {
                        $this->notification()->success(
                            $title = 'Success',
                            $description = $role_name->name . ' Role Assigned'
                        );
                    }
                    // UsersHasRoles::create([
                    //     'user_id' => $assignRoleDetails->id,
                    //     'role_id' => $assignRoleDetails->roles[0]->id
                    // ]);
                    // dd($newUserDetails,Auth::user()->user_type,$userType->type);
                    // }
                    DB::commit();
                    $this->reset();
                    $this->emit('openEntryForm');
                    return;
                }
            }
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            DB::rollBack();
            $this->notification()->error(
                $title = 'Error !!!',
                $description = 'Something went wrong.'
            );
            $this->emit('showError', $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.user-management.create-user');
    }
}
