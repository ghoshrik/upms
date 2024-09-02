<?php

namespace App\Http\Livewire\Components\Modal\Estimate;

use App\Models\EstimateUserAssignRecord;
use App\Models\Office;
use App\Models\SanctionLimitMaster;
use App\Models\SorMaster;
use App\Models\EstimateFlow;
use App\Models\SanctionRole;
use App\Models\User;
use App\Models\UserResource;
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
    public $forwardModal = false, $estimate_id, $assigenUsersList = [], $assignUserDetails, $userAssignRemarks, $updateDataTableTracker,$outsideOffice;
    public $fwdRequestFrom;

    public $selectUserLabel='Select User for Office';

    public function mount()
    {
        $this->selectUserLabel = 'Select User for Office';
    }
    public function updateLabel()
    {
        if($this->outsideOffice)
        {
            $this->selectUserLabel = 'Selected Offices in Group';
        }
        else
        {
            $this->selectUserLabel='Select User for Office';
        }
    }
    public function updatedOutsideOffice($value)
    {
        $this->updateLabel();
        $this->outsideOfficeUser();
    }

    public function outsideOfficeUser()
    {
//        $groupId = Office::where('group_id',Auth::user()->group_id)->get();
        $user = Auth::user();

       $users =  User::join('offices','offices.group_id','=','offices.group_id')
                ->where('users.id',Auth::user()->group_id)
                ->where('offices.group_id',Auth::user()->group_id)
                ->get();
//        $user1 = Office::doesntHave ('office')->get();

//        $user->resources

//       dd($users,$user->resources);
    }

