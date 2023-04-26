<?php

namespace App\Http\Livewire\EstimateProject;

use App\Models\Department;
use App\Models\Esrecommender;
use App\Models\EstimatePrepare;
use App\Models\SOR;
use App\Models\SORCategory;
use App\Models\SorCategoryType;
use App\Models\SorMaster;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class EditEstimateProject extends Component
{
    use Actions;
    public $estimateData = [], $getCategory = [], $fatchDropdownData = [], $sorMasterDesc;
    public $kword = null, $selectedSORKey, $selectedCategoryId, $showTableOne = false, $updateDataTableTracker;
    public $addedEstimate = [];
    public $searchDtaCount, $searchStyle, $searchResData;
    // TODO:: remove $showTableOne if not use
    // TODO::pop up modal view estimate and project estimate
    // TODO::forward revert draft modify
    public $currentEstimate = [];
    public $estimate_id;
    protected $listeners = ['editEstimateRow' => 'editEstimate'];

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
        'estimateData.estimate_no.required' => 'This field is required',
        'estimateData.estimate_no.numeric' => 'This field is must be numeric',
        'estimateData.estimate_desc.required' => 'This field is required',
        'estimateData.estimate_desc.string' => 'Invalid format input'
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
        if($this->selectedCategoryId == 3){
            $this->rules =  Arr::collapse([$this->rules, [
                'estimateData.dept_id' => 'required|integer',
                'estimateData.estimate_no' => 'required|integer',
                // 'estimateData.estimate_desc' => 'required|string',
                'estimateData.total_amount' => 'required|numeric'
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
            $this->updateDataTableTracker = rand(1, 1000);
        }
    }
    public function changeCategory($value)
    {
        $this->resetExcept(['addedEstimate', 'selectedCategoryId', 'updateDataTableTracker', 'sorMasterDesc']);
        $value = $value['_x_bindings']['value'];
        $this->estimateData['item_name'] = $value;
        if ($this->estimateData['item_name'] == 'SOR') {
            $this->fatchDropdownData['departments'] = Department::select('id', 'department_name')->get();
            $this->estimateData['estimate_no'] = NULL;
            $this->estimateData['dept_id'] = '';
            $this->estimateData['dept_category_id'] = '';
            $this->estimateData['version'] = '';
            $this->estimateData['item_number'] = '';
            $this->estimateData['description'] = '';
            $this->estimateData['other_name'] = '';
            $this->estimateData['qty'] = '';
            $this->estimateData['rate'] = '';
            $this->estimateData['total_amount'] = '';
        } elseif($this->estimateData['item_name'] == 'Other') {
            $this->estimateData['estimate_no'] = NULL;
            $this->estimateData['dept_id'] = '';
            $this->estimateData['dept_category_id'] = '';
            $this->estimateData['version'] = '';
            $this->estimateData['item_number'] = '';
            $this->estimateData['description'] = '';
            $this->estimateData['other_name'] = '';
            $this->estimateData['qty'] = '';
            $this->estimateData['rate'] = '';
            $this->estimateData['total_amount'] = '';
        }elseif($this->estimateData['item_name'] == 'Estimate'){
            $this->fatchDropdownData['departments'] = Department::select('id', 'department_name')->get();
            $this->estimateData['estimate_no'] = '';
            // $this->estimateData['estimate_desc'] = '';
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
        // $this->fatchDropdownData['estimatesList'] = Esrecommender::join('sor_masters', 'estimate_recomender.estimate_id', 'sor_masters.estimate_id')
        //     ->where('estimate_recomender.dept_id', $this->estimateData['dept_id'])
        //     ->where('sor_masters.is_verified', '=', 1)
        //     ->get();
        $this->fatchDropdownData['estimatesList'] = SorMaster::select('estimate_id','dept_id','sorMasterDesc','status','is_verified')->where([['dept_id',Auth::user()->department_id],['status',8],['is_verified',1]])->get();
    }

    public function getEstimateDetails()
    {
        $this->estimateData['total_amount'] = '';
        $this->estimateData['description'] = '';
        $this->estimateData['qty'] = '';
        $this->estimateData['rate'] = '';
        $this->fatchDropdownData['estimateDetails'] = Esrecommender::join('sor_masters', 'estimate_recomender.estimate_id', 'sor_masters.estimate_id')
        ->where('estimate_recomender.estimate_id', $this->estimateData['estimate_no'])
        ->where('estimate_recomender.operation', 'Total')->where('sor_masters.is_verified', '=', 1)->first();
        $this->estimateData['total_amount'] = $this->fatchDropdownData['estimateDetails']['total_amount'];
        $this->estimateData['description'] = $this->fatchDropdownData['estimateDetails']['sorMasterDesc'];
        $this->estimateData['qty'] = 1;
        $this->estimateData['rate'] = $this->fatchDropdownData['estimateDetails']['total_amount'];
    }
    public function editEstimate($estimateId = 0)
    {
       $this->estimate_id = $estimateId;
       $this->currentEstimate = EstimatePrepare::where('estimate_id',$this->estimate_id)->get()->toArray();
       $sorDesc = SorMaster::select('sorMasterDesc')->where('estimate_id',$this->estimate_id)->first();
       $this->sorMasterDesc = $sorDesc['sorMasterDesc'];
    }
    public function addEstimate()
    {
        $validatee = $this->validate();
        $this->reset('addedEstimate');
        $this->showTableOne = !$this->showTableOne;
        $this->addedEstimate['estimate_no'] = $this->estimateData['estimate_no'];
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
        $this->updateDataTableTracker = rand(1, 1000);
        $this->resetExcept(['addedEstimate', 'showTableOne', 'updateDataTableTracker', 'sorMasterDesc']);
    }
    public function render()
    {
        $this->getCategory = SORCategory::select('item_name', 'id')->get();
        return view('livewire.estimate-project.edit-estimate-project');
    }
}
