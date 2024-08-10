<?php

namespace App\Http\Livewire\EstimateSanctionLimit;

use App\Models\Role;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\SanctionRole;
use Illuminate\Support\Facades\DB;
use App\Models\SanctionLimitMaster;
use Illuminate\Notifications\Action;
use Spatie\Permission\Models\Permission;

class EstimateSanctionMaster extends Component
{
    use Actions;
    public $formOpen = false;
    protected $listeners = ['openEntryForm' => 'fromEntryControl', 'showError' => 'setErrorAlert', 'openAddRolesSection'];
    public $openedFormType = false, $isFromOpen, $subTitle = "List", $selectedIdForEdit, $errorMessage, $title;
    public $openAddRolesForm = false;
    public $updateDataTableTracker;
    public $sanctionLimit;
    public $roles = [];
    public $role_id;
    public $permission_name;
    public $permissions = [];
    public $sanction_roles = [];

    protected $rules = [
        'role_id' => 'required',
        'permission_name' => 'required',
    ];
    protected $messages = [
        'role_id.required' => 'This Field is Required.',
        'permission_name.required' => 'This Field is Required.',
    ];
    public function updated($param)
    {
        $this->validateOnly($param);
    }
    public function mount()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        $this->roles = Role::whereIn('id', [3, 4, 12, 7, 9])->orderBy('has_level_no')->get();
        $this->sanction_roles = collect();
        $this->permissions = collect([
            'create estimate' => 'Maker',
            'verify estimate' => 'Checker',
            'approve estimate' => 'Approver',
        ]);
    }

    public function fromEntryControl($data = '')
    {
        $this->openedFormType = is_array($data) ? $data['formType'] : $data;
        $this->isFromOpen = !$this->isFromOpen;
        switch ($this->openedFormType) {
            case 'create':
                $this->subTitle = 'Create';
                break;
            case 'edit':
                $this->subTitle = 'Edit';
                break;
            default:
                $this->subTitle = 'List';
                break;
        }
        if (isset($data['id'])) {
            $this->selectedIdForEdit = $data['id'];
        }
    }
    public function openAddRolesSection($id)
    {
        $this->sanctionLimit = SanctionLimitMaster::where('id', $id)->first();
        // $this->sanction_roles_permissions = DB::table('sanctions_roles_permissions')
        //     ->join('roles', 'roles.id', '=', 'sanctions_roles_permissions.role_id')
        //     ->join('permissions', 'permissions.id', '=', 'sanctions_roles_permissions.permission_id')
        //     ->where('sanctions_roles_permissions.sanction_id', $this->sanctionLimit->id)
        //     ->select('roles.name AS role_name','permissions.name AS permission_name','sanctions_roles_permissions.sequence_no','sanctions_roles_permissions.id as sanction_role_permission_id')
        //     // ->selectRaw('permissions.name AS permission_name')
        //     // ->selectRaw('sanctions_roles_permissions.sequence_no')
        //     // ->selectRaw('sanctions_roles_permissions.id as sanction_role_permission_id')
        //     ->get()
        //     ->map(function ($item) {
        //         return (array) $item;
        //     })
        //     ->toArray();
        $this->sanction_roles = $this->sanctionLimit->roles()->with(['role','permission'])->get();
        // dd($this->sanction_roles);
        $this->openAddRolesForm = !$this->openAddRolesForm;
        $this->reset(['role_id', 'permission_name']);
    }

    public function addSanctionRolePermission()
    {
        // Need to apply Validation
        $this->validate();
        DB::table('sanction_roles')->insert([
            'sanction_limit_master_id' => $this->sanctionLimit->id,
            'sequence_no' => count($this->sanction_roles) + 1,
            'role_id' => $this->role_id,
            'permission_id' => Permission::whereName($this->permission_name)->first()->id,
        ]);
        $this->reset(['role_id', 'permission_name']);
        $this->refreshSanctionRolePermissions();
    }

    public function refreshSanctionRolePermissions()
    {
        // $this->sanction_roles_permissions = DB::table('sanctions_roles_permissions')
        //     ->join('roles', 'roles.id', '=', 'sanctions_roles_permissions.role_id')
        //     ->join('permissions', 'permissions.id', '=', 'sanctions_roles_permissions.permission_id')
        //     ->where('sanctions_roles_permissions.sanction_id', $this->sanctionLimit->id)
        //     ->select('roles.name AS role_name','permissions.name AS permission_name','sanctions_roles_permissions.sequence_no','sanctions_roles_permissions.id as sanction_role_permission_id')
        //     // ->selectRaw('permissions.name AS permission_name')
        //     // ->selectRaw('sanctions_roles_permissions.sequence_no')
        //     // ->selectRaw('sanctions_roles_permissions.id as sanction_role_permission_id')
        //     ->get()
        //     ->map(function ($item) {
        //         return (array) $item;
        //     })
        //     ->toArray();
        $this->sanction_roles = $this->sanctionLimit->roles()->with(['role','permission'])->get();
    }
    public function confDeleteDialogRolePermission($value): void
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'icon' => 'error',
            'accept' => [
                'label' => 'Yes, Delete it',
                'method' => 'deleteSanctionRolePermission',
                'params' => $value,
            ],
            'reject' => [
                'label' => 'No, cancel',
                // 'method' => 'cancel',
            ],
        ]);
    }
    public function deleteSanctionRolePermission($id)
    {
        SanctionRole::where('id', $id)->delete();
        $this->refreshSanctionRolePermissions();
    }
    public function closeRolePermissionDrawer()
    {
        $this->reset(['openAddRolesForm', 'sanction_roles']);
    }
    public function setErrorAlert($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        $this->title = 'Estimate Sanction Limit Master';
        $assets = ['chart', 'animation'];
        return view('livewire.estimate-sanction-limit.estimate-sanction-master');
    }
}
