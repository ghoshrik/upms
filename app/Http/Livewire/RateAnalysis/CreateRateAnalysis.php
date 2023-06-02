<?php

namespace App\Http\Livewire\RateAnalysis;

use App\Models\SOR;
use Livewire\Component;
use App\Models\SorMaster;
use App\Models\Department;
use WireUi\Traits\Actions;
use App\Models\CompositSor;
use Illuminate\Support\Arr;
use App\Models\Esrecommender;
use App\Models\RatesAnalysis;
use App\Models\EstimatePrepare;
use App\Models\SorCategoryType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class CreateRateAnalysis extends Component
{
    use Actions;
    public $estimateData = [], $getCategory = [], $fatchDropdownData = [], $sorMasterDesc, $selectSor = [], $dropdownData = [];
    public $kword = null, $selectedSORKey, $selectedCategoryId, $showTableOne = false, $addedEstimateUpdateTrack;
    public $addedEstimate = [];
    public $searchDtaCount, $searchStyle, $searchResData;
    // TODO:: remove $showTableOne if not use
    // TODO::pop up modal view estimate and project estimate
    // TODO::forward revert draft modify

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
        'estimateData.rate_no.required' => 'This field is required',
        'estimateData.rate_no.numeric' => 'This field is must be numeric',
        'estimateData.estimate_desc.required' => 'This field is required',
        'estimateData.estimate_desc.string' => 'Invalid format input',
    ];
    public function booted()
    {
        if ($this->selectedCategoryId == 1) {
            $this->rules = Arr::collapse([$this->rules, [
                'estimateData.dept_id' => 'required|integer',
                'estimateData.dept_category_id' => 'required|integer',
                'estimateData.version' => 'required',
                'selectedSORKey' => 'required|string',

            ]]);
        }
        if ($this->selectedCategoryId == 2) {
            $this->rules = Arr::collapse([$this->rules, [
                'estimateData.other_name' => 'required|string',
            ]]);
        }
        if ($this->selectedCategoryId == 3) {
            $this->rules = Arr::collapse([$this->rules, [
                'estimateData.dept_id' => 'required|integer',
                'estimateData.rate_no' => 'required|integer',
                // 'estimateData.estimate_desc' => 'required|string',
                'estimateData.total_amount' => 'required|numeric',
            ]]);
        }
        if ($this->selectedCategoryId == 1 || $this->selectedCategoryId == 2) {
            $this->rules = Arr::collapse([$this->rules, [
                'estimateData.qty' => 'required|numeric',
                'estimateData.rate' => 'required|numeric',
                'estimateData.total_amount' => 'required|numeric',

            ]]);
        }
    }
    // public function updated($param)
    // {
    //     $this->validateOnly($param);
    // }
    public function mount()
    {
        $this->dropdownData['allDept'] = Department::select('id', 'department_name')->get();
        $this->selectSor['dept_id'] = '';
        $this->selectSor['dept_category_id'] = '';
        $this->selectSor['version'] = '';
        $this->selectSor['selectedSOR'] = '';
        if (Session()->has('addedEstimateData')) {
            $this->addedEstimateUpdateTrack = rand(1, 1000);
        }
    }
    public function changeCategory($value)
    {
        $this->resetExcept(['addedEstimate', 'selectedCategoryId', 'addedEstimateUpdateTrack', 'sorMasterDesc', 'dropdownData', 'selectSor']);
        $value = $value['_x_bindings']['value'];
        $this->estimateData['item_name'] = $value;
        if ($this->selectedCategoryId == 1) {
            $this->fatchDropdownData['departments'] = Department::select('id', 'department_name')->get();
            $this->estimateData['rate_no'] = '';
            $this->estimateData['dept_id'] = Auth::user()->department_id;
            $this->getDeptCategory();
            $this->estimateData['dept_category_id'] = '';
            $this->estimateData['version'] = '';
            $this->estimateData['item_number'] = '';
            $this->estimateData['description'] = '';
            $this->estimateData['other_name'] = '';
            $this->estimateData['qty'] = '';
            $this->estimateData['rate'] = '';
            $this->estimateData['total_amount'] = '';
        } elseif ($this->selectedCategoryId == 2) {
            $this->estimateData['rate_no'] = '';
            $this->estimateData['dept_id'] = '';
            $this->estimateData['dept_category_id'] = '';
            $this->estimateData['version'] = '';
            $this->estimateData['item_number'] = '';
            $this->estimateData['description'] = '';
            $this->estimateData['other_name'] = '';
            $this->estimateData['qty'] = '';
            $this->estimateData['rate'] = '';
            $this->estimateData['total_amount'] = '';
        } elseif ($this->selectedCategoryId == 3) {
            $this->fatchDropdownData['departments'] = Department::select('id', 'department_name')->get();
            $this->estimateData['rate_no'] = '';
            // $this->estimateData['estimate_desc'] = '';
            $this->estimateData['dept_id'] = Auth::user()->department_id;

            $this->estimateData['dept_category_id'] = '';
            $this->estimateData['version'] = '';
            $this->estimateData['item_number'] = '';
            $this->estimateData['description'] = '';
            $this->estimateData['other_name'] = '';
            $this->estimateData['qty'] = '';
            $this->estimateData['rate'] = '';
            $this->estimateData['total_amount'] = '';
        } elseif ($this->selectedCategoryId == 4) {
            $this->fatchDropdownData['departments'] = Department::select('id', 'department_name')->get();
            $this->estimateData['rate_no'] = '';
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
    public function getSorDeptCategory()
    {
        $this->dropdownData['sorDepartmentsCategory'] = SorCategoryType::select('id', 'dept_category_name')->where('department_id', '=', $this->selectSor['dept_id'])->get();
    }
    public function getVersion()
    {
        $this->fatchDropdownData['versions'] = SOR::select('version')->where('department_id', $this->estimateData['dept_id'])
            ->where('dept_category_id', $this->estimateData['dept_category_id'])->groupBy('version')
            ->get();
    }
    public function getSorVersion()
    {
        $this->dropdownData['sorVersions'] = SOR::select('version')->where('department_id', $this->selectSor['dept_id'])
            ->where('dept_category_id', $this->selectSor['dept_category_id'])->groupBy('version')
            ->get();
    }

    public function autoSorSearch()
    {
        if ($this->selectSor['selectedSOR']) {
            $this->dropdownData['sor_items_number'] = SOR::select('Item_details', 'id')
                ->where('department_id', $this->selectSor['dept_id'])
                ->where('dept_category_id', $this->selectSor['dept_category_id'])
                ->where('version', $this->selectSor['version'])
                ->where('Item_details', 'like', $this->selectSor['selectedSOR'] . '%')
                ->where('is_approved', 1)
                ->get();

            // dd($this->fatchDropdownData['items_number']);
            if (count($this->dropdownData['sor_items_number']) > 0) {
                $this->searchDtaCount = (count($this->dropdownData['sor_items_number']) > 0);
                $this->searchStyle = 'block';
            } else {
                $this->selectSor['description'] = '';
                $this->searchStyle = 'none';
                $this->notification()->error(
                    $title = 'Not data found !!' . $this->selectSor['selectedSOR']
                );
            }
        } else {
            $this->selectSor['description'] = '';
            $this->searchStyle = 'none';
            $this->notification()->error(
                $title = 'Not found !!' . $this->selectSor['selectedSOR']
            );
        }
    }
    public function getSorItemDetails($id)
    {
        $this->searchResData = SOR::where('id', $id)->get();
        $this->searchDtaCount = count($this->searchResData) > 0;
        $this->searchStyle = 'none';
        if (count($this->searchResData) > 0) {
            foreach ($this->searchResData as $list) {
                // $this->selectSor['description'] = $list['description'];
                $this->sorMasterDesc = $list['description'];
                $this->selectSor['item_number'] = $list['id'];
                $this->selectSor['selectedSOR'] = $list['Item_details'];
            }
        } else {
            $this->selectSor['description'] = '';
        }
    }
    public function autoSearch()
    {
        // $keyword = $keyword['_x_bindings']['value'];
        // $this->kword = $keyword;
        // $this->fatchDropdownData['items_number'] = SOR::where('department_id', $this->estimateData['dept_id'])
        //     ->where('dept_category_id', $this->estimateData['dept_category_id'])
        //     ->where('version', $this->estimateData['version'])
        //     ->where('Item_details', 'like', '%' . $keyword . '%')->get();
        if ($this->selectedSORKey) {
            $this->fatchDropdownData['items_number'] = SOR::select('Item_details', 'id')
                ->where('department_id', $this->estimateData['dept_id'])
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
        // $this->estimateData['description'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['description'];
        // $this->estimateData['qty'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['unit'];
        // $this->estimateData['rate'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['cost'];
        // $this->estimateData['item_number'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['id'];
        // $this->calculateValue();

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
    public function getCompositSorItemDetails($id)
    {
        // $this->estimateData['description'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['description'];
        // $this->estimateData['qty'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['unit'];
        // $this->estimateData['rate'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['cost'];
        // $this->estimateData['item_number'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['id'];
        // $this->calculateValue();

        $getCompositSorList = CompositSor::where('sor_itemno_parent_id', $id)->get();
        // $getRateList = RatesAnalysis::where('operation','Total')->get();
        foreach ($getCompositSorList as $key => $sor) {
            $this->estimateData['rate_no'] = '';
            $this->estimateData['dept_id'] = '';
            $this->estimateData['dept_category_id'] = $sor['dept_category_id'];
            $this->estimateData['version'] = '';
            $this->estimateData['item_number'] = $sor['sor_itemno_child'];
            $this->estimateData['description'] = getSorItemNumberDesc($sor['sor_itemno_child']);
            $this->estimateData['other_name'] = '';
            $this->estimateData['qty'] = $sor['rate'];
            $rateDetails = RatesAnalysis::where([['sor_item_number', $sor['sor_itemno_child']], ['operation', 'Total']])->first();
            $this->estimateData['rate'] = $rateDetails->total_amount;
            $this->estimateData['total_amount'] = $rateDetails->total_amount * $sor['rate'];
            // foreach($getRateList as $rate)
            // {
            //     // if($sor['sor_itemno_child'] == $rate['sor_item_number']){
            //         $this->estimateData['rate'] = $rate['total_amount'];
            //         $this->estimateData['total_amount'] = $rate['total_amount'] * $sor['rate'];
            //     // }
            // }
            $this->addEstimate($key + 1);
        }
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

    public function getDeptEstimates()
    {
        $this->fatchDropdownData['estimatesList'] = '';
        $this->estimateData['rate_no'] = '';
        $this->estimateData['description'] = '';
        $this->estimateData['total_amount'] = '';
        // $this->fatchDropdownData['estimatesList'] = EstimatePrepare::select('estimate_id')->where('dept_id',$this->estimateData['dept_id'])->groupBy('estimate_id')->get();
        // $this->fatchDropdownData['estimatesList'] = EstimatePrepare::join('sor_masters','estimate_prepares.estimate_id','sor_masters.estimate_id')
        //                                             ->where('estimate_prepares.dept_id',$this->estimateData['dept_id'])
        //                                             ->where('sor_masters.is_verified','=',1)
        //                                             ->get();
        // $this->fatchDropdownData['estimatesList'] = Esrecommender::join('sor_masters', 'estimate_recomender.estimate_id', 'sor_masters.estimate_id')
        //     ->where('estimate_recomender.dept_id', $this->estimateData['dept_id'])
        //     ->where('sor_masters.is_verified', '=', 1)
        //     ->get();
        $this->fatchDropdownData['estimatesList'] = SorMaster::select('estimate_id', 'dept_id', 'sorMasterDesc', 'status', 'is_verified')->where([['dept_id', Auth::user()->department_id], ['status', 1], ['is_verified', 1]])->get();
        // $this->fatchDropdownData['estimatesList'] = RatesAnalysis::select('description', 'rate_id', 'total_amount')->where([['operation', 'Total'], ['dept_id', Auth::user()->department_id], ['category_id', $this->estimateData['dept_category_id']]])->get();
    }

    public function getDeptRates()
    {
        $this->fatchDropdownData['ratesList'] = '';
        $this->estimateData['rate_no'] = '';
        $this->estimateData['description'] = '';
        $this->estimateData['total_amount'] = '';
        // $this->fatchDropdownData['estimatesList'] = EstimatePrepare::select('estimate_id')->where('dept_id',$this->estimateData['dept_id'])->groupBy('estimate_id')->get();
        // $this->fatchDropdownData['estimatesList'] = EstimatePrepare::join('sor_masters','estimate_prepares.estimate_id','sor_masters.estimate_id')
        //                                             ->where('estimate_prepares.dept_id',$this->estimateData['dept_id'])
        //                                             ->where('sor_masters.is_verified','=',1)
        //                                             ->get();
        // $this->fatchDropdownData['estimatesList'] = Esrecommender::join('sor_masters', 'estimate_recomender.estimate_id', 'sor_masters.estimate_id')
        //     ->where('estimate_recomender.dept_id', $this->estimateData['dept_id'])
        //     ->where('sor_masters.is_verified', '=', 1)
        //     ->get();
        // $this->fatchDropdownData['ratesList'] = SorMaster::select('estimate_id','dept_id','sorMasterDesc','status','is_verified')->where([['dept_id',Auth::user()->department_id],['status',1],['is_verified',1]])->get();
        $this->fatchDropdownData['ratesList'] = RatesAnalysis::select('description', 'rate_id')->where([['operation', 'Total'], ['dept_id', $this->estimateData['dept_id']]])->get();
        // $this->fatchDropdownData['ratesList'] = RatesAnalysis::all();
    }
    public function getEstimateDetails()
    {
        // $rateId = (int)$this->estimateData['rate_no'];

        // if ($rateId) {
        //     $key = collect($this->fatchDropdownData['estimatesList'])->search(function ($item) use ($rateId) {
        //         return $item['rate_id'] === $rateId;
        //     });
        //     $details = $this->fatchDropdownData['estimatesList'][$key];
        //     $this->estimateData['total_amount'] = '';
        //     $this->estimateData['description'] = '';
        //     $this->estimateData['qty'] = '';
        //     $this->estimateData['rate'] = '';
        //     $this->estimateData['total_amount'] = $details['total_amount'];
        //     $this->estimateData['description'] = $details['description'];
        //     $this->estimateData['qty'] = 1;
        //     $this->estimateData['rate'] = $details['total_amount'];
        // }

        $this->estimateData['total_amount'] = '';
        $this->estimateData['description'] = '';
        $this->estimateData['qty'] = '';
        $this->estimateData['rate'] = '';
        $this->fatchDropdownData['estimateDetails'] = EstimatePrepare::join('sor_masters', 'estimate_prepares.estimate_id', 'sor_masters.estimate_id')
            ->where('estimate_prepares.estimate_id', $this->estimateData['rate_no'])
            ->where('estimate_prepares.operation', 'Total')->where([['sor_masters.is_verified', 1], ['sor_masters.status', 1]])->first();
        $this->estimateData['total_amount'] = $this->fatchDropdownData['estimateDetails']['total_amount'];
        $this->estimateData['description'] = $this->fatchDropdownData['estimateDetails']['sorMasterDesc'];
        $this->estimateData['qty'] = 1;
        $this->estimateData['rate'] = $this->fatchDropdownData['estimateDetails']['total_amount'];
    }

    public function getRateDetails()
    {
        // $rateId = (int)$this->estimateData['rate_no'];

        // if ($rateId) {
        //     $key = collect($this->fatchDropdownData['estimatesList'])->search(function ($item) use ($rateId) {
        //         return $item['rate_id'] === $rateId;
        //     });
        //     $details = $this->fatchDropdownData['estimatesList'][$key];
        //     $this->estimateData['total_amount'] = '';
        //     $this->estimateData['description'] = '';
        //     $this->estimateData['qty'] = '';
        //     $this->estimateData['rate'] = '';
        //     $this->estimateData['total_amount'] = $details['total_amount'];
        //     $this->estimateData['description'] = $details['description'];
        //     $this->estimateData['qty'] = 1;
        //     $this->estimateData['rate'] = $details['total_amount'];
        // }

        $this->estimateData['total_amount'] = '';
        $this->estimateData['description'] = '';
        $this->estimateData['qty'] = '';
        $this->estimateData['rate'] = '';
        $this->fatchDropdownData['rateDetails'] = RatesAnalysis::select('description', 'rate_id', 'total_amount')->where([['rate_id', $this->estimateData['rate_no']], ['operation', 'Total'], ['dept_id', Auth::user()->department_id]])->first();
        $this->estimateData['total_amount'] = $this->fatchDropdownData['rateDetails']['total_amount'];
        $this->estimateData['description'] = $this->fatchDropdownData['rateDetails']['description'];
        $this->estimateData['qty'] = 1;
        $this->estimateData['rate'] = $this->fatchDropdownData['rateDetails']['total_amount'];
    }
    public function addEstimate()
    {
        // $validatee = $this->validate();
        if (isset($key)) {
            $this->showTableOne = !$this->showTableOne;
            $this->addedEstimate[$key]['rate_no'] = ($this->estimateData['rate_no'] == '') ? 0 : $this->estimateData['rate_no'];
            // $this->addedEstimate[$key]['dept_id'] = ($this->estimateData['dept_id'] == '') ? 0 : $this->estimateData['dept_id'];
            $this->addedEstimate[$key]['dept_id'] = Auth::user()->department_id;
            $this->addedEstimate[$key]['category_id'] = ($this->estimateData['dept_category_id'] == '') ? 0 : $this->estimateData['dept_category_id'];
            $this->addedEstimate[$key]['sor_item_number'] = ($this->estimateData['item_number'] == '') ? 0 : $this->estimateData['item_number'];
            $this->addedEstimate[$key]['item_name'] = $this->estimateData['item_name'];
            $this->addedEstimate[$key]['other_name'] = $this->estimateData['other_name'];
            $this->addedEstimate[$key]['description'] = $this->estimateData['description'];
            $this->addedEstimate[$key]['qty'] = ($this->estimateData['qty'] == '') ? 0 : $this->estimateData['qty'];
            $this->addedEstimate[$key]['rate'] = ($this->estimateData['rate'] == '') ? 0 : $this->estimateData['rate'];
            $this->addedEstimate[$key]['total_amount'] = $this->estimateData['total_amount'];
            $this->addedEstimate[$key]['version'] = $this->estimateData['version'];
            $this->addedEstimateUpdateTrack = rand(1, 1000);
            $this->estimateData[$key]['item_number'] = '';
            $this->estimateData[$key]['qty'] = '';
            $this->estimateData[$key]['rate'] = '';
            $this->estimateData[$key]['total_amount'] = '';
            $this->resetExcept(['addedEstimate', 'showTableOne', 'addedEstimateUpdateTrack', 'sorMasterDesc', 'dropdownData', 'selectSor', 'estimateData', 'fatchDropdownData']);
        } else {
            $this->reset('addedEstimate');
            $this->showTableOne = !$this->showTableOne;
            $this->addedEstimate['rate_no'] = ($this->estimateData['rate_no'] == '') ? 0 : $this->estimateData['rate_no'];
            // $this->addedEstimate['dept_id'] = ($this->estimateData['dept_id'] == '') ? 0 : $this->estimateData['dept_id'];
            $this->addedEstimate['dept_id'] = Auth::user()->department_id;
            $this->addedEstimate['category_id'] = ($this->estimateData['dept_category_id'] == '') ? 0 : $this->estimateData['dept_category_id'];
            $this->addedEstimate['sor_item_number'] = ($this->estimateData['item_number'] == '') ? 0 : $this->estimateData['item_number'];
            $this->addedEstimate['item_name'] = $this->estimateData['item_name'];
            $this->addedEstimate['other_name'] = $this->estimateData['other_name'];
            $this->addedEstimate['description'] = $this->estimateData['description'];
            $this->addedEstimate['qty'] = ($this->estimateData['qty'] == '') ? 0 : $this->estimateData['qty'];
            $this->addedEstimate['rate'] = ($this->estimateData['rate'] == '') ? 0 : $this->estimateData['rate'];
            $this->addedEstimate['total_amount'] = $this->estimateData['total_amount'];
            $this->addedEstimate['version'] = $this->estimateData['version'];
            $this->addedEstimateUpdateTrack = rand(1, 1000);
            $this->estimateData['item_number'] = '';
            $this->estimateData['estimate_no'] = '';
            $this->estimateData['rate_no'] = '';
            $this->estimateData['qty'] = '';
            $this->estimateData['rate'] = '';
            $this->estimateData['total_amount'] = '';
            $this->resetExcept(['addedEstimate', 'showTableOne', 'addedEstimateUpdateTrack', 'sorMasterDesc', 'dropdownData', 'selectSor', 'estimateData', 'fatchDropdownData']);
        }
        // dd($this->addedEstimate);
    }
    public function render()
    {
        return view('livewire.rate-analysis.create-rate-analysis');
    }
}
