<?php

namespace App\Http\Livewire\Components\Modal\ItemModal;

use App\Models\Department;
use App\Models\DynamicSorHeader;
use App\Models\SOR;
use App\Models\SorCategoryType;
use App\Models\UnitMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use WireUi\Traits\Actions;

class AddSubItemModal extends Component
{
    use Actions;
    protected $listeners = ['closeDynamicModal', 'getRowValueSub'];
    public $rowParentId, $selectedCategoryId, $fatchDropdownData = [], $subItemData = [], $viewModal = false, $modalName, $searchKeyWord = '', $counterForItemNo = 0, $depDwnRowId, $allData,$value=0,$editEstimate_id;
    public function mount()
    {
        //dd($this->editEstimate_id);
         $this->department_id= Auth::user()->department_id;

         if ($this->editEstimate_id != '') {
            $this->allData =  Session()->get('editProjectEstimateV2Data' . $this->editEstimate_id);
        } else {
            $this->allData = Session()->get('addedProjectEstimateV2Data');
        }
        
       // dd($this->allData);
        $id = $this->rowParentId;
        $filteredData = array_filter($this->allData, function ($item) use ($id) {
            return $item['id'] == $id || $item['p_id'] == $id;
        });
        $this->fatchDropdownData['depDwnDatas'] = $filteredData;
        $allDept = Cache::get('allDept');
        if ($allDept != '') {
            $this->fatchDropdownData['departments1'] = $allDept;
        } else {
            $this->fatchDropdownData['departments1'] = Cache::remember('allDept', now()->addMinutes(720), function () {
                return Department::select('id', 'department_name')->get();
            });
        }
        $getAllUnit = Cache::get('getUnits');
        if ($getAllUnit != '') {
            $this->fatchDropdownData['units'] = $getAllUnit;
        } else {
            $this->fatchDropdownData['units'] = Cache::remember('getUnits', now()->addMinutes(720), function () {
                return UnitMaster::select('id', 'unit_name')->get();
            });
        }
    }




    
    public function checkQty($newqty, $rowId)
    {
    if (!empty($newqty)) {
        if ($this->editEstimate_id != '') {
            $this->allData =  Session()->get('editProjectEstimateV2Data' . $this->editEstimate_id);
        } else {
            $this->allData = Session()->get('addedProjectEstimateV2Data');
        }
        $parentQty = null;
        $childSum = 0;
        foreach ($this->allData as $item) {
            if ($item['p_id'] == 0) {
                $parentQty = $item['qty'];
                break; 
            }
        }
      
        foreach ($this->allData as $item) {
            if ($item['p_id'] != 0 && $item['p_id'] == $rowId) {
                $childSum += $item['qty'];
            }
        }
     
        $remainingQty = $parentQty - $childSum;
        $epsilon = 0.00001;
        if ($newqty > $remainingQty + $epsilon) {
            session()->flash('error', "Subrow allowable quantity : {$remainingQty}");
            $this->subItemData['qty']="";
        }else{
            $this->subItemData['qty'] = $newqty;
        }
    }
}


