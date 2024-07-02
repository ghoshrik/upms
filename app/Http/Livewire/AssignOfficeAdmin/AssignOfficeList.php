<?php

namespace App\Http\Livewire\AssignOfficeAdmin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AssignOfficeList extends Component
{
    use WithPagination;
    public $openAssignAdmin, $perPage = 1, $listUsers,$selectedItemId;
    protected $listeners = ['assignuser','openModal'=>'openModal'];

    public function assignuser($id)
    {
        $this->openAssignAdmin = $id;
    }
    public function openModal($id)
{
    $this->selectedItemId = $id;
    $this->dispatchBrowserEvent('open-modal');
}
    public function mount()
    {
        $listUsers = User::where('office_id', '!=', null)->where('office_id', $this->openAssignAdmin)
            ->paginate(10);
    }
    public function nextPage()
    {
        $this->page++;
        $listUsers = User::where('office_id', '!=', null)->where('office_id', $this->openAssignAdmin)
            ->paginate(10, ['*'], 'page', $this->perPage);
    }
    public function render()
    {
        $listUsers = User::where('office_id', '!=', null)->where('office_id', $this->openAssignAdmin)
            ->paginate($this->perPage);
        return view('livewire.assign-office-admin.assign-office-list', ['allUsers' => $listUsers]);
    }
}
