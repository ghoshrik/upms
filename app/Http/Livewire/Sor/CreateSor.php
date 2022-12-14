<?php

namespace App\Http\Livewire\Sor;

use App\Models\Department;
use App\Models\SOR;
use App\Models\SorCategoryType;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class CreateSor extends Component
{
    use Actions;
    public $inputsData = [], $fetchDropDownData = [];
    public function mount()
    {
        $this->inputsData = [
            [
                'item_details' => '',
                'department_id' => Auth::user()->department_id,
                'dept_category_id' => '',
                'description' => '',
                'unit' => 0,
                'cost' => 0,
                'version' => '',
                'effect_from' => '',
            ]
        ];
        $this->fetchDropDownData['departmentCategory'] = SorCategoryType::where('department_id', Auth::user()->department_id)->get();
    }
    public function addNewRow()
    {
        $this->inputsData[] =
            [
                'item_details' => '',
                'department_id' => Auth::user()->department_id,
                'dept_category_id' => '',
                'description' => '',
                'unit' => 0,
                'cost' => 0,
                'version' => '',
                'effect_from' => '',
            ];
    }
    public function store()
    {
        try {
            foreach ($this->inputsData as $key => $data) {
                SOR::create($data);
            }
            $this->notification()->success(
                $title = 'SOR Created Successfully!!'
            );
            $this->reset();
            $this->emit('openForm');
        } catch (\Throwable $th) {
            $this->emit('showError', $th->getMessage());
        }
    }
    public function removeRow($index)
    {
        if (count($this->inputsData) > 1) {
            unset($this->inputsData[$index]);
            $this->inputsData =  array_values($this->inputsData);
            return;
        }
    }
    public function render()
    {
        return view('livewire.sor.create-sor');
    }
}
