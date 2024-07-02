<?php

namespace App\Http\Livewire\Components\Modal\Estimate;

use App\Models\EstimateUserAssignRecord;
use App\Models\SorMaster;
use App\Models\User;
use App\Models\UsersHasRoles;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class EstimateForwardModal extends Component
{
    use Actions;
    protected $listeners = ['openForwdModal' => 'fwdModalOpen'];
    public $fwdModal = false, $estimate_id, $assigenUsersList = [], $assignUserDetails, $userAssignRemarks, $updateDataTableTracker;
    public $fwdRequestFrom;
    public function fwdModalOpen($forwdEstimateDeatils)
    {

        dd($forwdEstimateDeatils);
        $this->reset();
        $estimate_id = is_array($forwdEstimateDeatils) ? $forwdEstimateDeatils['estimate_id'] : $forwdEstimateDeatils;
        $this->fwdRequestFrom = $forwdEstimateDeatils['forward_from'];
        $this->estimate_id = $estimate_id;
        $this->fwdModal = !$this->fwdModal;
        // $userAccess_id = AccessMaster::select('access_parent_id')->join('access_types', 'access_masters.access_type_id', '=', 'access_types.id')->where('user_id', Auth::user()->id)->first();
        // $this->assigenUsersList = User::join('access_masters', 'users.id', '=', 'access_masters.user_id')
        //     ->join('access_types', 'access_masters.access_type_id', '=', 'access_types.id')
        //     ->where('access_types.id', $userAccess_id->access_parent_id)
        //     ->get();
    }

    public function fwdAssignUser()
    {
        $fwdUserDetails = explode('-', $this->assignUserDetails);
        $data = [
            'estimate_id' => (int) $fwdUserDetails[2],
            'estimate_user_type' => (int) $fwdUserDetails[1],
            'user_id' => Auth::user()->id,
            'assign_user_id' => (int) $fwdUserDetails[0],
            'comments' => $this->userAssignRemarks,
        ];
        if ($this->fwdRequestFrom == 'EP' || $this->fwdRequestFrom == 'PE') {
            SorMaster::where('estimate_id', $fwdUserDetails[2])->update(['status' => 2]);
            $data['status'] = 2;
            $assignDetails = EstimateUserAssignRecord::create($data);
            if ($assignDetails) {
                $returnId = $assignDetails->id;
                EstimateUserAssignRecord::where([['estimate_id',$fwdUserDetails[2]],['id','!=',$returnId],['is_done',0]])->groupBy('estimate_id')->update(['is_done'=>1]);
                $this->notification()->success(
                    $title = 'Success',
                    $description = 'Successfully Assign!!'
                );
            }
        } elseif ($this->fwdRequestFrom == 'ER') {
            $data['status'] = 9;
            SorMaster::where('estimate_id', $fwdUserDetails[2])->update(['status' => 9]);
            $assignDetails = EstimateUserAssignRecord::create($data);
            if ($assignDetails) {
                $returnId = $assignDetails->id;
                EstimateUserAssignRecord::where([['estimate_id',$fwdUserDetails[2]],['id','!=',$returnId],['is_done',0]])->groupBy('estimate_id')->update(['is_done'=>1]);
                $this->notification()->success(
                    $title = 'Success',
                    $description = 'Successfully Assign!!'
                );
            }
        } else {
            $this->notification()->error(
                $title = 'Error',
                $description = 'Please Check & try again'
            );
        }
        $this->reset();
        $this->updateDataTableTracker = rand(1, 1000);
        $this->emit('refreshData', $this->updateDataTableTracker);
        // $this->updateDataTableTracker = rand(1,1000);
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        // TODO:: 1) REMOVE THIS SQL FROM RENDER 2) AFTER GEETING THE USER DATA, IF WE TYPE THE REMARKS THE USER DATA CHANGING TO ADMIN [NEED TO BE FIXED]
        // $userAccess_id = AccessMaster::select('access_parent_id')->join('access_types', 'access_masters.access_type_id', '=', 'access_types.id')->where('user_id', Auth::user()->id)->first();
        $roles = UsersHasRoles::join('roles', 'roles.id', '=', 'users_has_roles.role_id')
            ->where('users_has_roles.user_id', Auth::user()->id)
            ->select('users_has_roles.role_id as id', 'roles.name as role_name')
            ->get();
        foreach ($roles as $role) {
            if (Auth::user()->getRoleNames()[0] == $role->role_name) {
                $roles_id =  $role->id ;
            }
        }
        $userAccess_id = UsersHasRoles::select(
            "users_has_roles.user_id",
            "roles_order.id as roles_order_id",
            "users_has_roles.role_id as users_has_role_id",
            "roles_order.parent_id",
            "roles_order.role_id")
            ->join('roles_order', 'users_has_roles.role_id', '=', 'roles_order.role_id')
            ->where('roles_order.role_id', $roles_id)
            ->where('users_has_roles.user_id', Auth::user()->id)
            ->first();
// dd($userAccess_id->parent_id);
        $this->assigenUsersList = User::join('users_has_roles', 'users.id', '=', 'users_has_roles.user_id')
            ->join('roles_order', 'users_has_roles.role_id', '=', 'roles_order.role_id')
            ->join('roles', 'roles.id', '=', 'users_has_roles.role_id')
            ->where('roles_order.id', $userAccess_id->parent_id)
            ->where('users.department_id', Auth::user()->department_id)
            ->where('users.is_active', 1)
            ->select("users.emp_name", "users.designation_id", "users.id", "roles.name", "users_has_roles.role_id")
            ->get();
        // Log::info(json_encode($this->assigenUsersList));
        return view('livewire.components.modal.estimate.estimate-forward-modal');
    }
}
