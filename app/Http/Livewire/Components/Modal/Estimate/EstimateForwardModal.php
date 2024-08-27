<?php

namespace App\Http\Livewire\Components\Modal\Estimate;

use App\Models\EstimateUserAssignRecord;
use App\Models\SanctionLimitMaster;
use App\Models\SorMaster;
use App\Models\EstimateFlow;
use App\Models\SanctionRole;
use App\Models\User;
use App\Models\UsersHasRoles;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use WireUi\Traits\Actions;

class EstimateForwardModal extends Component
{
    use Actions;
    protected $listeners = ['openForwardModal' => 'fwdModalOpen'];
    public $forwardModal = false, $estimate_id, $assigenUsersList = [], $assignUserDetails, $userAssignRemarks, $updateDataTableTracker;
    public $fwdRequestFrom;
    public function fwdModalOpen($forwdEstimateDeatils)
    {

        $estimate_id = is_array($forwdEstimateDeatils['estimate_id']) ? $forwdEstimateDeatils['estimate_id'] : $forwdEstimateDeatils;
      $this->reset();
//        dd($estimate_id);
        $this->estimate_id = $estimate_id['estimate_id'];
        $this->forwardModal = !$this->forwardModal;

        $estimateFlowDtls = EstimateFlow::where('estimate_id',$forwdEstimateDeatils['estimate_id'])->get();
        foreach($estimateFlowDtls as $estimateFlow)
        {
            $slmDetails = SanctionRole::where('sanction_limit_master_id',$estimateFlow->slm_id)
                                        ->first();
            if($slmDetails)
            {
                $currentSequenceNo = $slmDetails->sequence_no;
                $nextSequenceNo = $currentSequenceNo + 1;

                $nextSequenceExists = SanctionRole::where('sanction_limit_master_id', $estimateFlow->slm_id)
                    ->where('sequence_no', $nextSequenceNo)
                    ->exists();
                if($nextSequenceExists)
                {
                    $associatedId = SanctionRole::select('role_id','permission_id')
                                                ->where('sequence_no',$nextSequenceNo)
                                                ->first();
                    $role = Role::find($associatedId->role_id);
                    $this->assigenUsersList = $role->users->map(function ($user) use ($estimateFlow,$nextSequenceNo,$associatedId) {
                        return [
                            'id'=>$user->id,
                            'emp_name'=>$user->emp_name,
                            'designation'=>$user->getDesignationName->designation_name,
                            'slm_id' => $estimateFlow->slm_id,
                            'sequence_no' => $nextSequenceNo,
                            'role_id'=>$associatedId->role_id,
                            'permission_id'=>$associatedId->permission_id,
                            'estimate_id'=>$estimateFlow->estimate_id
                        ];
                    });
//                    dd($this->assigenUsersList);



                }
                else
                {
                    echo "The next sequence number ($nextSequenceNo) does not exists.";
                }
            }
            else
            {
                echo "No record found for the given Sanction Limit Master";
            }

//            dd($estimateFlowDtls,$slmDetails);
        }


//        $this->reset();
//            $estimate_id = is_array($forwdEstimateDeatils) ? $forwdEstimateDeatils['estimate_id'] : $forwdEstimateDeatils;
//        $this->fwdRequestFrom = $forwdEstimateDeatils['forward_from'];
//        $this->estimate_id = $estimate_id;
//        $this->fwdModal = !$this->fwdModal;
        // $userAccess_id = AccessMaster::select('access_parent_id')->join('access_types', 'access_masters.access_type_id', '=', 'access_types.id')->where('user_id', Auth::user()->id)->first();
        // $this->assigenUsersList = User::join('access_masters', 'users.id', '=', 'access_masters.user_id')
        //     ->join('access_types', 'access_masters.access_type_id', '=', 'access_types.id')
        //     ->where('access_types.id', $userAccess_id->access_parent_id)
        //     ->get();
    }

    /*public function fwdAssignUser()
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
    }*/

    public function getRoleAndPermission($sanctionLimitMasterId)
    {
        $slmDetails = SanctionRole::where('sanction_limit_master_id', $sanctionLimitMasterId)->first();

        if ($slmDetails) {
            $currentSequenceNo = $slmDetails->sequence_no;

            // Find the next available sequence number greater than the current one
            $nextSequenceDetails = SanctionRole::where('sanction_limit_master_id', $sanctionLimitMasterId)
                ->where('sequence_no', '>', $currentSequenceNo)
                ->orderBy('sequence_no', 'asc')
                ->first();
            if ($nextSequenceDetails) {
                // Retrieve the associated role_id and permission_id
                $associatedIds = SanctionRole::select('role_id', 'permission_id')
                    ->where('sequence_no', $nextSequenceDetails->sequence_no)
                    ->first();

                return $associatedIds;
            }
        }

        return null; // Return null if no matching record is found
    }

    public function forwardAssignUser()
    {
        $fwdUserDetails = explode('-', $this->assignUserDetails);
//        dd($fwdUserDetails);
//        $assignUserId =$fwdUserDetails[0];
//        $assignSeqNo = $fwdUserDetails[2];
        $assignUserDtls = $this->getRoleAndPermission($fwdUserDetails[1]);
        if($assignUserDtls)
        {
            $roleId = $assignUserDtls->role_id;
            $permissionId = $assignUserDtls->permission_id;

//            dd($roleId,$permissionId);
            SorMaster::where('estimate_id', $fwdUserDetails[3])->update(['status' => 2]);
            $assignDetails = EstimateFlow::create(
                [
                    'estimate_id'=>$fwdUserDetails[3],
                    'slm_id'=>$fwdUserDetails[1],
                    'sequence_no'=>$fwdUserDetails[2],
                    'role_id'=> $roleId,
                    'permission_id'=>$permissionId,
                    'user_id'=>$fwdUserDetails[0]
                ]
            );
            if($assignDetails)
            {
                $returnId = $assignDetails->id;
                EstimateFlow::where('estimate_id',$fwdUserDetails[3])->where('id','!=',$returnId)->groupBy('estimate_id')->update(['associated_at'=>Carbon::now()]);
                $this->notification()->success(
                    $title = 'Success',
                    $description = 'Successfully Assign!!'
                );
            }
            else
            {
                $this->notification()->error(
                    $title = 'Error',
                    $description = 'Please Check & try again'
                );
            }
            $this->reset();
            $this->updateDataTableTracker = rand(1, 1000);
            $this->emit('refreshData', $this->updateDataTableTracker);
        }
        else
        {
            $this->notification()->error(
                $title = 'Error',
                $description = 'Please Check & try again'
            );
        }



    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        // TODO:: 1) REMOVE THIS SQL FROM RENDER 2) AFTER GEETING THE USER DATA, IF WE TYPE THE REMARKS THE USER DATA CHANGING TO ADMIN [NEED TO BE FIXED]
        // $userAccess_id = AccessMaster::select('access_parent_id')->join('access_types', 'access_masters.access_type_id', '=', 'access_types.id')->where('user_id', Auth::user()->id)->first();
        /*$roles = UsersHasRoles::join('roles', 'roles.id', '=', 'users_has_roles.role_id')
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
            ->get();*/
        // Log::info(json_encode($this->assigenUsersList));
        return view('livewire.components.modal.estimate.estimate-forward-modal');
    }
}
