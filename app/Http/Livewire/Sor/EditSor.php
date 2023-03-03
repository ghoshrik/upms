<?php

namespace App\Http\Livewire\Sor;

use App\Models\SOR;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use WireUi\Traits\Actions;

class EditSor extends Component
{
    use Actions;
    protected $listeners = ['editSorRow' => 'editSor'];
    public $sor_id, $sorEditData = [], $editRow, $effect_to, $editedData,$updateDataTableTracker;
    public function mount()
    {
        $this->editRow = [
            [
                'item_details' => '',
                'dept_category_id' => '',
                'description' => '',
                'unit' => '',
                'cost' => '',
                'version' => '',
            ]
        ];
    }
    public function editSor($sorId = 0)
    {
        $this->sor_id = $sorId;
        $this->sorEditData = SOR::where('id', $this->sor_id)->first();
        $this->editRow = [
            'item_details' => $this->sorEditData['Item_details'],
            'dept_category_id' => $this->sorEditData->getDeptCategoryName->dept_category_name,
            'description' => $this->sorEditData['description'],
            'unit' => $this->sorEditData['unit'],
            'cost' => $this->sorEditData['cost'],
            'version' => $this->sorEditData['version'],
        ];
    }
    public function store()
    {
        try {
            $this->editedData = [
                'item_details' => $this->sorEditData['Item_details'],
                'department_id' => $this->sorEditData['department_id'],
                'dept_category_id' => $this->sorEditData['dept_category_id'],
                'description' => $this->sorEditData['description'],
                'unit' => $this->sorEditData['unit'],
                'cost' => $this->editRow['cost'],
                'version' => $this->sorEditData['version'],
                'effect_from' => $this->effect_to,
            ];
            // dd($this->editedData);
            if ($this->sor_id) {
                if (SOR::create($this->editedData)) {
                    SOR::where('id', $this->sor_id)->update(['effect_to' => date('Y-m-d', strtotime('-1 day', strtotime($this->effect_to)))]);
                }
                $this->notification()->success(
                    $title = 'SOR Updated Successfully!!'
                );
            }
            $this->reset();
            $this->emit('openForm');
            $this->updateDataTableTracker = rand(1,1000);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            // $this->emit('showError', $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.sor.edit-sor');
    }
}
