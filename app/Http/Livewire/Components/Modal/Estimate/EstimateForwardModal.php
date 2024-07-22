<?php

namespace App\Http\Livewire\Components\Modal\Estimate;

use App\Models\EstimateAcceptanceLimitMaster;
use App\Models\EstimatePrepare;
use App\Models\EstimateStatus;
use App\Models\User;
use App\Models\Levels;
use App\Models\Office;
use Livewire\Component;
use App\Models\SorMaster;
use WireUi\Traits\Actions;
use App\Models\UsersHasRoles;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\EstimateUserAssignRecord;

class EstimateForwardModal extends Component
{
    use Actions;
    protected $listeners = ['openForwardModal' => 'forwardModalOpen'];
    public $forwardModal = false, $estimate_id, $assigenUsersList = [], $assignUserDetails, $userAssignRemarks, $updateDataTableTracker, $assignOfficeUserList = [], $selectedOffice;
    public $forwardRequestFrom;

    public $estimateTotal = [];

    public function forwardModalOpen($forwardEstimateDeatils)
    {
        // dd($forwardEstimateDeatils);
        $this->reset();
        $estimate_id = is_array($forwardEstimateDeatils) ? $forwardEstimateDeatils['estimate_id'] : $forwardEstimateDeatils;
        $this->forwardRequestFrom = $forwardEstimateDeatils['forward_from'];
        $this->estimate_id = $estimate_id;
        $this->forwardModal = !$this->forwardModal;
        // $userAccess_id = AccessMaster::select('access_parent_id')->join('access_types', 'access_masters.access_type_id', '=', 'access_types.id')->where('user_id', Auth::user()->id)->first();
        // $this->assigenUsersList = User::join('access_masters', 'users.id', '=', 'access_masters.user_id')
        //     ->join('access_types', 'access_masters.access_type_id', '=', 'access_types.id')
        //     ->where('access_types.id', $userAccess_id->access_parent_id)
        //     ->get();

        $roleParent = Auth::user()->roles1->first();
        $roleLevelNo = Role::select('name', 'has_level_no')->where('id', $roleParent->role_parent)->first();
        // $this->assigenUsersList = Office::select('users.designation_id', 'users.emp_name', 'users.id', 'users.name', 'offices.level_no','offices.id as officeId')
        //     ->join('users', 'users.office_id', '=', 'offices.id')
        //     ->where('offices.level_no', $roleLevelNo->has_level_no)
        //     ->where('users.department_id', Auth::user()->department_id)
        //     ->where('users.id', Auth::user()->created_by)
        //     ->get();
        // dd($this->assigenUsersList);

        //estimate total Amount
        $this->estimateTotal['amount'] = EstimatePrepare::select('total_amount')
            ->join('estimate_masters', 'estimate_prepares.estimate_id', '=', 'estimate_masters.estimate_id')
            ->where('estimate_masters.estimate_id', $this->estimate_id)
            ->where('estimate_masters.dept_id', Auth::user()->department_id)
            ->where('estimate_prepares.operation', 'Total')
            ->first();

        // dd($this->estimateTotal['amount']['total_amount']);
        $estimateLimits = EstimateAcceptanceLimitMaster::where('department_id', Auth::user()->department_id)->get();
        $level = 'error'; // Default to 'error' if no matching limit is found

        foreach ($estimateLimits as $value) {
            if ($this->estimateTotal['amount']['total_amount'] > $value['min_amount'] && $this->estimateTotal['amount']['total_amount'] <= $value['max_amount']) {
                $level = $value['level_id'];
                break; // Exit the loop once a matching limit is found
            }
        }

        // dd($this->estimateTotal);
        // dd($level);
        $levelsALL = Levels::where('id', $level)->get();
        // dd($levelsALL);

        // Office::join('users','users.office_id')
        //         ->where('department_id',Auth::user()->department_id)
        //         ->where('level_no',$level)
        //         ->get();
        $this->assignOfficeUserList['officeParent'] = Office::where('id', Auth::user()->office_id)
            ->first(); // 7

        $test = Office::where('id', $this->assignOfficeUserList['officeParent']['office_parent'])
            ->first(); // 6
        $this->assignOfficeUserList['officeList'] = Office::where('department_id', Auth::user()->department_id)->where('level_no', ($roleLevelNo->has_level_no != $level) ? $level-1 : $level)->get();
        // $this->selectedOffice = $this->assigenUsersList[0]['officeId'];
        // dd($this->assignOfficeUserList['officeList']);
    }
    public function OfficeUserList()
    {
        $this->assigenUsersList = User::select('users.designation_id', 'users.emp_name', 'users.id', 'users.name', 'offices.level_no')
        ->join('offices','users.office_id','=','offices.id')
        ->where('users.office_id', $this->selectedOffice)->where('users.department_id', Auth::user()->department_id)->get();
        // foreach($estimateLimits)
        // $estimateLimits = EstimateAcceptanceLimitMaster::select('min_amount', 'max_amount')
        //     ->where('department_id', Auth::user()->department_id)->get();

        // dd($this->assigenUsersList);
    }
    public function forwardAssignUser()
    {
        $forwardUserDetails = explode('-', $this->assignUserDetails);
        // dd($forwardUserDetails);
        $data = [
            'estimate_id' => (int) $forwardUserDetails[3],
            // 'estimate_user_type' => (int) $forwardUserDetails[1],
            'user_id' => Auth::user()->id,
            'assign_user_id' => (int) $forwardUserDetails[0],
            'level_no' => $forwardUserDetails[2],
            'comments' => $this->userAssignRemarks,
        ];
        // dd($data);
        /*if ($this->forwardRequestFrom == 'EP' || $this->forwardRequestFrom == 'PE') {
            SorMaster::where('estimate_id', $forwardUserDetails[2])->update(['status' => 2]);
            $data['status'] = 2;
            $assignDetails = EstimateUserAssignRecord::create($data);
            if ($assignDetails) {
                $returnId = $assignDetails->id;
                EstimateUserAssignRecord::where([['estimate_id', $forwardUserDetails[2]], ['id', '!=', $returnId], ['is_done', 0]])->groupBy('estimate_id')->update(['is_done' => 1]);
                $this->notification()->success(
                    $title = 'Success',
                    $description = 'Successfully Assign!!'
                );
            }
        } elseif ($this->forwardRequestFrom == 'ER') {
            $data['status'] = 9;
            SorMaster::where('estimate_id', $forwardUserDetails[2])->update(['status' => 9]);
            $assignDetails = EstimateUserAssignRecord::create($data);
            if ($assignDetails) {
                $returnId = $assignDetails->id;
                EstimateUserAssignRecord::where([['estimate_id', $forwardUserDetails[2]], ['id', '!=', $returnId], ['is_done', 0]])->groupBy('estimate_id')->update(['is_done' => 1]);
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
        }*/
        // dd($forwardUserDetails);
        SorMaster::where('estimate_id', $forwardUserDetails[3])->update(['status' => 2]);
        $data['status'] = 2;
        $assignDetails = EstimateUserAssignRecord::create($data);

        if ($assignDetails) {
            $returnId = $assignDetails->id;
            EstimateUserAssignRecord::where([['estimate_id', $forwardUserDetails[3]], ['id', '!=', $returnId], ['is_done', 0]])->groupBy('estimate_id')->update(['is_done' => 1]);
            $this->notification()->success(
                $title = 'Success',
                $description = 'Successfully Assign!!'
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
        // /TODO:: 1) REMOVE THIS SQL FROM RENDER 2) AFTER GEETING THE USER DATA, IF WE TYPE THE REMARKS THE USER DATA CHANGING TO ADMIN [NEED TO BE FIXED]
        // $userAccess_id = AccessMaster::select('access_parent_id')->join('access_types', 'access_masters.access_type_id', '=', 'access_types.id')->where('user_id', Auth::user()->id)->first();
        $roles = UsersHasRoles::join('roles', 'roles.id', '=', 'users_has_roles.role_id')
            ->where('users_has_roles.user_id', Auth::user()->id)
            ->select('users_has_roles.role_id as id', 'roles.name as role_name')
            ->get();
        foreach ($roles as $role) {
            if (Auth::user()->getRoleNames()[0] == $role->role_name) {
                $roles_id =  $role->id;
            }
        }
        /*$userAccess_id = UsersHasRoles::select(
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


        // dd($test, $test2);

        // dd($this->estimate_id);



        // $office = Office::find($this->assignOfficeUserList['officeParent']['office_parent']);
        // $parentOffice = $office->officeChildren;
        // dd($parentOffice);

        return view('livewire.components.modal.estimate.estimate-forward-modal');
    }
}
