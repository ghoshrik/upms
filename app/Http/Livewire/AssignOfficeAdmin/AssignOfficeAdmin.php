<?php

namespace App\Http\Livewire\AssignOfficeAdmin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AssignOfficeAdmin extends Component
{
    use WithPagination;
    public $subTitel = "List", $titel, $errorMessage, $viewMode = false, $Assignusers;
    protected $listeners = ['refresh' => 'render', 'showError' => 'setErrorAlert', 'assignAdmin' => 'officeAssignAdmin'];

    public function setErrorAlert($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
    public function officeAssignAdmin($id)
    {
        $this->viewMode = !$this->viewMode;
        $this->Assignusers = User::where('office_id', $id)->get();
        // dd($this->Assignusers);
    }

    public function render()
    {

        $this->titel = 'Assign Office Admin';
        $assets = ['chart', 'animation'];
        return view('livewire.assign-office-admin.assign-office-admin', compact('assets'));
    }
}
