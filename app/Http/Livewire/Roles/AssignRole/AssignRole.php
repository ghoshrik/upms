<?php

namespace App\Http\Livewire\Roles\AssignRole;

use App\Models\User;
use Livewire\Component;

class AssignRole extends Component
{
    public $formOpen=false,$editFormOpen=false,$updateDataTableTracker;
    public $titel = 'Assign Role';
    public $subTitel='List';
    protected $listeners = ['openEntryForm' => 'fromEntryControl'];
    public $openedFormType= false,$isFromOpen,$selectedIdForEdit,$errorMessage,$AccessManagerTable = [];
    public $assignUserList = [];
    public function mount()
    {
        $this->assignUserList = User::with('roles')->has('roles')->get();
        // dd($this->assignUserList);
    }
    public function fromEntryControl($data='')
    {
        // dd($data);
        $this->openedFormType = is_array($data) ? $data['formType']:$data;
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
        if(isset($data['id'])){
            $this->selectedIdForEdit = $data['id'];
        }
        $this->updateDataTableTracker = rand(1,1000);
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1,1000);
        return view('livewire.roles.assign-role.assign-role');
    }
}
