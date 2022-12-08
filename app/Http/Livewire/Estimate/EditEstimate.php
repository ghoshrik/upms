<?php

namespace App\Http\Livewire\Estimate;

use App\Models\Department;
use App\Models\EstimatePrepare;
use App\Models\SOR;
use App\Models\SORCategory;
use App\Models\SorCategoryType;
use Livewire\Component;
use WireUi\Traits\Actions;

class EditEstimate extends Component
{
    use Actions;
    public $estimateData = [], $getCategory = [],$fatchDropdownData = [],$sorMasterDesc;
    // TODO:: remove $showTableOne if not use
    public $kword = null,$selectedSORKey,$selectedCategoryId,$showTableOne=false,$addedEstimateUpdateTrack;
    public $addedEstimate = [];
    //set estimate value for testing edit
    public $estimate_id = 471446;
    public function mount()
    {
        if(Session()->has('addedEstimateData')){
            $this->addedEstimateUpdateTrack = rand(1, 1000);
        }
        if($this->estimate_id)
        {
            $this->addedEstimate = EstimatePrepare::where('estimate_id',$this->estimate_id)->get();
        }
    }
    public function changeCategory($value)
    {
        $this->resetExcept(['addedEstimate','selectedCategoryId','addedEstimateUpdateTrack','sorMasterDesc']);
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
        $this->fatchDropdownData['items_number'] = SORR::where('department_id', $this->estimateData['dept_id'])
            ->where('dept_category_id', $this->estimateData['dept_category_id'])
            ->where('version', $this->estimateData['version'])
            ->where('Item_details', 'like', '%' . $keyword . '%')->get();
    }

    public function getItemDetails()
    {
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
        $this->reset('addedEstimate');
        $this->showTableOne = !$this->showTableOne;
        $this->addedEstimate['dept_id'] =$this->estimateData['dept_id'];
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

        $this->resetExcept(['addedEstimate','showTableOne','addedEstimateUpdateTrack','sorMasterDesc']);
    }
    public function render()
    {
        $this->getCategory = SORCategory::select('item_name', 'id')->get();
        return view('livewire.estimate.edit-estimate');
    }
}
