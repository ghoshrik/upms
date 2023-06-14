<?php

namespace App\Http\Livewire\Carriagecost;

use App\Models\SOR;
use Livewire\Component;
use App\Models\Department;
use WireUi\Traits\Actions;
use App\Models\SorCategoryType;
use Illuminate\Support\Facades\Auth;

class CreateCarriageCost extends Component
{
    use Actions;
    public $estimateData = [], $getCategory = [], $fatchDropdownData = [], $dropdownData = [], $selectSor = [];
    public $addedEstimate = [], $addedEstimateUpdateTrack, $selectedSORKey,$InputText=[];
    public $searchDtaCount, $searchStyle, $searchResData,$showTableOne;

    public function mount()
    {
        $this->dropdownData['allDept'] = Department::select('id', 'department_name')->where('id', Auth::user()->department_id)->get();
        $this->fatchDropdownData['departmentsCategory'] = SorCategoryType::select('id', 'dept_category_name')->where('department_id', '=', Auth::user()->department_id)->get();
        // dd($this->fatchDropdownData['departmentsCategory']);
        $this->selectSor['dept_id'] = '';
        $this->selectSor['dept_category_id'] = '';
        $this->selectSor['version'] = '';
        $this->selectSor['selectedSOR'] = '';
        $this->estimateData['dept_category_id'] = '';
        $this->estimateData['version'] = '';
        $this->estimateData['item_number'] = '';
        $this->InputText['Desc']='';
        $this->InputText['distance']='';
        $this->InputText['unit']='';

        if (Session()->has('addedEstimateData')) {
            $this->addedEstimateUpdateTrack = rand(1, 1000);
        }
    }
    public function getVersion()
    {
        $this->fatchDropdownData['versions'] = SOR::select('version')->where('department_id', Auth::user()->department_id)
            ->where('dept_category_id', $this->estimateData['dept_category_id'])->groupBy('version')
            ->get();
    }

