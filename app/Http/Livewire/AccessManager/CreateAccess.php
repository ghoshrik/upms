<?php

namespace App\Http\Livewire\AccessManager;

use App\Models\AccessType;
use App\Models\Designation;
use App\Models\Office;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateAccess extends Component
{
    public $dropDownData =[],$newAccessData = [];
    public function mount()
    {
        $this->newAccessData = [
            'designation_id' => null,
            'user_id' => null,
            'access_type_id' => null,
        ];
        $this->getDropdownData('DES');
        $this->getDropdownData('ACCS');
    }
    public function getDropdownData($lookingFor)
    {
        try {
            switch ($lookingFor) {
                case 'DES':
                    $this->dropDownData['designations'] = Designation::all();
                    break;
                case 'OFC':
                    $this->dropDownData['offices'] = Office::where('id',Auth::user()->office_id)->get();
                    break;
                case 'ACCS':
                      $this->dropDownData['accessTypes'] = AccessType::all();
                    break;
                default:
                    // $this->allUsers = User::select('users.id','users.emp_name')->join('user_types', 'users.user_type', '=', 'user_types.id')
                    // ->where([['parent_id', Auth::user()->user_type], ['department_id', Auth::user()->department_id]])->get();
                    break;
            }
        } catch (\Throwable $th) {
            session()->flash('serverError', $th->getMessage());
        }
    }
    public function getUsers()
    {
        $this->dropDownData['users'] = User::select('users.id','users.emp_name')->join('user_types', 'users.user_type', '=', 'user_types.id')
                    ->where([['parent_id', Auth::user()->user_type], ['department_id', Auth::user()->department_id],['designation_id',$this->newAccessData['designation_id']],['office_id',Auth::user()->office_id]])->get();
    }
    public function store()
    {
        $this->newAccessData['department_id'] = Auth::user()->department_id;
        $this->newAccessData['office_id'] = Auth::user()->office_id;
        $newAccessData = $this->newAccessData;
    }
    public function render()
    {
        return view('livewire.access-manager.create-access');
    }
}