//    user belongs to a office , office belongs to a group , groups and user have common another resource table
//how to get login office outside office all user show
//    there in three tabel user,group,resources pivot table ,

    public function fwdModalOpen($forwdEstimateDeatils)
    {

//         dd($forwdEstimateDeatils);
        $estimate_id = is_array($forwdEstimateDeatils['estimate_id']) ? $forwdEstimateDeatils['estimate_id'] : $forwdEstimateDeatils;
        $this->reset();
        $this->estimate_id = $estimate_id['estimate_id'];
        $this->forwardModal = !$this->forwardModal;

        $estimateFlowDtls = EstimateFlow::where('estimate_id', $forwdEstimateDeatils['estimate_id'])
            ->whereNull('associated_at')
            ->orderBy('sequence_no')
            ->first();

//         dd($estimateFlowDtls);
        $associatedId = SanctionRole::select('role_id', 'permission_id')
            ->where('sequence_no', $estimateFlowDtls->sequence_no)
            ->first();
//        dd($associatedId);

        $role = Role::findById($associatedId->role_id);
//        $this->assigenUsersList = $role->users;
        $this->assigenUsersList = $role->users->map(function ($user) use ($estimateFlowDtls, $associatedId) {
            return [
                'id' => $user->id,
                'emp_name' => $user->emp_name,
                'designation' => $user->getDesignationName->designation_name,
                'slm_id' => $estimateFlowDtls->slm_id,
                'sequence_no' => $estimateFlowDtls->sequence_no,
                'role_id' => $associatedId->role_id,
                'permission_id' => $associatedId->permission_id,
                'estimate_id' => $estimateFlowDtls->estimate_id
            ];
        });



        /*if (count($estimateFlowDtls) > 0) {
            foreach ($estimateFlowDtls as $estimateFlow) {
                $slmDetails = SanctionRole::where('sanction_limit_master_id', $estimateFlow->slm_id)
                    ->where('sequence_no', $estimateFlow->sequence_no)
                    ->first();
                if ($slmDetails) {

                    $associatedId = SanctionRole::select('role_id', 'permission_id')
                        ->where('sequence_no', $slmDetails->sequence_no)
                        ->first();
                    $role = Role::findById($associatedId->role_id);
                    $usersWithRole = $role->users;
                    // $this->assigenUsersList = $usersWithRole;
                    // dd($usersWithRole);

                    // foreach ($usersWithRole as $user) {
                    //     dd($user->id);
                    //     $this->assigenUsersList[] = [
                    //         'id' => $user->id,
                    //         'emp_name' => $user->emp_name,
                    //         'designation' => $user->designation_id,
                    //         'slm_id' => $slmDetails->slm_id,
                    //         'sequence_no' => $slmDetails->sequence_no,
                    //         'role_id' => $slmDetails->role_id,
                    //         'permission_id' => $slmDetails->role_id,
                    //         'estimate_id' => $this->estimate_id,
                    //     ];
                    // }



                    // dd($this->assigenUsersList);
                }
            }
            $this->assigenUsersList = $usersWithRole->map(function ($user) use ($estimateFlow, $slmDetails, $associatedId) {
                return [
                    'id' => $user->id,
                    'emp_name' => $user->emp_name,
                    'designation' => $user->getDesignationName->designation_name,
                    'slm_id' => $estimateFlow->slm_id,
                    'sequence_no' => $slmDetails->sequence_no,
                    'role_id' => $associatedId->role_id,
                    'permission_id' => $associatedId->permission_id,
                    'estimate_id' => $estimateFlow->estimate_id
                ];
            });
        }*/



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
//        dd($slmDetails);
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
//         dd($this->assignUserDetails);

        $fwdUserDetails = explode('-', $this->assignUserDetails);
        // $assignUserDtls = $this->getRoleAndPermission($fwdUserDetails[1]);
//         dd($fwdUserDetails);
        /*if ($assignUserDtls) {
            $roleId = $assignUserDtls->role_id;
            $permissionId = $assignUserDtls->permission_id;

            // dd($roleId, $permissionId);
            SorMaster::where('estimate_id', $fwdUserDetails[3])->update(['status' => $fwdUserDetails[1]]);
            EstimateFlow::select('id')
                ->where('estimate_id', $fwdUserDetails[3])
                ->where('slm_id', $fwdUserDetails[1])
                ->where('role_id', $assignUserDtls->role_id)
                ->where('permission_id', $assignUserDtls->permission_id)
                ->update(['user_id' => $fwdUserDetails[0], 'associated_at' => Carbon::now()]);
            $this->notification()->success(
                $title = 'Success',
                $description = 'Successfully Assign!!'
            );

            $this->reset();
            $this->updateDataTableTracker = rand(1, 1000);
            $this->emit('refreshData', $this->updateDataTableTracker);
        } else {
            $this->notification()->error(
                $title = 'Error',
                $description = 'Please Check & try again'
            );
        }*/

        DB::transaction(function ()use ($fwdUserDetails)
        {
//            dd($fwdUserDetails[0],$fwdUserDetails[1],$fwdUserDetails[2],$fwdUserDetails[3]);

                $userId = $fwdUserDetails[0];
                $slmId = $fwdUserDetails[1];
                $sequenceNo = $fwdUserDetails[2];
                $estimateId = $fwdUserDetails[3];
            $sanctionLists = SanctionRole::select('role_id','permission_id')->where('sequence_no', $sequenceNo)->first();
//            dd($sanctionLists);
            EstimateFlow::where('estimate_id', $estimateId)
                ->where('slm_id', $slmId)
                ->where('role_id', $sanctionLists->role_id)
                ->where('permission_id', $sanctionLists->permission_id)
                ->update(['user_id' => $userId, 'associated_at' => Carbon::now()]);
            DB::enableQueryLog();
            EstimateFlow::where('user_id',Auth::user()->id)->update(['dispatch_at'=>Carbon::now()]);
            DB::getQueryLog();
            SorMaster::where('estimate_id',$estimateId)->update(['status' => 13,'associated_with'=>$userId]);



        });
        DB::getQueryLog();
        $this->notification()->success(
            $title = 'Success',
            $description = 'Successfully Assign!!'
        );

        $this->reset();
        $this->updateDataTableTracker = rand(1, 1000);
        $this->emit('refreshData', $this->updateDataTableTracker);





//         dd($sanctionLists);



        // }
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
