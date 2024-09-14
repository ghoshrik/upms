<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use App\Models\UsersHasRoles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserManagement extends Component
{
    public $formOpen = false, $updateDataTableTracker;

    protected $listeners = ['openEntryForm' => 'fromEntryControl', 'showError' => 'setErrorAlert', 'refreshCSRFToken' => '$refresh', 'openRoleModal', 'closeAddRoleDrawer'];
    public $openedFormType = false, $isFromOpen, $subTitel = "List", $selectedIdForEdit, $errorMessage, $titel;
    public $activeTab, $tabs = [];
    public $openRoleModalForm = false, $editUserRole, $fetchDropdownData = [], $userRoles = [], $role_id = '';
    public function mount()
    {
        // $InputData = [];
        // $departmentUsers = 3;
        // $i = 1;
        // foreach ($departmentUsers as $user) {
        //     $InputData[] = [
        //         'Sl No' => $i,
        //         'name' => $user->emp_name,
        //         'email' => $user->email,

        //     ];
        // }
        // $i++;
        /*$this->tabs = [
        [

        'title' => 'Departments Users',
        'id' => 'department',
        'data' => 3,

        ],

        [
        'title' => 'Office Admin Users',
        'id' => 'office-admin',
        'data' => 4,
        ],
        [
        'title' => 'Office Users',
        'id' => 'office-user',
        'data' => 6,
        ]
        ];*/
        if (Auth::user()->user_type == 1) {
            $this->tabs[] =
                [

                    'title' => 'State Users',
                    'id' => 'state',
                    'data' => 1,

                ];
        }
        if (Auth::user()->hasRole('State Admin')) {
            $roles = Role::whereIn('name', ['Department Admin', 'Office Admin','Group Admin', 'SOR Preparer'])->orderBy('name')->select('id', 'name')->get();
            foreach ($roles as $key => $role) {
                $this->tabs[] = [
                    'title' => $role['name'],
                    'id' => 'office-user' . $key,
                    // 'data' => array_values($roles),
                    'data' => $role['id'],
                ];
            }
            $this->tabs[] =
            [
                'title' => 'Office User',
                'id' => 'office-users',
                'data' => 0,
            ];
        } elseif (Auth::user()->hasRole('Department Admin')) {
            $roles = Role::whereIn('name', ['Department Admin', 'Group Admin', 'SOR Preparer','Office Admin'])->orderBy('name')->select('id', 'name')->get();
            foreach ($roles as $key => $role) {
                $this->tabs[] = [
                    'title' => $role['name'],
                    'id' => 'office-user' . $key,
                    // 'data' => array_values($roles),
                    'data' => $role['id'],
                ];
            }
            $this->tabs[] =
            [
                'title' => 'Office User',
                'id' => 'office-users',
                'data' => 0,
            ];
        } elseif (Auth::user()->hasRole('Group Admin')) {
            $roles = Role::whereIn('name', ['Group Admin', 'Office Admin'])->orderBy('name')->select('id', 'name')->get();
            foreach ($roles as $key => $role) {
                $this->tabs[] = [
                    'title' => $role['name'],
                    'id' => 'office-user' . $key,
                    // 'data' => array_values($roles),
                    'data' => $role['id'],
                ];
            }
            $this->tabs[] =
            [
                'title' => 'Office User',
                'id' => 'office-users',
                'data' => 0,
            ];
        } elseif (Auth::user()->hasRole('Office Admin')) {
            //            $roles = Role::whereIn('name', ['Chief Engineer', 'Superintending Engineer', 'Executive Engineer', 'Assistant Engineer', 'Junior Engineer'])->select('id', 'name')->get();
            $roles = Role::where('for_sanction', true)->orWhere('name','Office Admin')->select('id', 'name')->get();
            foreach ($roles as $key => $role) {
                $this->tabs[] = [
                    'title' => $role['name'],
                    'title' => $role['name'],
                    'id' => 'office-user' . $key,
                    // 'data' => array_values($roles),
                    'data' => $role['id'],
                ];
            }
            $this->tabs[] =
            [
                'title' => 'Office User',
                'id' => 'office-users',
                'data' => 0,
            ];
        }
        // else if(Auth::user()->user_type==3)
        // {

        // $this->tabs[] =
        //     [
        //     'title' => 'Office Admin Users',
        //     'id' => 'office-admin',
        //     'data' => 3,
        // ];
        // }
        // else{

        // $this->tabs[] =
        //     [
        //     'title' => 'Office Users',
        //     'id' => 'office-user',
        //     'data' => 4,
        // ];

        // }*/

        // dd($this->tabs[1]['data']);
        $this->activeTab = $this->tabs[0]['title'];
        // dd($this->activeTab);
    }
    public function setActiveTab($title)
    {
        $this->activeTab = $title;
    }

    public function fromEntryControl($data = '')
    {
        $this->openedFormType = is_array($data) ? $data['formType'] : $data;
        $this->isFromOpen = !$this->isFromOpen;
        switch ($this->openedFormType) {
            case 'create':
                $this->subTitel = 'Create';
                break;
            case 'edit':
                $this->subTitel = 'Edit';
                break;
            default:
                $this->subTitel = 'List';
                break;
        }
        if (isset($data['id'])) {
            $this->selectedIdForEdit = $data['id'];
        }
    }
    public function openRoleModal($user)
    {
        $this->openRoleModalForm = !$this->openRoleModalForm;
        $this->editUserRole = $user;
        // $this->userRoles = $user->getUserRole->pluck('role_id');
        // $this->userRoles = $user->getUserRole;
        // $assignedRoles = $user->getUserRole->pluck('role_id');
        // $this->fetchDropdownData['roles'] = Role::whereIn('name', ['Department Admin', 'Group Admin', 'SOR Preparer'])
        //                                     // ->whereNotIn('id', $assignedRoles)
        //                                     ->orderBy('name')
        //                                     ->select('id', 'name')->get();
    }
    public function closeAddRoleDrawer()
    {
        $this->openRoleModalForm = !$this->openRoleModalForm;
        $this->reset('editUserRole');
    }
    public function getRoleWiseData()
    {
        // dd($this->userRoles);
        // $getRole = Role::where('id',$this->role_id)->first();
        // if($getRole->name == 'Group Admin'){
        //     $this->fetchDropdownData['groups'] = Group::where('department_id',Auth::user()->department_id)->get();
        // }else{
        //     unset($this->fetchDropdownData['groups']);
        // }
    }
    protected $rules = [
        'userRoles' => 'required',
    ];
    protected $messages = [
        'userRoles.required' => 'This Field is Required'
    ];
    public function updateUserRole()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            if (count($this->userRoles) > 0) {
                // Delete existing roles for the user
                UsersHasRoles::where('user_id', $this->editUserRole->id)->delete();
                // Create new roles for the user
                foreach ($this->userRoles as $role) {
                    UsersHasRoles::create([
                        'user_id' => $this->editUserRole->id,
                        'role_id' => $role,
                    ]);
                }
            } else {
                $this->openRoleModalForm = true;
            }
            // Commit the transaction
            DB::commit();
            $this->openRoleModalForm = !$this->openRoleModalForm;
        } catch (\Exception $e) {
            // Rollback the transaction if there was an error
            DB::rollBack();
        }
    }
    public function updated()
    {
        $this->dispatchBrowserEvent('refreshCSRFToken');
    }
    public function updatedRefreshCSRFToken()
    {
        $this->emit('$refresh');
    }
    public function setErrorAlert($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
    public function render()
    {
        // $this->updateDataTableTracker = rand(1, 9999);
        $this->titel = trans('cruds.user-management.title');
        $assets = ['chart', 'animation'];
        return view('livewire.user-management.user-management', compact('assets'));
    }
}
