<?php

namespace App\Http\Livewire\Components\Modal\NonSchedule;

use App\Models\Nonsor;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use WireUi\Traits\Actions;

class NonScheduleItems extends Component
{
    use Actions;
    protected $listeners = ['openNonScheduleList'];
    public $project_id,$approveNonSchudule = false,$updateDataTableTracker,$assignUserDetails,$assignUsersList=[];
    public function openNonScheduleList($id)
    {
        $idValue = is_array($id['project_id']) ? $id['project_id'] : $id;
        $this->reset();
        $this->project_id = $idValue['project_id'];
        $this->approveNonSchudule = !$this->approveNonSchudule;
;
//        $roleName = Role::findByName('Superintending Engineer');
        $role = Role::where('name','Superintending Engineer')->first();
        if($role)
        {
            $roleUser = User::role($role->name)
                        ->where('department_id',Auth::user()->department_id)
                        ->get();
            $this->assignUsersList = $roleUser->map(function ($user){

                return [
                    'id'=>$user->id,
                    'emp_name'=>$user->emp_name,
                    'office_name'=>$user->getOfficeName->office_name,
                    'designation'=>$user->getDesignationName->designation_name,
                    'projectId'=> $this->project_id
                ];
            });
        }
//        dd($userOffice);
//        Role::
        else
        {
            //
        }
    }

    public function ForwardUser()
    {
//        dd($this->assignUserDetails);
        $fwdUserDetails = explode('-', $this->assignUserDetails);
        $associatedAt = (int)$fwdUserDetails[0];
         $id= (int)$fwdUserDetails[1];

          $user = Nonsor::find($id);
          $user->associated_at = $associatedAt;
          $user->associated_with = Carbon::now();
          $user->save();

        $this->notification()->success(
            $description = 'Item Forward for Approval'
        );
        $this->reset();
        $this->updateDataTableTracker = rand(1, 1000);
        $this->emit('refreshData', $this->updateDataTableTracker);
    }


    public function render()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        return view('livewire.components.modal.non-schedule.non-schedule-items');
    }
}
