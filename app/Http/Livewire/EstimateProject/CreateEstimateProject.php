<?php

namespace App\Http\Livewire\EstimateProject;

use App\Models\Department;
use App\Models\DynamicSorHeader;
use App\Models\EstimatePrepare;
use App\Models\QultiyEvaluation;
use App\Models\RatesAnalysis;
use App\Models\SOR;
use App\Models\SorCategoryType;
use App\Models\SorMaster;
use App\Models\UnitMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use WireUi\Traits\Actions;

class CreateEstimateProject extends Component
{
    use Actions;
    protected $listeners = ['getRowValue', 'closeModal', 'editEstimate'];
    public $estimateData = [], $getCategory = [], $fatchDropdownData = [], $sorMasterDesc;
    public $kword = null, $selectedSORKey, $selectedCategoryId, $showTableOne = false, $addedEstimateUpdateTrack, $part_no = '';
    public $addedEstimate = [];
    public $searchDtaCount, $searchStyle, $searchResData, $quntity_type = 'menual', $quntity_type_id = 2, $qc_value, $viewModal = false, $counterForItemNo = 0, $modalName = '', $getSor = [], $editEstimate_id = '';
    // TODO:: remove $showTableOne if not use
    // TODO::pop up modal view estimate and project estimate
    // TODO::forward revert draft modify

    protected $rules = [
        'sorMasterDesc' => 'required|string',
        'part_no' => 'required',
        // 'selectedCategoryId' => 'required|integer',

    ];

    protected $messages = [
        'sorMasterDesc.required' => 'The description cannot be empty.',
        'sorMasterDesc.string' => 'The description format is not valid.',
        'part_no.required' => 'Only A to Z as input.',
        // 'selectedCategoryId.required' => 'Selected at least one ',
        // 'selectedCategoryId.integer' => 'This Selected field is Invalid',
        // 'estimateData.other_name.required' => 'selected other name required',
        // 'estimateData.other_name.string' => 'This field is must be character',
        // 'estimateData.dept_id.required' => 'This field is required',
        // 'estimateData.dept_id.integer' => 'This Selected field is invalid',
        // 'estimateData.dept_category_id.required' => 'This field is required',
        // 'estimateData.dept_category_id.integer' => 'This Selected field is invalid',
        // 'estimateData.version.required' => 'This Selected field is required',
        // 'estimateData.version.integer' => 'This Selected field is invalid',
        // 'selectedSORKey.required' => 'This field is required',
        // 'selectedSORKey.string' => 'This field is must be string',
        // 'estimateData.qty.required' => 'This field is not empty',
        // 'estimateData.qty.numeric' => 'This field is must be numeric',
        // 'estimateData.rate.required' => 'This field is not empty',
        // 'estimateData.rate.numeric' => 'This field is must be numeric',
        // 'estimateData.total_amount.required' => 'This field is not empty',
        // 'estimateData.total_amount.numeric' => 'This field is must be numeric',
        // 'estimateData.estimate_no.required' => 'This field is required',
        // 'estimateData.estimate_no.numeric' => 'This field is must be numeric',
        // 'estimateData.estimate_desc.required' => 'This field is required',
        // 'estimateData.estimate_desc.string' => 'Invalid format input',
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
        if (Session()->has('addedProjectEstimateData')) {
            if (Session::has('projectEstimateDesc')) {
                $this->sorMasterDesc = Session::get('projectEstimateDesc');
            }
            if (Session()->has('projectEstimatePartNo')) {
                $this->part_no = Session()->get('projectEstimatePartNo');
            }
            if (Session()->has('projectEstimationTotal')) {
                $this->totalOnSelectedCount = Session()->get('projectEstimationTotal');
            }
            $this->addedEstimateUpdateTrack = rand(1, 1000);
        }
    }

