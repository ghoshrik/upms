<?php

namespace App\Http\Livewire\RateAnalysis;

use App\Models\Carriagesor;
use App\Models\CompositSor;
use App\Models\Department;
use App\Models\DynamicSorHeader;
use App\Models\EstimatePrepare;
use App\Models\RatesAnalysis;
use App\Models\RatesMaster;
use App\Models\SOR;
use App\Models\SorCategoryType;
use App\Models\SorMaster;
use App\Models\UnitMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use WireUi\Traits\Actions;

class CreateRateAnalysis extends Component
{
    use Actions;
    protected $listeners = ['getRowValue', 'closeModal', 'getComposite', 'getCompositePlaceWise', 'editRate'];
    public $rateData = [], $getCategory = [], $fatchDropdownData = [], $rateMasterDesc, $selectSor = [], $dropdownData = [], $part_no = '';
    public $kword = null, $selectedSORKey, $selectedCategoryId, $showTableOne = false, $addedRateUpdateTrack;
    public $addedRate = [];
    public $searchDtaCount, $searchStyle = 'none', $searchResData, $totalDistance;
    public $getSor, $viewModal = false, $modalName = '', $counterForItemNo = 0, $isParent = false, $editRate_id;
    public $searchKeyWord = '';
    // TODO:: remove $showTableOne if not use
    // TODO::pop up modal view estimate and project estimate
    // TODO::forward revert draft modify

