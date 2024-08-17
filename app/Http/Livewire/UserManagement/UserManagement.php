<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserManagement extends Component
{
    public $formOpen = false, $updateDataTableTracker;

    protected $listeners = ['openEntryForm' => 'fromEntryControl', 'showError' => 'setErrorAlert', 'refreshCSRFToken' => '$refresh'];
    public $openedFormType = false, $isFromOpen, $subTitel = "List", $selectedIdForEdit, $errorMessage, $titel;
    public $activeTab, $tabs = [];

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
            $this->tabs = [
                [
                    'title' => 'Department Admin Users',
                    'id' => 'department-admin',
                    'data' => Role::where('name', 'Department Admin')->first()->id,

                ], 
                // [
                //     'title' => 'Departments Users',
                //     'id' => 'department',
                //     'data' => 2,

                // ],
            ];
        } elseif (Auth::user()->hasRole('Department Admin')) {
            $this->tabs[] = [
                'title' => 'Group Admin Users',
                'id' => 'group-admin',
                'data' => Role::where('name', 'Group Admin')->first()->id,
            ];
        } elseif (Auth::user()->hasRole('Group Admin')) {
            $this->tabs[] = [
                'title' => 'Office Admin Users',
                'id' => 'office-admin',
                'data' => Role::where('name', 'Office Admin')->first()->id,
            ];
        } elseif (Auth::user()->hasRole('Office Admin')) {
            $roles = Role::whereIn('name', ['Chief Engineer', 'Superintending Engineer', 'Executive Engineer', 'Assistant Engineer', 'Junior Engineer'])->select('id', 'name')->get();
            foreach ($roles as $key => $role) {
                $this->tabs[] = [
                    'title' => $role['name'].' Users',
                    'id' => 'office-user'.$key,
                    // 'data' => array_values($roles),
                    'data' => $role['id'],
                ];
            }
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
        $this->titel = trans('cruds.user-management.title');
        $assets = ['chart', 'animation'];
        return view('livewire.user-management.user-management', compact('assets'));
    }
}
