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
        } catch (\Throwable $th) {
            session()->flash('serverError', $th->getMessage());
        }
    }
    public function getUsers()
    {
        $this->dropDownData['users'] = User::select('users.id', 'users.emp_name')->join('user_types', 'users.user_type', '=', 'user_types.id')
            ->where([['parent_id', Auth::user()->user_type], ['department_id', Auth::user()->department_id], ['designation_id', $this->newAccessData['designation_id']], ['office_id', Auth::user()->office_id]])->get();
    }
    public $access_type_name = [], $userlist = [];


    public function store()
    {

        try {

            $this->newAccessData['department_id'] = Auth::user()->department_id;
            $this->newAccessData['office_id'] = Auth::user()->office_id;
            $insert = [
                'department_id' => $this->newAccessData['department_id'],
                'office_id' => $this->newAccessData['office_id'],
                'designation_id' => $this->newAccessData['designation_id'],
                'access_type_id' => implode(',', $this->newAccessData['access_type_id']),
                'user_id' => implode(',', $this->newAccessData['user_id']),
            ];
            dd($insert);



            $accessTypeName = array_filter($this->dropDownData['accessTypes'], function ($e) {
                if ($e['id'] == $this->newAccessData['access_type_id']) {
                    return $e;
                }
            });
            // dd($accessTypeName);
            foreach ($this->newAccessData['access_type_id'] as $accesstype) {
                $access = AccessType::where('id', $accesstype)->pluck('access_name');
                $this->newAccessData['department_id'] = Auth::user()->department_id;
                $this->newAccessData['office_id'] = Auth::user()->office_id;

                // foreach($this->newAccessData['user_id'] as $users)
                // {
                //     foreach($this->newAccessData['access_type_id'] as $access_type)
                //     {
                //         $this->access_type_name = $access_type;
                //         $this->userlist = $users;
                //     }
                // }
                // if(AccessMaster::create($insert))
                // {
                //     $user = User::find($this->userlist);
                //     $user->assignRole($this->access_type_name);
                //     $this->notification()->success(
                //         $title = 'Success',
                //         $description =  'New User created successfully!'
                //     );
                //     $this->reset();
                //     $this->emit('openEntryForm');
                // }
                // else
                // {
                //     $this->notification()->error(
                //         $title = 'Error !!!',
                //         $description = 'Something went wrong.'
                //     );
                // }







                // $this->newAccessData['department_id'] = Auth::user()->department_id;
                // $this->newAccessData['office_id'] = Auth::user()->office_id;
                // implode(',',$this->newAccessData['access_type_id']);
                // implode()
                // $accessTypeName = array_filter($this->dropDownData['accessTypes'], function ($e) {
                //     if ($e['id'] == $this->newAccessData['access_type_id']) {
                //         return $e;
                //     }
                // });
                // dd($accessTypeName);

                // $accessTypeName = $accessTypeName[array_key_first($accessTypeName)];
                // dd()
                // foreach ($this->newAccessData['access_type_id'] as $access_type) {
                //     // $user = User::find($this->newAccessData['user_id']);
                //     // $sde = AccessType::whereIn('id', [$access_type])->pluck('access_name');
                //     // $user->assignRole([$sde]);
                //     $insert = [
                //         'department_id' => $this->newAccessData['department_id'],
                //         'designation_id' => $this->newAccessData['designation_id'],
                //         'office_id' => $this->newAccessData['office_id'],
                //         'access_type_id' => $access_type,
                //         'user_id' => $this->newAccessData['user_id'],
                //     ];
                //     dd($insert);
                //     if (AccessMaster::create($insert)) {
                //         // dd($accessTypeName['access_name']);
                //         // $user = User::find($this->newAccessData['user_id']);
                //         // $accessType = $access_type->pluck('access_name');

                //         // dd($accessType);
                //         // $user->assignRole($access_type);
                //         $this->notification()->success(
                //             $title = 'Success',
                //             $description =  'New User created successfully!'
                //         );
                //         $this->reset();
                //         $this->emit('openEntryForm');
                //     } else {
                //         $this->notification()->error(
                //             $title = 'Error !!!',
                //             $description = 'Something went wrong.'
                //         );
                //         return;
                //     }
                // }
                // dd($newAccessData);
                // dd($this->newAccessData);

                // foreach ($this->newAccessData['user_id'] as $user_id) {
                //     $newAccessData = $this->newAccessData;
                //     $newAccessData['user_id'] = $user_id;
                //     if(AccessMaster::create($this->newAccessData))
                // {
                //     $user = User::find($user_id);
                //     $user->assignRole($accessTypeName);
                //     $this->notification()->success(
                //         $title = 'Success',
                //         $description =  'New User created successfully!'
                //     );
                //     $this->reset();
                //     $this->emit('openEntryForm');
                // }
                // else
                // {
                //     $this->notification()->error(
                //         $title = 'Error !!!',
                //         $description = 'Something went wrong.'
                //     );
                // }

            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.access-manager.create-access');
    }
}