<?php

namespace App\Http\Livewire\AssignToAnotherOffice;

use App\Models\Office;
use Livewire\Component;
use App\Models\District;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class AssignToAnotherOfficeModal extends Component
{
    public $openAssignModal;
    public $selectedUser;
    public $selectedLevel, $selectedDist, $selectedOffice, $dropdownData = [], $searchCondition = [], $filtredOffices;
    protected $listeners = ['openAssignModel'];
    public function mount()
    {
        $this->dropdownData['dist'] = District::all();
    }
    public function openAssignModel($selectedUserId=0)
    {
        $this->selectedUser = $selectedUserId;
        $this->openAssignModal = true;
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
        $this->resetExcept('filtredOffices', 'dropdownData', 'selectedLevel', 'selectedDist','openAssignModal');
    }
    public function render()
    {
        return view('livewire.assign-to-another-office.assign-to-another-office-modal');
    }
}
