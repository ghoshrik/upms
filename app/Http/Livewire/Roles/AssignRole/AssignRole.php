<?php

namespace App\Http\Livewire\Roles\AssignRole;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class AssignRole extends Component
{
    use Actions;
    public $formOpen = false, $editFormOpen = false, $updateDataTableTracker;
    public $titel = 'Assign Role';
    public $subTitel = 'List';
    protected $listeners = ['openEntryForm' => 'fromEntryControl','reset'=>'mount'];
    public $openedFormType = false, $isFromOpen, $selectedIdForEdit, $errorMessage, $AccessManagerTable = [];
    public $assignUserList = [];
    public function mount()
    {
        $userRole = Auth::user()->roles1->first();
        // dd($userRole);
        $childRoles = $userRole->childRoles;
        // dd($childRoles);
        foreach ($childRoles as $key => $role) {
            $usersWithRole = User::where('created_by',Auth::user()->id)->whereHas('roles', function ($query) use ($role) {
                $query->where('id', $role->id);
            })
            // ->where('created_by',Auth::user()->id)
                ->with('roles')
                ->get()
                ->toArray();
            foreach ($usersWithRole as $user) {
                $userExists = false;
                foreach ($this->assignUserList as $assignedUsers) {
                    foreach ($assignedUsers as $assignedUser) {
                        if ($assignedUser == $user['id']) {
                            $userExists = true;
                            break 2; // Break out of both loops
                        }
                    }
                }
                if (!$userExists) {
                    $this->assignUserList[] = $user;
                }
            }
        }
        // dd($this->assignUserList);
    }
    public function fromEntryControl($data = '')
    {
        // dd($data['id']);
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
        $this->updateDataTableTracker = rand(1, 1000);
    }

    public function roleRevokeConf($id)
    {

        $this->dialog()->confirm([
            'title' => 'Are you Sure Revoke All Roles?',
            'icon' => 'error',
            'accept' => [
                'label' => 'Yes',
                'method' => 'rolesRevoke',
                'params' => $id,
            ],
            'reject' => [
                'label' => 'No, cancel',
                // 'method'=>"fromEntryControl",
                // 'params' => ['formType' => 'edit', 'id' => $id],
            ]
        ]);
    }
    public function roleChangeConf($id)
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure Change Existing Roles?',
            'icon' => 'success',
            'accept' => [
                'label' => 'Yes',
                'method'=>"fromEntryControl",
                'params' => ['formType' => 'edit', 'id' => $id],
            ],
            'reject' => [
                'label' => 'No, cancel',

            ]
        ]);
    }
    public function rolesRevoke($id)
    {
        $user = User::find($id);
        if (!$user) {
            $this->notification()->error(
                $title = 'Error',
                $description = 'User Not Exists'
            );
        }
        $user->roles()->detach();
        $user->where('id',$id)->update(['is_active'=>0]);
        $this->notification()->success(
            $title = 'Success',
            $description = 'All Roles Removes successfully'
        );
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        return view('livewire.roles.assign-role.assign-role');
    }
}
