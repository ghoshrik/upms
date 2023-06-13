<?php

namespace App\Http\Livewire\Carriages;

use App\Models\Carriagesor;
use Livewire\Component;
use App\Models\UnitMaster;
use WireUi\Traits\Actions;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class CreateCarriageSor extends Component
{
    use Actions, WithFileUploads;
    public $inputsData = [], $fetchDropDownData = [], $file_upload,$inputText=[];
    protected $rules = [
        'inputText.description'=>'required',
        'inputText.unit_id'=>'required|integer',
        'inputText.zone'=>'required',
        'inputsData.*.anyDistance' => 'required|integer|numeric',
        'inputsData.*.aboveDistance' => 'required|integer|numeric',
        'inputsData.*.cost'=>'required|numeric',
    ];
    protected $messages = [

        'inputText.description.required'=>'This field is required',
        'inputText.unit_id.required'=>'This field id required',
        'inputText.unit_id.integer'=>'This field id required',
        'inputText.zone.required'=>'This field id required',


        'inputsData.*.anyDistance.required' => 'This field is required',
        'inputsData.*.anyDistance.integer'=>'Data Type Mismatched',
        'inputsData.*.anyDistance.numeric'=>'Data must be need numberic value',

        'inputsData.*.aboveDistance.required' => 'This field is required',
        'inputsData.*.aboveDistance.integer'=>'Data Type Mismatched',
        'inputsData.*.aboveDistance.numeric'=>'Data must be need numberic value',

        'inputsData.*.cost.required' => 'This field is required',
        'inputsData.*.cost.numeric'=>'Only Allow Numeric Value'

    ];
    public function mount()
    {
        $this->inputText['description']='';
        $this->inputText['unit_id']='';
        $this->inputText['zone']='';

        $this->inputsData = [
            [
                'anyDistance'=>0,
                'aboveDistance'=>0,
                'cost'=>''
            ]
        ];
        // $this->fetchDropDownData['departmentCategory'] = SorCategoryType::where('department_id', Auth::user()->department_id)->get();
        $this->fetchDropDownData['unitMaster'] =  UnitMaster::select('id', 'unit_name', 'short_name', 'is_active')->where('is_active', 1)->orderBy('id', 'desc')->get();
    }
    public function addNewRow()
    {
        $currentInputData = $this->inputsData;
        $inpuDataCount = count($currentInputData);
        $key = $inpuDataCount - 1;
        $this->inputsData[] =
            [
                'anyDistance' => $currentInputData[$key]['anyDistance'],
                'aboveDistance' => $currentInputData[$key]['aboveDistance'],
                'cost' => $currentInputData[$key]['cost']
            ];
    }
    public function updated($param)
    {
        $this->validateOnly($param);
    }


    public function store()
    {
        try {

            foreach ($this->inputsData as $key => $data)
            {
                Carriagesor::create(
                    [
                        'description'=>$this->inputText['description'],
                        'unit_id'=>$this->inputText['unit_id'],
                        'zone'=>$this->inputText['zone'],
                        'start_distance'=>$data['anyDistance'],
                        'upto_distance'=>$data['aboveDistance'],
                        'cost'=>$data['cost']
                    ]);
            }


            $this->notification()->success(
                $title = trans('cruds.sor.create_msg')
            );
            $this->reset();
            $this->emit('openEntryForm');
        }
        catch (\Throwable $th) {

            // dd($th->getMessage());
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
        return view('livewire.carriages.create-carriage-sor');
    }
}
