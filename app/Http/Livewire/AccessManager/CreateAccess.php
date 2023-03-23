<?php

namespace App\Http\Livewire\AccessManager;

use App\Models\AccessMaster;
use App\Models\AccessType;
use App\Models\Designation;
use App\Models\Office;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class CreateAccess extends Component
{
    use Actions;
    public $dropDownData = [], $newAccessData = [];
    public $access_type_name = [], $userlist = [];
    // protected $rules = [
    //     ''
    // ];

    public function mount()
    {
        $this->newAccessData = [
            'designation_id' => null,
            'user_id' => null,
            'access_type_id' => null,
        ];
        $this->getDropdownData('DES');
        $this->getDropdownData('ACCS');
    }
    public function getDropdownData($lookingFor)
    {
        try {
            switch ($lookingFor) {
                case 'DES':
                    $this->dropDownData['designations'] = Designation::all();
                    break;
                case 'OFC':
                    $this->dropDownData['offices'] = Office::where('id', Auth::user()->office_id)->get();
                    break;
                case 'ACCS':
                    $this->dropDownData['accessTypes'] = AccessType::all();
                    break;
                default:
                    // $this->allUsers = User::select('users.id','users.emp_name')->join('user_types', 'users.user_type', '=', 'user_types.id')
                    // ->where([['parent_id', Auth::user()->user_type], ['department_id', Auth::user()->department_id]])->get();
                    break;
            }
        } catch (\Throwable$th) {
            session()->flash('serverError', $th->getMessage());
        }
    }
    public function getUsers()
    {
        $this->dropDownData['users'] = User::select('users.id', 'users.emp_name')->join('user_types', 'users.user_type', '=', 'user_types.id')
            ->where([['parent_id', Auth::user()->user_type], ['department_id', Auth::user()->department_id], ['designation_id', $this->newAccessData['designation_id']], ['office_id', Auth::user()->office_id]])->get();
    }

    public function store()
    {
        try {
            $this->newAccessData['department_id'] = Auth::user()->department_id;
            $this->newAccessData['office_id'] = Auth::user()->office_id;
            $accessTypeName = array_filter($this->dropDownData['accessTypes'], function ($e) {
                if ($e['id'] == $this->newAccessData['access_type_id']) {
                    return $e;
                }
            });
            $accessTypeName = $accessTypeName[array_key_first($accessTypeName)];
            foreach ($this->newAccessData['user_id'] as $user_id) {
                $newAccessData = $this->newAccessData;
                $newAccessData['user_id'] = $user_id;
                // dd($newAccessData);
                $isAlreadyAssign = AccessMaster::where([['user_id', $user_id], ['access_type_id', $this->newAccessData['access_type_id']]])->first();
                if (!isset($isAlreadyAssign)) {
                    if (AccessMaster::create($newAccessData)) {
                        $user = User::find($user_id);
                        $user->assignRole($accessTypeName['access_name']);
                        $this->notification()->success(
                            $title = 'Success',
                            $description = 'New User created successfully!'
                        );
                    } else {
                        $this->notification()->error(
                            $title = 'Error !!!',
                            $description = 'Something went wrong.'
                        );
                        // return;
                    }
                }else{
                    $this->notification()->error(
                        $title = 'Error !!!',
                        $description = 'User already assign.'
                    );
                }

            }
            $this->reset();
            $this->emit('openEntryForm');
            return;
        } catch (\Throwable$th) {
            dd($th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.access-manager.create-access');
    }
}
