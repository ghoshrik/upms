<?php

namespace App\Http\Livewire\UserManagement;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

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
        if(Auth::user()->user_type==2)
        {
            $this->tabs[] =
                [

                    'title' => 'Departments Users',
                    'id' => 'department',
                    'data' => 2,

                ];
        }
        // else if(Auth::user()->user_type==3)
        // {

            $this->tabs[]=
            [
                'title' => 'Office Admin Users',
                'id' => 'office-admin',
                'data' => 3,
            ];
        // }
        // else{

            $this->tabs[]=
            [
                'title' => 'Office Users',
                'id' => 'office-user',
                'data' => 4,
            ];

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
