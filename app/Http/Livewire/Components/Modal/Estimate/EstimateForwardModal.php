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
        $this->assigenUsersList = $role->users->map(function ($user) use ($estimateFlowDtls, $associatedId) {
            return [
                'id' => $user->id,
                'office_name'=>$user->getOfficeName->office_name,
                'emp_name' => $user->emp_name,
                'designation' => $user->getDesignationName->designation_name,
                'slm_id' => $estimateFlowDtls->slm_id,
                'sequence_no' => $estimateFlowDtls->sequence_no,
                'role_id' => $associatedId->role_id,
                'permission_id' => $associatedId->permission_id,
                'estimate_id' => $estimateFlowDtls->estimate_id
            ];
        });
//        dd($this->assigenUsersList);
    }


    public function forwardAssignUser()
    {
//         dd($this->assignUserDetails);

        $fwdUserDetails = explode('-', $this->assignUserDetails);
//        dd($fwdUserDetails);


//        (int)$fwdUserDetails[0];
        /*DB::transaction(function ()use ($fwdUserDetails)
        {
//            dd($fwdUserDetails[0],$fwdUserDetails[1],$fwdUserDetails[2],$fwdUserDetails[3]);

                $userId = (int)$fwdUserDetails[0];
                $slmId = (int)$fwdUserDetails[1];
                $sequenceNo = (int)$fwdUserDetails[2];
                $estimateId = (int)$fwdUserDetails[3];
            DB::enableQueryLog();
            $sanctionLists = SanctionRole::select('role_id','permission_id')->where('sequence_no', $sequenceNo)->first();
//            dd($sanctionLists);
            EstimateFlow::where('estimate_id', $estimateId)
                ->where('slm_id', $slmId)
                ->where('role_id', $sanctionLists->role_id)
                ->where('permission_id', $sanctionLists->permission_id)
                ->update(['user_id' => $userId, 'associated_at' => Carbon::now()]);

            EstimateFlow::where('user_id',Auth::user()->id)->update(['dispatch_at'=>Carbon::now()]);
            DB::getQueryLog();
            SorMaster::where('estimate_id',$estimateId)->update(['status' => 13,'associated_with'=>$userId]);



        });*/
        $userId = (int)$fwdUserDetails[0];
        $slmId = (int)$fwdUserDetails[1];
        $sequenceNo = (int)$fwdUserDetails[2];
        $estimateId = (int)$fwdUserDetails[3];

//        dd($userId,$slmId,$sequenceNo,$estimateId);
        $sanctionLists = SanctionRole::select('role_id','permission_id')->where('sequence_no', $sequenceNo)->first();
//        dd($sanctionLists->permission_id);
//        $estId = EstimateFlow::where('estimate_id',$estimateId)->first();
//        $estId->id =

//        dd($estId);



        $estId = EstimateFlow::where('estimate_id', $estimateId)
            ->where('slm_id', $slmId)
            ->where('role_id', $sanctionLists->role_id)
//            ->where('permission_id', $sanctionLists->permission_id)
//            ->get();
            ->update(['user_id' => $userId, 'associated_at' => Carbon::now()]);
//        dd($estId);/
        EstimateFlow::where('user_id',Auth::user()->id)->update(['dispatch_at'=>Carbon::now()]);
        SorMaster::where('estimate_id',$estimateId)->update(['status' => 13,'associated_with'=>$userId]);

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
