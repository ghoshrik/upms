<?php

namespace App\Http\Livewire\QuantityEvaluation;

use Livewire\Component;
use App\Models\Department;
use App\Models\Esrecommender;
use App\Models\EstimatePrepare;
use App\Models\RatesAnalysis;
use App\Models\SOR;
use App\Models\SorCategoryType;
use App\Models\SorMaster;
use App\Models\UnitMaster;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use WireUi\Traits\Actions;

class CreateQuantityEvaluation extends Component
{
    use Actions;
    public $estimateData = [], $getCategory = [], $fatchDropdownData = [], $selectedDept,$selectedRate;
    public $kword = null, $selectedSORKey, $selectedCategoryId, $showTableOne = false, $addedEstimateUpdateTrack;
    public $addedEstimate = [];
    public $searchDtaCount, $searchStyle, $searchResData,$unite;
    // TODO:: remove $showTableOne if not use
    // TODO::pop up modal view estimate and project estimate
    // TODO::forward revert draft modify

    protected $rules = [
        // 'sorMasterDesc' => 'required|string',
        // 'selectedCategoryId' => 'required|integer',
        'unite' =>'required'

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
        'estimateData.estimate_no.required' => 'This field is required',
        'estimateData.estimate_no.numeric' => 'This field is must be numeric',
        'estimateData.estimate_desc.required' => 'This field is required',
        'estimateData.estimate_desc.string' => 'Invalid format input',
    ];
    public function booted()
    {
        // if ($this->selectedCategoryId == 1) {
        //     $this->rules = Arr::collapse([$this->rules, [
        //         'estimateData.dept_id' => 'required|integer',
        //         'estimateData.dept_category_id' => 'required|integer',
        //         'estimateData.version' => 'required',
        //         'selectedSORKey' => 'required|string',

        //     ]]);
        // }
        // if ($this->selectedCategoryId == 2) {
        //     $this->rules = Arr::collapse([$this->rules, [
        //         'estimateData.other_name' => 'required|string',
        //     ]]);
        // }
        // if ($this->selectedCategoryId == 3) {
        //     $this->rules = Arr::collapse([$this->rules, [
        //         'estimateData.dept_id' => 'required|integer',
        //         'estimateData.estimate_no' => 'required|integer',
        //         // 'estimateData.estimate_desc' => 'required|string',
        //         'estimateData.total_amount' => 'required|numeric',
        //     ]]);
        // }
        // if ($this->selectedCategoryId == 1 || $this->selectedCategoryId == 2) {
        //     $this->rules = Arr::collapse([$this->rules, [
        //         'estimateData.qty' => 'required|numeric',
        //         'estimateData.rate' => 'required|numeric',
        //         'estimateData.total_amount' => 'required|numeric',

        //     ]]);
        // }
    }
    // public function updated($param)
    // {
    //     $this->validateOnly($param);
    // }
    public function mount()
    {
        $this->fatchDropdownData['departments'] = Department::select('id', 'department_name')->get();
        $this->fatchDropdownData['ratesList'] = [];
        $this->selectedDept = Auth::user()->department_id;
        $this->unite =  UnitMaster::select('id', 'unit_name', 'short_name', 'is_active')->where('is_active', 1)->orderBy('id', 'desc')->get();
        if (Session()->has('addedQuantityEvaluationData')) {
            $this->addedEstimateUpdateTrack = rand(1, 1000);
        }
        // $this->estimateData['estimate_no'] = null;
        // $this->estimateData['dept_id'] = '';
        // $this->estimateData['dept_category_id'] = '';
        // $this->estimateData['version'] = '';
        // $this->estimateData['item_number'] = '';
        // $this->estimateData['description'] = '';
        // $this->estimateData['other_name'] = '';
        // $this->estimateData['qty'] = '';
        // $this->estimateData['rate'] = '';
        // $this->estimateData['total_amount'] = '';
        // $this->estimateData['item_name'] = 'Other';
        $this->estimateData['unite'] ='';
        $this->estimateData['label'] ='';
        $this->estimateData['value'] ='';
        if(!empty($this->selectedDept)){
            $this->getDeptRates();
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
        $this->estimateData['estimate_no'] = '';
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
        $this->fatchDropdownData['estimatesList'] = SorMaster::select('estimate_id','dept_id','sorMasterDesc','status','is_verified')->where([['dept_id',Auth::user()->department_id],['status',1],['is_verified',1]])->get();
        // $this->fatchDropdownData['estimatesList'] = RatesAnalysis::select('description', 'rate_id', 'total_amount')->where([['operation', 'Total'], ['dept_id', Auth::user()->department_id], ['category_id', $this->estimateData['dept_category_id']]])->get();
    }
    public function getDeptRates()
    {
        $this->fatchDropdownData['ratesList'] = [];
        // $this->estimateData['rate_no'] = '';
        // $this->estimateData['description'] = '';
        // $this->estimateData['total_amount'] = '';
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
        $this->fatchDropdownData['ratesList'] = RatesAnalysis::select('description', 'rate_id')->where([['operation', 'Total'], ['dept_id', $this->selectedDept]])->get();
        // $this->fatchDropdownData['ratesList'] = RatesAnalysis::all();
    }
    public function getEstimateDetails()
    {
        // $rateId = (int)$this->estimateData['estimate_no'];

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
            ->where('estimate_prepares.estimate_id', $this->estimateData['estimate_no'])
            ->where('estimate_prepares.operation', 'Total')->where([['sor_masters.is_verified', 1],['sor_masters.status', 1]])->first();
        $this->estimateData['total_amount'] = $this->fatchDropdownData['estimateDetails']['total_amount'];
        $this->estimateData['description'] = $this->fatchDropdownData['estimateDetails']['sorMasterDesc'];
        $this->estimateData['qty'] = 1;
        $this->estimateData['rate'] = $this->fatchDropdownData['estimateDetails']['total_amount'];
    }
    public function addEstimate()
    {
        // $validatee = $this->validate();
        $this->reset('addedEstimate');
        // $this->showTableOne = !$this->showTableOne;
        // $this->addedEstimate['estimate_no'] = ($this->estimateData['estimate_no'] == '') ? 0 : $this->estimateData['estimate_no'];
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
        $this->addedEstimate['label'] = $this->estimateData['label'];
        $this->addedEstimate['value'] = $this->estimateData['value'];
        $this->addedEstimate['unite'] = $this->estimateData['unite'];
        $this->addedEstimate['rate_id'] = (int) $this->selectedRate;
        $this->addedEstimate['dept_id'] = (int) $this->selectedDept;
        $this->addedEstimateUpdateTrack = rand(1, 1000);
        $this->resetExcept(['addedEstimate', 'showTableOne', 'addedEstimateUpdateTrack', 'selectedRate','selectedDept','unite','fatchDropdownData']);
        // dd($this->addedEstimate);
    }
    public function render()
    {
        return view('livewire.quantity-evaluation.create-quantity-evaluation');
    }
}
