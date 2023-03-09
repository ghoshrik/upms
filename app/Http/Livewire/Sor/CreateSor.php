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

    protected $rules = [
        'inputsData.*.dept_category_id'=>'required|integer',
        'inputsData.*.item_details'=>'required',
        'inputsData.*.description'=>'required|string',
        'inputsData.*.unit'=>'required|numeric',
        'inputsData.*.cost'=>'required|numeric',
        'inputsData.*.version'=>'required|string',
        'inputsData.*.effect_from'=>'required'
    ];
    protected $messages = [
        'inputsData.*.dept_category_id.required'=>'This field is required',
        'inputsData.*.dept_category_id.required'=>'Invalid format',
        'inputsData.*.item_details.required'=> 'This field is required',
        // 'inputsData.*.item_details.numeric'=>'Only allow number',
        'inputsData.*.description.required'=>'This field is required',
        'inputsData.*.description.string'=>'This field must be allow alphabet',
        'inputsData.*.unit.required'=>'This field is required',
        'inputsData.*.unit.numeric'=>'This field allow only numeric',
        'inputsData.*.unit.max:0'=>'Not allow any negative number',
        'inputsData.*.cost.required'=>'This field is required',
        'inputsData.*.cost.numeric'=>'This field allow only numeric',
        // 'inputsData.*.cost.max:0'=>'Not allow any negative number',
        'inputsData.*.version.required'=>'This field is required',
        'inputsData.*.version.string'=>'This field allow only alphabet',
        'inputsData.*.effect_from.required'=>'This field is required',
        // 'inputsData.*.effect_from.date_format'=>'This field must be valid only date format'

    ];
    public function mount()
    {
        $this->inputsData = [
            [
                'item_details' => '',
                'department_id' => Auth::user()->department_id,
                'dept_category_id' => '',
                'description' => '',
                'unit' => '',
                'cost' => '',
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
            'unit' => '',
            'cost' => '',
            'version' => '',
            'effect_from' => '',
        ];
    }
    public function updated($param)
    {
        $this->validateOnly($param);
    }
    public function store()
    {
        $this->validate();

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
