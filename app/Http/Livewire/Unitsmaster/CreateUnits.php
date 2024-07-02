<?php

namespace App\Http\Livewire\Unitsmaster;

use Livewire\Component;
use App\Models\UnitMaster;
use WireUi\Traits\Actions;

class CreateUnits extends Component
{
    use Actions;
    public $InputStoreData = [];
    protected $rules = [
        'InputStoreData.unitName' => 'required|string|unique:unit_masters,unit_name',
        'InputStoreData.unitShortName' => 'required|string|unique:unit_masters,short_name'
    ];
    protected $messages = [
        'InputStoreData.unitName.required' => 'This field is required',
        'InputStoreData.unitName.string' => 'This field must be Alphabet value',
        'InputStoreData.unitName.unique' => 'Unit name Already Exists',
        'InputStoreData.unitShortName.required' => 'This field is required',
        'InputStoreData.unitShortName.string' => 'This field must be Alphabet value',
        'InputStoreData.unitShortName.unique' => 'Short name Already Exists'

    ];
    public function mount()
    {
        $this->InputStoreData['unitName'] = '';
        $this->InputStoreData['unitShortName'] = '';
    }
    public function updated($param)
    {
        $this->validateOnly($param);
    }
    public function store()
    {
        $this->validate();
        try {
            $insert = [
                'unit_name' => $this->InputStoreData['unitName'],
                'short_name' => $this->InputStoreData['unitShortName']
            ];
            UnitMaster::create($insert);
            $this->notification()->success(
                $title = "New Unit Created !"
            );
            $this->reset();
            $this->emit('openEntryForm');
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            $this->emit('showError', $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.unitsmaster.create-units');
    }
}
