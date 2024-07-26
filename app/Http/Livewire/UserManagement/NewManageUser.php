<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\States;
use Livewire\Component;
use WireUi\Traits\Actions;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class NewManageUser extends Component
{
    use Actions;
    public $dropDownData = [], $newUserData = [], $isChecked = false;


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
            'department_id' => (Auth::user()->department_id != '' && Auth::user()->department_id != 0) ? Auth::user()->department_id : '',
            'designation_id' => '',
            'office_id' => '',
            'username' => '',
            'password' => '',
            'confirm_password' => '',
            'mobile' => '',
            'email' => '',
            'state_code' => '',
            'dept_category_id' => (Auth::user()->dept_category_id != '' && Auth::user()->dept_category_id != 0) ? Auth::user()->dept_category_id : '',
            // 'is_active' => 1,
        ];

        if (Auth::user()->user_type == 1) {
            $this->dropDownData['states'] = States::all();
        }
    }

    public function render()
    {
        return view('livewire.user-management.new-manage-user');
    }
}