    public function editEstimate($estimate_id)
    {
        $fatchEstimateMaster = SORMaster::where([['estimate_id', $estimate_id]])->first();
        // $fatchEstimateMaster = SORMaster::where([['estimate_id', $estimate_id], ['created_by', Auth::user()->id]])->first();
        if ($fatchEstimateMaster != '') {
            $this->sorMasterDesc = $fatchEstimateMaster['sorMasterDesc'];
            $this->part_no = $fatchEstimateMaster['part_no'];
            $this->editEstimate_id = $estimate_id;
            Session()->forget('editProjectEstimateData' . $this->editEstimate_id);
            Session()->forget('editProjectEstimateDesc' . $this->editEstimate_id);
            Session()->forget('editProjectEstimatePartNo' . $this->editEstimate_id);
            Session()->forget('editModalData');
            // if (Session()->has('editProjectEstimateData' . $estimate_id)) {
            //     $fatchEstimateData = Session()->get('editProjectEstimateData' . $estimate_id);
            // } else {
                $fatchEstimateData = EstimatePrepare::where('estimate_id', $estimate_id)->where('created_by', Auth::user()->id)->orderBy('id','asc')->get();
            // }
            // dd($fatchEstimateData);
            $this->emit('setFatchEstimateData', $fatchEstimateData);
        }
    }

    public function changeCategory($value)
    {
        $this->resetExcept(['addedEstimate', 'selectedCategoryId', 'addedEstimateUpdateTrack', 'sorMasterDesc', 'part_no', 'editEstimate_id']);
        // dd($this->addedEstimate,$this->editEstimate_id);
        $this->part_no = strtoupper($this->part_no);
        $value = $value['_x_bindings']['value'];
        $this->estimateData['item_name'] = $value;
        $getAllUnit = Cache::get('getUnits');
        if ($getAllUnit != '') {
            $this->fatchDropdownData['units'] = $getAllUnit;
        } else {
            $this->fatchDropdownData['units'] = Cache::remember('getUnits', now()->addMinutes(720), function () {
                return UnitMaster::select('id', 'unit_name')->get();
            });
        }
        if ($this->estimateData['item_name'] == 'SOR') {
            // $this->fatchDropdownData['departments'] = Department::select('id', 'department_name')->get();
            $allDept = Cache::get('allDept');
            if ($allDept != '') {
                $this->fatchDropdownData['departments'] = $allDept;
            } else {
                $this->fatchDropdownData['departments'] = Cache::remember('allDept', now()->addMinutes(720), function () {
                    return Department::select('id', 'department_name')->get();
                });
            }
            $this->fatchDropdownData['page_no'] = [];
            $this->estimateData['estimate_no'] = null;
            $this->estimateData['rate_no'] = '';
            $this->estimateData['dept_id'] = Auth::user()->department_id;
            $this->getDeptCategory();
            $this->estimateData['dept_category_id'] = '';
            $this->estimateData['version'] = '';
            $this->estimateData['volume'] = '';
            $this->estimateData['table_no'] = '';
            $this->estimateData['page_no'] = '';
            $this->estimateData['id'] = '';
            $this->estimateData['item_number'] = '';
            $this->estimateData['description'] = '';
            $this->estimateData['other_name'] = '';
            $this->estimateData['unit_id'] = '';
            $this->estimateData['qty'] = '';
            $this->estimateData['rate'] = '';
            $this->estimateData['total_amount'] = '';
        } elseif ($this->estimateData['item_name'] == 'Other') {
            $this->estimateData['estimate_no'] = null;
            $this->estimateData['rate_no'] = '';
            $this->estimateData['dept_id'] = '';
            $this->estimateData['dept_category_id'] = '';
            $this->estimateData['version'] = '';
            $this->estimateData['item_number'] = '';
            $this->estimateData['description'] = '';
            $this->estimateData['other_name'] = '';
            $this->estimateData['unit_id'] = '';
            $this->estimateData['qty'] = '';
            $this->estimateData['rate'] = 0;
            $this->estimateData['total_amount'] = '';
        } elseif ($this->estimateData['item_name'] == 'Estimate') {
            // $this->fatchDropdownData['departments'] = Department::select('id', 'department_name')->get();
            $allDept = Cache::get('allDept');
            if ($allDept != '') {
                $this->fatchDropdownData['departments'] = $allDept;
            } else {
                $this->fatchDropdownData['departments'] = Cache::remember('allDept', now()->addMinutes(720), function () {
                    return Department::select('id', 'department_name')->get();
                });
            }
            $this->estimateData['estimate_no'] = '';
            // $this->estimateData['estimate_desc'] = '';
            $this->estimateData['rate_no'] = '';
            $this->estimateData['dept_id'] = Auth::user()->department_id;
            $this->getDeptEstimates();
            $this->estimateData['dept_category_id'] = '';
            $this->estimateData['version'] = '';
            $this->estimateData['item_number'] = '';
            $this->estimateData['description'] = '';
            $this->estimateData['other_name'] = '';
            $this->estimateData['unit_id'] = '';
            $this->estimateData['qty'] = '';
            $this->estimateData['rate'] = '';
            $this->estimateData['total_amount'] = '';
        } elseif ($this->estimateData['item_name'] == 'Rate') {
            // $this->fatchDropdownData['departments'] = Department::select('id', 'department_name')->get();
            $allDept = Cache::get('allDept');
            if ($allDept != '') {
                $this->fatchDropdownData['departments'] = $allDept;
            } else {
                $this->fatchDropdownData['departments'] = Cache::remember('allDept', now()->addMinutes(720), function () {
                    return Department::select('id', 'department_name')->get();
                });
            }
            $this->estimateData['estimate_no'] = '';
            $this->estimateData['rate_no'] = '';
            $this->estimateData['rate_type'] = '';
            // $this->estimateData['estimate_desc'] = '';
            $this->estimateData['dept_id'] = Auth::user()->department_id;
            $this->getDeptRates();
            $this->estimateData['dept_category_id'] = '';
            $this->estimateData['version'] = '';
            $this->estimateData['item_number'] = '';
            $this->estimateData['description'] = '';
            $this->estimateData['other_name'] = '';
            $this->estimateData['unit_id'] = '';
            $this->estimateData['qty'] = '';
            $this->estimateData['rate'] = '';
            $this->estimateData['total_amount'] = '';
        }
    }

