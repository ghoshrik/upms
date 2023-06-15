<?php

namespace App\Http\Livewire\Carriages;

use Livewire\Component;
use App\Models\Department;
use App\Models\UnitMaster;
use WireUi\Traits\Actions;
use App\Models\Carriagesor;
use App\Models\SOR;
use Livewire\WithFileUploads;
use App\Models\SorCategoryType;
use Illuminate\Support\Facades\Auth;

class CreateCarriageSor extends Component
{
    use Actions, WithFileUploads;
    public $inputsData = [], $fetchDropDownData = [], $file_upload,$inputText=[];
    protected $rules = [
        'inputText.dept_cate_id'=>'required',
        // 'inputText.unit_id'=>'required|integer',
        // 'inputText.zone'=>'required',
        // 'inputsData.*.dept_id'=>'required',
        // 'inputsData.*.dept_cate_id'=>'required',
        // 'inputsData.*.sor_parent_id'=>'required',
        'inputsData.*.Item_no'=>'required',
        // 'inputsData.*.start_sor_item_no'=>'required',
        'inputsData.*.description'=>'required',
        'inputsData.*.anyDistance' => 'required|integer|numeric',
        'inputsData.*.aboveDistance' => 'required|integer|numeric',
        'inputsData.*.cost'=>'required|numeric',
    ];
    protected $messages = [

        'inputText.dept_cate_id.required'=>'This field is required',
        // 'inputText.unit_id.required'=>'This field id required',
        // 'inputText.unit_id.integer'=>'This field id required',
        // 'inputText.zone.required'=>'This field id required',


        // 'inputsData.*.dept_id.required'=>'This field is required',
        // 'inputsData.*.dept_cate_id.required'=>'This field is required',
        // 'inputsData.*.sor_parent_id.required'=>'This field is required',
        'inputsData.*.Item_no.required'=>'This field is required',
        // 'inputsData.*.start_sor_item_no.required'=>'This field is required',
        'inputsData.*.description.required'=>'This field is required',


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
        $this->inputText['dept_cate_id']='';
        $this->inputText['item_Parent_no']='';
        // $this->inputText['zone']='';

        $this->inputsData = [
            [
                // 'dept_cate_id'=>SorCategoryType::where('department_id', Auth::user()->department_id)->get(),
                'item_no'=>'',
                // 'Item_no'=>'',
                'description'=>'',
                'anyDistance'=>0,
                'aboveDistance'=>0,
                'cost'=>''
            ]
        ];
        // $this->fetchDropDownData['carriageSor'] = '';
        $this->fetchDropDownData['departmentCategory'] = SorCategoryType::select('id','dept_category_name','department_id')->where('department_id', Auth::user()->department_id)->get();
        // $this->fetchDropDownData['sor_parent_id']=SOR::select('id','Item_details')->where('department_id',Auth::user()->department_id)->where('dept_category_id',$this->fetchDropDownData['departmentCategory'])->get();
        // // dd($this->fetchDropDownData['sor_parent_id']);
        $this->fetchDropDownData['unitMaster'] =  UnitMaster::select('id', 'unit_name', 'short_name', 'is_active')->where('is_active', 1)->orderBy('id', 'desc')->get();
    }

    public function getDeptCategory()
    {
        $this->fetchDropDownData['sorParent_no'] = SOR::select('id','Item_details')->where('department_id',Auth::user()->department_id)->where('dept_category_id',$this->inputText['dept_cate_id'])->get();
    }

    public function getFilterItemNo()
    {
        $res = SOR::select('Item_details')->where('id',$this->inputText['item_Parent_no'])->first();
        $this->fetchDropDownData['carriageSor'] = SOR::select('Item_details','id')->where('Item_details','LIKE',$res['Item_details']."%")->get();

    }

    public function getItemNo($key)
    {
        $res = SOR::select('Item_details')->where('id',$this->inputsData[$key]['sor_parent_id'])->first();
        $this->fetchDropDownData['carriageSor'] = SOR::select('Item_details','id')->where('Item_details','LIKE',$res['Item_details']."%")->get();
    }
    public function getItemDetails($key)
    {
        // dd($this->inputsData[$key]['item_no']);
        $sorDesc = SOR::select('description','cost')->where('id',$this->inputsData[$key]['item_no'])->first();
        $this->inputsData[$key]['description'] = $sorDesc['description'];
        $this->inputsData[$key]['cost'] = $sorDesc['cost'];
        // dd($sorDesc['description']);
    }
    public function addNewRow()
    {
        $currentInputData = $this->inputsData;
        $inpuDataCount = count($currentInputData);
        $key = $inpuDataCount - 1;
        $this->inputsData[] =
            [
                // 'dept_cate_id'=>SorCategoryType::where('department_id', Auth::user()->department_id)->get(),
                'item_no'=>'',
                // 'Item_no'=>'',
                'description'=>'',
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
            // dd($this->inputsData);
            foreach ($this->inputsData as $key => $data)
            {
                $insert=[
                    'dept_id'=>Auth::user()->department_id,
                    'dept_cate_id'=>$this->inputText['dept_cate_id'],
                    'sor_parent_id'=>$this->inputText['item_Parent_no'],
                    'child_sor_id'=>$data['item_no'],
                    'descrption'=>$data['descrption'],
                    'start_distance'=>$data['anyDistance'],
                    'upto_distance'=>$data['aboveDistance'],
                    'cost'=>$data['cost']
                ];

                dd($insert);
                Carriagesor::create($insert);
            }
            $this->notification()->success(
                $title = trans('cruds.sor.create_msg')
            );
            $this->reset();
            $this->emit('openEntryForm');
        }
        catch (\Throwable $th) {
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
