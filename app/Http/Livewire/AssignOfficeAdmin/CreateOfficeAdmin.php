<?php

namespace App\Http\Livewire\AssignOfficeAdmin;

use App\Models\District;
use App\Models\Office;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class CreateOfficeAdmin extends Component
{
    use Actions, WithPagination;
    public $selectedLevel, $selectedDist, $selectedOffice, $dropdownData = [], $searchCondition = [], $filtredOffices = [], $hooUsers, $selectedUser, $openAssignAdminId, $openModel = false;
    // public $viewMode = false;
    protected $listeners = ['assignuser', 'filter'];

    public function mount()
    {
        // $this->modifyUsers['userList'] = '';
        $this->hooUsers = User::where([['user_type', 4], ['department_id', Auth::user()->department_id], ['is_active', 1]])->get();
        $this->dropdownData['dist'] = District::all();
    }
    public function filter()
    {
        // dd("dsds");
        if ($this->selectedLevel) {
            $this->searchCondition = Arr::add($this->searchCondition, 'level_no', $this->selectedLevel);
        }
        if ($this->selectedDist) {
            $this->searchCondition = Arr::add($this->searchCondition, 'dist_code', $this->selectedDist);
        }
        // dd($this->searchCondition);
        // $this->emit('filterOfficeAssign', $this->searchCondition);
        $this->getOffices();
        $this->getSelectedUsers();
    }
    private function getOffices()
    {
        $this->reset('filtredOffices');
        $this->filtredOffices = Office::leftJoin('users', function ($join) {
            $join->on('offices.id', '=', 'users.office_id')
                ->where('users.user_type', 4);
        })
            ->where($this->searchCondition)
            ->where('offices.department_id', Auth::user()->department_id)
            ->select('offices.id as id', 'offices.office_name', 'offices.office_address', 'offices.office_code', 'offices.level_no', 'offices.dist_code', 'users.id as user_id')
            ->orderBy('users.id', 'asc')
            ->get();
        if (count($this->filtredOffices) == 0) {
            $this->notification()->error(
                $title = 'No Data Found'
            );
        }
        $this->resetExcept('hooUsers', 'dropdownData', 'filtredOffices', 'selectedLevel', 'selectedDist', 'selectedUser');
    }
    private function getSelectedUsers()
    {
        $this->reset('selectedUser');
        $this->selectedUser = collect($this->hooUsers)->filter(function ($user) {
            return $user['office_id'] !== null;
        })->mapWithKeys(function ($user) {
            return [$user['office_id'] => $user['id']];
        })->all();
    }
    public function assign($office_id)
    {
        try {
            // $selectUserData = User::where('id', $this->selectedUser[$office_id]);

            // if ($selectUserData->where('office_id', null)->first()) {
            //     $selectUserData->update(['office_id' => $office_id]);

            //     $this->notification()->success(
            //         $title = 'User Assign successfully'
            //     );
            //     return;
            // }

            // $this->emit('refresh');
            // $this->notification()->error(
            //     $title = 'User already assigned.'
            // );

        } catch (\Throwable $th) {
            $this->emit('showError', $th->getMessage());
        }
    }
    public $alreadyAssignUserDist, $alreadyAssignUserLevel;

    public function assignuser($office_id, $dist_code, $level_no)
    {
        // dd("dsd");
        // dd($office_id,$dist_code,$level_no);
        $this->openAssignAdminId = $office_id;
        $this->alreadyAssignUserLevel = $level_no;
        $this->alreadyAssignUserDist = $dist_code;

        // $list = Office::select('users.emp_name','offices.id')->join('users','users.office_id','=','offices.id')

        //     ->where('users.user_type',4)
        //     ->where('offices.dist_code',$dist_code)
        //     ->where('offices.level_no',$level_no)
        //     ->where('offices.department_id',Auth::user()->department_id)
        //     ->where('users.office_id',$office_id)
        //     // ->whereNot('users.office_id',$office_id)

        //     ->where('users.is_active',1)
        //     ->exists();
        // if($list)
        // {
        //     dd('exists');
        // }
        // else
        // {
        //     dd("not exists");
        // }
        $this->openModel = true;
    }

    public $selectedUserofice;
    public function assignusertoOffice()
    {
        dd($this->selectedUserofice);
        // $userexistsOffice = User::where('id',$this->selectedUserofice)->where('office_id',$this->openAssignAdminId)->exists();
        // dd($userexistsOffice);
        // if($userexistsOffice)
        // {
        //     $this->emit('refresh');
        //     $this->notification()->error(
        //         $title = 'User already assigned.'
        //     );
        // }
        // else
        // {
        //     dd("yes");
        // }

    }

    public $modifyUsers, $listUser;
    public function assignModify($userid, $office_id, $dist_code, $level_no)
    {
        // dd(Auth::user()->department_id);
        $this->modifyUsers = Office::select('users.emp_name as name', 'users.office_id as id')
            ->join('users', 'offices.id', '=', 'users.office_id')
            ->where('offices.dist_code', $dist_code)
            ->where('offices.level_no', $level_no)
            ->where('users.department_id', Auth::user()->department_id)
            ->where('users.user_type', 4)
        //     // ->where('users.office_id', $office_id)
        //     // ->where('users.office_id', 0)
            ->whereNotIn('users.id', explode(',', $userid))
            ->get();
        $this->openModel = true;
        // dd($this->modifyUsers['userList']);
    }

    public function render()
    {
        // $this->modifyUsers['userList'] = '';
        return view('livewire.assign-office-admin.create-office-admin');
    }
}