    public function getDepDwnData()
    {
        $id = $this->depDwnRowId;
        if ($id != '') {
            $filteredData = array_filter($this->allData, function ($item) use ($id) {
                return $item['id'] == $id;
            });
            $filteredData = array_values($filteredData);
            // dd($filteredData);
            switch ($filteredData[0]['item_name']) {
                case 'SOR':
                    $this->selectedCategoryId = 1;
                    break;
                case 'Other':
                    $this->selectedCategoryId = 2;
                    break;
                default:
                    $this->selectedCategoryId = '';
            }
            if ($this->selectedCategoryId == '1') {
                $this->subItemData['item_name'] = $filteredData[0]['item_name'];
                $this->subItemData['dept_id'] = $filteredData[0]['dept_id'];
                $this->getDeptCategory();
                $this->subItemData['dept_category_id'] = $filteredData[0]['category_id'];
                $this->getVolumn();
                $this->subItemData['volume'] = $filteredData[0]['volume_no'];
                $this->getTableNo();
                $this->subItemData['table_no'] = $filteredData[0]['table_no'];
                $this->getPageNo();
                $this->subItemData['unit_id'] = '';
                $this->subItemData['estimate_no'] = null;
                $this->subItemData['rate_no'] = '';
                $this->subItemData['version'] = '';
                $this->subItemData['other_name'] = '';
            }
        } else {
            $this->reset('selectedCategoryId');
        }
    }
    public function changeCategory()
    {
        $this->subItemData['item_name'] = $this->selectedCategoryId;
        // $getAllUnit = Cache::get('getUnits');
        // if ($getAllUnit != '') {
        //     $this->fatchDropdownData['units'] = $getAllUnit;
        // } else {
        //     $this->fatchDropdownData['units'] = Cache::remember('getUnits', now()->addMinutes(720), function () {
        //         return UnitMaster::select('id', 'unit_name')->get();
        //     });
        // }
        if ($this->selectedCategoryId == '1') {
            // $this->fatchDropdownData['departments'] = Department::select('id', 'department_name')->get();
            // $allDept = Cache::get('allDept');
            // if ($allDept != '') {
            //     $this->fatchDropdownData['departments'] = $allDept;
            // } else {
            //     $this->fatchDropdownData['departments'] = Cache::remember('allDept', now()->addMinutes(720), function () {
            //         return Department::select('id', 'department_name')->get();
            //     });
            // }
            $this->fatchDropdownData['page_no'] = [];
            $this->subItemData['estimate_no'] = null;
            $this->subItemData['rate_no'] = '';
            $this->subItemData['dept_id'] = Auth::user()->department_id;
            $this->getDeptCategory();
            $this->subItemData['dept_category_id'] = '';
            $this->subItemData['version'] = '';
            $this->subItemData['volume'] = '';
            $this->subItemData['table_no'] = '';
            $this->subItemData['page_no'] = '';
            $this->subItemData['id'] = '';
            $this->subItemData['item_number'] = '';
            $this->subItemData['description'] = '';
            $this->subItemData['other_name'] = '';
            $this->subItemData['unit_id'] = '';
            $this->subItemData['qty'] = '';
            $this->subItemData['rate'] = '';
            $this->subItemData['total_amount'] = '';
        } elseif ($this->selectedCategoryId == '2') {
            $this->subItemData['estimate_no'] = null;
            $this->subItemData['rate_no'] = '';
            $this->subItemData['dept_id'] = '';
            $this->subItemData['dept_category_id'] = '';
            $this->subItemData['version'] = '';
            $this->subItemData['item_number'] = '';
            $this->subItemData['description'] = '';
            $this->subItemData['other_name'] = '';
            $this->subItemData['unit_id'] = '';
            $this->subItemData['qty'] = '';
            $this->subItemData['rate'] = 0;
            $this->subItemData['total_amount'] = '';
        }
    }
    public function getDeptCategory()
    {
        $this->subItemData['dept_category_id'] = '';
        $this->subItemData['volume'] = '';
        $this->subItemData['table_no'] = '';
        $this->subItemData['page_no'] = '';
        $this->subItemData['id'] = '';
        $this->subItemData['description'] = '';
        $this->subItemData['qty'] = '';
        $this->subItemData['rate'] = '';
        $this->subItemData['total_amount'] = '';
        // $this->fatchDropdownData['departmentsCategory'] = SorCategoryType::select('id', 'dept_category_name')->where('department_id', '=', $this->subItemData['dept_id'])->get();
        $cacheKey = 'dept_cat' . '_' . $this->subItemData['dept_id'];
        $cacheHasDeptCat = Cache::get($cacheKey);
        if ($cacheHasDeptCat != '') {
            $this->fatchDropdownData['departmentsCategory'] = $cacheHasDeptCat;
        } else {
            $this->fatchDropdownData['departmentsCategory'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                return SorCategoryType::select('id', 'dept_category_name')->where('department_id', '=', $this->subItemData['dept_id'])->get();
            });
        }
    }
    public function autoSearch()
    {
        // $keyword = $keyword['_x_bindings']['value'];
        // $this->kword = $keyword;
        // $this->fatchDropdownData['items_number'] = SOR::where('department_id', $this->subItemData['dept_id'])
        //     ->where('dept_category_id', $this->subItemData['dept_category_id'])
        //     ->where('version', $this->subItemData['version'])
        //     ->where('Item_details', 'like', '%' . $keyword . '%')->get();
        if ($this->selectedSORKey) {
            $this->fatchDropdownData['items_number'] = SOR::select('Item_details', 'id', 'description')
                ->where('department_id', $this->subItemData['dept_id'])
                ->where('dept_category_id', $this->subItemData['dept_category_id'])
                ->where('version', $this->subItemData['version'])
                ->where('Item_details', 'like', $this->selectedSORKey . '%')
                ->where('is_approved', 1)
                ->get();

            // dd($jsonData = $this->fatchDropdownData['items_number']->toJson());
            if (count($this->fatchDropdownData['items_number']) > 0) {
                $this->searchDtaCount = (count($this->fatchDropdownData['items_number']) > 0);
                $this->searchStyle = 'block';
            } else {
                $this->subItemData['description'] = '';
                $this->subItemData['qty'] = '';
                $this->subItemData['rate'] = '';
                $this->searchStyle = 'none';
                $this->notification()->error(
                    $title = 'Not data found !!' . $this->selectedSORKey
                );
            }
        } else {
            $this->subItemData['description'] = '';
            $this->subItemData['qty'] = '';
            $this->subItemData['rate'] = '';
            $this->searchStyle = 'none';
            $this->notification()->error(
                $title = 'Not found !!' . $this->selectedSORKey
            );
        }
    }

    public function textSearchSOR()
    {
        $this->fatchDropdownData['searchDetails'] = [];
        if (isset($this->subItemData['dept_id']) && $this->subItemData['dept_id'] != '') {
            if (isset($this->subItemData['dept_category_id']) && $this->subItemData['dept_category_id'] != '') {
                $this->fatchDropdownData['searchDetails'] = DynamicSorHeader::where([['department_id', $this->subItemData['dept_id']], ['dept_category_id', $this->subItemData['dept_category_id']]])
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
        $this->subItemData['id'] = '';
        $this->subItemData['page_no'] = '';
        $this->subItemData['table_no'] = '';
        $this->subItemData['volume'] = '';
        $this->subItemData['description'] = '';
        $this->subItemData['qty'] = '';
        $this->subItemData['rate'] = '';
        $this->subItemData['total_amount'] = '';
        $this->subItemData['unit_id'] = '';
        $this->searchStyle = 'none';
    }
    public function getItemDetails($id)
    {
        // $this->subItemData['description'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['description'];
        // $this->subItemData['qty'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['unit'];
        // $this->subItemData['rate'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['cost'];
        // $this->subItemData['item_number'] = $this->fatchDropdownData['items_number'][$this->selectedSORKey]['id'];
        // $this->calculateValue();

        $this->searchResData = SOR::where('id', $id)->get();
        // dd($this->searchResData);
        $this->searchDtaCount = count($this->searchResData) > 0;
        $this->searchStyle = 'none';
        if (count($this->searchResData) > 0) {
            foreach ($this->searchResData as $list) {
                $this->subItemData['description'] = $list['description'];
                $this->subItemData['qty'] = $list['unit'];
                $this->subItemData['rate'] = $list['cost'];
                $this->subItemData['item_number'] = $list['id'];
                $this->selectedSORKey = $list['Item_details'];
            }
            $this->calculateValue();
        } else {
            $this->subItemData['description'] = '';
            $this->subItemData['qty'] = '';
            $this->subItemData['rate'] = '';
        }
    }

    public function getVolumn()
    {
        $this->fatchDropdownData['table_no'] = [];
        $this->fatchDropdownData['page_no'] = [];
        $this->subItemData['volume'] = '';
        $this->subItemData['table_no'] = '';
        $this->subItemData['page_no'] = '';
        $this->subItemData['id'] = '';
        $this->subItemData['description'] = '';
        $this->subItemData['qty'] = '';
        $this->subItemData['rate'] = '';
        $this->subItemData['total_amount'] = '';
        // $this->fatchDropdownData['volumes'] = DynamicSorHeader::where([['department_id', $this->subItemData['dept_id']], ['dept_category_id', $this->subItemData['dept_category_id']]])->select('volume_no')->groupBy('volume_no')->get();
        $cacheKey = 'volume_' . $this->subItemData['dept_id'] . '_' . $this->subItemData['dept_category_id'];
        $getCacheData = Cache::get($cacheKey);
        $this->fatchDropdownData['volumes'] = [];
        if ($getCacheData != '') {
            $this->fatchDropdownData['volumes'] = $getCacheData;
        } else {
            $this->fatchDropdownData['volumes'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                return DynamicSorHeader::where([['department_id', $this->subItemData['dept_id']], ['dept_category_id', $this->subItemData['dept_category_id']]])->select('volume_no')->groupBy('volume_no')->get();
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
        $this->subItemData['table_no'] = '';
        $this->subItemData['page_no'] = '';
        $this->subItemData['id'] = '';
        $this->subItemData['description'] = '';
        $this->subItemData['qty'] = '';
        $this->subItemData['rate'] = '';
        $this->subItemData['total_amount'] = '';
        // $this->fatchDropdownData['table_no'] = DynamicSorHeader::where([['department_id', $this->subItemData['dept_id']], ['dept_category_id', $this->subItemData['dept_category_id']], ['volume_no', $this->subItemData['volume']]])->select('table_no')->groupBy('table_no')->get();
        $cacheKey = 'table_no_' . $this->subItemData['dept_id'] . '_' . $this->subItemData['dept_category_id'] . '_' . $this->subItemData['volume'];
        $getCacheData = Cache::get($cacheKey);
        if ($getCacheData != '') {
            $this->fatchDropdownData['table_no'] = $getCacheData;
        } else {
            $this->fatchDropdownData['table_no'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                return DynamicSorHeader::where([['department_id', $this->subItemData['dept_id']], ['dept_category_id', $this->subItemData['dept_category_id']], ['volume_no', $this->subItemData['volume']]])->select('table_no')->groupBy('table_no')->get();
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
        $this->subItemData['id'] = '';
        $this->subItemData['description'] = '';
        $this->subItemData['qty'] = '';
        $this->subItemData['rate'] = '';
        $this->subItemData['total_amount'] = '';
        // $this->fatchDropdownData['page_no'] = DynamicSorHeader::where([['department_id', $this->subItemData['dept_id']], ['dept_category_id', $this->subItemData['dept_category_id']], ['volume_no', $this->subItemData['volume']], ['table_no', $this->subItemData['table_no']]])
        //     ->select('id', 'page_no', 'corrigenda_name')->get();
        $cacheKey = 'page_no_' . $this->subItemData['dept_id'] . '_' . $this->subItemData['dept_category_id'] . '_' . $this->subItemData['volume'] . '_' . $this->subItemData['table_no'];
        $getCacheData = Cache::get($cacheKey);
        if ($getCacheData != '') {
            $this->fatchDropdownData['page_no'] = $getCacheData;
        } else {
            $this->fatchDropdownData['page_no'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                return DynamicSorHeader::where([['department_id', $this->subItemData['dept_id']], ['dept_category_id', $this->subItemData['dept_category_id']], ['volume_no', $this->subItemData['volume']], ['table_no', $this->subItemData['table_no']]])
                    ->select('id', 'page_no', 'corrigenda_name')->orderBy('page_no', 'asc')->orderBy('corrigenda_name', 'asc')->get();
            });
        }
        // }
    }

    public function getDynamicSor($id = '')
    {
        // dd($id,$this->subItemData);
        $this->getSor = [];
        // if ($this->selectedCategoryId == '') {
        //     // $this->getSor = DynamicSorHeader::where([['department_id', $this->selectSor['dept_id']], ['dept_category_id', $this->selectSor['dept_category_id']], ['volume_no', $this->selectSor['volume']], ['table_no', $this->selectSor['table_no']], ['page_no', $this->selectSor['page_no']]])->first();
        //     $this->getSor = DynamicSorHeader::where('id', $this->selectSor['id'])->first();
        //     $this->subItemData['page_no'] = $this->selectSor['page_no'];
        //     $this->selectSor['sor_id'] = $this->getSor['id'];
        // } else {
        // $this->getSor = DynamicSorHeader::where([['department_id', $this->subItemData['dept_id']], ['dept_category_id', $this->subItemData['dept_category_id']], ['volume_no', $this->subItemData['volume']], ['table_no', $this->subItemData['table_no']], ['page_no', $this->subItemData['page_no']]])->first();
        // $this->getSor = DynamicSorHeader::where('id', $this->subItemData['id'])->first();
        $cacheKey = 'getSor_' . (($id != '') ? $id : $this->subItemData['id']);
        $getCacheData = Cache::get($cacheKey);
        if ($getCacheData != '') {
            $this->getSor = $getCacheData;
        } else {
            $this->getSor = Cache::remember($cacheKey, now()->addMinutes(720), function () use ($id) {
                return DynamicSorHeader::where('id', ($id != '') ? $id : $this->subItemData['id'])->first();
            });
        }
        $this->subItemData['id'] = $this->getSor['id'];
        $this->subItemData['page_no'] = $this->getSor['page_no'];
        if ($this->searchKeyWord != '') {
            $this->subItemData['volume'] = $this->getSor['volume'];
            $this->subItemData['table_no'] = $this->getSor['table_no'];
        }
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
        if ($this->subItemData['qty'] != '' && $this->subItemData['rate'] != '') {
            $this->subItemData['rate_det'] = ($this->subItemData['qty'] > 1) ? $this->subItemData['qty'] . ' * ' . $this->subItemData['rate'] : '';
            if ($this->subItemData['item_name'] == 'SOR' || $this->subItemData['item_name'] == 1) {
                if (floatval($this->subItemData['qty']) >= 0 && floatval($this->subItemData['rate']) >= 0) {
                    $this->subItemData['qty'] = number_format(round($this->subItemData['qty'], 3), 3);
                    $this->subItemData['qty'] = str_replace(',', '', $this->subItemData['qty']);
                    // $this->subItemData['rate'] = ($this->subItemData['qty'] > 1) ? floatval($this->subItemData['qty']) * floatval($this->subItemData['rate']) : $this->subItemData['rate'];
                    $this->subItemData['rate'] = number_format(round($this->subItemData['rate'], 2), 2);
                    $this->subItemData['rate'] = str_replace(',', '', $this->subItemData['rate']);
                    $this->subItemData['total_amount'] = floatval($this->subItemData['qty']) * floatval($this->subItemData['rate']);
                    $this->subItemData['total_amount'] = number_format(round($this->subItemData['total_amount'], 2), 2);
                    $this->subItemData['total_amount'] = str_replace(',', '', $this->subItemData['total_amount']);
                    // if($this->subItemData['qty'] > 1){
                    //     $this->subItemData['rate'] = $this->subItemData['total_amount'];
                    // }
                }
            } else {
                if (floatval($this->subItemData['qty']) >= 0 && floatval($this->subItemData['rate']) >= 0) {
                    $this->subItemData['qty'] = number_format(round($this->subItemData['qty'], 3), 3);
                    $this->subItemData['qty'] = str_replace(',', '', $this->subItemData['qty']);
                    $this->subItemData['rate'] = number_format(round($this->subItemData['rate'], 2), 2);
                    $this->subItemData['rate'] = str_replace(',', '', $this->subItemData['rate']);
                    $this->subItemData['total_amount'] = floatval($this->subItemData['qty']) * floatval($this->subItemData['rate']);
                    $this->subItemData['total_amount'] = number_format(round($this->subItemData['total_amount'], 2), 2);
                    $this->subItemData['total_amount'] = str_replace(',', '', $this->subItemData['total_amount']);
                }
            }
        }
    }
    public function getRowValueSub($data)
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
        $this->subItemData['item_index'] = $selectedItemId;
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
        $this->extractDescOfItems($fetchRow, $descriptions, $convertedArray, $loopCount);
        // if ($data != null && $this->selectedCategoryId != '' && $this->isParent == false) {
        // dd($descriptions);
        // $this->viewModal = !$this->viewModal;
        $this->subItemData['description'] = $descriptions . " " . $data[0]['desc'];
        $this->subItemData['qty'] = 1;
        if($this->department_id == 26){
        $this->checkQty(1,$this->rowParentId);
        }else{
            $this->subItemData['qty'] = 1;
        }
       
        $this->subItemData['rate'] = $data[0]['rowValue'];
        $this->subItemData['item_number'] = $itemNo;
        $this->subItemData['col_position'] = $data[0]['colPosition'];
        $this->subItemData['unit_id'] = $data[0]['unit'];
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
        // dd($this->subItemData);
        if ($this->searchKeyWord != '') {
            // $this->reset('searchKeyWord');
            $this->fatchDropdownData['searchDetails'] = [];
            $this->searchStyle = 'none';
            // $this->clearSearch();
        }
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

    public function extractDescOfItems($data, &$descriptions, $counter, $loopCount)
    {
        // dd($data);
        if (isset($data->desc_of_item) && $data->desc_of_item != '') {
            $descriptions .= $data->desc_of_item . ' ';
        }
        if (count($counter) > 2) {
            if (isset($data->_subrow)) {
                foreach ($data->_subrow as $item) {
                    if (isset($counter[$loopCount]) && isset($item->desc_of_item)) {
                        if ($counter[$loopCount] === $item->id) {
                            $descriptions .= $item->desc_of_item . ' ';
                            $loopCount++;
                        }
                        if (!empty($item->_subrow)) {
                            $this->extractDescOfItems($item->_subrow, $descriptions, $counter, $loopCount);
                        }
                    }
                }
            }
        }
    }
    public function closeDynamicModal()
    {
        $this->viewModal = !$this->viewModal;
        // if ($this->selectedCategoryId == '') {
        //     $this->selectSor['page_no'] = '';
        // } else {
        $this->subItemData['page_no'] = '';
        $this->subItemData['id'] = '';
        // }
    }
    public function addSub()
    {
        if ($this->depDwnRowId != '') {
            // $allData = Session()->get('addedProjectEstimateV2Data');
            $id = $this->depDwnRowId;
            $filteredData = array_filter($this->allData, function ($item) use ($id) {
                return $item['id'] == $id;
            });
            $filteredData = array_values($filteredData);
            // dd($singleArray);
            // dd($filteredData[0]['rate'],$this->subItemData['rate']);
            $this->calculateValue();
            $this->subItemData['rate'] = $filteredData[0]['rate'] + $this->subItemData['total_amount'];
            $this->subItemData['total_amount'] = $this->subItemData['rate'];
            // $this->calculateValue();
        }
        if($this->department_id == 26){
            if($this->subItemData['qty'] != ''){
                $this->emit('addEstimate', $this->subItemData, $this->rowParentId);
               }else{
                // $this->notification()->error(
                //     $title = 'Error !!!',
                //     $description = 'Qty required!.'
                // );
                session()->flash('error', "Quantity Cannot be Empty!");
                
               }
        }else{
            $this->emit('addEstimate', $this->subItemData, $this->rowParentId);
        }
      
    }
    public function render()
    {
        return view('livewire.components.modal.item-modal.add-sub-item-modal');
    }
}
