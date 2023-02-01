<?php

namespace App\Http\Livewire\Estimate;

use Throwable;
use App\Models\SOR;
use Livewire\Component;
use App\Models\Department;
use WireUi\Traits\Actions;
use App\Models\SORCategory;
use Illuminate\Support\Arr;
use App\Models\SorCategoryType;
use Illuminate\Support\Facades\Log;

class CreateEstimate extends Component
{
    use Actions;
    public $estimateData = [], $getCategory = [], $fatchDropdownData = [], $sorMasterDesc;
    // TODO:: remove $showTableOne if not use
    public $kword = null, $selectedSORKey, $selectedCategoryId, $showTableOne = false, $addedEstimateUpdateTrack;
    public $addedEstimate = [];

    protected $rules = [
        'sorMasterDesc' => 'required|string',
        'selectedCategoryId' => 'required|integer',

    ];
    protected $messages = [
        'sorMasterDesc.required' => 'The description cannot be empty.',
        'sorMasterDesc.string' => 'The description format is not valid.',
        'selectedCategoryId.required' => 'Selected at least one ',
        'selectedCategoryId.integer' => 'This Selected field is Invalid',
        'estimateData.other_name.required' => 'selected other name required',
        'estimateData.other_name.string' => 'This field is must be character',
        'estimateData.dept_id.required' => 'This field is required',
        'estimateData.dept_id.integer' => 'This Selected field is invalid',
        'estimateData.dept_category_id.required' => 'This field is required',
        'estimateData.dept_category_id.integer' => 'This Selected field is invalid',
        'estimateData.version.required' => 'This Selected field is required',
        'estimateData.version.integer' => 'This Selected field is invalid',
        'selectedSORKey.required' => 'This field is required',
        'selectedSORKey.string' => 'This field is must be string',
        'estimateData.qty.required' => 'This field is not empty',
        'estimateData.qty.numeric' => 'This field is must be numeric',
        'estimateData.rate.required' => 'This field is not empty',
        'estimateData.rate.numeric' => 'This field is must be numeric',
        'estimateData.total_amount.required' => 'This field is not empty',
        'estimateData.total_amount.numeric' => 'This field is must be numeric',

    ];
    public function booted()
    {
        if ($this->selectedCategoryId == 1) {
            $this->rules =  Arr::collapse([$this->rules, [
                'estimateData.dept_id' => 'required|integer',
                'estimateData.dept_category_id' => 'required|integer',
                'estimateData.version' => 'required',
                'selectedSORKey' => 'required|string',

            ]]);
        }
        if ($this->selectedCategoryId == 2) {
            $this->rules =  Arr::collapse([$this->rules, [
                'estimateData.other_name' => 'required|string',
            ]]);
        }
        if ($this->selectedCategoryId == 1 || $this->selectedCategoryId == 2) {
            $this->rules =  Arr::collapse([$this->rules, [
                'estimateData.qty' => 'required|numeric',
                'estimateData.rate' => 'required|numeric',
                'estimateData.total_amount' => 'required|numeric'
            ]]);
        }
    }
    public function updated($param)
    {
        $this->validateOnly($param);
    }
    public function mount()
    {
        if (Session()->has('addedEstimateData')) {
            $this->addedEstimateUpdateTrack = rand(1, 1000);
        }
    }
    public function changeCategory($value)
    {
        $this->resetExcept(['addedEstimate', 'selectedCategoryId', 'addedEstimateUpdateTrack', 'sorMasterDesc']);
        $value = $value['_x_bindings']['value'];
        $this->estimateData['item_name'] = $value;
        if ($this->estimateData['item_name'] == 'SOR') {
            $this->fatchDropdownData['departments'] = Department::select('id', 'department_name')->get();
            $this->estimateData['dept_id'] = '';
            $this->estimateData['dept_category_id'] = '';
            $this->estimateData['version'] = '';
            $this->estimateData['item_number'] = '';
            $this->estimateData['description'] = '';
            $this->estimateData['other_name'] = '';
            $this->estimateData['qty'] = '';
            $this->estimateData['rate'] = '';
            $this->estimateData['total_amount'] = '';
        } else {
            $this->estimateData['dept_id'] = '';
            $this->estimateData['dept_category_id'] = '';
            $this->estimateData['version'] = '';
            $this->estimateData['item_number'] = '';
            $this->estimateData['description'] = '';
            $this->estimateData['other_name'] = '';
            $this->estimateData['qty'] = '';
            $this->estimateData['rate'] = '';
            $this->estimateData['total_amount'] = '';
        }
    }

    public function getDeptCategory()
    {
        $this->fatchDropdownData['departmentsCategory'] = SorCategoryType::select('id', 'dept_category_name')->where('department_id', '=', $this->estimateData['dept_id'])->get();
    }

    public function getVersion()
    {
        $this->fatchDropdownData['versions'] = SOR::select('version')->where('department_id', $this->estimateData['dept_id'])
            ->where('dept_category_id', $this->estimateData['dept_category_id'])->groupBy('version')
            ->get();
    }
    public $searchDtaCount,$searchStyle,$searchResData;
    public function autoSearch()
    {
        // $keyword = $keyword['_x_bindings']['value'];
        // $this->kword = $keyword;
        // $this->fatchDropdownData['items_number'] = SOR::where('department_id', $this->estimateData['dept_id'])
        //     ->where('dept_category_id', $this->estimateData['dept_category_id'])
        //     ->where('version', $this->estimateData['version'])
        //     ->where('Item_details', 'like', '%' . $keyword . '%')->get();

        // dd("sdfsdf");
        if($this->selectedSORKey)
        {
            $this->fatchDropdownData['items_number'] = SOR::select('Item_details','id')
            ->where('department_id', $this->estimateData['dept_id'])
            ->where('dept_category_id', $this->estimateData['dept_category_id'])
            ->where('version', $this->estimateData['version'])
            ->where('Item_details', 'like', $this->selectedSORKey.'%')->get();
            if(count($this->fatchDropdownData['items_number'])>0)
            {
                $this->searchDtaCount = (count($this->fatchDropdownData['items_number'])>0);
                $this->searchStyle= 'block';
            }
            else
            {
                $this->notification()->error(
                    $title = 'Not data found !!'.$this->selectedSORKey
                );
            }
        }
        else{
            $this->notification()->error(
                $title = 'Not found !!'.$this->selectedSORKey
            );
        }
    }