    public function autoSearch()
    {
        if ($this->selectedSORKey) {
            $this->fatchDropdownData['items_number'] = SOR::select('Item_details', 'id')
                ->where('department_id', Auth::user()->department_id)
                ->where('dept_category_id', $this->estimateData['dept_category_id'])
                ->where('version', $this->estimateData['version'])
                ->where('Item_details', 'like', $this->selectedSORKey . '%')
                ->where('is_approved', 1)
                ->get();

            // dd($this->fatchDropdownData['items_number']);
            if (count($this->fatchDropdownData['items_number']) > 0) {
                $this->searchDtaCount = (count($this->fatchDropdownData['items_number']) > 0);
                $this->searchStyle = 'block';
            } else {
                $this->estimateData['description'] = '';
                $this->estimateData['qty'] = '';
                $this->estimateData['rate'] = '';
                $this->searchStyle = 'none';
                $this->notification()->error(
                    $title = 'Not data found !!' . $this->selectedSORKey
                );
            }
        } else {
            $this->estimateData['description'] = '';
            $this->estimateData['qty'] = '';
            $this->estimateData['rate'] = '';
            $this->searchStyle = 'none';
            $this->notification()->error(
                $title = 'Not found !!' . $this->selectedSORKey
            );
        }
    }
    public function getItemDetails($id)
    {
        $this->searchResData = SOR::where('id', $id)->get();
        // dd($this->searchResData);
        $this->searchDtaCount = count($this->searchResData) > 0;
        $this->searchStyle = 'none';
        if (count($this->searchResData) > 0) {
            foreach ($this->searchResData as $list) {
                $this->estimateData['description'] = $list['description'];
                $this->estimateData['qty'] = $list['unit'];
                $this->estimateData['rate'] = $list['cost'];
                $this->estimateData['item_number'] = $list['id'];
                $this->selectedSORKey = $list['Item_details'];
            }
            $this->calculateValue();
        } else {
            $this->estimateData['description'] = '';
            $this->estimateData['qty'] = '';
            $this->estimateData['rate'] = '';
        }
    }
    public function calculateValue()
    {
        if (floatval($this->estimateData['qty']) >= 0 && floatval($this->estimateData['rate']) >= 0) {
            $this->estimateData['total_amount'] = floatval($this->estimateData['qty']) * floatval($this->estimateData['rate']);
        }
    }
    public function addEstimate()
    {
        // $this->reset('addedEstimate');
        // /*assign all data variable one to another*/
        // $this->addedEstimate['description'] = $this->InputText['Desc'] ?? '';
        // $this->addedEstimate['distance'] = $this->InputText['distance'] ?? '';
        // $this->addedEstimate['unit'] = $this->InputText['unit'] ?? '';
        // $this->addedEstimate['dept_id'] = Auth::user()->department_id;
        // $this->addedEstimate['dept_category_id'] = $this->estimateData['dept_category_id'];
        // $this->addedEstimate['version'] = $this->estimateData['version'];
        // $this->addedEstimate['Item_details'] = $this->estimateData['item_number'];
        // $this->resetExcept(['addedEstimate','InputText','estimateData']);
        // dd($this->addedEstimate);

        // dd($this->estimateData['total_amount']);
        // $validatee = $this->validate();
        $this->reset('addedEstimate');
        $this->showTableOne = !$this->showTableOne;
        $this->addedEstimate['description'] = ($this->InputText['Desc'] == '') ? 0 : $this->InputText['Desc'];
        $this->addedEstimate['distance'] = ($this->InputText['distance'] == '') ? 0 :$this->InputText['distance'];
        $this->addedEstimate['unit'] = ($this->InputText['unit']=='')? 0 : $this->InputText['unit'] ;
        $this->addedEstimate['dept_id'] = Auth::user()->department_id;
        $this->addedEstimate['dept_category_id'] = ($this->estimateData['dept_category_id'] == '') ? 0 :$this->InputText['unit'];
        $this->addedEstimate['version'] = ($this->estimateData['version'] =='') ? 0 : $this->estimateData['version'];
        $this->addedEstimate['Item_details'] = ($this->estimateData['item_number'] =='') ? 0 : $this->estimateData['item_number'];
        $this->addedEstimate['description'] = ($this->estimateData['description']=='')? 0 : $this->estimateData['description'];
        $this->addedEstimate['qty'] = ($this->estimateData['qty'] =='')? 0 : $this->estimateData['qty'];
        $this->addedEstimate['rate'] = ($this->estimateData['rate']=='')? 0 : $this->estimateData['rate'];
        $this->addedEstimate['total_amount'] = ($this->estimateData['total_amount'] =='')? 0 : $this->estimateData['total_amount'];
        $this->addedEstimateUpdateTrack = rand(1, 1000);





        // $this->addedEstimate['estimate_no'] = ($this->estimateData['estimate_no'] == '') ? 0 : $this->estimateData['estimate_no'];
        // $this->addedEstimate['rate_no'] = ($this->estimateData['rate_no'] == '') ? 0 : $this->estimateData['rate_no'];
        // $this->addedEstimate['dept_id'] = ($this->estimateData['dept_id'] == '') ? 0 : $this->estimateData['dept_id'];
        // $this->addedEstimate['category_id'] = ($this->estimateData['dept_category_id'] == '') ? 0 : $this->estimateData['dept_category_id'];
        // $this->addedEstimate['sor_item_number'] = ($this->estimateData['item_number'] == '') ? 0 : $this->estimateData['item_number'];
        // $this->addedEstimate['item_name'] = $this->estimateData['item_name'];
        // $this->addedEstimate['other_name'] = $this->estimateData['other_name'];
        // $this->addedEstimate['description'] = $this->estimateData['description'];
        // $this->addedEstimate['qty'] = ($this->estimateData['qty'] == '') ? 0 : $this->estimateData['qty'];
        // $this->addedEstimate['rate'] = ($this->estimateData['rate'] == '') ? 0 : $this->estimateData['rate'];
        // $this->addedEstimate['total_amount'] = $this->estimateData['total_amount'];
        // $this->addedEstimate['version'] = $this->estimateData['version'];
        // $this->addedEstimateUpdateTrack = rand(1, 1000);
        // $this->estimateData['item_number'] = '';
        // $this->estimateData['estimate_no'] = '';
        // $this->estimateData['rate_no'] = '';
        // $this->estimateData['qty'] = '';
        // $this->estimateData['rate'] = '';
        // $this->estimateData['total_amount'] = '';
        $this->resetExcept(['addedEstimate', 'showTableOne', 'addedEstimateUpdateTrack', 'estimateData','fatchDropdownData','selectedSORKey','InputText']);



    }
    public function render()
    {
        return view('livewire.carriagecost.create-carriage-cost');
    }
}
