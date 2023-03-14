<?php

namespace App\Http\Livewire\AssignOfficeAdmin;

use App\Models\District;
use App\Models\Office;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateOfficeAdmin extends Component
{
    public  $selectedLevel,$selectedDist,$selectedOffice, $dropdownData = [],$searchCondition=[], $filtredOffices, $hooUsers;
    public function mount()
    {
        $this->hooUsers = User::where([['user_type',4],['department_id',Auth::user()->department_id]])->get();
        $this->dropdownData['dist'] = District::all();
    }
    public function getOffices()
    {
        if($this->selectedLevel){
            $this->searchCondition=Arr::add($this->searchCondition,'level',$this->selectedLevel);
        }
        if($this->selectedDist){
            $this->searchCondition=Arr::add($this->searchCondition,'dist_code',$this->selectedDist);
        }
            $this->filtredOffices = Office::where($this->searchCondition)->where('department_id',Auth::user()->department_id)->get();
            // $this->filtredOffices = Office::leftJoin('users', function($join) {
            //     $join->on('offices.id', '=', 'users.office_id')
            //          ->where([['users.user_type',4]]);
            // })
            // ->where('offices.department_id',Auth::user()->department_id)
            // ->select('offices.id as id', 'offices.office_name','offices.office_address','offices.level', 'users.id as user_id')
            // ->get();
            // dd($this->filtredOffices);
        $this->resetExcept('hooUsers','filtredOffices','dropdownData','selectedLevel','selectedDist');
    }
    public function render()
    {
        return view('livewire.assign-office-admin.create-office-admin');
    }
}
