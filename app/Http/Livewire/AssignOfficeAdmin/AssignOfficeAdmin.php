<?php

namespace App\Http\Livewire\AssignOfficeAdmin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AssignOfficeAdmin extends Component
{
    use WithPagination;
    public $subTitel = "List", $titel, $errorMessage, $viewMode = false, $selectedItemId, $openAssignAdminId;
    protected $listeners = ['refresh' => 'render', 'showError' => 'setErrorAlert'];

    public function setErrorAlert($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
    // public function assignuser($id)
    // {
    //     $this->openAssignAdminId = $id;
    // }

    public function render()
    {

        $this->titel = 'Assign Office Admin';
        $assets = ['chart', 'animation'];
        return view('livewire.assign-office-admin.assign-office-admin', compact('assets'));
    }
}