    protected $rules = [
        'rateMasterDesc' => 'required|string',
        'part_no' => 'required',
        // 'selectedCategoryId' => 'required|integer',

    ];
    protected $messages = [
        'rateMasterDesc.required' => 'The description cannot be empty.',
        'rateMasterDesc.string' => 'The description format is not valid.',
        'part_no.required' => 'Only A to Z as input.',
        // 'selectedCategoryId.required' => 'Selected at least one ',
        // 'selectedCategoryId.integer' => 'This Selected field is Invalid',
        // 'rateData.other_name.required' => 'selected other name required',
        // 'rateData.other_name.string' => 'This field is must be character',
        // 'rateData.dept_id.required' => 'This field is required',
        // 'rateData.dept_id.integer' => 'This Selected field is invalid',
        // 'rateData.dept_category_id.required' => 'This field is required',
        // 'rateData.dept_category_id.integer' => 'This Selected field is invalid',
        // 'rateData.version.required' => 'This Selected field is required',
        // 'rateData.version.integer' => 'This Selected field is invalid',
        // 'selectedSORKey.required' => 'This field is required',
        // 'selectedSORKey.string' => 'This field is must be string',
        // 'rateData.qty.required' => 'This field is not empty',
        // 'rateData.qty.numeric' => 'This field is must be numeric',
        // 'rateData.rate.required' => 'This field is not empty',
        // 'rateData.rate.numeric' => 'This field is must be numeric',
        // 'rateData.total_amount.required' => 'This field is not empty',
        // 'rateData.total_amount.numeric' => 'This field is must be numeric',
        // 'rateData.rate_no.required' => 'This field is required',
        // 'rateData.rate_no.numeric' => 'This field is must be numeric',
        // 'rateData.estimate_desc.required' => 'This field is required',
        // 'rateData.estimate_desc.string' => 'Invalid format input',
    ];
    public function booted()
    {
        // if ($this->selectedCategoryId == 1) {
        //     $this->rules = Arr::collapse([$this->rules, [
        //         'rateData.dept_id' => 'required|integer',
        //         'rateData.dept_category_id' => 'required|integer',
        //         'rateData.version' => 'required',
        //         'selectedSORKey' => 'required|string',

        //     ]]);
        // }
        // if ($this->selectedCategoryId == 2) {
        //     $this->rules = Arr::collapse([$this->rules, [
        //         'rateData.other_name' => 'required|string',
        //     ]]);
        // }
        // if ($this->selectedCategoryId == 3) {
        //     $this->rules = Arr::collapse([$this->rules, [
        //         'rateData.dept_id' => 'required|integer',
        //         'rateData.rate_no' => 'required|integer',
        //         // 'rateData.estimate_desc' => 'required|string',
        //         'rateData.total_amount' => 'required|numeric',
        //     ]]);
        // }
        // if ($this->selectedCategoryId == 1 || $this->selectedCategoryId == 2) {
        //     $this->rules = Arr::collapse([$this->rules, [
        //         'rateData.qty' => 'required|numeric',
        //         'rateData.rate' => 'required|numeric',
        //         'rateData.total_amount' => 'required|numeric',

        //     ]]);
        // }
    }
    // public function updated($param)
    // {
    //     $this->validateOnly($param);
    // }
    public function mount()
    {
        $allDept = Cache::get('allDept');
        if ($allDept != '') {
            $this->dropdownData['allDept'] = $allDept;
        } else {
            $this->dropdownData['allDept'] = Cache::remember('allDept', now()->addMinutes(720), function () {
                return Department::select('id', 'department_name')->get();
            });
        }

        $this->dropdownData['page_no'] = [];
        $this->selectSor['dept_id'] = '';
        $this->selectSor['dept_category_id'] = '';
        $this->selectSor['version'] = '';
        $this->selectSor['selectedSOR'] = '';
        $this->selectSor['table_no'] = '';
        $this->selectSor['page_no'] = '';
        $this->selectSor['volume'] = '';
        $this->selectSor['sor_id'] = '';
        $this->selectSor['id'] = '';
        if (Session()->has('addedRateAnalysisData')) {
            if (Session()->has('rateDescription')) {
                $this->rateMasterDesc = Session()->get('rateDescription');
            }
            if (Session()->has('ratePartNo')) {
                $this->part_no = Session()->get('ratePartNo');
            }
            // $this->addedRateUpdateTrack = rand(1, 1000);
        }
        // dd(Session()->get('addedRateAnalysisData'));
        // $alphabetArray = range('A', 'Z');
        // $this->dropdownData['alphabets'] = $alphabetArray;
    }
    public function changeCategory($value)
    {
        $this->resetExcept(['addedRate', 'selectedCategoryId', 'addedRateUpdateTrack', 'rateMasterDesc', 'dropdownData', 'selectSor', 'part_no', 'editRate_id']);
        $this->part_no = strtoupper($this->part_no);
        $value = $value['_x_bindings']['value'];
        $this->rateData['item_name'] = $value;
        $allDept = Cache::get('allDept');
        $getAllUnit = Cache::get('getUnits');
        if ($getAllUnit != '') {
            $this->fatchDropdownData['units'] = $getAllUnit;
        } else {
            $this->fatchDropdownData['units'] = Cache::remember('getUnits', now()->addMinutes(720), function () {
                return UnitMaster::select('id', 'unit_name')->get();
            });
        }
        if ($this->selectedCategoryId == 1) {
            $this->fatchDropdownData['departments'] = [];
            if ($allDept != '') {
                $this->fatchDropdownData['departments'] = $allDept;
            } else {
                $this->fatchDropdownData['departments'] = Cache::remember('allDept', now()->addMinutes(720), function () {
                    return Department::select('id', 'department_name')->get();
                });
            }
            // $this->fatchDropdownData['table_no'] = DynamicSorHeader::select('table_no')->groupBy('table_no')->get();
            $this->fatchDropdownData['page_no'] = [];
            $this->rateData['rate_no'] = '';
            $this->rateData['dept_id'] = (Session::get('user_data')) ? Session::get('user_data.department_id') : '';
            if (!empty($this->rateData['dept_id'])) {
                $this->getDeptCategory();
            }
            $this->rateData['table_no'] = '';
            $this->rateData['page_no'] = '';
            $this->rateData['id'] = '';
            $this->rateData['dept_category_id'] = '';
            $this->rateData['version'] = '';
            $this->rateData['volume'] = '';
            $this->rateData['item_number'] = '';
            $this->rateData['description'] = '';
            $this->rateData['other_name'] = '';
            $this->rateData['qty'] = '';
            $this->rateData['rate'] = '';
            $this->rateData['total_amount'] = '';
            $this->rateData['distance'] = '';
            $this->rateData['unit_id'] = '';
        } elseif ($this->selectedCategoryId == 2) {
            $this->rateData['id'] = '';
            $this->rateData['rate_no'] = '';
            $this->rateData['dept_id'] = '';
            $this->rateData['dept_category_id'] = '';
            $this->rateData['version'] = '';
            $this->rateData['volume'] = '';
            $this->rateData['item_number'] = '';
            $this->rateData['description'] = '';
            $this->rateData['other_name'] = '';
            $this->rateData['qty'] = '';
            $this->rateData['rate'] = 0;
            $this->rateData['total_amount'] = '';
            $this->rateData['distance'] = '';
            $this->rateData['unit_id'] = '';
        } elseif ($this->selectedCategoryId == 3) {
            $this->fatchDropdownData['departments'] = '';
            if ($allDept != '') {
                $this->fatchDropdownData['departments'] = $allDept;
            } else {
                $this->fatchDropdownData['departments'] = Cache::remember('allDept', now()->addMinutes(720), function () {
                    return Department::select('id', 'department_name')->get();
                });
            }
            $this->rateData['dept_id'] = (Session::get('user_data')) ? Session::get('user_data.department_id') : '';
            if (!empty($this->rateData['dept_id'])) {
                $this->getDeptRates();
            }
            $this->rateData['id'] = '';
            $this->rateData['rate_no'] = '';
            // $this->rateData['estimate_desc'] = '';
            $this->rateData['dept_category_id'] = '';
            $this->rateData['version'] = '';
            $this->rateData['volume'] = '';
            $this->rateData['item_number'] = '';
            $this->rateData['description'] = '';
            $this->rateData['other_name'] = '';
            $this->rateData['qty'] = '';
            $this->rateData['rate'] = '';
            $this->rateData['total_amount'] = '';
            $this->rateData['distance'] = '';
            $this->rateData['rate_type'] = '';
            $this->rateData['unit_id'] = '';
            // $this->render();
        } elseif ($this->selectedCategoryId == 4) {
            $this->fatchDropdownData['departments'] = '';
            if ($allDept != '') {
                $this->fatchDropdownData['departments'] = $allDept;
            } else {
                $this->fatchDropdownData['departments'] = Cache::remember('allDept', now()->addMinutes(720), function () {
                    return Department::select('id', 'department_name')->get();
                });
            }
            $this->fatchDropdownData['page_no'] = [];
            $this->rateData['rate_no'] = '';
            $this->rateData['dept_id'] = (Session::get('user_data')) ? Session::get('user_data.department_id') : '';
            if (!empty($this->rateData['dept_id'])) {
                $this->getDeptCategory();
            }
            $this->rateData['table_no'] = '';
            $this->rateData['id'] = '';
            $this->rateData['dept_category_id'] = '';
            $this->rateData['version'] = '';
            $this->rateData['volume'] = '';
            $this->rateData['item_number'] = '';
            $this->rateData['description'] = '';
            $this->rateData['other_name'] = '';
            $this->rateData['qty'] = '';
            $this->rateData['rate'] = '';
            $this->rateData['total_amount'] = '';
            $this->rateData['distance'] = '';
            $this->rateData['childSorId'] = '';
            $this->rateData['unit_id'] = '';
        } else {
            $this->fatchDropdownData['departments'] = '';
            if ($allDept != '') {
                $this->fatchDropdownData['departments'] = $allDept;
            } else {
                $this->fatchDropdownData['departments'] = Cache::remember('allDept', now()->addMinutes(720), function () {
                    return Department::select('id', 'department_name')->get();
                });
            }
            // $sessionGetTableNo = Session::get('table_no');
            // if ($sessionGetTableNo != '') {
            //     $this->fatchDropdownData['table_no'] = $sessionGetTableNo;
            // } else {
            //     $this->fatchDropdownData['table_no'] = DynamicSorHeader::select('table_no')->groupBy('table_no')->get();
            //     Session::put('table_no', $this->fatchDropdownData['table_no']);
            // }
            $this->fatchDropdownData['page_no'] = [];
            $this->rateData['dept_id'] = (Session::get('user_data')) ? Session::get('user_data.department_id') : '';
            if (!empty($this->rateData['dept_id'])) {
                $this->getDeptCategory();
            }
            $this->rateData['table_no'] = '';
            $this->rateData['page_no'] = '';
            $this->rateData['rate_no'] = '';
            $this->rateData['dept_category_id'] = '';
            $this->rateData['version'] = '';
            $this->rateData['volume'] = '';
            $this->rateData['item_number'] = '';
            $this->rateData['description'] = '';
            $this->rateData['other_name'] = '';
            $this->rateData['qty'] = '';
            $this->rateData['rate'] = '';
            $this->rateData['total_amount'] = '';
            $this->rateData['distance'] = '';
            $this->rateData['unit_id'] = '';
        }
    }
    public function editRate($rate_id)
    {
        $this->editRate_id = $rate_id;
        $rate_desc = RatesMaster::where('rate_id', $this->editRate_id)->first();
        $this->rateMasterDesc = $rate_desc['rate_description'];
        $this->part_no = $rate_desc['part_no'];
        $fetchRates = RatesAnalysis::where('rate_id', $this->editRate_id)->orderBy('id', 'asc')->get();
        Session()->forget('editRateData' . $this->editRate_id);
        // Session()->forget('editRateDescription'. $this->editRate_id);
        // Session()->forget('editRatePartNo'. $this->editRate_id);
        $this->emit('setFetchRateData', $fetchRates);
        // $this->addedRateUpdateTrack = rand(1, 1000);
    }
    public function getDeptCategory()
    {
        $this->rateData['dept_category_id'] = '';
        $this->rateData['volume'] = '';
        $this->rateData['table_no'] = '';
        $this->rateData['id'] = '';
        $this->fatchDropdownData['volumes'] = [];
        $this->fatchDropdownData['table_no'] = [];
        $this->fatchDropdownData['page_no'] = [];
        $this->fatchDropdownData['departmentsCategory'] = [];
        $cacheKey = 'dept_cat' . '_' . $this->rateData['dept_id'];
        $cacheHasDeptCat = Cache::get($cacheKey);
        if ($cacheHasDeptCat != '') {
            $this->fatchDropdownData['departmentsCategory'] = $cacheHasDeptCat;
        } else {
            $this->fatchDropdownData['departmentsCategory'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                return SorCategoryType::select('id', 'dept_category_name')->where('department_id', '=', $this->rateData['dept_id'])->get();
            });
        }
    }
    public function getSorDeptCategory()
    {
        $this->dropdownData['sorDepartmentsCategory'] = [];
        $cacheKey = 'sorDept_cat' . '_' . $this->selectSor['dept_id'];
        $cacheHasDeptCat = Cache::get($cacheKey);
        if ($cacheHasDeptCat != '') {
            $this->dropdownData['sorDepartmentsCategory'] = $cacheHasDeptCat;
        } else {
            $this->dropdownData['sorDepartmentsCategory'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                return SorCategoryType::select('id', 'dept_category_name')->where('department_id', '=', $this->selectSor['dept_id'])->get();
            });
        }
        $this->selectSor['volume'] = '';
        $this->selectSor['table_no'] = '';
        $this->selectSor['page_no'] = '';
        $this->selectSor['sor_id'] = '';
        $this->selectSor['id'] = '';
        $this->selectSor['selectedSOR'] = '';
        $this->selectSor['item_index'] = '';
    }
    public function getVersion()
    {
        $this->fatchDropdownData['versions'] = SOR::select('version')->where('department_id', $this->rateData['dept_id'])
            ->where('dept_category_id', $this->rateData['dept_category_id'])->groupBy('version')
            ->get();
    }
    public function getSorVolumn()
    {
        $this->dropdownData['table_no'] = [];
        $this->dropdownData['page_no'] = [];
        $this->selectSor['volume'] = '';
        $this->selectSor['table_no'] = '';
        $this->selectSor['id'] = '';
        $this->selectSor['page_no'] = '';
        $this->selectSor['selectedSOR'] = '';
        $this->selectSor['item_index'] = '';
        $cacheKey = 'volume_' . $this->selectSor['dept_id'] . '_' . $this->selectSor['dept_category_id'];
        $getCacheData = Cache::get($cacheKey);
        if ($getCacheData != '') {
            $this->dropdownData['volumes'] = $getCacheData;
        } else {
            $this->dropdownData['volumes'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                return DynamicSorHeader::where([['department_id', $this->selectSor['dept_id']], ['dept_category_id', $this->selectSor['dept_category_id']]])->select('volume_no')->groupBy('volume_no')->get();
            });
        }
    }
    public function getSorTableNo()
    {
        $this->dropdownData['table_no'] = [];
        $this->selectSor['table_no'] = '';
        $this->selectSor['id'] = '';
        $this->selectSor['page_no'] = '';
        $this->selectSor['selectedSOR'] = '';
        $this->selectSor['item_index'] = '';
        $cacheKey = 'table_no_' . $this->selectSor['dept_id'] . '_' . $this->selectSor['dept_category_id'] . '_' . $this->selectSor['volume'];
        $getCacheData = Cache::get($cacheKey);
        if ($getCacheData != '') {
            $this->dropdownData['table_no'] = $getCacheData;
        } else {
            $this->dropdownData['table_no'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                return DynamicSorHeader::where([['department_id', $this->selectSor['dept_id']], ['dept_category_id', $this->selectSor['dept_category_id']], ['volume_no', $this->selectSor['volume']]])
                    ->select('table_no')->groupBy('table_no')->get();
            });
        }
    }
    public function getSorPageNo()
    {
        $this->viewModal = false;
        $this->selectSor['id'] = '';
        $this->selectSor['page_no'] = '';
        $this->selectSor['selectedSOR'] = '';
        $this->selectSor['item_index'] = '';
        $cacheKey = 'page_no_' . $this->selectSor['dept_id'] . '_' . $this->selectSor['dept_category_id'] . '_' . $this->selectSor['volume'] . '_' . $this->selectSor['table_no'];
        $getCacheData = Cache::get($cacheKey);
        if ($getCacheData != '') {
            $this->dropdownData['page_no'] = $getCacheData;
        } else {
            $this->dropdownData['page_no'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                return DynamicSorHeader::where([['department_id', $this->selectSor['dept_id']], ['dept_category_id', $this->selectSor['dept_category_id']], ['volume_no', $this->selectSor['volume']], ['table_no', $this->selectSor['table_no']]])
                    ->select('id', 'page_no', 'corrigenda_name')->orderBy('page_no', 'asc')->orderBy('corrigenda_name', 'asc')->get();
            });
        }
        // dd($this->dropdownData);
    }
    public function getSorDynamicSor()
    {
        // $this->isParent = !$this->isParent;
        $this->getSor = [];
        // $this->getSor = DynamicSorHeader::where([['department_id', $this->selectSor['dept_id']], ['dept_category_id', $this->selectSor['dept_category_id']], ['volume_no', $this->selectSor['volume']], ['table_no', $this->selectSor['table_no']], ['page_no', $this->selectSor['page_no']]])->first();
        $cacheKey = 'getSor_' . $this->selectSor['id'];
        $getCacheData = Cache::get($cacheKey);
        if ($getCacheData != '') {
            $this->getSor = $getCacheData;
        } else {
            $this->getSor = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                return DynamicSorHeader::where('id', $this->selectSor['id'])->first();
            });
        }
        if ($this->getSor != null) {
            $this->viewModal = !$this->viewModal;
            $this->isParent = !$this->isParent;
            $this->modalName = "dynamic-sor-modal_" . rand(1, 1000);
            $this->modalName = str_replace(' ', '_', $this->modalName);
        }
        // dd($this->viewModal,$this->isParent);
    }
    public function getVolumn()
    {
        // dd('hi');
        $this->fatchDropdownData['table_no'] = [];
        $this->fatchDropdownData['page_no'] = [];
        if ($this->selectedCategoryId == '') {
            $this->selectSor['volume'] = '';
            $this->selectSor['table_no'] = '';
            $this->selectSor['page_no'] = '';
            $cacheKey = 'volume_' . $this->selectSor['dept_id'] . '_' . $this->selectSor['dept_category_id'];
            $getCacheData = Cache::get($cacheKey);
            $this->dropdownData['volumes'] = [];
            if ($getCacheData != '') {
                $this->dropdownData['volumes'] = $getCacheData;
            } else {
                $this->dropdownData['volumes'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                    return DynamicSorHeader::where([['department_id', $this->selectSor['dept_id']], ['dept_category_id', $this->selectSor['dept_category_id']]])->select('volume_no')->groupBy('volume_no')->get();
                });
            }
        } else {
            // dd('hi');
            $this->rateData['volume'] = '';
            $this->rateData['table_no'] = '';
            $this->rateData['page_no'] = '';
            $cacheKey = 'volume_' . $this->rateData['dept_id'] . '_' . $this->rateData['dept_category_id'];
            $getCacheData = Cache::get($cacheKey);
            $this->fatchDropdownData['volumes'] = [];
            if ($getCacheData != '') {
                $this->fatchDropdownData['volumes'] = $getCacheData;
            } else {
                $this->fatchDropdownData['volumes'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                    return DynamicSorHeader::where([['department_id', $this->rateData['dept_id']], ['dept_category_id', $this->rateData['dept_category_id']]])->select('volume_no')->groupBy('volume_no')->get();
                });
            }
        }
    }
    public function getTableNo()
    {
        $this->fatchDropdownData['table_no'] = [];
        if ($this->selectedCategoryId == '') {
            $this->selectSor['table_no'] = '';
            $this->selectSor['page_no'] = '';
            $this->dropdownData['table_no'] = [];
            $cacheKey = 'table_no_' . $this->selectSor['dept_id'] . '_' . $this->selectSor['dept_category_id'] . '_' . $this->selectSor['volume'];
            $getCacheData = Cache::get($cacheKey);
            if ($getCacheData != '') {
                $this->dropdownData['table_no'] = $getCacheData;
            } else {
                $this->dropdownData['table_no'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                    return DynamicSorHeader::where([['department_id', $this->selectSor['dept_id']], ['dept_category_id', $this->selectSor['dept_category_id']], ['volume_no', $this->selectSor['volume']]])
                        ->select('table_no')->groupBy('table_no')->get();
                });
            }
        } else {
            $this->rateData['table_no'] = '';
            $this->rateData['page_no'] = '';
            $cacheKey = 'table_no_' . $this->rateData['dept_id'] . '_' . $this->rateData['dept_category_id'] . '_' . $this->rateData['volume'];
            $getCacheData = Cache::get($cacheKey);
            if ($getCacheData != '') {
                $this->fatchDropdownData['table_no'] = $getCacheData;
            } else {
                $this->fatchDropdownData['table_no'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                    return DynamicSorHeader::where([['department_id', $this->rateData['dept_id']], ['dept_category_id', $this->rateData['dept_category_id']], ['volume_no', $this->rateData['volume']]])
                        ->select('table_no')->groupBy('table_no')->get();
                });
            }
        }

    }
    public function getPageNo()
    {

        $this->viewModal = false;
        // if ($this->selectedCategoryId == '') {
        //     $this->selectSor['page_no'] = '';
        //     $this->dropdownData['page_no'] = DynamicSorHeader::where([['department_id', $this->selectSor['dept_id']], ['dept_category_id', $this->selectSor['dept_category_id']], ['volume_no', $this->selectSor['volume']], ['table_no', $this->selectSor['table_no']]])
        //         ->select('page_no')->get();
        // } else {
        $this->rateData['id'] = '';
        $cacheKey = 'page_no_' . $this->rateData['dept_id'] . '_' . $this->rateData['dept_category_id'] . '_' . $this->rateData['volume'] . '_' . $this->rateData['table_no'];
        $getCacheData = Cache::get($cacheKey);
        if ($getCacheData != '') {
            $this->fatchDropdownData['page_no'] = $getCacheData;
        } else {
            $this->fatchDropdownData['page_no'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                return DynamicSorHeader::where([['department_id', $this->rateData['dept_id']], ['dept_category_id', $this->rateData['dept_category_id']], ['volume_no', $this->rateData['volume']], ['table_no', $this->rateData['table_no']]])
                    ->select('id', 'page_no', 'corrigenda_name')->orderBy('page_no', 'asc')->orderBy('corrigenda_name', 'asc')->get();
            });
        }

        // }
    }
    public function getDynamicSor($id = '')
    {
        $this->getSor = [];
        if ($this->selectedCategoryId == '') {
            // $this->getSor = DynamicSorHeader::where([['department_id', $this->selectSor['dept_id']], ['dept_category_id', $this->selectSor['dept_category_id']], ['volume_no', $this->selectSor['volume']], ['table_no', $this->selectSor['table_no']], ['page_no', $this->selectSor['page_no']]])->first();
            $cacheKey = 'getSor_' . $this->selectSor['id'];
            $getCacheData = Cache::get($cacheKey);
            if ($getCacheData != '') {
                $this->getSor = $getCacheData;
            } else {
                $this->getSor = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                    return DynamicSorHeader::where('id', $this->selectSor['id'])->first();
                });
            }
            $this->rateData['page_no'] = $this->selectSor['page_no'];
            $this->selectSor['sor_id'] = $this->getSor['id'];
        } else {
            // $this->getSor = DynamicSorHeader::where([['department_id', $this->rateData['dept_id']], ['dept_category_id', $this->rateData['dept_category_id']], ['volume_no', $this->rateData['volume']], ['table_no', $this->rateData['table_no']], ['page_no', $this->rateData['page_no']]])->first();
            $cacheKey = 'getSor_' . (($id != '') ? $id : $this->rateData['id']);
            $getCacheData = Cache::get($cacheKey);
            if ($getCacheData != '') {
                $this->getSor = $getCacheData;
            } else {
                $this->getSor = Cache::remember($cacheKey, now()->addMinutes(720), function () use ($id) {
                    return DynamicSorHeader::where('id', ($id != '') ? $id : $this->rateData['id'])->first();
                });
            }
            $this->rateData['sor_id'] = $this->getSor['id'];
            $this->rateData['page_no'] = $this->getSor['page_no'];
            if ($this->searchKeyWord != '') {
                $this->rateData['volume'] = $this->getSor['volume'];
                $this->rateData['table_no'] = $this->getSor['table_no'];
            }
        }
        if ($this->getSor != null) {
            $this->viewModal = !$this->viewModal;
            $this->modalName = "dynamic-sor-modal_" . rand(1, 1000);
            $this->modalName = str_replace(' ', '_', $this->modalName);
        }
        // dd($this->isParent);
    }
    public function getRowValue($data)
    {
        // dd($data);
        // dd($this->rateData);
        // dd($this->isParent);
        $this->reset('counterForItemNo');
        $fetchRow[] = [];
        // $descriptions = [];
        if ($this->selectedCategoryId == 5) {
            $id = explode('.', $data['id'])[0];
            foreach (json_decode($this->getSor['row_data']) as $d) {
                if ($d->id == $id && $d->desc_of_item != '') {
                    $this->rateMasterDesc .= $d->desc_of_item;
                }
            }
            $this->getItemDetails1($data);
        } else {
            $rowId = explode('.', $data[0]['id'])[0];
            foreach (json_decode($this->getSor['row_data']) as $row) {
                if ($row->id == $rowId) {
                    $fetchRow = $row;
                }
            }
            // dd(json_encode($fetchRow));
            $selectedItemId = $data[0]['id'];
            $this->rateData['item_index'] = $selectedItemId;
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
            $this->extractDescOfItems($fetchRow, $descriptions, $convertedArray);
            if ($data != null && $this->selectedCategoryId != '' && $this->isParent == false) {
                // dd('hi');
                $this->viewModal = !$this->viewModal;
                $this->rateData['description'] = $descriptions . " " . $data[0]['desc'];
                $this->rateData['qty'] = 1;
                $this->rateData['rate'] = $data[0]['rowValue'];
                $this->rateData['item_number'] = $itemNo;
                $this->rateData['col_position'] = $data[0]['colPosition'];
                $this->rateData['unit_id'] = $data[0]['unit'];
                $this->calculateValue();
            } else {
                $this->selectSor['selectedSOR'] = $itemNo;
                $this->selectSor['sor_id'] = $this->getSor['id'];
                $this->selectSor['page_no'] = $this->getSor['page_no'];
                $this->selectSor['selectedItemId'] = $selectedItemId;
                $this->selectSor['item_index'] = $data[0]['id'];
                $this->selectSor['col_position'] = $data[0]['colPosition'];
                $this->rateMasterDesc = $data[0]['desc'];
                // $this->rateMasterDesc = $descriptions . " " . $data[0]['desc'];
                $this->viewModal = !$this->viewModal;
                $this->isParent = !$this->isParent;
            }
        }
        if ($this->searchKeyWord != '') {
            // $this->reset('searchKeyWord');
            $this->fatchDropdownData['searchDetails'] = [];
            $this->searchStyle = 'none';
            // $this->clearSearch();
        }

        // dd($this->selectSor);
        // dd($this->rateData);
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

    public function extractDescOfItems($data, &$descriptions, $counter)
    {
        if (count($counter) > 1) {
            if (isset($data->desc_of_item) && $data->desc_of_item != '') {
                $descriptions .= $data->desc_of_item . " ";
            }
            if (isset($data->_subrow) && count($counter) > 2) {
                foreach ($data->_subrow as $item) {
                    if (isset($item->_subrow)) {
                        if (isset($item->desc_of_item)) {
                            $descriptions .= $item->desc_of_item . ' ';
                        }
                        if (!empty($item->_subrow)) {
                            $this->extractDescOfItems($item->_subrow, $descriptions, $counter);
                        }
                    }
                }
            }
        }

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
    public function textSearchSOR()
    {
        $this->fatchDropdownData['searchDetails'] = [];
        if (isset($this->rateData['dept_id']) && $this->rateData['dept_id'] != '') {
            if (isset($this->rateData['dept_category_id']) && $this->rateData['dept_category_id'] != '') {
                $this->fatchDropdownData['searchDetails'] = DynamicSorHeader::where([['department_id', $this->rateData['dept_id']], ['dept_category_id', $this->rateData['dept_category_id']]])
                    ->whereRaw("to_tsvector('english', row_data) @@ plainto_tsquery('english', ?)", [$this->searchKeyWord])
                    ->selectRaw("id,page_no,table_no, ts_headline('english', row_data::text, plainto_tsquery('english', ?)) AS highlighted_row_data", [$this->searchKeyWord])
                    ->get();
                if (count($this->fatchDropdownData['searchDetails']) > 0) {
                    $this->searchDtaCount = (count($this->fatchDropdownData['searchDetails']) > 0);
                    $this->searchStyle = 'block';
                } else {
                    $this->searchStyle = 'none';
                    $this->notification()->error(
                        $title = 'Not data found !!' . $this->searchKeyWord
                    );
                }
            } else {
                $this->notification()->error(
                    $title = 'Select Department Category'
                );
            }
        } else {
            $this->notification()->error(
                $title = 'Select Department First'
            );
        }
        // $this->fatchDropdownData['searchDetails'] = DynamicSorHeader::where('department_id', $this->rateData['dept_id'])
        //     ->whereRaw("to_tsvector('english', row_data::text || ' ' || table_no) @@ plainto_tsquery('english', ?)", [$this->searchKeyWord])
        //     ->selectRaw("id,page_no,table_no, ts_headline('english', row_data::text || ' ' || table_no, plainto_tsquery('english', ?)) AS highlighted_row_data", [$this->searchKeyWord])
        //     ->get();
        // $this->searchStyle = 'block';

    }

    public function clearSearch()
    {
        $this->reset('searchKeyWord');
        $this->rateData['sor_id'] = '';
        $this->rateData['page_no'] = '';
        $this->rateData['table_no'] = '';
        $this->rateData['volume'] = '';
        $this->rateData['description'] = '';
        $this->rateData['qty'] = '';
        $this->rateData['rate'] = '';
        $this->rateData['total_amount'] = '';
        $this->rateData['unit_id'] = '';
        $this->searchStyle = 'none';
    }

    public function getSorItemDetails($id)
    {
        $this->searchResData = SOR::where('id', $id)->get();
        $this->searchDtaCount = count($this->searchResData) > 0;
        $this->searchStyle = 'none';
        if (count($this->searchResData) > 0) {
            foreach ($this->searchResData as $list) {
                // $this->selectSor['description'] = $list['description'];
                $this->rateMasterDesc = $list['description'];
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
        // $this->fatchDropdownData['items_number'] = SOR::where('department_id', $this->rateData['dept_id'])
        //     ->where('dept_category_id', $this->rateData['dept_category_id'])
        //     ->where('version', $this->rateData['version'])
        //     ->where('Item_details', 'like', '%' . $keyword . '%')->get();
        if ($this->selectedSORKey) {
            $this->fatchDropdownData['items_number'] = SOR::select('Item_details', 'id', 'description')
                ->where('department_id', $this->rateData['dept_id'])
                ->where('dept_category_id', $this->rateData['dept_category_id'])
                ->where('version', $this->rateData['version'])
                ->where('Item_details', 'like', $this->selectedSORKey . '%')
                ->where('is_approved', 1)
                ->get();

            // dd($this->fatchDropdownData['items_number']);
            if (count($this->fatchDropdownData['items_number']) > 0) {
                $this->searchDtaCount = (count($this->fatchDropdownData['items_number']) > 0);
                $this->searchStyle = 'block';
            } else {
                $this->rateData['description'] = '';
                $this->rateData['qty'] = '';
                $this->rateData['rate'] = '';
                $this->searchStyle = 'none';
                $this->notification()->error(
                    $title = 'Not data found !!' . $this->selectedSORKey
                );
            }
        } else {
            $this->rateData['description'] = '';
            $this->rateData['qty'] = '';
            $this->rateData['rate'] = '';
            $this->searchStyle = 'none';
            $this->notification()->error(
                $title = 'Not found !!' . $this->selectedSORKey
            );
        }
    }

    public function getItemDetails($id)
    {
        // $this->rateData['description'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['description'];
        // $this->rateData['qty'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['unit'];
        // $this->rateData['rate'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['cost'];
        // $this->rateData['item_number'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['id'];
        // $this->calculateValue();

        $this->searchResData = SOR::where('id', $id)->get();
        // dd($this->searchResData);
        $this->searchDtaCount = count($this->searchResData) > 0;
        $this->searchStyle = 'none';
        if (count($this->searchResData) > 0) {
            foreach ($this->searchResData as $list) {
                $this->rateData['description'] = $list['description'];
                $this->rateData['qty'] = $list['unit'];
                $this->rateData['rate'] = $list['cost'];
                $this->rateData['item_number'] = $list['id'];
                $this->selectedSORKey = $list['Item_details'];
            }
            $this->calculateValue();
        } else {
            $this->rateData['description'] = '';
            $this->rateData['qty'] = '';
            $this->rateData['rate'] = '';
        }
    }
    public $distance;
    // public function getItemDetails1($id)
    public function getItemDetails1($getData)
    {
        // dd($id);
        $this->distance = $this->rateData['distance'];
        // $this->rateData['description'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['description'];
        // $this->rateData['qty'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['unit'];
        // $this->rateData['rate'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['cost'];
        // $this->rateData['item_number'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['id'];
        // $this->calculateValue();

        // $this->searchResData = SOR::select('Item_details', 'id', 'description', 'cost')->where('Item_details', 'like', $id . '%')->get();
        // dd($this->searchResData);
        // foreach ($this->searchResData as $key => $data) {
        //     if ($key == 0 && $this->rateData['distance'] != 0) {
        //         if ($this->rateData['distance'] >= 5) {
        //             $this->rateData['qty'] = 5;
        //         } else {
        //             $this->rateData['qty'] = $this->rateData['distance'];
        //         }
        //         $this->rateData['item_number'] = $data['id'];
        //         $this->rateData['description'] = $data['description'];
        //         $this->rateData['rate'] = $data['cost'];
        //         $this->rateData['total_amount'] = $data['cost'];
        //         $this->rateData['distance'] = $this->rateData['distance'] - $this->rateData['qty'];
        //         $this->addRate($key + 1);
        //     } elseif ($key == 1 && $this->rateData['distance'] != 0) {
        //         if ($this->rateData['distance'] >= 5) {
        //             $this->rateData['qty'] = 5;
        //         } else {
        //             $this->rateData['qty'] = $this->rateData['distance'];
        //         }
        //         $this->rateData['item_number'] = $data['id'];
        //         $this->rateData['description'] = $data['description'];
        //         $this->rateData['rate'] = $data['cost'];
        //         $this->rateData['total_amount'] = $data['cost'] * $this->rateData['qty'];
        //         $this->rateData['distance'] = $this->rateData['distance'] - $this->rateData['qty'];
        //         $this->addRate($key + 1);
        //     } elseif ($key == 2 && $this->rateData['distance'] != 0) {
        //         if ($this->rateData['distance'] >= 10) {
        //             $this->rateData['qty'] = 10;
        //         } else {
        //             $this->rateData['qty'] = $this->rateData['distance'];
        //         }
        //         $this->rateData['item_number'] = $data['id'];
        //         $this->rateData['description'] = $data['description'];
        //         $this->rateData['rate'] = $data['cost'];
        //         $this->rateData['total_amount'] = $data['cost'] * $this->rateData['qty'];
        //         $this->rateData['distance'] = $this->rateData['distance'] - $this->rateData['qty'];
        //         $this->addRate($key + 1);
        //     } elseif ($key == 3 && $this->rateData['distance'] != 0) {
        //         if ($this->rateData['distance'] >= 30) {
        //             $this->rateData['qty'] = 30;
        //         } else {
        //             $this->rateData['qty'] = $this->rateData['distance'];
        //         }
        //         $this->rateData['item_number'] = $data['id'];
        //         $this->rateData['description'] = $data['description'];
        //         $this->rateData['rate'] = $data['cost'];
        //         $this->rateData['total_amount'] = $data['cost'] * $this->rateData['qty'];
        //         $this->rateData['distance'] = $this->rateData['distance'] - $this->rateData['qty'];
        //         $this->addRate($key + 1);
        //     } elseif ($key == 4 && $this->rateData['distance'] != 0) {
        //         if ($this->rateData['distance'] >= 50) {
        //             $this->rateData['qty'] = 50;
        //         } else {
        //             $this->rateData['qty'] = $this->rateData['distance'];
        //         }
        //         $this->rateData['item_number'] = $data['id'];
        //         $this->rateData['description'] = $data['description'];
        //         $this->rateData['rate'] = $data['cost'];
        //         $this->rateData['total_amount'] = $data['cost'] * $this->rateData['qty'];
        //         $this->rateData['distance'] = $this->rateData['distance'] - $this->rateData['qty'];
        //         $this->addRate($key + 1);
        //     } elseif ($key == 5 && $this->rateData['distance'] != 0) {
        //         $this->rateData['item_number'] = $data['id'];
        //         $this->rateData['description'] = $data['description'];
        //         $this->rateData['qty'] = $this->rateData['distance'];
        //         $this->rateData['rate'] = $data['cost'];
        //         $this->rateData['total_amount'] = $data['cost'] * $this->rateData['qty'];
        //         $this->addRate($key + 1);
        //     } else {
        //         return;
        //     }
        // }
        // dd($this->rateData);
        // $this->searchDtaCount = count($this->searchResData) > 0;
        // $this->searchStyle = 'none';
        // if (count($this->searchResData) > 0) {
        //     foreach ($this->searchResData as $list) {
        //         $this->rateData['description'] = $list['description'];
        //         $this->rateData['qty'] = $list['unit'];
        //         $this->rateData['rate'] = $list['cost'];
        //         $this->rateData['item_number'] = $list['id'];
        //         $this->selectedSORKey = $list['Item_details'];
        //     }
        //     $this->calculateValue();
        // } else {
        //     $this->rateData['description'] = '';
        //     $this->rateData['qty'] = '';
        //     $this->rateData['rate'] = '';
        // }
        $this->reset('addedRate');
        $array = [];
        $arrCount = 0;
        // dd($getData);
        if (isset($getData['upTo_5'])) {
            if (isset($getData['upTo_10'])) {
                if ($getData['upTo_5'] == $getData['upTo_10']) {
                    $array[$arrCount]['upTo_10'] = $getData['upTo_10'];
                    // unset($array[$arrCount]['upTo_5']);
                } else {
                    $array[$arrCount++]['upTo_5'] = $getData['upTo_5'];
                }
            } else {
                $array[$arrCount++]['upTo_5'] = $getData['upTo_5'];
            }
        }
        if (isset($getData['upTo_10'])) {
            if (isset($getData['upTo_20'])) {
                if ($getData['upTo_10'] == $getData['upTo_20']) {
                    unset($array[$arrCount]);
                    $array[$arrCount]['upTo_20'] = $getData['upTo_20'];
                } else {
                    $array[$arrCount++]['upTo_10'] = $getData['upTo_10'];
                }
            } else {
                $array[$arrCount++]['upTo_10'] = $getData['upTo_10'];
            }
        }
        if (isset($getData['upTo_16'])) {
            $array[$arrCount++]['upTo_16'] = $getData['upTo_16'];
        }
        if (isset($getData['above_16'])) {
            $array[$arrCount++]['above_16'] = $getData['above_16'];
        }
        if (isset($getData['upTo_20'])) {
            if (isset($getData['upTo_50'])) {
                if ($getData['upTo_20'] == $getData['upTo_50']) {
                    unset($array[$arrCount]);
                    $array[$arrCount]['upTo_50'] = $getData['upTo_50'];
                } else {
                    $array[$arrCount++]['upTo_20'] = $getData['upTo_20'];
                }
            } else {
                $array[$arrCount++]['upTo_20'] = $getData['upTo_20'];
            }
        }
        if (isset($getData['upTo_50'])) {
            if (isset($getData['upTo_100'])) {
                if ($getData['upTo_50'] == $getData['upTo_100']) {
                    unset($array[$arrCount]);
                    $array[$arrCount]['upTo_100'] = $getData['upTo_100'];
                    $array[$arrCount]['distance'] = 100;
                } else {
                    $array[$arrCount++]['upTo_50'] = $getData['upTo_50'];
                }
            } else {
                $array[$arrCount++]['upTo_50'] = $getData['upTo_50'];
            }
        }
        if (isset($getData['upTo_100'])) {
            if (isset($getData['above_100'])) {
                if ($getData['upTo_100'] == $getData['above_100']) {
                    unset($array[$arrCount]);
                    $array[$arrCount]['above_100'] = $getData['above_100'];
                } else {
                    $array[$arrCount++]['upTo_100'] = $getData['upTo_100'];
                }
            } else {
                $array[$arrCount++]['upTo_100'] = $getData['upTo_100'];
            }
        }
        if (isset($getData['above_100'])) {
            $array[$arrCount++]['above_100'] = $getData['above_100'];
        }
        // dd($array);
        // Log::debug(json_encode($array));
        foreach ($array as $key => $data) {
            // dd($data);
            // Log::debug(json_encode($this->rateData));
            if (isset($data['upTo_5']) && $this->rateData['distance'] != 0) {
                if ($this->rateData['distance'] >= 5) {
                    $this->rateData['qty'] = 1;
                } else {
                    $this->rateData['qty'] = $this->rateData['distance'];
                }
                $this->rateData['item_number'] = $getData['id'] . ' ( Zone ' . $getData['zone'] . ')';
                $this->rateData['description'] = "Any Distance up to 5 km";
                $this->rateData['rate'] = $data['upTo_5'];
                $this->rateData['total_amount'] = (int) $data['upTo_5'];
                $this->rateData['distance'] = $this->rateData['distance'] - 5;
                // Log::debug(json_encode($this->rateData));
                $this->addRate($key + 1);
                // dd($this->rateData);
            } elseif (isset($data['upTo_10']) && $this->rateData['distance'] != 0) {
                if ($this->rateData['distance'] >= 5) {
                    $this->rateData['qty'] = 5;
                } else {
                    $this->rateData['qty'] = $this->rateData['distance'];
                }
                $this->rateData['item_number'] = $getData['id'] . ' ( Zone ' . $getData['zone'] . ')';
                $this->rateData['description'] = "Above 5 km up to 10 km (per km)";
                $this->rateData['rate'] = $data['upTo_10'];
                $this->rateData['total_amount'] = $data['upTo_10'] * $this->rateData['qty'];
                $this->rateData['distance'] = $this->rateData['distance'] - $this->rateData['qty'];
                $this->addRate($key + 1);
            } elseif (isset($data['upTo_16']) && $this->rateData['distance'] != 0) {
                if ($this->rateData['distance'] >= 11) {
                    $this->rateData['qty'] = 11;
                } else {
                    $this->rateData['qty'] = $this->rateData['distance'];
                }
                $this->rateData['item_number'] = $getData['id'] . ' ( Zone ' . $getData['zone'] . ')';
                $this->rateData['description'] = "Above 5 km up to 16 km (per km)";
                $this->rateData['rate'] = $data['upTo_16'];
                $this->rateData['total_amount'] = $data['upTo_16'] * $this->rateData['qty'];
                $this->rateData['distance'] = $this->rateData['distance'] - $this->rateData['qty'];
                $this->addRate($key + 1);
            } elseif (isset($data['above_16']) && $this->rateData['distance'] != 0) {
                $this->rateData['item_number'] = $getData['id'] . ' ( Zone ' . $getData['zone'] . ')';
                $this->rateData['description'] = "Above 16 km (per km)";
                $this->rateData['qty'] = $this->rateData['distance'];
                $this->rateData['rate'] = $data['above_16'];
                $this->rateData['total_amount'] = $data['above_16'] * $this->rateData['qty'];
                $this->addRate($key + 1);
            } elseif (isset($data['upTo_20']) && $this->rateData['distance'] != 0) {
                if ($this->rateData['distance'] >= 10) {
                    $this->rateData['qty'] = 10;
                } else {
                    $this->rateData['qty'] = $this->rateData['distance'];
                }
                $this->rateData['item_number'] = $getData['id'] . ' ( Zone ' . $getData['zone'] . ')';
                $this->rateData['description'] = "Above 10 km up to 20 km (per km)";
                $this->rateData['rate'] = $data['upTo_20'];
                $this->rateData['total_amount'] = $data['upTo_20'] * $this->rateData['qty'];
                $this->rateData['distance'] = $this->rateData['distance'] - $this->rateData['qty'];
                $this->addRate($key + 1);
            } elseif (isset($data['upTo_50']) && $this->rateData['distance'] != 0) {
                if ($this->rateData['distance'] >= 30) {
                    $this->rateData['qty'] = 30;
                } else {
                    $this->rateData['qty'] = $this->rateData['distance'];
                }
                $this->rateData['item_number'] = $getData['id'] . ' ( Zone ' . $getData['zone'] . ')';
                $this->rateData['description'] = "Above 20 km up to 50 km (per km)";
                $this->rateData['rate'] = $data['upTo_50'];
                $this->rateData['total_amount'] = $data['upTo_50'] * $this->rateData['qty'];
                $this->rateData['distance'] = $this->rateData['distance'] - $this->rateData['qty'];
                $this->addRate($key + 1);
            } elseif (isset($data['upTo_100']) && $this->rateData['distance'] != 0) {
                if ($this->rateData['distance'] >= 50) {
                    if (isset($data['distance'])) {
                        $this->rateData['qty'] = ($this->rateData['distance'] > $data['distance']) ? $data['distance'] : $this->rateData['distance'];
                        $this->rateData['total_amount'] = $data['upTo_100'];
                    } else {
                        $this->rateData['qty'] = 50;
                    }
                } else {
                    $this->rateData['qty'] = $this->rateData['distance'];
                }
                $this->rateData['item_number'] = $getData['id'] . ' ( Zone ' . $getData['zone'] . ')';
                $this->rateData['description'] = (isset($data['distance'])) ? "Any to 100 km" : "Above 50 km up to 100 km (per km)";
                $this->rateData['rate'] = $data['upTo_100'];
                if (count($array) == 2) {
                    $this->rateData['total_amount'] = $data['upTo_100'];
                } else {
                    $this->rateData['total_amount'] = $data['upTo_100'] * $this->rateData['qty'];
                }
                $tempDistance = $this->rateData['distance'] - $this->rateData['qty'];
                $this->rateData['distance'] = ($tempDistance > 0) ? $tempDistance : 0;
                $this->addRate($key + 1);
            } elseif (isset($data['above_100']) && $this->rateData['distance'] != 0) {
                $this->rateData['item_number'] = $getData['id'] . ' ( Zone ' . $getData['zone'] . ')';
                $this->rateData['description'] = "Above 100 km (per km)";
                $this->rateData['qty'] = $this->rateData['distance'];
                $this->rateData['rate'] = $data['above_100'];
                $this->rateData['total_amount'] = $data['above_100'] * $this->rateData['qty'];
                $this->addRate($key + 1);
            } else {
                return;
            }
        }
        // $array = [];
        // dd($this->rateData);
    }
    public $getCompositeDatas = [], $fetchChildSor = false;
    public function getComposite($data)
    {
        // dd($data);
        $this->reset('addedRate');
        $compositeCacheKey = 'composite_sor_' . $data[0]['parentId'] . '_' . $data[0]['item_index'];
        $getCompositeCacheData = Cache::get($compositeCacheKey);
        if ($getCompositeCacheData != '') {
            $this->getCompositeDatas = $getCompositeCacheData;
        } else {
            // $this->getCompositeDatas = CompositSor::where([['sor_itemno_parent_id', $data[0]['parentId']], ['sor_itemno_parent_index', $data[0]['item_index']]])->get();
            $this->getCompositeDatas = Cache::remember($compositeCacheKey, now()->addMinutes(720), function () use ($data) {
                return CompositSor::where([['sor_itemno_parent_id', $data[0]['parentId']], ['sor_itemno_parent_index', $data[0]['item_index']]])->get();
            });
        }
        if (count($this->getCompositeDatas) > 0) {
            $this->modalName = '';
            $this->viewModal = !$this->viewModal;
            // $this->fetchChildSor = !$this->fetchChildSor;
            $cacheKey = 'getSor_' . $this->getCompositeDatas[0]['sor_itemno_child_id'];
            $getCacheData = Cache::get($cacheKey);
            if ($getCacheData != '') {
                $this->getSor = $getCacheData;
            } else {
                $this->getSor = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                    return DynamicSorHeader::where('id', $this->getCompositeDatas[0]['sor_itemno_child_id'])->first();
                });
            }

            // $rdata = [];
            // foreach(json_decode($this->getSor['row_data']) as $json){
            //     // dd($json);
            //     foreach($this->getCompositeDatas as $comp){
            //         // dd($comp);
            //         if($json->id == $comp['sor_itemno_child']){
            //             $rdata[] = $json;
            //         }
            //     }
            // }
            // $this->getSor['row_data'] = json_encode($rdata);
            // dd($this->getSor['row_data']);
            // dd(json_encode($rdata));
            // dd(json_decode($this->getSor['row_data']));
            // dd($this->getSor);
            foreach ($this->getCompositeDatas as $key => $compositeData) {
                $this->rateData['rate_no'] = '';
                $this->rateData['dept_id'] = '';
                $this->rateData['dept_category_id'] = $compositeData['dept_category_id'];
                $this->rateData['item_number'] = $compositeData['sor_itemno_child'];
                $this->rateData['sor_itemno_child_id'] = $compositeData['sor_itemno_child_id'];
                $this->rateData['description'] = $compositeData['description'];
                $this->rateData['version'] = '';
                $this->rateData['other_name'] = '';
                $this->rateData['qty'] = $compositeData['rate'];
                if ($compositeData['is_row'] == 2) {
                    $this->rateData['rate_type'] = 'other';
                } else {
                    $this->rateData['rate_type'] = 'fetch';
                }
                $this->rateData['rate'] = 0;
                $this->rateData['total_amount'] = 0;
                $this->rateData['is_row'] = $compositeData['is_row'];
                $this->rateData['unit_id'] = getunitName($compositeData['unit_id']);
                // dd($this->rateData);
                $this->addRate($key + 1);
            }
        } else {
            $this->modalName = '';
            $this->viewModal = !$this->viewModal;
            $this->rateData['id'] = '';
            $this->notification()->error(
                $title = 'No Composite Sor Found'
            );
        }
        // foreach ($getCompositeDatas as $key => $compositeData) {
        //     $getRateDetails = RatesAnalysis::where([['item_index', $compositeData['sor_itemno_child']], ['sor_id', $compositeData['sor_itemno_child_id']], ['operation', '=', 'Total']])->first();
        //     if (!empty($getRateDetails)) {
        //         $this->rateData['rate_no'] = '';
        //         $this->rateData['dept_id'] = '';
        //         $this->rateData['dept_category_id'] = $compositeData['dept_category_id'];
        //         $this->rateData['item_number'] = $compositeData['sor_itemno_child'];
        //         $this->rateData['description'] = $compositeData['description'];
        //         $this->rateData['version'] = '';
        //         $this->rateData['other_name'] = '';
        //         $this->rateData['qty'] = $compositeData['rate'];
        //         $this->rateData['rate'] = $getRateDetails->total_amount;
        //         $this->rateData['total_amount'] = $getRateDetails->total_amount * $compositeData['rate'];
        //         $this->addRate($key + 1);
        //     }
        // dd();
        // }
        // dd($getRateDetails);
    }
    public function getPlaceWiseComposite()
    {
        $this->viewModal = !$this->viewModal;
        $this->modalName = "child-sor-modal_" . rand(1, 1000);
        $this->modalName = str_replace(' ', '_', $this->modalName);
        // dd($this->getCompositeDatas[0]['sor_itemno_child_id'],$this->rateData);
        $this->getSor = DynamicSorHeader::where('id', (int) $this->rateData['childSorId'])->first();
        $rdata = [];
        foreach (json_decode($this->getSor['row_data']) as $json) {
            // dd($json);
            foreach ($this->getCompositeDatas as $comp) {
                // dd($comp);
                if ($json->id == $comp['sor_itemno_child']) {
                    $rdata[] = $json;
                }
            }
        }
        $this->getSor['row_data'] = json_encode($rdata);
        // dd($this->getSor['row_data']);
    }
    public function getCompositePlaceWise($data)
    {
        // dd($data, $this->getCompositeDatas);
        foreach ($this->getCompositeDatas as $key => $compositeData) {
            // dd($compositeData,$data);
            $getRateDetails[] = RatesAnalysis::where([['sor_id', $compositeData['sor_itemno_child_id']], ['item_index', $compositeData['sor_itemno_child']], ['operation', 'With Stacking']])
            // ->whereIn('operation', ['With Stacking', 'Without Stacking'])
                ->get();

            // if (!empty($getRateDetails)) {
            //     $this->rateData['rate_no'] = '';
            //     $this->rateData['dept_id'] = '';
            //     $this->rateData['dept_category_id'] = $compositeData['dept_category_id'];
            //     $this->rateData['item_number'] = $compositeData['sor_itemno_child'];
            //     $this->rateData['description'] = $compositeData['description'];
            //     $this->rateData['version'] = '';
            //     $this->rateData['other_name'] = '';
            //     $this->rateData['qty'] = $compositeData['rate'];
            //     $this->rateData['rate'] = $getRateDetails->total_amount;
            //     $this->rateData['total_amount'] = $getRateDetails->total_amount * $compositeData['rate'];
            //     $this->addRate($key + 1);
            // }
        }
        dd($getRateDetails);
    }
    public function getCompositSorItemDetails($id)
    {
        // $this->rateData['description'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['description'];
        // $this->rateData['qty'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['unit'];
        // $this->rateData['rate'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['cost'];
        // $this->rateData['item_number'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['id'];
        // $this->calculateValue();

        $getCompositSorList = CompositSor::where('sor_itemno_parent_id', $id)->get();
        // $getRateList = RatesAnalysis::where('operation','Total')->get();

        // dd($getCompositSorList);

        foreach ($getCompositSorList as $key => $sor) {
            // dd(intval($sor['sor_itemno_child']));
            // dd(RatesAnalysis::where('sor_item_number',intval($sor['sor_itemno_child']))->where('operation','=','Total')->first());

            $this->rateData['rate_no'] = '';
            $this->rateData['dept_id'] = '';
            $this->rateData['dept_category_id'] = $sor['dept_category_id'];
            $this->rateData['version'] = '';
            $this->rateData['item_number'] = $sor['sor_itemno_child'];
            $this->rateData['description'] = getSorItemNumberDesc($sor['sor_itemno_child']);
            $this->rateData['other_name'] = '';
            $this->rateData['qty'] = $sor['rate'];
            $rateDetails = RatesAnalysis::where('sor_item_number', $sor['sor_itemno_child'])->where('operation', '=', 'Total')->first();
            if (!empty($rateDetails)) {
                $this->rateData['rate'] = $rateDetails->total_amount;
                $this->rateData['total_amount'] = $rateDetails->total_amount * $sor['rate'];
                $this->addRate($key + 1);
            } else {

                $this->searchStyle = 'none';
                $this->notification()->error(
                    $title = 'Not data found !!' . $this->selectedSORKey
                );
                $this->selectedSORKey = '';
                return;
            }
            // where([['sor_item_number',$sor['sor_itemno_child']],['operation','Total']])->first();
            // dd($rateDetails);
            // $this->rateData['rate'] = $rateDetails->total_amount;
            // $this->rateData['total_amount'] = $rateDetails->total_amount * $sor['rate'];
            // foreach($getRateList as $rate)
            // {
            //     // if($sor['sor_itemno_child'] == $rate['sor_item_number']){
            //         $this->rateData['rate'] = $rate['total_amount'];
            //         $this->rateData['total_amount'] = $rate['total_amount'] * $sor['rate'];
            //     // }
            // }
            // $this->addRate($key+1);
        }
    }

    /*
     * Carriage SOR search
     */
    public $searchCarriageDtaCount;
    public function autoCarriagesSearch()
    {
        if ($this->selectedSORKey) {
            $this->fatchDropdownData['items_number'] = SOR::select('s_o_r_s.Item_details', 's_o_r_s.id')
            // ->join('carriagesors','carriagesors.sor_parent_id','=','s_o_r_s.id')
                ->where('s_o_r_s.department_id', $this->rateData['dept_id'])
                ->where('s_o_r_s.dept_category_id', $this->rateData['dept_category_id'])
                ->where('s_o_r_s.version', $this->rateData['version'])
                ->where('s_o_r_s.Item_details', 'like', $this->selectedSORKey . '%')
                ->where('s_o_r_s.is_approved', 1)
                ->get();
            // dd($this->fatchDropdownData['items_number']);
            if (count($this->fatchDropdownData['items_number']) > 0) {
                $this->searchCarriageDtaCount = (count($this->fatchDropdownData['items_number']) > 0);
                $this->searchStyle = 'block';
            } else {
                $this->rateData['description'] = '';
                $this->rateData['qty'] = '';
                $this->rateData['rate'] = '';
                $this->searchStyle = 'none';
                $this->notification()->error(
                    $title = 'Not data found !!' . $this->selectedSORKey
                );
            }
        } else {
            $this->rateData['description'] = '';
            $this->rateData['qty'] = '';
            $this->rateData['rate'] = '';
            $this->searchStyle = 'none';
            $this->notification()->error(
                $title = 'Not found !!' . $this->selectedSORKey
            );
        }
    }

    public function getSorDtls()
    {
        $this->fatchDropdownData['selectSOR'] = Carriagesor::select('s_o_r_s.Item_details as ItemNo', 's_o_r_s.id as sl_no')
            ->join('s_o_r_s', 's_o_r_s.id', '=', 'carriagesors.sor_parent_id')
            ->where('carriagesors.dept_category_id', $this->rateData['dept_category_id'])
            ->where('carriagesors.dept_id', Auth::user()->department_id)
            ->where('s_o_r_s.version', $this->rateData['version'])
            ->groupBy('s_o_r_s.id')
            ->get();
        // dd($this->fatchDropdownData['selectSOR']);
    }
    // public $totalCost;
    public function getListData()
    {
        // dd($this->rateData['distance']);

        $res = Carriagesor::where(function ($query) {
            $query->where('start_distance', '>=', 0)
                ->where('upto_distance', '<', $this->rateData['distance']);
        })
        // ->orWhere(function($query){
        //     $query->where('start_distance', '>=', 0)
        //     ->where('upto_distance', '<=', $this->rateData['distance']);
        // })
            ->where('dept_id', Auth::user()->department_id)
            ->where('dept_category_id', $this->rateData['dept_category_id'])
            ->where('sor_parent_id', $this->rateData['itemNo'])
            ->get();
        // dd($res);
        $totalCost = 0;
        foreach ($res as $key => $resp) {
            $totalCost += $resp->total_number;
        }
        // dd($totalCost);
        $this->addRate($key + 1);
    }

    public function calculateValue()
    {
        if ($this->rateData['qty'] != '' && $this->rateData['rate'] != '') {
            if ($this->rateData['item_name'] == 'SOR') {
                if (floatval($this->rateData['qty']) >= 0 && floatval($this->rateData['rate']) >= 0) {

                    /*$this->rateData['qty'] = round($this->rateData['qty'], 3);
                    $this->rateData['rate'] = round($this->rateData['rate'], 2);
                    $this->rateData['total_amount'] = floatval($this->rateData['qty']) * floatval($this->rateData['rate']);
                    $this->rateData['total_amount'] = round($this->rateData['total_amount'], 2);*/

                    switch (Auth::user()->department_id === 47 && (int) $this->rateData['dept_category_id'] === 2 && Auth::user()->dept_category_id === 2) {
                        case true:
                            $this->rateData['qty'];
                            $this->rateData['total_amount'] = floatval($this->rateData['qty']) * floatval($this->rateData['rate']);
                            $this->rateData['total_amount'] = round($this->rateData['total_amount'], 2);
                            break;
                        default:
                            $this->rateData['qty'] = round($this->rateData['qty'], 3);
                            $this->rateData['rate'] = round($this->rateData['rate'], 2);
                            $this->rateData['total_amount'] = floatval($this->rateData['qty']) * floatval($this->rateData['rate']);
                            $this->rateData['total_amount'] = round($this->rateData['total_amount'], 2);
                    }
                }
            } else {
                if (floatval($this->rateData['qty']) >= 0 && floatval($this->rateData['rate']) >= 0) {
                    // $this->rateData['qty'] = round($this->rateData['qty'], 3);
                    // $this->rateData['rate'] = round($this->rateData['rate'], 2);
                    // $this->rateData['total_amount'] = floatval($this->rateData['qty']) * floatval($this->rateData['rate']);
                    // $this->rateData['total_amount'] = round($this->rateData['total_amount'], 2);
                    switch (Auth::user()->department_id === 47 && Auth::user()->dept_category_id === 2) {
                        case true:
                            $this->rateData['qty'];
                            $this->rateData['total_amount'] = floatval($this->rateData['qty']) * floatval($this->rateData['rate']);
                            $this->rateData['total_amount'] = round($this->rateData['total_amount'], 2);
                            break;
                        default:
                            $this->rateData['qty'] = round($this->rateData['qty'], 3);
                            $this->rateData['rate'] = round($this->rateData['rate'], 2);
                            $this->rateData['total_amount'] = floatval($this->rateData['qty']) * floatval($this->rateData['rate']);
                            $this->rateData['total_amount'] = round($this->rateData['total_amount'], 2);
                    }
                    //var_dump(Auth::user()->department_id === 47, Auth::user()->dept_category_id === 2);
                }
            }
        }
    }

    public function getDeptEstimates()
    {
        $this->fatchDropdownData['estimatesList'] = '';
        $this->rateData['rate_no'] = '';
        $this->rateData['description'] = '';
        $this->rateData['total_amount'] = '';
        // $this->fatchDropdownData['estimatesList'] = EstimatePrepare::select('estimate_id')->where('dept_id',$this->rateData['dept_id'])->groupBy('estimate_id')->get();
        // $this->fatchDropdownData['estimatesList'] = EstimatePrepare::join('sor_masters','estimate_prepares.estimate_id','sor_masters.estimate_id')
        //                                             ->where('estimate_prepares.dept_id',$this->rateData['dept_id'])
        //                                             ->where('sor_masters.is_verified','=',1)
        //                                             ->get();
        // $this->fatchDropdownData['estimatesList'] = Esrecommender::join('sor_masters', 'estimate_recomender.estimate_id', 'sor_masters.estimate_id')
        //     ->where('estimate_recomender.dept_id', $this->rateData['dept_id'])
        //     ->where('sor_masters.is_verified', '=', 1)
        //     ->get();
        $this->fatchDropdownData['estimatesList'] = SorMaster::select('estimate_id', 'dept_id', 'rateMasterDesc', 'status', 'is_verified')->where([['dept_id', Auth::user()->department_id], ['status', 1], ['is_verified', 1]])->get();
        // $this->fatchDropdownData['estimatesList'] = RatesAnalysis::select('description', 'rate_id', 'total_amount')->where([['operation', 'Total'], ['dept_id', Auth::user()->department_id], ['category_id', $this->rateData['dept_category_id']]])->get();
    }

    public function getDeptRates()
    {
        $this->fatchDropdownData['ratesList'] = '';
        $this->rateData['rate_no'] = '';
        $this->rateData['description'] = '';
        $this->rateData['total_amount'] = '';
        // $this->fatchDropdownData['estimatesList'] = EstimatePrepare::select('estimate_id')->where('dept_id',$this->rateData['dept_id'])->groupBy('estimate_id')->get();
        // $this->fatchDropdownData['estimatesList'] = EstimatePrepare::join('sor_masters','estimate_prepares.estimate_id','sor_masters.estimate_id')
        //                                             ->where('estimate_prepares.dept_id',$this->rateData['dept_id'])
        //                                             ->where('sor_masters.is_verified','=',1)
        //                                             ->get();
        // $this->fatchDropdownData['estimatesList'] = Esrecommender::join('sor_masters', 'estimate_recomender.estimate_id', 'sor_masters.estimate_id')
        //     ->where('estimate_recomender.dept_id', $this->rateData['dept_id'])
        //     ->where('sor_masters.is_verified', '=', 1)
        //     ->get();
        // $this->fatchDropdownData['ratesList'] = SorMaster::select('estimate_id','dept_id','rateMasterDesc','status','is_verified')->where([['dept_id',Auth::user()->department_id],['status',1],['is_verified',1]])->get();
        $this->fatchDropdownData['ratesList'] = RatesAnalysis::where([['dept_id', $this->rateData['dept_id']], ['operation', '!=', ''], ['operation', '!=', 'Exp Calculoation'], ['rate_no', 0]])->select('description', 'rate_id')->groupBy('description', 'rate_id')->get();
        // $this->fatchDropdownData['ratesList'] = RatesAnalysis::all();
    }
    public function getEstimateDetails()
    {
        // $rateId = (int)$this->rateData['rate_no'];

        // if ($rateId) {
        //     $key = collect($this->fatchDropdownData['estimatesList'])->search(function ($item) use ($rateId) {
        //         return $item['rate_id'] === $rateId;
        //     });
        //     $details = $this->fatchDropdownData['estimatesList'][$key];
        //     $this->rateData['total_amount'] = '';
        //     $this->rateData['description'] = '';
        //     $this->rateData['qty'] = '';
        //     $this->rateData['rate'] = '';
        //     $this->rateData['total_amount'] = $details['total_amount'];
        //     $this->rateData['description'] = $details['description'];
        //     $this->rateData['qty'] = 1;
        //     $this->rateData['rate'] = $details['total_amount'];
        // }

        $this->rateData['total_amount'] = '';
        $this->rateData['description'] = '';
        $this->rateData['qty'] = '';
        $this->rateData['rate'] = '';
        $this->fatchDropdownData['estimateDetails'] = EstimatePrepare::join('sor_masters', 'estimate_prepares.estimate_id', 'sor_masters.estimate_id')
            ->where('estimate_prepares.estimate_id', $this->rateData['rate_no'])
            ->where('estimate_prepares.operation', 'Total')->where([['sor_masters.is_verified', 1], ['sor_masters.status', 1]])->first();
        $this->rateData['total_amount'] = $this->fatchDropdownData['estimateDetails']['total_amount'];
        $this->rateData['description'] = $this->fatchDropdownData['estimateDetails']['rateMasterDesc'];
        $this->rateData['qty'] = 1;
        $this->rateData['rate'] = $this->fatchDropdownData['estimateDetails']['total_amount'];
    }
    public function getRateDetailsTypes()
    {
        $this->rateData['total_amount'] = '';
        $this->rateData['description'] = '';
        $this->rateData['qty'] = '';
        $this->rateData['rate'] = '';
        $this->rateData['rate_type'] = '';
        $this->fatchDropdownData['rateDetailsTypes'] = RatesAnalysis::where([['rate_id', $this->rateData['rate_no']], ['dept_id', $this->rateData['dept_id']], ['operation', '!=', ''], ['operation', '!=', 'Exp Calculoation'], ['rate_no', 0]])->select('rate_id', 'operation')->get();
        // dd($this->fatchDropdownData['rateDetailsTypes']);
    }
    public function getRateDetails()
    {
        // dd($this->rateData['rate_type']);
        // $rateId = (int)$this->rateData['rate_no'];

        // if ($rateId) {
        //     $key = collect($this->fatchDropdownData['estimatesList'])->search(function ($item) use ($rateId) {
        //         return $item['rate_id'] === $rateId;
        //     });
        //     $details = $this->fatchDropdownData['estimatesList'][$key];
        //     $this->rateData['total_amount'] = '';
        //     $this->rateData['description'] = '';
        //     $this->rateData['qty'] = '';
        //     $this->rateData['rate'] = '';
        //     $this->rateData['total_amount'] = $details['total_amount'];
        //     $this->rateData['description'] = $details['description'];
        //     $this->rateData['qty'] = 1;
        //     $this->rateData['rate'] = $details['total_amount'];
        // }

        $this->rateData['total_amount'] = '';
        $this->rateData['description'] = '';
        $this->rateData['qty'] = '';
        $this->rateData['rate'] = '';
        $this->fatchDropdownData['rateDetails'] = RatesAnalysis::where([['rate_no', 0], ['rate_id', $this->rateData['rate_no']], ['operation', $this->rateData['rate_type']], ['dept_id', $this->rateData['dept_id']]])->select('description', 'rate_id', 'qty', 'total_amount')->first();
        // dd($this->fatchDropdownData['rateDetails']);
        $this->rateData['total_amount'] = round($this->fatchDropdownData['rateDetails']['total_amount'], 2);
        $this->rateData['description'] = $this->fatchDropdownData['rateDetails']['description'];
        // $this->rateData['qty'] = ($this->fatchDropdownData['rateDetails']['qty'] != 0) ? $this->fatchDropdownData['rateDetails']['qty'] : 1;
        $this->rateData['qty'] = 1;
        $this->rateData['rate'] = $this->fatchDropdownData['rateDetails']['total_amount'];
    }
    public function addRate($key = null)
    {
        // dd($this->rateData);
        $this->validate();
        $this->part_no = strtoupper($this->part_no);
        if (isset($key)) {
            $currentIndex = count($this->addedRate);
            $key = $currentIndex++;
            $this->showTableOne = !$this->showTableOne;
            $this->addedRate[$key]['rate_no'] = ($this->rateData['rate_no'] == '') ? 0 : $this->rateData['rate_no'];
            $this->addedRate[$key]['dept_id'] = ($this->rateData['dept_id'] == '') ? 0 : $this->rateData['dept_id'];
            // $this->addedRate[$key]['dept_id'] = $this->rateData['dept_id'];
            $this->addedRate[$key]['dept_id'] = Auth::user()->department_id;
            $this->addedRate[$key]['category_id'] = ($this->rateData['dept_category_id'] == '') ? 0 : $this->rateData['dept_category_id'];
            $this->addedRate[$key]['sor_item_number'] = ($this->rateData['item_number'] == '') ? 0 : $this->rateData['item_number'];
            $this->addedRate[$key]['volume_no'] = (isset($this->rateData['volume']) && $this->rateData['volume'] != '') ? $this->rateData['volume'] : 0;
            $this->addedRate[$key]['table_no'] = (isset($this->rateData['table_no']) && $this->rateData['table_no'] != '') ? $this->rateData['table_no'] : 0;
            $this->addedRate[$key]['page_no'] = (isset($this->rateData['page_no']) && $this->rateData['page_no'] != '') ? $this->rateData['page_no'] : 0;
            $this->addedRate[$key]['sor_id'] = (isset($this->rateData['sor_id']) && $this->rateData['sor_id'] != '') ? $this->rateData['sor_id'] : 0;
            $this->addedRate[$key]['item_index'] = (isset($this->rateData['item_index']) && $this->rateData['item_index'] != '') ? $this->rateData['item_index'] : 0;
            $this->addedRate[$key]['item_name'] = $this->rateData['item_name'];
            $this->addedRate[$key]['other_name'] = $this->rateData['other_name'];
            $this->addedRate[$key]['description'] = $this->rateData['description'];
            $this->addedRate[$key]['qty'] = ($this->rateData['qty'] == '') ? 0 : round($this->rateData['qty'], 3);
            $this->addedRate[$key]['rate'] = ($this->rateData['rate'] == '') ? 0 : round($this->rateData['rate'], 2);
            $this->addedRate[$key]['total_amount'] = round($this->rateData['total_amount'], 2);
            $this->addedRate[$key]['version'] = $this->rateData['version'];
            $this->addedRate[$key]['sor_itemno_child_id'] = isset($this->rateData['sor_itemno_child_id']) ? $this->rateData['sor_itemno_child_id'] : 0;
            $this->addedRate[$key]['is_row'] = isset($this->rateData['is_row']) ? $this->rateData['is_row'] : null;
            if (isset($this->rateData['rate_type'])) {
                $this->addedRate[$key]['rate_type'] = $this->rateData['rate_type'];
            }
            if (isset($this->rateData['unit_id'])) {
                $this->addedRate[$key]['unit_id'] = $this->rateData['unit_id'];
            }
            $this->addedRateUpdateTrack = rand(1, 1000);
            // $this->rateData['item_number'] = '';
            // $this->rateData['other_name'] = '';
            // $this->rateData['estimate_no'] = '';
            // $this->rateData['rate_no'] = '';
            // $this->rateData['qty'] = '';
            // $this->rateData['rate'] = '';
            // $this->rateData['total_amount'] = '';
            // dd($this->addedRate);
            $this->resetExcept(['addedRate', 'showTableOne', 'addedRateUpdateTrack', 'rateMasterDesc', 'dropdownData', 'selectSor', 'rateData', 'distance', 'part_no', 'editRate_id']);
        } else {
            // dd("key");
            $this->reset('addedRate');
            $this->showTableOne = !$this->showTableOne;
            $this->addedRate['rate_no'] = ($this->rateData['rate_no'] == '') ? 0 : $this->rateData['rate_no'];
            $this->addedRate['dept_id'] = ($this->rateData['dept_id'] == '') ? 0 : $this->rateData['dept_id'];
            // $this->addedRate['dept_id'] = $this->rateData['dept_id'];
            $this->addedRate['category_id'] = ($this->rateData['dept_category_id'] == '') ? 0 : $this->rateData['dept_category_id'];
            $this->addedRate['sor_item_number'] = ($this->rateData['item_number'] == '') ? 0 : $this->rateData['item_number'];
            $this->addedRate['volume_no'] = ($this->rateData['volume'] == '') ? 0 : $this->rateData['volume'];
            $this->addedRate['table_no'] = (isset($this->rateData['table_no']) && $this->rateData['table_no'] != '') ? $this->rateData['table_no'] : 0;
            $this->addedRate['page_no'] = (isset($this->rateData['page_no']) && $this->rateData['page_no'] != '') ? $this->rateData['page_no'] : 0;
            $this->addedRate['sor_id'] = (isset($this->rateData['sor_id']) && $this->rateData['sor_id'] != '') ? $this->rateData['sor_id'] : 0;
            $this->addedRate['item_index'] = (isset($this->rateData['item_index']) && $this->rateData['item_index'] != '') ? $this->rateData['item_index'] : 0;
            $this->addedRate['item_name'] = $this->rateData['item_name'];
            $this->addedRate['other_name'] = $this->rateData['other_name'];
            $this->addedRate['description'] = $this->rateData['description'];
            $this->addedRate['qty'] = ($this->rateData['qty'] == '') ? 0 : $this->rateData['qty'];
            $this->addedRate['rate'] = ($this->rateData['rate'] == '') ? 0 : $this->rateData['rate'];
            $this->addedRate['total_amount'] = $this->rateData['total_amount'];
            $this->addedRate['version'] = $this->rateData['version'];
            $this->addedRate['operation'] = (isset($this->rateData['rate_type'])) ? $this->rateData['rate_type'] : '';
            $this->addedRate['col_position'] = isset($this->rateData['col_position']) ? $this->rateData['col_position'] : 0;
            $this->addedRate['is_row'] = isset($this->rateData['is_row']) ? $this->rateData['is_row'] : null;
            $this->addedRate['unit_id'] = is_numeric($this->rateData['unit_id']) ? getUnitName($this->rateData['unit_id']) : $this->rateData['unit_id'];
            $this->addedRateUpdateTrack = rand(1, 1000);
            $this->rateData['item_number'] = '';
            $this->rateData['other_name'] = '';
            $this->rateData['estimate_no'] = '';
            $this->rateData['description'] = '';
            $this->rateData['rate_no'] = '';
            $this->rateData['qty'] = '';
            $this->rateData['unit_id'] = '';
            $this->rateData['rate'] = '';
            $this->rateData['total_amount'] = '';
            $this->rateData['page_no'] = '';
            $this->rateData['rate_type'] = '';
            $this->rateData['id'] = '';
            $this->resetExcept(['addedRate', 'showTableOne', 'addedRateUpdateTrack', 'rateMasterDesc', 'dropdownData', 'selectSor', 'rateData', 'selectedCategoryId', 'fatchDropdownData', 'part_no', 'editRate_id']);
        }
        // dd($this->addedRate);
    }
    public function closeModal()
    {
        $this->viewModal = !$this->viewModal;
        if ($this->selectedCategoryId == '') {
            $this->selectSor['page_no'] = '';
        } else {
            $this->rateData['page_no'] = '';
            $this->rateData['id'] = '';
        }
    }
    public function render()
    {
        $this->addedRateUpdateTrack = rand(1, 1000);
        return view('livewire.rate-analysis.create-rate-analysis');
    }
}