    public function changeQuntity($value)
    {
        $value = $value['_x_bindings']['value'];
        // dd($value);
        $this->quntity_type = $value;
        if ($value == 'Qutity Evaluation') {
            $this->fatchDropdownData['qultiyEvaluation'] = QultiyEvaluation::select('value')->where('rate_id', $this->estimateData['rate_no'])->where('operation', '=', 'Final')->get();
        }
        // dd($this->fatchDropdownData['qultiyEvaluation']);
    }

    public function getDeptCategory()
    {
        $this->estimateData['dept_category_id'] = '';
        $this->estimateData['volume'] = '';
        $this->estimateData['table_no'] = '';
        $this->estimateData['page_no'] = '';
        $this->estimateData['id'] = '';
        $this->estimateData['description'] = '';
        $this->estimateData['qty'] = '';
        $this->estimateData['rate'] = '';
        $this->estimateData['total_amount'] = '';
        // $this->fatchDropdownData['departmentsCategory'] = SorCategoryType::select('id', 'dept_category_name')->where('department_id', '=', $this->estimateData['dept_id'])->get();
        $cacheKey = 'dept_cat' . '_' . $this->estimateData['dept_id'];
        $cacheHasDeptCat = Cache::get($cacheKey);
        if ($cacheHasDeptCat != '') {
            $this->fatchDropdownData['departmentsCategory'] = $cacheHasDeptCat;
        } else {
            $this->fatchDropdownData['departmentsCategory'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                return SorCategoryType::select('id', 'dept_category_name')->where('department_id', '=', $this->estimateData['dept_id'])->get();
            });
        }
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
            $this->fatchDropdownData['items_number'] = SOR::select('Item_details', 'id', 'description')
                ->where('department_id', $this->estimateData['dept_id'])
                ->where('dept_category_id', $this->estimateData['dept_category_id'])
                ->where('version', $this->estimateData['version'])
                ->where('Item_details', 'like', $this->selectedSORKey . '%')
                ->where('is_approved', 1)
                ->get();

            // dd($jsonData = $this->fatchDropdownData['items_number']->toJson());
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