        $this->searchDtaCount = count($this->searchResData)>0;
        $this->searchStyle = 'none';
        foreach($this->searchResData as $list)
        {
            $this->estimateData['description'] = $list['description'];
            $this->estimateData['qty'] = $list['unit'];
            $this->estimateData['rate'] = $list['cost'];
            $this->selectedSORKey = $list['Item_details'];
        }
        $this->calculateValue();


        // try
        // {
        //     if($this->selectedSORKey)
        //     {
        //         $this->searchResData = SOR::select('description','cost','unit')->where('Item_details',$this->selectedSORKey)->get();
        //         if(count($this->searchResData)>0)
        //         {
        //             foreach($this->searchResData as $list)
        //             {
        //                 $this->estimateData['description'] = $list['description'];
        //                 $this->estimateData['qty'] = $list['unit'];
        //                 $this->estimateData['rate'] = $list['cost'];
        //             }
        //             $this->calculateValue();
        //         }
        //         else
        //         {
        //             // dd("Not found ".$this->selectedSORKey);
        //             $this->notification()->error(
        //                 $title = 'Not found !!'.$this->selectedSORKey
        //             );
        //             sleep(1);
        //             $this->resetExcept($this->selectedSORKey);

        //         }
        //     }
        //     else
        //     {
        //         dd("fill up Item Details number then press Tab on Keyboard either error");
        //     }
        // }
        // catch (Throwable $th) {
        //     // session()->flash('serverError', $th->getMessage());
        //     $this->emit('showError', $th->getMessage());
        // }
        // dd($this->fatchDropdownData['items_number'][$this->selectedSORKey]['id']);

        // $this->estimateData['description'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['description'];
        // $this->estimateData['qty'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['unit'];
        // $this->estimateData['rate'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['cost'];
        // $this->estimateData['item_number'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['id'];
        // $this->calculateValue();

    }
    public $resetExcept;
    public function resetValus($resetAll = false)
    {
        if($resetAll)
        {
            $this->selectedSORKey = "";
        }
        $this->resetExcept(['selectedSORKey']);
    }
    public function calculateValue()
    {
        if ($this->estimateData['item_name'] == 'SOR') {
            if (floatval($this->estimateData['qty']) >= 0 && floatval($this->estimateData['rate']) >= 0) {
                $this->estimateData['total_amount'] = floatval($this->estimateData['qty']) * floatval($this->estimateData['rate']);
            }
        } else {
            if (floatval($this->estimateData['qty']) >= 0 && floatval($this->estimateData['rate']) >= 0) {
                $this->estimateData['total_amount'] = floatval($this->estimateData['qty']) * floatval($this->estimateData['rate']);
            }
        }
    }
    public function getItemDetails($id)
    {
        // $this->estimateData['description'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['description'];
        // $this->estimateData['qty'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['unit'];
        // $this->estimateData['rate'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['cost'];
        // $this->estimateData['item_number'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['id'];
        // $this->calculateValue();

        $this->searchResData = SOR::where('id',$id)->get();
        // dd($this->searchResData);
        $this->searchDtaCount = count($this->searchResData)>0;
        $this->searchStyle = 'none';
        foreach($this->searchResData as $list)
        {
            $this->estimateData['description'] = $list['description'];
            $this->estimateData['qty'] = $list['unit'];
            $this->estimateData['rate'] = $list['cost'];
            $this->selectedSORKey = $list['Item_details'];
        }
        $this->calculateValue();
    }
    public function addEstimate()
    {
        $validatee = $this->validate();
        $this->reset('addedEstimate');
        $this->showTableOne = !$this->showTableOne;
        $this->addedEstimate['dept_id'] = $this->estimateData['dept_id'];
        $this->addedEstimate['category_id'] = $this->estimateData['dept_category_id'];
        $this->addedEstimate['sor_item_number'] = $this->estimateData['item_number'];
        $this->addedEstimate['item_name'] = $this->estimateData['item_name'];
        $this->addedEstimate['other_name'] = $this->estimateData['other_name'];
        $this->addedEstimate['description'] = $this->estimateData['description'];
        $this->addedEstimate['qty'] = $this->estimateData['qty'];
        $this->addedEstimate['rate'] = $this->estimateData['rate'];
        $this->addedEstimate['total_amount'] = $this->estimateData['total_amount'];
        $this->addedEstimate['version'] = $this->estimateData['version'];
        $this->addedEstimateUpdateTrack = rand(1, 1000);
        // dd($this->sorMasterDesc);
        // dd($this->addedEstimate);
        $this->resetExcept(['addedEstimate', 'showTableOne', 'addedEstimateUpdateTrack', 'sorMasterDesc']);
    }

    public function render()
    {
        $this->getCategory = SORCategory::select('item_name', 'id')->get();
        return view('livewire.estimate.create-estimate');
    }
}
