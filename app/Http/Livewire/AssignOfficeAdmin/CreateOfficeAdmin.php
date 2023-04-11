<?php

namespace App\Http\Livewire\AssignOfficeAdmin;

use App\Models\User;
use App\Models\Office;
use Livewire\Component;
use App\Models\District;
use WireUi\Traits\Actions;
use Illuminate\Support\Arr;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class CreateOfficeAdmin extends Component
{
    use Actions, WithPagination;
    public $selectedLevel, $selectedDist, $selectedOffice, $dropdownData = [], $searchCondition = [], $filtredOffices, $hooUsers, $selectedUser, $openAssignAdminModal;
    // public $viewMode = false;

    public function mount()
    {
        $this->hooUsers = User::where([['user_type', 4], ['department_id', Auth::user()->department_id], ['is_active', 1]])->get();
        $this->dropdownData['dist'] = District::all();
    }
    public function filter()
    {
        if ($this->selectedLevel) {
            $this->searchCondition = Arr::add($this->searchCondition, 'level_no', $this->selectedLevel);
        }
        if ($this->selectedDist) {
            $this->searchCondition = Arr::add($this->searchCondition, 'dist_code', $this->selectedDist);
        }
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
        $this->resetExcept('hooUsers', 'filtredOffices', 'dropdownData', 'selectedLevel', 'selectedDist', 'selectedUser');
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
            // // $this->emit('')
            // // dd($this->selectedUser[$office_id]);

            // if ($selectUserData->where('office_id', null)->first()) {
            //     $selectUserData->update(['office_id' => $office_id]);
            //     $this->emit('assignAdmin', $office_id);

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
    public $AllofficeUsers;
    public function assignuser($id)
    {
        $this->emit('assignAdmin', $id);
    }
    public function render()
    {
        return view('livewire.assign-office-admin.create-office-admin');
    }
}
