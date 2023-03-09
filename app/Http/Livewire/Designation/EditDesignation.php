<?php

namespace App\Http\Livewire\Designation;

use App\Models\Designation;
use Livewire\Component;
use WireUi\Traits\Actions;

class EditDesignation extends Component
{

    use Actions;
    protected $listeners = ['editDesignationRow' => 'editDesignation'];
    public $desg_id,$desgEditData = [],$editRow;

    public function editDesignation($desg_id = 0)
    {
        $this->desg_id = $desg_id;
        $this->desgEditData = Designation::where('id',$this->desg_id)->first();
        $this->editRow = [
            'designation_name'=>$this->desgEditData['designation_name']
        ];
    }

    public function store()
    {
        try {
            $this->desgEditData = [
                'designation_name' => $this->desgEditData['designation_name'],
            ];
            if($this->desg_id)
            {
                Designation::find($this->desg_id)->update($this->desgEditData);
                $this->notification()->success(
                    $title = 'Designation Updated !!'
                );
            }

            $this->reset();
            $this->emit('openForm');
        }
        catch (\Throwable $th) {
            $this->emit('showError', $th->getMessage());
        }
    }



    public function render()
    {
        return view('livewire.designation.edit-designation');
    }
}
