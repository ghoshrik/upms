<?php

namespace App\Http\Livewire\Estimate;

use App\Models\Department;
use App\Models\SOR;
use App\Models\SORCategory;
use App\Models\SorCategoryType;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CreateEstimate extends Component
{
    public $estimateData = [], $getCategory = [],$fatchDropdownData = [];
    public $kword = null,$selectedSORKey,$selectedCategoryId,$showTableOne=false;
    public $addedEstimates = [];
    public function changeCategory($value)
    {
        $this->resetExcept(['addedEstimates','selectedCategoryId','showTableOne']);
        $value = $value['_x_bindings']['value'];
        $this->estimateData['item_name'] = $value;
        if ($this->estimateData['item_name'] == 'SOR') {
            $this->fatchDropdownData['departments'] = Department::select('id', 'department_name')->get();
            $this->estimateData['dept_id'] ='';
            $this->estimateData['dept_category_id'] ='';
            $this->estimateData['version'] ='';
            $this->estimateData['item_number'] ='';
            $this->estimateData['description'] ='';
            $this->estimateData['other_name'] ='';
            $this->estimateData['qty'] ='';
            $this->estimateData['rate'] ='';
            $this->estimateData['total_amount'] ='';
        }else{
            $this->estimateData['dept_id'] ='';
            $this->estimateData['dept_category_id'] ='';
            $this->estimateData['version'] ='';
            $this->estimateData['item_number'] ='';
            $this->estimateData['description'] ='';
            $this->estimateData['other_name'] ='';
            $this->estimateData['qty'] ='';
            $this->estimateData['rate'] ='';
            $this->estimateData['total_amount'] ='';
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

    public function autoSearch($keyword)
    {
        $keyword = $keyword['_x_bindings']['value'];
        $this->kword = $keyword;
        $this->fatchDropdownData['items_number'] = SOR::where('department_id', $this->estimateData['dept_id'])
            ->where('dept_category_id', $this->estimateData['dept_category_id'])
            ->where('version', $this->estimateData['version'])
            ->where('Item_details', 'like', '%' . $keyword . '%')->get();
    }

    public function getItemDetails()
    {
        // dd($this->fatchDropdownData);
        $this->estimateData['description'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['description'];
        $this->estimateData['qty'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['unit'];
        $this->estimateData['rate'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['cost'];
        $this->estimateData['item_number'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['Item_details'];
        $this->calculateValue();
    }

    public function calculateValue()
    {
        if($this->estimateData['item_name'] == 'SOR')
        {
            if (floatval($this->estimateData['qty']) >= 0 && floatval($this->estimateData['rate']) >= 0) {
            $this->estimateData['total_amount'] = floatval($this->estimateData['qty']) * floatval($this->estimateData['rate']);
            }
        }else{
            if(floatval($this->estimateData['qty']) >= 0 && floatval($this->estimateData['rate']) >= 0){
                $this->estimateData['total_amount'] = floatval($this->estimateData['qty']) * floatval($this->estimateData['rate']);
            }
        }

    }

    public function addEstimate()
    {
        $this->showTableOne = !$this->showTableOne;
        $index = count($this->addedEstimates)+1;
        $this->addedEstimates[$index]['array_id'] = $index;
        // $this->addedEstimates[$index]['arrayIndex'] = $arrayIndex;
        $this->addedEstimates[$index]['dept_id'] =$this->estimateData['dept_id'];
        $this->addedEstimates[$index]['category_id'] = $this->estimateData['dept_category_id'];
        $this->addedEstimates[$index]['sor_item_number'] = $this->estimateData['item_number'];
        $this->addedEstimates[$index]['item_name'] = $this->estimateData['item_name'];
        $this->addedEstimates[$index]['other_name'] = $this->estimateData['other_name'];
        $this->addedEstimates[$index]['description'] = $this->estimateData['description'];
        $this->addedEstimates[$index]['qty'] = $this->estimateData['qty'];
        $this->addedEstimates[$index]['rate'] = $this->estimateData['rate'];
        $this->addedEstimates[$index]['total_amount'] = $this->estimateData['total_amount'];
        // $this->addedEstimates[$index]['operation'] = $operation;
        $this->addedEstimates[$index]['version'] = $this->estimateData['version'];
        // $this->addedEstimates[$this->indexCount]['perRate'] = $perRate;
        // $this->addedEstimates[$this->indexCount]['AddRemarks'] = $AddRemarks;
        // dd($this->addedEstimates);
        $this->resetExcept(['addedEstimates','showTableOne']);

    }

    public function render()
    {
        $this->getCategory = SORCategory::select('item_name', 'id')->get();
        return view('livewire.estimate.create-estimate');
    }
}
