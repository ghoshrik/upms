<?php

namespace App\Http\Livewire\AssignOfficeAdmin;

use Illuminate\Support\Collection;
use Livewire\Component;

class CreateOfficeAdmin extends Component
{
    public $offices, $officeLevel, $selectedLevelAllOffices = [], $filtredOffices=[], $users, $office_id, $getUserList = [], $officeDetail;

    public function mount()
    {
        $this->offices = [
            [
                'id' => 1,
                'level_id' => 1,
                'office_name' => 'Office 1',
            ],
            [
                'id' => 2,
                'level_id' => 1,
                'office_name' => 'Office 2',
            ],
            [
                'id' => 3,
                'level_id' => 2,
                'office_name' => 'Office 3',
            ],
            [
                'id' => 4,
                'level_id' => 2,
                'office_name' => 'Office 4',
            ],
            [
                'id' => 5,
                'level_id' => 3,
                'office_name' => 'Office 5',
            ],
            [
                'id' => 6,
                'level_id' => 4,
                'office_name' => 'Office 6',
            ],
            [
                'id' => 7,
                'level_id' => 5,
                'office_name' => 'Office 7',
            ],
        ];
        $this->users = [
            [
                'id' => 1,
                'user_type' => 'HOD',
                'office_id' => 1,
                'user_name' => 'User 1',

            ],
            [
                'id' => 2,
                'user_type' => 'HOD',
                'office_id' => 1,
                'user_name' => 'User 2',

            ],
            [
                'id' => 3,
                'user_type' => 'HOD',
                'office_id' => 1,
                'user_name' => 'User 3',

            ],
            [
                'id' => 4,
                'user_type' => 'HOD',
                'office_id' => 2,
                'user_name' => 'User 4',

            ],
        ];
    }
    public function getOffice()
    {
            $this->resetExcept(['officeLevel', 'offices','users']);
            $userCollection = collect($this->users);
            foreach ($this->offices as $key=> $office) {
                if ($office['level_id'] == $this->officeLevel) {
                    $this->selectedLevelAllOffices[] = $office;
                    $this->filtredOffices[] = $office;
                    $this->filtredOffices[count($this->filtredOffices)-1]['users'] = $userCollection->where('office_id',$office['id']);
                }
            }

    }
    public function getOfficeById()
    {
        $this->resetExcept(['officeLevel', 'offices', 'office_id','selectedLevelAllOffices','users']);
        $userCollection = collect($this->users);
        foreach ($this->offices as $office) {
            if ($office['id'] == $this->office_id) {
                $this->filtredOffices[] = $office;
                $this->filtredOffices[count($this->filtredOffices)-1]['users'] = $userCollection->where('office_id',$office['id']);
            }
        }
    }
    public function render()
    {
        return view('livewire.assign-office-admin.create-office-admin');
    }
}
