<?php

namespace App\Http\Livewire\EstimateSanctionLimit;

use App\Models\Role;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use App\Models\EstimateAcceptanceLimitMaster;

class EstimateSanctionMaster extends Component
{
    public $formOpen = false;
    protected $listeners = ['openEntryForm' => 'fromEntryControl','showError'=>'setErrorAlert','openAddRolesSection'];
    public $openedFormType= false,$isFromOpen,$subTitle = "List",$selectedIdForEdit,$errorMessage,$title;
    public $openAddRolesForm = false;
    public $addedOfficeUpdateTrack;
    public $sanctionLimit;
    public $roles = [];
    public $role_id;
    public $permission_name;
    public $permissions = [];

    public $sanction_roles_permissions = [];

    public function mount()
    {
        $this->addedOfficeUpdateTrack = rand(1,1000);
        $this->roles = Role::whereIn('id', [3, 4, 5, 7, 9])->orderBy('has_level_no')->get();
        $this->sanction_roles_permissions = collect();
        $this->permissions = collect([
            'create estimate'   =>  'Maker',
            'verify estimate'   =>  'Checker',
            'approve estimate'  =>  'Approver',
        ]);
    }

    public function fromEntryControl($data='')
    {
        $this->openedFormType = is_array($data) ? $data['formType']:$data;
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
        if(isset($data['id'])){
            $this->selectedIdForEdit = $data['id'];
        }
    }
    public function openAddRolesSection($id){
        $this->sanctionLimit = EstimateAcceptanceLimitMaster::find($id)->first();

        $this->sanction_roles_permissions = DB::table('sanctions_roles_permissions')
        ->join('roles', 'roles.id', '=', 'sanctions_roles_permissions.role_id')
        ->join('permissions', 'permissions.id', '=', 'sanctions_roles_permissions.permission_id')
        ->where('sanctions_roles_permissions.sanction_id', $this->sanctionLimit->id)
        ->selectRaw('roles.name AS role_name')
        ->selectRaw('permissions.name AS permission_name')
        ->selectRaw('sanctions_roles_permissions.sequence_no')
        ->get();

        $this->openAddRolesForm = !$this->openAddRolesForm;
    }

    public function addSanctionRolePermission()
    {
        // Need to apply Validation
        DB::table('sanctions_roles_permissions')->insert([
            'sanction_id'   =>  $this->sanctionLimit->id,
            'role_id'   =>  $this->role_id,
            'permission_id'   =>  Permission::whereName($this->permission_name)->first()->id,
        ]);

       $this->refreshSanctionRolePermissions();
    }

    public function refreshSanctionRolePermissions()
    {
        $this->sanction_roles_permissions = DB::table('sanctions_roles_permissions')
        ->join('roles', 'roles.id', '=', 'sanctions_roles_permissions.role_id')
        ->join('permissions', 'permissions.id', '=', 'sanctions_roles_permissions.permission_id')
        ->where('sanctions_roles_permissions.sanction_id', $this->sanctionLimit->id)
        ->selectRaw('roles.name AS role_name')
        ->selectRaw('permissions.name AS permission_name')
        ->selectRaw('sanctions_roles_permissions.sequence_no')
        ->get();
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