    public function getVolumn()
    {
        $this->fatchDropdownData['table_no'] = [];
        $this->fatchDropdownData['page_no'] = [];
        $this->estimateData['volume'] = '';
        $this->estimateData['table_no'] = '';
        $this->estimateData['page_no'] = '';
        $this->estimateData['id'] = '';
        $this->estimateData['description'] = '';
        $this->estimateData['qty'] = '';
        $this->estimateData['rate'] = '';
        $this->estimateData['total_amount'] = '';
        // $this->fatchDropdownData['volumes'] = DynamicSorHeader::where([['department_id', $this->estimateData['dept_id']], ['dept_category_id', $this->estimateData['dept_category_id']]])->select('volume_no')->groupBy('volume_no')->get();
        $cacheKey = 'volume_' . $this->estimateData['dept_id'] . '_' . $this->estimateData['dept_category_id'];
        $getCacheData = Cache::get($cacheKey);
        $this->fatchDropdownData['volumes'] = [];
        if ($getCacheData != '') {
            $this->fatchDropdownData['volumes'] = $getCacheData;
        } else {
            $this->fatchDropdownData['volumes'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                return DynamicSorHeader::where([['department_id', $this->estimateData['dept_id']], ['dept_category_id', $this->estimateData['dept_category_id']]])->select('volume_no')->groupBy('volume_no')->get();
            });
        }
    }

    public function getTableNo()
    {
        $this->fatchDropdownData['table_no'] = [];
        // if ($this->selectedCategoryId == '') {
        //     $this->selectSor['table_no'] = '';
        //     $this->selectSor['page_no'] = '';
        //     $this->dropdownData['table_no'] = DynamicSorHeader::where([['department_id', $this->selectSor['dept_id']], ['dept_category_id', $this->selectSor['dept_category_id']], ['volume_no', $this->selectSor['volume']]])
        //         ->select('table_no')->groupBy('table_no')->get();
        // } else {
        $this->estimateData['table_no'] = '';
        $this->estimateData['page_no'] = '';
        $this->estimateData['id'] = '';
        $this->estimateData['description'] = '';
        $this->estimateData['qty'] = '';
        $this->estimateData['rate'] = '';
        $this->estimateData['total_amount'] = '';
        // $this->fatchDropdownData['table_no'] = DynamicSorHeader::where([['department_id', $this->estimateData['dept_id']], ['dept_category_id', $this->estimateData['dept_category_id']], ['volume_no', $this->estimateData['volume']]])->select('table_no')->groupBy('table_no')->get();
        $cacheKey = 'table_no_' . $this->estimateData['dept_id'] . '_' . $this->estimateData['dept_category_id'] . '_' . $this->estimateData['volume'];
        $getCacheData = Cache::get($cacheKey);
        if ($getCacheData != '') {
            $this->fatchDropdownData['table_no'] = $getCacheData;
        } else {
            $this->fatchDropdownData['table_no'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                return DynamicSorHeader::where([['department_id', $this->estimateData['dept_id']], ['dept_category_id', $this->estimateData['dept_category_id']], ['volume_no', $this->estimateData['volume']]])->select('table_no')->groupBy('table_no')->get();
            });
        }
        // }
    }

    public function getPageNo()
    {

        $this->viewModal = false;
        // if ($this->selectedCategoryId == '') {
        //     $this->selectSor['page_no'] = '';
        //     $this->dropdownData['page_no'] = DynamicSorHeader::where([['department_id', $this->selectSor['dept_id']], ['dept_category_id', $this->selectSor['dept_category_id']], ['volume_no', $this->selectSor['volume']], ['table_no', $this->selectSor['table_no']]])
        //         ->select('page_no')->get();
        // } else {
        $this->estimateData['id'] = '';
        $this->estimateData['description'] = '';
        $this->estimateData['qty'] = '';
        $this->estimateData['rate'] = '';
        $this->estimateData['total_amount'] = '';
        // $this->fatchDropdownData['page_no'] = DynamicSorHeader::where([['department_id', $this->estimateData['dept_id']], ['dept_category_id', $this->estimateData['dept_category_id']], ['volume_no', $this->estimateData['volume']], ['table_no', $this->estimateData['table_no']]])
        //     ->select('id', 'page_no', 'corrigenda_name')->get();
        $cacheKey = 'page_no_' . $this->estimateData['dept_id'] . '_' . $this->estimateData['dept_category_id'] . '_' . $this->estimateData['volume'] . '_' . $this->estimateData['table_no'];
        $getCacheData = Cache::get($cacheKey);
        if ($getCacheData != '') {
            $this->fatchDropdownData['page_no'] = $getCacheData;
        } else {
            $this->fatchDropdownData['page_no'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                return DynamicSorHeader::where([['department_id', $this->estimateData['dept_id']], ['dept_category_id', $this->estimateData['dept_category_id']], ['volume_no', $this->estimateData['volume']], ['table_no', $this->estimateData['table_no']]])
                    ->select('id', 'page_no', 'corrigenda_name')->orderBy('page_no', 'asc')->orderBy('corrigenda_name', 'asc')->get();
            });
        }
        // }
    }

    public function getDynamicSor()
    {
        // dd($this->estimateData);
        $this->getSor = [];
        // if ($this->selectedCategoryId == '') {
        //     // $this->getSor = DynamicSorHeader::where([['department_id', $this->selectSor['dept_id']], ['dept_category_id', $this->selectSor['dept_category_id']], ['volume_no', $this->selectSor['volume']], ['table_no', $this->selectSor['table_no']], ['page_no', $this->selectSor['page_no']]])->first();
        //     $this->getSor = DynamicSorHeader::where('id', $this->selectSor['id'])->first();
        //     $this->estimateData['page_no'] = $this->selectSor['page_no'];
        //     $this->selectSor['sor_id'] = $this->getSor['id'];
        // } else {
        // $this->getSor = DynamicSorHeader::where([['department_id', $this->estimateData['dept_id']], ['dept_category_id', $this->estimateData['dept_category_id']], ['volume_no', $this->estimateData['volume']], ['table_no', $this->estimateData['table_no']], ['page_no', $this->estimateData['page_no']]])->first();
        // $this->getSor = DynamicSorHeader::where('id', $this->estimateData['id'])->first();
        $cacheKey = 'getSor_' . $this->estimateData['id'];
        $getCacheData = Cache::get($cacheKey);
        if ($getCacheData != '') {
            $this->getSor = $getCacheData;
        } else {
            $this->getSor = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                return DynamicSorHeader::where('id', $this->estimateData['id'])->first();
            });
        }
        $this->estimateData['sor_id'] = $this->getSor['id'];
        $this->estimateData['page_no'] = $this->getSor['page_no'];
        // }
        if ($this->getSor != null) {
            $this->viewModal = !$this->viewModal;
            $this->modalName = "dynamic-sor-modal_" . rand(1, 1000);
            $this->modalName = str_replace(' ', '_', $this->modalName);
        }
        // dd($this->isParent);
    }
    public function calculateValue()
    {
        if ($this->estimateData['qty'] != '' && $this->estimateData['rate'] != '') {
            if ($this->estimateData['item_name'] == 'SOR') {
                if (floatval($this->estimateData['qty']) >= 0 && floatval($this->estimateData['rate']) >= 0) {
                    $this->estimateData['qty'] = round($this->estimateData['qty'], 3);
                    $this->estimateData['rate'] = round($this->estimateData['rate'], 2);
                    $this->estimateData['total_amount'] = floatval($this->estimateData['qty']) * floatval($this->estimateData['rate']);
                    $this->estimateData['total_amount'] = round($this->estimateData['total_amount'], 2);
                }
            } else {
                if (floatval($this->estimateData['qty']) >= 0 && floatval($this->estimateData['rate']) >= 0) {
                    $this->estimateData['qty'] = round($this->estimateData['qty'], 3);
                    $this->estimateData['rate'] = round($this->estimateData['rate'], 2);
                    $this->estimateData['total_amount'] = floatval($this->estimateData['qty']) * floatval($this->estimateData['rate']);
                    $this->estimateData['total_amount'] = round($this->estimateData['total_amount'], 2);
                }
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
        // $this->fatchDropdownData['estimatesList'] = SorMaster::select('estimate_id', 'dept_id', 'sorMasterDesc', 'status', 'is_verified')->where([['dept_id', $this->estimateData['dept_id']], ['status', 8], ['is_verified', 1]])->get();
        $this->fatchDropdownData['estimatesList'] = SorMaster::select('estimate_id', 'dept_id', 'sorMasterDesc')->where([['dept_id', $this->estimateData['dept_id']]])->get();
    }
    public function getDeptRates()
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
        // $this->fatchDropdownData['ratesList'] = DB::select(DB::raw("SELECT rate_id, description FROM rates_analyses WHERE dept_id = :dept_id AND operation != '' AND operation != 'Exp Calculoation' GROUP BY rate_id, description"), ['dept_id' => $this->estimateData['dept_id']]);
        // $this->fatchDropdownData['ratesList'] = json_decode(json_encode($this->fatchDropdownData['ratesList']), true);
        $this->fatchDropdownData['ratesList'] = RatesAnalysis::where([['dept_id', $this->estimateData['dept_id']], ['operation', '!=', ''], ['operation', '!=', 'Exp Calculoation'], ['rate_no', 0]])->select('description', 'rate_id')->groupBy('description', 'rate_id')->get();
        // $this->fatchDropdownData['estimatesList'] = SorMaster::select('estimate_id','dept_id','sorMasterDesc','status','is_verified')->where([['dept_id',Auth::user()->department_id],['status',8],['is_verified',1]])->get();
    }

    public function getRateDetails()
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
        // $this->fatchDropdownData['rateDetails'] = RatesAnalysis::where([['rate_no', 0], ['rate_id', $this->estimateData['rate_no']], ['operation', $this->estimateData['rate_type']], ['dept_id', $this->estimateData['dept_id']]])->select('description', 'rate_id', 'qty', 'total_amount')->first();
        $cacheKey = 'rateNo_' . $this->estimateData['rate_no'];
        if (Cache::has($cacheKey)) {
            $this->fatchDropdownData['rateDetails'] = Cache::get($cacheKey);
        } else {
            $this->fatchDropdownData['rateDetails'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                return RatesAnalysis::where([['rate_no', 0], ['rate_id', $this->estimateData['rate_no']], ['operation', $this->estimateData['rate_type']], ['dept_id', $this->estimateData['dept_id']]])->select('description', 'rate_id', 'qty', 'total_amount')->first();
            });
        }
        $this->estimateData['total_amount'] = round($this->fatchDropdownData['rateDetails']['total_amount'], 2);
        $this->estimateData['description'] = $this->fatchDropdownData['rateDetails']['description'];
        $this->estimateData['qty'] = 1;
        $this->estimateData['rate'] = round($this->fatchDropdownData['rateDetails']['total_amount'], 2);
    }

    public function getEstimateDetails()
    {
        $this->estimateData['total_amount'] = '';
        $this->estimateData['description'] = '';
        $this->estimateData['qty'] = '';
        $this->estimateData['rate'] = '';
        // $this->fatchDropdownData['estimateDetails'] = Esrecommender::join('sor_masters', 'estimate_recomender.estimate_id', 'sor_masters.estimate_id')
        //     ->where('estimate_recomender.estimate_id', $this->estimateData['estimate_no'])
        //     ->where('estimate_recomender.operation', 'Total')->where('sor_masters.is_verified', '=', 1)->first();
        $this->fatchDropdownData['estimateDetails'] = EstimatePrepare::where('estimate_id', $this->estimateData['estimate_no'])
            ->where('operation', 'Total')->first();
        if ($this->fatchDropdownData['estimateDetails'] == '') {
            $this->fatchDropdownData['estimateDetails'] = [];
            $this->notification()->error(
                $title = 'No Estimate Found !!'
            );
        }
        $this->estimateData['total_amount'] = round($this->fatchDropdownData['estimateDetails']['total_amount'], 2);
        $this->estimateData['description'] = $this->fatchDropdownData['estimateDetails']['sorMasterDesc'];
        $this->estimateData['qty'] = 1;
        $this->estimateData['rate'] = $this->fatchDropdownData['estimateDetails']['total_amount'];
    }

    public function getRateDetailsTypes()
    {
        $this->estimateData['total_amount'] = '';
        $this->estimateData['description'] = '';
        $this->estimateData['qty'] = '';
        $this->estimateData['rate'] = '';
        $this->fatchDropdownData['rateDetailsTypes'] = RatesAnalysis::where([['rate_id', $this->estimateData['rate_no']], ['dept_id', $this->estimateData['dept_id']], ['operation', '!=', ''], ['operation', '!=', 'Exp Calculoation'], ['rate_no', 0]])->select('rate_id', 'operation')->get();
        // dd($this->fatchDropdownData['rateDetailsTypes']);
    }

    public function getRowValue($data)
    {
        // dd($data);
        $this->reset('counterForItemNo');
        $fetchRow[] = [];
        // $descriptions = [];
        // if ($this->selectedCategoryId == 5) {
        //     $id = explode('.', $data['id'])[0];
        //     foreach (json_decode($this->getSor['row_data']) as $d) {
        //         if ($d->id == $id && $d->desc_of_item != '') {
        //             $this->sorMasterDesc .= $d->desc_of_item;
        //         }
        //     }
        //     $this->getItemDetails1($data);
        // } else {
        $rowId = explode('.', $data[0]['id'])[0];
        foreach (json_decode($this->getSor['row_data']) as $row) {
            if ($row->id == $rowId) {
                $fetchRow = $row;
            }
        }
        // dd(json_encode($fetchRow));
        $selectedItemId = $data[0]['id'];
        $this->estimateData['item_index'] = $selectedItemId;
        // ---------explode the id------
        $hierarchicalArray = explode(".", $selectedItemId);
        $convertedArray = [];
        $partialItemId = "";
        foreach ($hierarchicalArray as $part) {
            if ($partialItemId !== "") {
                $partialItemId .= ".";
            }
            $partialItemId .= $part;
            $convertedArray[] = $partialItemId;
        }
        // dd($convertedArray);
        $this->extractItemNoOfItems($fetchRow, $itemNo, $convertedArray, $this->counterForItemNo);
        $loopCount = 1;
        $this->extractDescOfItems($fetchRow, $descriptions, $convertedArray,$loopCount);
        // if ($data != null && $this->selectedCategoryId != '' && $this->isParent == false) {
        // dd('hi');
        // $this->viewModal = !$this->viewModal;
        $this->estimateData['description'] = $descriptions . " " . $data[0]['desc'];
        $this->estimateData['qty'] = 1;
        $this->estimateData['rate'] = $data[0]['rowValue'];
        $this->estimateData['item_number'] = $itemNo;
        $this->estimateData['col_position'] = $data[0]['colPosition'];
        $this->estimateData['unit_id'] = $data[0]['unit'];
        $this->calculateValue();
        // } else {
        //     $this->selectSor['selectedSOR'] = $itemNo;
        //     $this->selectSor['sor_id'] = $this->getSor['id'];
        //     $this->selectSor['page_no'] = $this->getSor['page_no'];
        //     $this->selectSor['selectedItemId'] = $selectedItemId;
        //     $this->selectSor['item_index'] = $data[0]['id'];
        //     $this->selectSor['col_position'] = $data[0]['colPosition'];
        //     $this->sorMasterDesc = $data[0]['desc'];
        //     // $this->sorMasterDesc = $descriptions . " " . $data[0]['desc'];
        //     $this->viewModal = !$this->viewModal;
        //     $this->isParent = !$this->isParent;
        // }
        // }

        // dd($this->selectSor);
        // dd($this->estimateData);
    }

    public function extractItemNoOfItems($data, &$itemNo, $counter, $position)
    {
        $position++;
        $this->counterForItemNo = $position;
        if (count($counter) > 1) {
            if (isset($data->item_no) && $data->item_no != '') {
                $itemNo = $data->item_no . ' ';
            }
            if (isset($data->_subrow)) {
                foreach ($data->_subrow as $key => $item) {
                    if (isset($counter[$position])) {
                        if (isset($item->item_no) && $item->id == $counter[$position]) {
                            $itemNo .= $item->item_no . ' ';
                        }
                        if (isset($item->_subrow)) {
                            $this->extractItemNoOfItems($item->_subrow, $itemNo, $counter, $position);
                        }
                    }
                }
            } else {
                if (count($data) > 0) {
                    foreach ($data as $key => $item) {
                        if (isset($counter[$position]) && isset($item->_subrow)) {
                            if (isset($item->item_no) && $item->id == $counter[$position]) {
                                $itemNo .= $item->item_no . ' ';
                            }
                            if (isset($item->_subrow)) {
                                $this->extractItemNoOfItems($item->_subrow, $itemNo, $counter, $position);
                            }
                        } else {
                            if (isset($counter[$position])) {
                                if (isset($item->item_no) && $item->id == $counter[$position]) {
                                    $itemNo .= $item->item_no . ' ';
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $itemNo = $data->item_no;
        }
    }

    public function extractDescOfItems($data, &$descriptions, $counter,$loopCount)
    {
        // dd($counter);
        if (count($counter) > 1) {
            if (isset($data->desc_of_item) && $data->desc_of_item != '') {
                $descriptions .= $data->desc_of_item . ' ';
            }
            if (isset($data->_subrow)) {
                foreach ($data->_subrow as $item) {
                    if (isset($counter[$loopCount]) && isset($item->desc_of_item)) {
                        if ($counter[$loopCount] == $item->id) {
                            $descriptions .= $item->desc_of_item . ' ';
                            $loopCount++;
                        }
                        if (!empty($item->_subrow)) {
                            extractDescOfItems($item->_subrow, $descriptions, $counter, $loopCount);
                        }
                    }
                }
            }
        }

    }

    public function addEstimate()
    {
        // dd($this->estimateData);
        $this->validate();
        $this->part_no = strtoupper($this->part_no);
        $this->reset('addedEstimate');
        $this->showTableOne = !$this->showTableOne;
        $this->addedEstimate['estimate_no'] = ($this->estimateData['estimate_no'] == '' || $this->estimateData['estimate_no'] == null) ? 0 : $this->estimateData['estimate_no'];
        $this->addedEstimate['rate_no'] = ($this->estimateData['rate_no'] == '') ? 0 : $this->estimateData['rate_no'];
        $this->addedEstimate['dept_id'] = ($this->estimateData['dept_id'] == '') ? 0 : $this->estimateData['dept_id'];
        $this->addedEstimate['category_id'] = ($this->estimateData['dept_category_id'] == '') ? 0 : $this->estimateData['dept_category_id'];
        $this->addedEstimate['sor_item_number'] = ($this->estimateData['item_number'] == '') ? 0 : $this->estimateData['item_number'];
        $this->addedEstimate['item_name'] = $this->estimateData['item_name'];
        $this->addedEstimate['other_name'] = $this->estimateData['other_name'];
        $this->addedEstimate['description'] = $this->estimateData['description'];
        $this->addedEstimate['unit_id'] = is_numeric($this->estimateData['unit_id']) ? getUnitName($this->estimateData['unit_id']) : $this->estimateData['unit_id'];
        $this->addedEstimate['qty'] = ($this->estimateData['qty'] == '') ? 0 : $this->estimateData['qty'];
        $this->addedEstimate['rate'] = ($this->estimateData['rate'] == '') ? 0 : $this->estimateData['rate'];
        $this->addedEstimate['total_amount'] = $this->estimateData['total_amount'];
        $this->addedEstimate['version'] = $this->estimateData['version'];
        $this->addedEstimate['page_no'] = (isset($this->estimateData['page_no'])) ? $this->estimateData['page_no'] : 0;
        $this->addedEstimate['table_no'] = (isset($this->estimateData['table_no'])) ? $this->estimateData['table_no'] : 0;
        $this->addedEstimate['volume_no'] = (isset($this->estimateData['volume'])) ? $this->estimateData['volume'] : 0;
        $this->addedEstimate['sor_id'] = (isset($this->estimateData['id'])) ? $this->estimateData['id'] : 0;
        $this->addedEstimate['item_index'] = (isset($this->estimateData['item_index'])) ? $this->estimateData['item_index'] : '';
        $this->addedEstimate['col_position'] = (isset($this->estimateData['col_position'])) ? $this->estimateData['col_position'] : 0;
        $this->addedEstimate['rate_type'] = (isset($this->estimateData['rate_type'])) ? $this->estimateData['rate_type'] : '';
        $this->addedEstimateUpdateTrack = rand(1, 1000);
        $this->estimateData['item_number'] = '';
        $this->estimateData['estimate_no'] = '';
        $this->estimateData['rate_no'] = '';
        $this->estimateData['rate_type'] = '';
        $this->estimateData['description'] = '';
        $this->estimateData['other_name'] = '';
        $this->estimateData['qty'] = '';
        $this->estimateData['unit_id'] = '';
        if (isset($this->estimateData['id'])) {
            $this->estimateData['id'] = '';
        }
        $this->estimateData['rate'] = '';
        $this->estimateData['total_amount'] = '';
        if (isset($this->fatchDropdownData['rateDetailsTypes'])) {
            $this->fatchDropdownData['rateDetailsTypes'] = [];
        }
        // dd($this->addedEstimate);
        $this->resetExcept(['addedEstimate', 'showTableOne', 'addedEstimateUpdateTrack', 'sorMasterDesc', 'estimateData', 'fatchDropdownData', 'selectedCategoryId', 'part_no', 'editEstimate_id']);
    }

    public function closeModal()
    {
        $this->viewModal = !$this->viewModal;
        // if ($this->selectedCategoryId == '') {
        //     $this->selectSor['page_no'] = '';
        // } else {
        $this->estimateData['page_no'] = '';
        // }
    }

    public function render()
    {
        return view('livewire.estimate-project.create-estimate-project');
    }
}
