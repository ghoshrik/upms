<?php

namespace App\Http\Livewire\RateAnalysis;

use App\Models\Carriagesor;
use App\Models\CompositSor;
use App\Models\Department;
use App\Models\DynamicSorHeader;
use App\Models\EstimatePrepare;
use App\Models\RatesAnalysis;
use App\Models\SOR;
use App\Models\SorCategoryType;
use App\Models\SorMaster;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class CreateRateAnalysis extends Component
{
    use Actions;
    protected $listeners = ['getRowValue', 'closeModal'];
    public $estimateData = [], $getCategory = [], $fatchDropdownData = [], $sorMasterDesc, $selectSor = [], $dropdownData = [];
    public $kword = null, $selectedSORKey, $selectedCategoryId, $showTableOne = false, $addedEstimateUpdateTrack;
    public $addedEstimate = [];
    public $searchDtaCount, $searchStyle, $searchResData, $totalDistance;
    public $getSor, $viewModal = false, $modalName = '', $counterForItemNo = 0;
    // TODO:: remove $showTableOne if not use
    // TODO::pop up modal view estimate and project estimate
    // TODO::forward revert draft modify

    protected $rules = [
        'sorMasterDesc' => 'required|string',
        // 'selectedCategoryId' => 'required|integer',

    ];
    protected $messages = [
        'sorMasterDesc.required' => 'The description cannot be empty.',
        'sorMasterDesc.string' => 'The description format is not valid.',
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
        // 'estimateData.rate_no.required' => 'This field is required',
        // 'estimateData.rate_no.numeric' => 'This field is must be numeric',
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
        //         'estimateData.rate_no' => 'required|integer',
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
            // $this->fatchDropdownData['table_no'] = DynamicSorHeader::select('table_no')->groupBy('table_no')->get();
            $this->fatchDropdownData['page_no'] = [];
            $this->estimateData['rate_no'] = '';
            $this->estimateData['dept_id'] = Auth::user()->department_id;
            if (!empty($this->estimateData['dept_id'])) {
                $this->getDeptCategory();
            }
            $this->estimateData['table_no'] = '';
            $this->estimateData['page_no'] = '';
            $this->estimateData['dept_category_id'] = '';
            $this->estimateData['version'] = '';
            $this->estimateData['volume'] = '';
            $this->estimateData['item_number'] = '';
            $this->estimateData['description'] = '';
            $this->estimateData['other_name'] = '';
            $this->estimateData['qty'] = '';
            $this->estimateData['rate'] = '';
            $this->estimateData['total_amount'] = '';
            $this->estimateData['distance'] = '';
        } elseif ($this->selectedCategoryId == 2) {
            $this->estimateData['rate_no'] = '';
            $this->estimateData['dept_id'] = '';
            $this->estimateData['dept_category_id'] = '';
            $this->estimateData['version'] = '';
            $this->estimateData['volume'] = '';
            $this->estimateData['item_number'] = '';
            $this->estimateData['description'] = '';
            $this->estimateData['other_name'] = '';
            $this->estimateData['qty'] = '';
            $this->estimateData['rate'] = '';
            $this->estimateData['total_amount'] = '';
            $this->estimateData['distance'] = '';
        } elseif ($this->selectedCategoryId == 3) {
            $this->fatchDropdownData['departments'] = Department::select('id', 'department_name')->get();
            $this->estimateData['dept_id'] = Auth::user()->department_id;
            if (!empty($this->estimateData['dept_id'])) {
                $this->getDeptRates();
            }
            $this->estimateData['rate_no'] = '';
            // $this->estimateData['estimate_desc'] = '';
            $this->estimateData['dept_category_id'] = '';
            $this->estimateData['version'] = '';
            $this->estimateData['volume'] = '';
            $this->estimateData['item_number'] = '';
            $this->estimateData['description'] = '';
            $this->estimateData['other_name'] = '';
            $this->estimateData['qty'] = '';
            $this->estimateData['rate'] = '';
            $this->estimateData['total_amount'] = '';
            $this->estimateData['distance'] = '';
        } elseif ($this->selectedCategoryId == 4) {
            $this->fatchDropdownData['departments'] = Department::select('id', 'department_name')->get();
            $this->estimateData['rate_no'] = '';
            $this->estimateData['dept_id'] = Auth::user()->department_id;
            if (!empty($this->estimateData['dept_id'])) {
                $this->getDeptCategory();
            }
            $this->estimateData['dept_category_id'] = '';
            $this->estimateData['version'] = '';
            $this->estimateData['volume'] = '';
            $this->estimateData['item_number'] = '';
            $this->estimateData['description'] = '';
            $this->estimateData['other_name'] = '';
            $this->estimateData['qty'] = '';
            $this->estimateData['rate'] = '';
            $this->estimateData['total_amount'] = '';
            $this->estimateData['distance'] = '';
        } else {
            $this->fatchDropdownData['departments'] = Department::select('id', 'department_name')->get();
            $this->fatchDropdownData['table_no'] = DynamicSorHeader::select('table_no')->groupBy('table_no')->get();
            $this->fatchDropdownData['page_no'] = [];
            $this->estimateData['dept_id'] = Auth::user()->department_id;
            if (!empty($this->estimateData['dept_id'])) {
                $this->getDeptCategory();
            }
            $this->estimateData['table_no'] = '';
            $this->estimateData['page_no'] = '';
            $this->estimateData['rate_no'] = '';
            $this->estimateData['dept_category_id'] = '';
            $this->estimateData['version'] = '';
            $this->estimateData['volume'] = '';
            $this->estimateData['item_number'] = '';
            $this->estimateData['description'] = '';
            $this->estimateData['other_name'] = '';
            $this->estimateData['qty'] = '';
            $this->estimateData['rate'] = '';
            $this->estimateData['total_amount'] = '';
            $this->estimateData['distance'] = '';
        }
    }
    public function getDeptCategory()
    {
        $this->estimateData['dept_category_id'] = '';
        $this->estimateData['volume'] = '';
        $this->estimateData['table_no'] = '';
        $this->estimateData['page_no'] = '';
        $this->fatchDropdownData['volumes'] = [];
        $this->fatchDropdownData['table_no'] = [];
        $this->fatchDropdownData['page_no'] = [];
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
    public function getVolumn()
    {
        $this->estimateData['volume'] = '';
        $this->estimateData['table_no'] = '';
        $this->estimateData['page_no'] = '';
        $this->fatchDropdownData['table_no'] = [];
        $this->fatchDropdownData['page_no'] = [];
        $this->fatchDropdownData['volumes'] = DynamicSorHeader::where([['department_id', $this->estimateData['dept_id']], ['dept_category_id', $this->estimateData['dept_category_id']]])->select('volume_no')->groupBy('volume_no')->get();
    }
    public function getTableNo()
    {
        $this->estimateData['table_no'] = '';
        $this->estimateData['page_no'] = '';
        $this->fatchDropdownData['table_no'] = [];
        $this->fatchDropdownData['table_no'] = DynamicSorHeader::where([['department_id', $this->estimateData['dept_id']], ['dept_category_id', $this->estimateData['dept_category_id']], ['volume_no', $this->estimateData['volume']]])
            ->select('table_no')->groupBy('table_no')->get();
    }
    public function getPageNo()
    {
        $this->fatchDropdownData['page_no'] = DynamicSorHeader::where([['department_id', $this->estimateData['dept_id']], ['dept_category_id', $this->estimateData['dept_category_id']], ['volume_no', $this->estimateData['volume']], ['table_no', $this->estimateData['table_no']]])
            ->select('page_no')->get();
        $this->viewModal = false;
        $this->estimateData['page_no'] = '';

    }
    public function getDynamicSor()
    {
        $this->getSor = [];
        $this->getSor = DynamicSorHeader::where([['page_no', $this->estimateData['page_no'], ['table_no', $this->estimateData['table_no']]]])->first();
        $this->estimateData['sor_id'] = $this->getSor['id'];
        if ($this->getSor != null) {
            $this->viewModal = !$this->viewModal;
            $this->modalName = "dynamic-sor-modal_" . rand(1, 1000);
            $this->modalName = str_replace(' ', '_', $this->modalName);
        }
        // dd($this->getSor);
    }
    public function getRowValue($data)
    {
        // dd($data);
        $fetchRow[] = [];
        // $descriptions = [];
        if ($this->selectedCategoryId == 5) {
            $id = explode('.', $data['id'])[0];
            foreach (json_decode($this->getSor['row_data']) as $d) {
                if ($d->id == $id && $d->desc_of_item != '') {
                    $this->sorMasterDesc .= $d->desc_of_item;
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
            $this->extractItemNoOfItems($fetchRow, $itemNo, $convertedArray);
            $this->estimateData['item_number'] = $itemNo;
            $this->extractDescOfItems($fetchRow, $descriptions, $convertedArray);
            // dd($descriptions);
            // $id = explode('.', $data[0]['id'])[$countLoop];
            // foreach ($convertedArray as $arr) {
            //     foreach (json_decode($this->getSor['row_data']) as $d) {
            //         if ($d->id == $arr) {
            //             if (isset($d->desc_of_item)) {
            //                 $descriptions[] = $d->desc_of_item;
            //             }
            //             if ($d->_subrow) {
            //                 foreach ($d->_subrow as $subRow) {
            //                     // dd($arr);
            //                     if ($subRow->id == $arr) {
            //                         $this->estimateData['description'] = $this->estimateData['description'] . " " . $subRow->desc_of_item;
            //                     }
            //                 }
            //             }
            //         }
            //         if ($d->id == $arr) {
            //             $this->estimateData['description'] = $this->estimateData['description'] . " " . $d->desc_of_item;
            //         }
            //     }
            // }

            if ($data != null) {
                $this->viewModal = !$this->viewModal;
                $this->estimateData['description'] = $descriptions . " " . $data[0]['desc'];
                $this->estimateData['qty'] = 1;
                $this->estimateData['rate'] = $data[0]['rowValue'];
                $this->calculateValue();
            }
        }

        // dd($this->estimateData['description']);
    }
    public function extractItemNoOfItems($data, &$itemNo, $counter)
    {
        if (isset($data->item_no) && $data->item_no != '') {
            $itemNo = $data->item_no . ' ';
        }
        if (isset($data->_subrow)) {
            foreach ($data->_subrow as $key => $item) {
                if (isset($counter[$this->counterForItemNo + 1])) {
                    if (isset($item->item_no) && $item->id == $counter[$this->counterForItemNo + 1]) {
                        $itemNo .= $item->item_no . ' ';
                    }
                    if (!empty($item->_subrow)) {
                        $this->extractItemNoOfItems($item->_subrow, $itemNo, $counter);
                    }
                }
            }
        }
    }
    public function extractDescOfItems($data, &$descriptions, $counter)
    {
        if (isset($data->desc_of_item) && $data->desc_of_item != '') {
            $descriptions .= $data->desc_of_item . ' ';
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
            $this->fatchDropdownData['items_number'] = SOR::select('Item_details', 'id', 'description')
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
    public $distance;
    // public function getItemDetails1($id)
    public function getItemDetails1($getData)
    {
        // dd($id);
        $this->distance = $this->estimateData['distance'];
        // $this->estimateData['description'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['description'];
        // $this->estimateData['qty'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['unit'];
        // $this->estimateData['rate'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['cost'];
        // $this->estimateData['item_number'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['id'];
        // $this->calculateValue();

        // $this->searchResData = SOR::select('Item_details', 'id', 'description', 'cost')->where('Item_details', 'like', $id . '%')->get();
        // dd($this->searchResData);
        // foreach ($this->searchResData as $key => $data) {
        //     if ($key == 0 && $this->estimateData['distance'] != 0) {
        //         if ($this->estimateData['distance'] >= 5) {
        //             $this->estimateData['qty'] = 5;
        //         } else {
        //             $this->estimateData['qty'] = $this->estimateData['distance'];
        //         }
        //         $this->estimateData['item_number'] = $data['id'];
        //         $this->estimateData['description'] = $data['description'];
        //         $this->estimateData['rate'] = $data['cost'];
        //         $this->estimateData['total_amount'] = $data['cost'];
        //         $this->estimateData['distance'] = $this->estimateData['distance'] - $this->estimateData['qty'];
        //         $this->addEstimate($key + 1);
        //     } elseif ($key == 1 && $this->estimateData['distance'] != 0) {
        //         if ($this->estimateData['distance'] >= 5) {
        //             $this->estimateData['qty'] = 5;
        //         } else {
        //             $this->estimateData['qty'] = $this->estimateData['distance'];
        //         }
        //         $this->estimateData['item_number'] = $data['id'];
        //         $this->estimateData['description'] = $data['description'];
        //         $this->estimateData['rate'] = $data['cost'];
        //         $this->estimateData['total_amount'] = $data['cost'] * $this->estimateData['qty'];
        //         $this->estimateData['distance'] = $this->estimateData['distance'] - $this->estimateData['qty'];
        //         $this->addEstimate($key + 1);
        //     } elseif ($key == 2 && $this->estimateData['distance'] != 0) {
        //         if ($this->estimateData['distance'] >= 10) {
        //             $this->estimateData['qty'] = 10;
        //         } else {
        //             $this->estimateData['qty'] = $this->estimateData['distance'];
        //         }
        //         $this->estimateData['item_number'] = $data['id'];
        //         $this->estimateData['description'] = $data['description'];
        //         $this->estimateData['rate'] = $data['cost'];
        //         $this->estimateData['total_amount'] = $data['cost'] * $this->estimateData['qty'];
        //         $this->estimateData['distance'] = $this->estimateData['distance'] - $this->estimateData['qty'];
        //         $this->addEstimate($key + 1);
        //     } elseif ($key == 3 && $this->estimateData['distance'] != 0) {
        //         if ($this->estimateData['distance'] >= 30) {
        //             $this->estimateData['qty'] = 30;
        //         } else {
        //             $this->estimateData['qty'] = $this->estimateData['distance'];
        //         }
        //         $this->estimateData['item_number'] = $data['id'];
        //         $this->estimateData['description'] = $data['description'];
        //         $this->estimateData['rate'] = $data['cost'];
        //         $this->estimateData['total_amount'] = $data['cost'] * $this->estimateData['qty'];
        //         $this->estimateData['distance'] = $this->estimateData['distance'] - $this->estimateData['qty'];
        //         $this->addEstimate($key + 1);
        //     } elseif ($key == 4 && $this->estimateData['distance'] != 0) {
        //         if ($this->estimateData['distance'] >= 50) {
        //             $this->estimateData['qty'] = 50;
        //         } else {
        //             $this->estimateData['qty'] = $this->estimateData['distance'];
        //         }
        //         $this->estimateData['item_number'] = $data['id'];
        //         $this->estimateData['description'] = $data['description'];
        //         $this->estimateData['rate'] = $data['cost'];
        //         $this->estimateData['total_amount'] = $data['cost'] * $this->estimateData['qty'];
        //         $this->estimateData['distance'] = $this->estimateData['distance'] - $this->estimateData['qty'];
        //         $this->addEstimate($key + 1);
        //     } elseif ($key == 5 && $this->estimateData['distance'] != 0) {
        //         $this->estimateData['item_number'] = $data['id'];
        //         $this->estimateData['description'] = $data['description'];
        //         $this->estimateData['qty'] = $this->estimateData['distance'];
        //         $this->estimateData['rate'] = $data['cost'];
        //         $this->estimateData['total_amount'] = $data['cost'] * $this->estimateData['qty'];
        //         $this->addEstimate($key + 1);
        //     } else {
        //         return;
        //     }
        // }
        // dd($this->estimateData);
        // $this->searchDtaCount = count($this->searchResData) > 0;
        // $this->searchStyle = 'none';
        // if (count($this->searchResData) > 0) {
        //     foreach ($this->searchResData as $list) {
        //         $this->estimateData['description'] = $list['description'];
        //         $this->estimateData['qty'] = $list['unit'];
        //         $this->estimateData['rate'] = $list['cost'];
        //         $this->estimateData['item_number'] = $list['id'];
        //         $this->selectedSORKey = $list['Item_details'];
        //     }
        //     $this->calculateValue();
        // } else {
        //     $this->estimateData['description'] = '';
        //     $this->estimateData['qty'] = '';
        //     $this->estimateData['rate'] = '';
        // }
        $this->reset('addedEstimate');
        $array = [];
        $arrCount = 0;
        if (isset($getData['upTo_5'])) {
            $array[$arrCount++]['upTo_5'] = $getData['upTo_5'];
        }
        if (isset($getData['upTo_10'])) {
            $array[$arrCount++]['upTo_10'] = $getData['upTo_10'];
        }
        if (isset($getData['upTo_16'])) {
            $array[$arrCount++]['upTo_16'] = $getData['upTo_16'];
        }
        if (isset($getData['above_16'])) {
            $array[$arrCount++]['above_16'] = $getData['above_16'];
        }
        if (isset($getData['upTo_20'])) {
            $array[$arrCount++]['upTo_20'] = $getData['upTo_20'];
        }
        if (isset($getData['upTo_50'])) {
            $array[$arrCount++]['upTo_50'] = $getData['upTo_50'];
        }
        if (isset($getData['upTo_100'])) {
            $array[$arrCount++]['upTo_100'] = $getData['upTo_100'];
        }
        if (isset($getData['above_100'])) {
            $array[$arrCount++]['above_100'] = $getData['above_100'];
        }
        // dd($array);
        // Log::debug(json_encode($array));
        foreach ($array as $key => $data) {
            // dd($data);
            // Log::debug(json_encode($data));
            if (isset($data['upTo_5']) && $this->estimateData['distance'] != 0) {
                if ($this->estimateData['distance'] >= 5) {
                    $this->estimateData['qty'] = 5;
                } else {
                    $this->estimateData['qty'] = $this->estimateData['distance'];
                }
                $this->estimateData['item_number'] = $getData['id'] . ' ( Zone ' . $getData['zone'] . ')';
                $this->estimateData['description'] = "Any Distance up to 5 km";
                $this->estimateData['rate'] = $data['upTo_5'];
                $this->estimateData['total_amount'] = (int) $data['upTo_5'];
                $this->estimateData['distance'] = $this->estimateData['distance'] - $this->estimateData['qty'];
                // Log::debug(json_encode($this->estimateData));
                $this->addEstimate($key + 1);
                // dd($this->estimateData);
            } elseif (isset($data['upTo_10']) && $this->estimateData['distance'] != 0) {
                if ($this->estimateData['distance'] >= 5) {
                    $this->estimateData['qty'] = 5;
                } else {
                    $this->estimateData['qty'] = $this->estimateData['distance'];
                }
                $this->estimateData['item_number'] = $getData['id'] . ' ( Zone ' . $getData['zone'] . ')';
                $this->estimateData['description'] = "Above 5 km up to 10 km (per km)";
                $this->estimateData['rate'] = $data['upTo_10'];
                $this->estimateData['total_amount'] = $data['upTo_10'] * $this->estimateData['qty'];
                $this->estimateData['distance'] = $this->estimateData['distance'] - $this->estimateData['qty'];
                $this->addEstimate($key + 1);
            } elseif (isset($data['upTo_16']) && $this->estimateData['distance'] != 0) {
                if ($this->estimateData['distance'] >= 11) {
                    $this->estimateData['qty'] = 11;
                } else {
                    $this->estimateData['qty'] = $this->estimateData['distance'];
                }
                $this->estimateData['item_number'] = $getData['id'] . ' ( Zone ' . $getData['zone'] . ')';
                $this->estimateData['description'] = "Above 5 km up to 16 km (per km)";
                $this->estimateData['rate'] = $data['upTo_16'];
                $this->estimateData['total_amount'] = $data['upTo_16'] * $this->estimateData['qty'];
                $this->estimateData['distance'] = $this->estimateData['distance'] - $this->estimateData['qty'];
                $this->addEstimate($key + 1);
            } elseif (isset($data['above_16']) && $this->estimateData['distance'] != 0) {
                $this->estimateData['item_number'] = $getData['id'] . ' ( Zone ' . $getData['zone'] . ')';
                $this->estimateData['description'] = "Above 16 km (per km)";
                $this->estimateData['qty'] = $this->estimateData['distance'];
                $this->estimateData['rate'] = $data['above_16'];
                $this->estimateData['total_amount'] = $data['above_16'] * $this->estimateData['qty'];
                $this->addEstimate($key + 1);
            } elseif (isset($data['upTo_20']) && $this->estimateData['distance'] != 0) {
                if ($this->estimateData['distance'] >= 10) {
                    $this->estimateData['qty'] = 10;
                } else {
                    $this->estimateData['qty'] = $this->estimateData['distance'];
                }
                $this->estimateData['item_number'] = $getData['id'] . ' ( Zone ' . $getData['zone'] . ')';
                $this->estimateData['description'] = "Above 10 km up to 20 km (per km)";
                $this->estimateData['rate'] = $data['upTo_20'];
                $this->estimateData['total_amount'] = $data['upTo_20'] * $this->estimateData['qty'];
                $this->estimateData['distance'] = $this->estimateData['distance'] - $this->estimateData['qty'];
                $this->addEstimate($key + 1);
            } elseif (isset($data['upTo_50']) && $this->estimateData['distance'] != 0) {
                if ($this->estimateData['distance'] >= 30) {
                    $this->estimateData['qty'] = 30;
                } else {
                    $this->estimateData['qty'] = $this->estimateData['distance'];
                }
                $this->estimateData['item_number'] = $getData['id'] . ' ( Zone ' . $getData['zone'] . ')';
                $this->estimateData['description'] = "Above 20 km up to 50 km (per km)";
                $this->estimateData['rate'] = $data['upTo_50'];
                $this->estimateData['total_amount'] = $data['upTo_50'] * $this->estimateData['qty'];
                $this->estimateData['distance'] = $this->estimateData['distance'] - $this->estimateData['qty'];
                $this->addEstimate($key + 1);
            } elseif (isset($data['upTo_100']) && $this->estimateData['distance'] != 0) {
                if ($this->estimateData['distance'] >= 50) {
                    $this->estimateData['qty'] = 50;
                } else {
                    $this->estimateData['qty'] = $this->estimateData['distance'];
                }
                $this->estimateData['item_number'] = $getData['id'] . ' ( Zone ' . $getData['zone'] . ')';
                $this->estimateData['description'] = "Above 50 km up to 100 km (per km)";
                $this->estimateData['rate'] = $data['upTo_100'];
                $this->estimateData['total_amount'] = $data['upTo_100'] * $this->estimateData['qty'];
                $this->estimateData['distance'] = $this->estimateData['distance'] - $this->estimateData['qty'];
                $this->addEstimate($key + 1);
            } elseif (isset($data['above_100']) && $this->estimateData['distance'] != 0) {
                $this->estimateData['item_number'] = $getData['id'] . ' ( Zone ' . $getData['zone'] . ')';
                $this->estimateData['description'] = "Above 100 km (per km)";
                $this->estimateData['qty'] = $this->estimateData['distance'];
                $this->estimateData['rate'] = $data['above_100'];
                $this->estimateData['total_amount'] = $data['above_100'] * $this->estimateData['qty'];
                $this->addEstimate($key + 1);
            } else {
                return;
            }
        }
        // $array = [];
        // dd($array);
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

        // dd($getCompositSorList);

        foreach ($getCompositSorList as $key => $sor) {
            // dd(intval($sor['sor_itemno_child']));
            // dd(RatesAnalysis::where('sor_item_number',intval($sor['sor_itemno_child']))->where('operation','=','Total')->first());

            $this->estimateData['rate_no'] = '';
            $this->estimateData['dept_id'] = '';
            $this->estimateData['dept_category_id'] = $sor['dept_category_id'];
            $this->estimateData['version'] = '';
            $this->estimateData['item_number'] = $sor['sor_itemno_child'];
            $this->estimateData['description'] = getSorItemNumberDesc($sor['sor_itemno_child']);
            $this->estimateData['other_name'] = '';
            $this->estimateData['qty'] = $sor['rate'];
            $rateDetails = RatesAnalysis::where('sor_item_number', $sor['sor_itemno_child'])->where('operation', '=', 'Total')->first();
            if (!empty($rateDetails)) {
                $this->estimateData['rate'] = $rateDetails->total_amount;
                $this->estimateData['total_amount'] = $rateDetails->total_amount * $sor['rate'];
                $this->addEstimate($key + 1);
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
            // $this->estimateData['rate'] = $rateDetails->total_amount;
            // $this->estimateData['total_amount'] = $rateDetails->total_amount * $sor['rate'];
            // foreach($getRateList as $rate)
            // {
            //     // if($sor['sor_itemno_child'] == $rate['sor_item_number']){
            //         $this->estimateData['rate'] = $rate['total_amount'];
            //         $this->estimateData['total_amount'] = $rate['total_amount'] * $sor['rate'];
            //     // }
            // }
            // $this->addEstimate($key+1);
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
                ->where('s_o_r_s.department_id', $this->estimateData['dept_id'])
                ->where('s_o_r_s.dept_category_id', $this->estimateData['dept_category_id'])
                ->where('s_o_r_s.version', $this->estimateData['version'])
                ->where('s_o_r_s.Item_details', 'like', $this->selectedSORKey . '%')
                ->where('s_o_r_s.is_approved', 1)
                ->get();
            // dd($this->fatchDropdownData['items_number']);
            if (count($this->fatchDropdownData['items_number']) > 0) {
                $this->searchCarriageDtaCount = (count($this->fatchDropdownData['items_number']) > 0);
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

    /*public function getCarriageItemDetails($id)
    {
    $sors = SOR::select('id','Item_details')->where('id',$id)->first();
    if(!empty($sors))
    {
    $ssa = Carriagesor::select('sor_parent_id','child_sor_id','description','start_distance','upto_distance','cost','total_number')->where('sor_parent_id',$sors->id)->get();
    dd($ssa);
    }
    else
    {
    dd("no");
    }
    }*/

    public function getSorDtls()
    {
        $this->fatchDropdownData['selectSOR'] = Carriagesor::select('s_o_r_s.Item_details as ItemNo', 's_o_r_s.id as sl_no')
            ->join('s_o_r_s', 's_o_r_s.id', '=', 'carriagesors.sor_parent_id')
            ->where('carriagesors.dept_category_id', $this->estimateData['dept_category_id'])
            ->where('carriagesors.dept_id', Auth::user()->department_id)
            ->where('s_o_r_s.version', $this->estimateData['version'])
            ->groupBy('s_o_r_s.id')
            ->get();
        // dd($this->fatchDropdownData['selectSOR']);
    }
    // public $totalCost;
    public function getListData()
    {
        // dd($this->estimateData['distance']);

        $res = Carriagesor::where(function ($query) {
            $query->where('start_distance', '>=', 0)
                ->where('upto_distance', '<', $this->estimateData['distance']);
        })
        // ->orWhere(function($query){
        //     $query->where('start_distance', '>=', 0)
        //     ->where('upto_distance', '<=', $this->estimateData['distance']);
        // })
            ->where('dept_id', Auth::user()->department_id)
            ->where('dept_category_id', $this->estimateData['dept_category_id'])
            ->where('sor_parent_id', $this->estimateData['itemNo'])
            ->get();
        // dd($res);
        $totalCost = 0;
        foreach ($res as $key => $resp) {
            $totalCost += $resp->total_number;
        }
        // dd($totalCost);
        $this->addEstimate($key + 1);
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
        $this->fatchDropdownData['rateDetails'] = RatesAnalysis::select('description', 'rate_id', 'qty', 'total_amount')->where([['rate_id', $this->estimateData['rate_no']], ['operation', 'Total'], ['dept_id', Auth::user()->department_id]])->first();
        // dd($this->fatchDropdownData['rateDetails']);
        $this->estimateData['total_amount'] = $this->fatchDropdownData['rateDetails']['total_amount'];
        $this->estimateData['description'] = $this->fatchDropdownData['rateDetails']['description'];
        // $this->estimateData['qty'] = ($this->fatchDropdownData['rateDetails']['qty'] != 0) ? $this->fatchDropdownData['rateDetails']['qty'] : 1;
        $this->estimateData['qty'] = 1;
        $this->estimateData['rate'] = $this->fatchDropdownData['rateDetails']['total_amount'];
    }
    public function addEstimate($key = null)
    {
        // dd($this->estimateData);
        $this->validate();
        if (isset($key)) {
            $currentIndex = count($this->addedEstimate);
            $key = $currentIndex++;
            $this->showTableOne = !$this->showTableOne;
            $this->addedEstimate[$key]['rate_no'] = ($this->estimateData['rate_no'] == '') ? 0 : $this->estimateData['rate_no'];
            $this->addedEstimate[$key]['dept_id'] = ($this->estimateData['dept_id'] == '') ? 0 : $this->estimateData['dept_id'];
            // $this->addedEstimate[$key]['dept_id'] = $this->estimateData['dept_id'];
            $this->addedEstimate[$key]['dept_id'] = Auth::user()->department_id;
            $this->addedEstimate[$key]['category_id'] = ($this->estimateData['dept_category_id'] == '') ? 0 : $this->estimateData['dept_category_id'];
            $this->addedEstimate[$key]['sor_item_number'] = ($this->estimateData['item_number'] == '') ? 0 : $this->estimateData['item_number'];
            $this->addedEstimate[$key]['volume_no'] = (isset($this->estimateData['volume']) && $this->estimateData['volume'] != '') ? $this->estimateData['volume'] : 0;
            $this->addedEstimate[$key]['table_no'] = (isset($this->estimateData['table_no']) && $this->estimateData['table_no'] != '') ? $this->estimateData['table_no'] : 0;
            $this->addedEstimate[$key]['page_no'] = (isset($this->estimateData['page_no']) && $this->estimateData['page_no'] != '') ? $this->estimateData['page_no'] : 0;
            $this->addedEstimate[$key]['sor_id'] = (isset($this->estimateData['sor_id']) && $this->estimateData['sor_id'] != '') ? $this->estimateData['sor_id'] : 0;
            $this->addedEstimate[$key]['item_index'] = (isset($this->estimateData['item_index']) && $this->estimateData['item_index'] != '') ? $this->estimateData['item_index'] : 0;
            $this->addedEstimate[$key]['item_name'] = $this->estimateData['item_name'];
            $this->addedEstimate[$key]['other_name'] = $this->estimateData['other_name'];
            $this->addedEstimate[$key]['description'] = $this->estimateData['description'];
            $this->addedEstimate[$key]['qty'] = ($this->estimateData['qty'] == '') ? 0 : $this->estimateData['qty'];
            $this->addedEstimate[$key]['rate'] = ($this->estimateData['rate'] == '') ? 0 : $this->estimateData['rate'];
            $this->addedEstimate[$key]['total_amount'] = $this->estimateData['total_amount'];
            $this->addedEstimate[$key]['version'] = $this->estimateData['version'];
            $this->addedEstimateUpdateTrack = rand(1, 1000);
            // $this->estimateData['item_number'] = '';
            // $this->estimateData['other_name'] = '';
            // $this->estimateData['estimate_no'] = '';
            // $this->estimateData['rate_no'] = '';
            // $this->estimateData['qty'] = '';
            // $this->estimateData['rate'] = '';
            // $this->estimateData['total_amount'] = '';
            // dd($this->addedEstimate);
            $this->resetExcept(['addedEstimate', 'showTableOne', 'addedEstimateUpdateTrack', 'sorMasterDesc', 'dropdownData', 'selectSor', 'estimateData', 'distance']);
        } else {
            // dd("key");
            $this->reset('addedEstimate');
            $this->showTableOne = !$this->showTableOne;
            $this->addedEstimate['rate_no'] = ($this->estimateData['rate_no'] == '') ? 0 : $this->estimateData['rate_no'];
            $this->addedEstimate['dept_id'] = ($this->estimateData['dept_id'] == '') ? 0 : $this->estimateData['dept_id'];
            // $this->addedEstimate['dept_id'] = $this->estimateData['dept_id'];
            $this->addedEstimate['category_id'] = ($this->estimateData['dept_category_id'] == '') ? 0 : $this->estimateData['dept_category_id'];
            $this->addedEstimate['sor_item_number'] = ($this->estimateData['item_number'] == '') ? 0 : $this->estimateData['item_number'];
            $this->addedEstimate['volume_no'] = ($this->estimateData['volume'] == '') ? 0 : $this->estimateData['volume'];
            $this->addedEstimate['table_no'] = (isset($this->estimateData['table_no']) && $this->estimateData['table_no'] != '') ? $this->estimateData['table_no'] : 0;
            $this->addedEstimate['page_no'] = (isset($this->estimateData['page_no']) && $this->estimateData['page_no'] != '') ? $this->estimateData['page_no'] : 0;
            $this->addedEstimate['sor_id'] = (isset($this->estimateData['sor_id']) && $this->estimateData['sor_id'] != '') ? $this->estimateData['sor_id'] : 0;
            $this->addedEstimate['item_index'] = (isset($this->estimateData['item_index']) && $this->estimateData['item_index'] != '') ? $this->estimateData['item_index'] : 0;
            $this->addedEstimate['item_name'] = $this->estimateData['item_name'];
            $this->addedEstimate['other_name'] = $this->estimateData['other_name'];
            $this->addedEstimate['description'] = $this->estimateData['description'];
            $this->addedEstimate['qty'] = ($this->estimateData['qty'] == '') ? 0 : $this->estimateData['qty'];
            $this->addedEstimate['rate'] = ($this->estimateData['rate'] == '') ? 0 : $this->estimateData['rate'];
            $this->addedEstimate['total_amount'] = $this->estimateData['total_amount'];
            $this->addedEstimate['version'] = $this->estimateData['version'];
            $this->addedEstimateUpdateTrack = rand(1, 1000);
            $this->estimateData['item_number'] = '';
            $this->estimateData['other_name'] = '';
            $this->estimateData['estimate_no'] = '';
            $this->estimateData['description'] = '';
            $this->estimateData['rate_no'] = '';
            $this->estimateData['qty'] = '';
            $this->estimateData['rate'] = '';
            $this->estimateData['total_amount'] = '';
            $this->estimateData['page_no'] = '';
            $this->resetExcept(['addedEstimate', 'showTableOne', 'addedEstimateUpdateTrack', 'sorMasterDesc', 'dropdownData', 'selectSor', 'estimateData', 'selectedCategoryId', 'fatchDropdownData']);
        }
        // dd($this->addedEstimate);
    }
    public function closeModal()
    {
        $this->viewModal = !$this->viewModal;
        $this->estimateData['page_no'] = '';
    }
    public function render()
    {
        return view('livewire.rate-analysis.create-rate-analysis');
    }
}
