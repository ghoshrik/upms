<?php

namespace App\Http\Livewire\AssignOfficeAdmin;

use Livewire\Component;

class AssignOfficeAdmin extends Component
{
    public $subTitel = "List",$titel;
    public function render()
    {
        $this->titel = 'Assign Office Admin';
        $assets = ['chart', 'animation'];
        return view('livewire.assign-office-admin.assign-office-admin',compact('assets'));
    }
}
