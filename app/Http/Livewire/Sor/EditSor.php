<?php

namespace App\Http\Livewire\Sor;

use App\Models\SOR;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class EditSor extends Component
{
    protected $listeners = ['editSorRow' => 'editSor'];
    public $sor_id,$sorEditData = [],$editRow=[];
    public function editSor($sorId = 0)
    {
        $this->sor_id = $sorId;
        $this->sorEditData = SOR::where('id',$this->sor_id)->first();
        // Log::info(json_encode($this->sor_id));
        // Log::info(json_encode($this->sorEditData));
        $this->editRow = [
            [
                'item_details' => $this->sorEditData['Item_details'],
                'dept_category_id' => $this->sorEditData->getDeptCategoryName->dept_category_name,
                'description' => $this->sorEditData['description'],
                'unit' => $this->sorEditData['unit'],
                'cost' => $this->sorEditData['cost'],
                'version' => $this->sorEditData['version'],
                'effect_from' => $this->sorEditData['effect_from'],
            ]
        ];
        // dd($this->editRow);
    }
    public function render()
    {
        Log::info(json_encode($this->sorEditData));
        return view('livewire.sor.edit-sor');
    }
}
