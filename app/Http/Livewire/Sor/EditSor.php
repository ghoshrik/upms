<?php

namespace App\Http\Livewire\Sor;

use App\Models\SOR;
use Livewire\Component;
use App\Models\UnitMaster;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\Log;

class EditSor extends Component
{
    use Actions;
    protected $listeners = ['editSorRow' => 'editSor'];
    public $sor_id, $sorEditData = [], $editRow, $effect_to, $editedData, $updateDataTableTracker, $fetchDropDownData = [];

    protected $rules = [
        'editRow.unit' => 'required|numeric',
        'editRow.version' => 'required'
    ];
    protected $messages = [
        'editRow.unit.required' => 'This field is required',
        'editRow.unit.numeric' => 'Only Allow Number',
        'editRow.version.required' => 'This field is required'
    ];






    public function updated($param)
    {
        $this->validateOnly($param);
    }
    public function mount()
    {

        $this->editRow = [
            [
                'item_details' => '',
                'dept_category_id' => '',
                'description' => '',
                'unit_id' => '',
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
        $this->fetchDropDownData['unitMaster'] = UnitMaster::select('id', 'unit_name', 'short_name', 'is_active')->where('is_active', 1)->orderBy('id', 'desc')->get();
        $this->editRow = [
            'item_details' => $this->sorEditData['Item_details'],
            'dept_category_id' => $this->sorEditData->getDeptCategoryName->dept_category_name,
            'description' => $this->sorEditData['description'],
            'unit' => $this->sorEditData['unit'],
            'unit_id' => $this->sorEditData['unit_id'],
            'cost' => $this->sorEditData['cost'],
            'version' => $this->sorEditData['version'],
        ];
    }
    public function store()
    {
        // dd($this->effect_to, $this->editedData);
        $this->validate();
        try {
            $this->editedData = [
                'Item_details' => $this->sorEditData['Item_details'],
                'department_id' => $this->sorEditData['department_id'],
                'dept_category_id' => $this->sorEditData['dept_category_id'],
                'description' => $this->sorEditData['description'],
                'unit_id' => $this->sorEditData['unit_id'],
                'unit' => $this->sorEditData['unit'],
                'cost' => $this->editRow['cost'],
                'version' => $this->sorEditData['version'],
                'effect_from' => $this->effect_to,
            ];
            // dd($this->sor_id, $this->editedData);
            if ($this->sor_id) {
                if (SOR::create($this->editedData)) {
                    SOR::where('id', $this->sor_id)->update(['effect_to' => date('Y-m-d', strtotime('-1 day', strtotime($this->effect_to)))]);
                }
                $this->notification()->success(
                    $title = 'SOR Updated Successfully!!'
                );
            }
            $this->reset();
            $this->emit('openEntryForm');
            $this->updateDataTableTracker = rand(1, 1000);
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
