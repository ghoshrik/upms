<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Office;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use WireUi\Traits\Actions;

use function PHPUnit\Framework\isEmpty;

class CreateUser extends Component
{
    use Actions;
    public $dropDownData = [], $newUserData = [];

    protected $rules = [
        'email'=>'required|unique:users,email',
        'phone'=>'required',
    ];
    protected $messages = [
        'email.required'=>'Email Field is required',
        'phone.required'=>'phone number field is required',
    ];


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
            'mobile'=>'',
            'email'=>'',
            'level'=>'',
        ];
        if (Auth::user()->user_type == 2) {
            $this->getDropdownData('DEPT');
        }
        if (Auth::user()->user_type == 3) {
            $this->getDropdownData('OFFC');
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
            } elseif ($lookingFor === 'OFFC') {
                $this->dropDownData['offices'] = Office::where('department_id', Auth::user()->department_id)->get();
            } else {
                // $this->allUserTypes = UserType::where('parent_id', Auth::user()->user_type)->get();
            }
        } catch (\Throwable $th) {
            session()->flash('serverError', $th->getMessage());
        }
    }

    public function store()
    {
        $this->validate();
        try{
        // TODO::INSERT THE DEPT. ID NAD OFFICE ID .
                unset($this->newUserData['confirm_password']);
                $userType =  UserType::where('parent_id', Auth::user()->user_type)->first();
                if (isset($userType)) {
                    $this->newUserData['user_type'] = $userType['id'];
                    $this->newUserData['department_id'] = Auth::user()->department_id;
                    $this->newUserData['office_id'] = Auth::user()->office_id;
                    $this->newUserData['email'] = $this->newUserData['email'];
                    $this->newUserData['mobile'] = $this->newUserData['mobile'];
                    // $this->newUserData['password'] = Hash::make($this->newUserData['password']);
                    $this->newUserData['password'] = Hash::make('password');
                    if (User::create($this->newUserData)) {
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
            }

            catch (\Throwable $th) {
                $this->emit('showError', $th->getMessage());
            }
    }
    public function render()
    {
        return view('livewire.user-management.create-user');
    }
}
