<?php

namespace App\Http\Livewire\AssignOfficeAdmin;

use App\Models\District;
use App\Models\Office;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class CreateOfficeAdmin extends Component
{
    use Actions;
    public $selectedLevel, $selectedDist, $selectedOffice, $dropdownData = [], $searchCondition = [], $filtredOffices, $hooUsers, $selectedUser;
    public function mount()
    {
        $this->hooUsers = User::where([['user_type', 4], ['department_id', Auth::user()->department_id],['is_active',1]])->get();
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
            ->select('offices.id as id', 'offices.office_name', 'offices.office_address','offices.office_code', 'offices.level_no', 'offices.dist_code', 'users.id as user_id')
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
            $selectUserData = User::where('id', $this->selectedUser[$office_id]);
            if ($selectUserData->where('office_id', null)->first()) {
                $selectUserData->update(['office_id' => $office_id]);
                $this->notification()->success(
                    $title = 'User Assign successfully'
                );
                return;
            }
            $this->emit('refresh');
            $this->notification()->error(
                $title = 'User already assigned.'
            );
        } catch (\Throwable$th) {
            $this->emit('showError', $th->getMessage());
        }

    }
    public function render()
    {
        return view('livewire.assign-office-admin.create-office-admin');
    }
}
