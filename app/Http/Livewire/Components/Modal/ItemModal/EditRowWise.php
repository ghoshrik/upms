<?php

namespace App\Http\Livewire\Components\Modal\ItemModal;

use Livewire\Component;
use App\Models\Department;
use App\Models\UnitMaster;
use WireUi\Traits\Actions;
use App\Models\RatesMaster;
use App\Models\RatesAnalysis;
use App\Models\EstimatePrepare;
use App\Models\SorCategoryType;
use App\Models\DynamicSorHeader;
use App\Models\EstimatePrepareV2;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
//use WireUi\Traits\Actions;

class EditRowWise extends Component
{
    use Actions;
    public $editRowId, $editRowData, $fatchDropdownData = [], $dataArray = [], $selectSor = [];
    public $getCompositeDatas = [], $fetchChildSor = false, $isParent = false, $counterForItemNo = 0, $viewModal = false, $qtyCnfModal = false;
    public $searchKeyWord = '';
    public $qtyval, $editEstimate_id, $editRate_id, $featureType, $storedSessionData, $modalName, $searchStyle, $identifier,$department_id,$rowSubrow_ID,$rowSubrow_PId;
    protected $listeners = [
        'getRowValues',
        'actionconfirm' => 'confirmAction'
    ];


    public function mount()
    {
       
        $this->department_id= Auth::user()->department_id;
        $allDept = Cache::get('allDept');
        if ($allDept != '') {
            $this->fatchDropdownData['departments'] = $allDept;
        } else {
            $this->fatchDropdownData['departments'] = Cache::remember('allDept', now()->addMinutes(720), function () {
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
        $updateRateAnalysisId = (!empty($this->editRate_id)) ? $this->editRate_id : ((!empty($this->editEstimate_id)) ? $this->editEstimate_id : null);
        if (isset($this->identifier) && $this->identifier != null) {
            $this->modalName = ($this->featureType == "RateAnalysis" && $updateRateAnalysisId === null) ? "RateAnalysisModalV2" : (($this->featureType == "RateAnalysis" && $updateRateAnalysisId !== null) ? "RateAnalysisEditModalV2" : (($this->featureType === null && $updateRateAnalysisId === null) ? "modalDataV2" : (($this->featureType === null && $updateRateAnalysisId !== null) ? "editModalDataV2" : "modalDataV2")));
        } else {
            $this->modalName = ($this->featureType == "RateAnalysis" && $updateRateAnalysisId === null) ? "RateAnalysisModal" : (($this->featureType == "RateAnalysis" && $updateRateAnalysisId !== null) ? "RateAnalysisEditModal" : (($this->featureType === null && $updateRateAnalysisId === null) ? "modalData" : (($this->featureType === null && $updateRateAnalysisId !== null) ? "editModalData" : "modalData")));
        }


        $this->storedSessionData = Session()->get($this->modalName);
      
        if (!empty($this->editRowData)) {
             $this->rowSubrow_ID=$this->editRowData['id'];
             $this->rowSubrow_PId=$this->editRowData['p_id'];
            if (isset($this->editRowData['is_v2_data'])) {
                $this->model = $this->editRowData['is_v2_data'] ? EstimatePrepareV2::class : EstimatePrepare::class;
            } else {
                $this->model = EstimatePrepare::class;
            }
            $this->tableName = isset($this->editRowData['is_v2_data']) && $this->editRowData['is_v2_data'] ? 'estimate_prepares_v2' : 'estimate_prepares';
            $this->dataArray['item_name'] = !empty($this->editRowData['item_name']) ? $this->editRowData['item_name'] : null;
            //dd($this->dataArray['item_name']);
            $this->dataArray['existingQty'] = $this->editRowData['qty'] ?? null;
            if (isset($this->editRowData['qtyUpdate'])) {
                $this->dataArray['qtyUpdate'] = $this->editRowData['qtyUpdate'];
            } else {
                $this->dataArray['qtyUpdate'] = false;
            }
            $this->dataArray['page_no'] = $this->editRowData['page_no'] ?? null;
            if ($this->dataArray['item_name'] == 'Rate' || $this->dataArray['item_name'] == '4') {
                if (isset($this->editRowData['qtyUpdate'])) {
                    $this->dataArray['qtyUpdate'] = $this->editRowData['qtyUpdate'];
                }
                $this->getDeptRates();
                $this->dataArray['rate_no'] = $this->editRowData['rate_no'];
                $this->getRateDetailsTypes();
                if ($this->storedSessionData && isset($this->storedSessionData[$this->editRowId])) {
                    $this->OpenConfirmModal();
                }
                $this->dataArray['unit_id'] = $this->editRowData['unit_id'];
                $this->dataArray['rate'] = $this->editRowData['rate'];
                $this->dataArray['qty'] = $this->editRowData['qty'];
                $this->dataArray['total_amount'] = $this->editRowData['total_amount'];
                if (!empty($this->editRowData['operation'])) {
                    $this->dataArray['rate_type'] = $this->editRowData['operation'];
                }
                if (!empty($this->editRowData['rate_type'])) {
                    $this->dataArray['rate_type'] = $this->editRowData['rate_type'];
                }
                $this->calculateValue();
            } elseif ($this->dataArray['item_name'] == 'SOR' || $this->dataArray['item_name'] == '1') {
                
                if (isset($this->editRowData['qtyUpdate'])) {
                    $this->dataArray['qtyUpdate'] = $this->editRowData['qtyUpdate'];
                }
                $this->dataArray['page_no'] = $this->editRowData['page_no'];
                $this->dataArray['dept_id'] = $this->editRowData['dept_id'];
                $this->dataArray['rate_type'] = $this->editRowData['operation'];
                $this->dataArray['rate_no'] = $this->editRowData['rate_no'];
                $this->getDeptCategory();
                $this->dataArray['dept_category_id'] = $this->editRowData['category_id'];
                $this->getVolumn();
                $this->dataArray['volume'] = $this->editRowData['volume_no'];
                $this->getTableNo();
                $this->dataArray['table_no'] = $this->editRowData['table_no'];
                $this->getPageNo();
                $this->dataArray['sor_id'] = $this->editRowData['sor_id'];
                $this->dataArray['description'] = !empty($this->editRowData['other_name']) ? $this->editRowData['other_name'] : $this->editRowData['description'];
                $this->dataArray['unit_id'] = $this->editRowData['unit_id'];
                $this->dataArray['qty'] = $this->editRowData['qty'];
                if ($this->storedSessionData && isset($this->storedSessionData[$this->editRowId])) {
                    $this->OpenConfirmModal();
                }
                $this->dataArray['rate'] = $this->editRowData['rate'];
                $this->dataArray['total_amount'] = $this->editRowData['total_amount'];
                $this->calculateValue();

            } elseif ($this->dataArray['item_name'] == 'Other' || $this->dataArray['item_name'] == '2') {
                if (isset($this->editRowData['qtyUpdate'])) {
                    $this->dataArray['qtyUpdate'] = $this->editRowData['qtyUpdate'];
                }
                if ($this->storedSessionData && isset($this->storedSessionData[$this->editRowId])) {
                    $this->OpenConfirmModal();
                }
                $this->dataArray['other_name'] = $this->editRowData['other_name'];
                $this->dataArray['qty'] = $this->editRowData['qty'];
                $this->dataArray['rate'] = $this->editRowData['rate'];
                $this->dataArray['total_amount'] = $this->editRowData['total_amount'];
                $this->dataArray['unit_id'] = $this->editRowData['unit_id'];
            } elseif ($this->dataArray['item_name'] == 'Estimate' || $this->dataArray['item_name'] == '3' ) {
                if (isset($this->editRowData['qtyUpdate'])) {
                    $this->dataArray['qtyUpdate'] = $this->editRowData['qtyUpdate'];
                }
                if (!empty($this->editRowData['operation'])) {
                    $this->dataArray['rate_type'] = $this->editRowData['operation'];
                }
                if (!empty($this->editRowData['rate_type'])) {
                    $this->dataArray['rate_type'] = $this->editRowData['rate_type'];
                }
                $this->dataArray['unit_id'] = $this->editRowData['unit_id'];
                $this->dataArray['qty'] = $this->editRowData['qty'];
                $this->dataArray['estimate_no'] = $this->editRowData['estimate_no'];
                $this->getEstimateDetails();
            }
            //dd($this->dataArray);
        }
    }

    
    public function checkQty($newqty, $parentRowId)
    {
       //dd($newqty, $parentRowId);
    if (!empty($newqty)) {
       
        if ($this->editEstimate_id != '') {
            $this->allData =  Session()->get('editProjectEstimateV2Data' . $this->editEstimate_id);
        } else {
            $this->allData = Session()->get('addedProjectEstimateV2Data');
        }


       //dd( $this->allData);
        $parentQty = null;
        $childSum = 0;
        foreach ($this->allData as $item) {
            if ($item['p_id'] == 0) {
                $parentQty = $item['qty'];
                break; 
            }
        }
        if ($parentQty === null) {
            $this->addError('qty', 'Error: Parent row not found.');
            return false; 
        }
        foreach ($this->allData as $item) {
            if ($item['p_id'] != 0 && $item['id'] == $parentRowId) {
                $childSum += $item['qty'];
            }
        }
     
        //dd( $childSum);
        $remainingQty = $parentQty - $childSum;
        if ($newqty > $remainingQty) {
            // $this->notification()->error(
            //     $title = 'Error !!!',
            //    $description = "Subrow quantity should be less than = {$remainingQty}!"
            // );
            session()->flash('error', "Subrow allowable quantity : {$remainingQty}");
            $this->dataArray['qty']="";
        }else{
            $this->dataArray['qty'] = $newqty;
        }
    }
}
    public function OpenConfirmModal()
    {
        $this->qtyCnfModal = !$this->qtyCnfModal;
    }
    public function confirmAction($value)
    {

        $this->qtyval = $value;
        if ($this->qtyval == 1) {
            $this->dataArray['qty'] = $this->editRowData['qty'];
            $this->dataArray['qtyUpdate'] = true;
            $this->calculateValue();
        } else {
            $this->dataArray['qtyUpdate'] = false;
            $this->dataArray['qty'] = 1;
            $this->calculateValue();
        }
    }
    public function calculateValue()
    {
        if ($this->dataArray['qty'] != '' && $this->dataArray['rate'] != '') {
            if ($this->editRowData['item_name'] == 'SOR') {
                if (floatval($this->dataArray['qty']) >= 0 && floatval($this->dataArray['rate']) >= 0) {
                    switch (Auth::user()->department_id === 47 && (int) $this->dataArray['dept_category_id'] === 2 && Auth::user()->dept_category_id === 2) {
                        case true:
                            $this->dataArray['qty'];
                            $this->dataArray['total_amount'] = floatval($this->dataArray['qty']) * floatval($this->dataArray['rate']);
                            $this->dataArray['total_amount'] = round($this->dataArray['total_amount'], 2);
                            break;
                        default:
                            $this->dataArray['qty'] = round($this->dataArray['qty'], 3);
                            $this->dataArray['rate'] = round($this->dataArray['rate'], 2);
                            $this->dataArray['total_amount'] = floatval($this->dataArray['qty']) * floatval($this->dataArray['rate']);
                            $this->dataArray['total_amount'] = round($this->dataArray['total_amount'], 2);
                    }
                }
            } else {
                if (floatval($this->dataArray['qty']) >= 0 && floatval($this->dataArray['rate']) >= 0) {
                    switch (Auth::user()->department_id === 47 && Auth::user()->dept_category_id === 2) {
                        case true:
                            $this->dataArray['qty'];
                            $this->dataArray['total_amount'] = floatval($this->dataArray['qty']) * floatval($this->dataArray['rate']);
                            $this->dataArray['total_amount'] = round($this->dataArray['total_amount'], 2);
                            break;
                        default:
                            $this->dataArray['qty'] = round($this->dataArray['qty'], 3);
                            $this->dataArray['rate'] = round($this->dataArray['rate'], 2);
                            $this->dataArray['total_amount'] = floatval($this->dataArray['qty']) * floatval($this->dataArray['rate']);
                            $this->dataArray['total_amount'] = round($this->dataArray['total_amount'], 2);
                    }
                }
            }
        }
    }
    public function getEstimateDetails()
    {
        $this->dataArray['total_amount'] = '';
        $this->dataArray['description'] = '';
        $this->dataArray['rate'] = '';
        $this->dataArray['sor_id'] = '';
        $this->fatchDropdownData['estimatesList'] = $this->model::join('sor_masters', "{$this->tableName}.estimate_id", '=', 'sor_masters.estimate_id')
            ->select('estimate_prepares.estimate_id', 'sor_masters.sorMasterDesc')
            ->distinct()
            ->get()
            ->toArray();
        if (!empty($this->dataArray['estimate_no'])) {
            $this->fatchDropdownData['estimateDetails'] = $this->model::join('sor_masters', "{$this->tableName}.estimate_id", 'sor_masters.estimate_id')
                ->where('estimate_prepares.estimate_id', $this->dataArray['estimate_no'])
                ->where('estimate_prepares.operation', 'Total')
                ->first();
            if ($this->fatchDropdownData['estimateDetails']) {
                $this->dataArray['total_amount'] = $this->fatchDropdownData['estimateDetails']['total_amount'];
                $this->dataArray['description'] = $this->fatchDropdownData['estimateDetails']['rateMasterDesc'];
                if ($this->storedSessionData && isset($this->storedSessionData[$this->editRowId])) {
                    $this->OpenConfirmModal();
                }
                $this->dataArray['rate'] = $this->fatchDropdownData['estimateDetails']['total_amount'];
            }
        }
    }
    public function getDeptCategory()
    {
        $this->dataArray['dept_category_id'] = '';
        $this->dataArray['volume'] = '';
        $this->dataArray['table_no'] = '';
        $this->dataArray['page_no'] = '';
        $this->dataArray['sor_id'] = '';
        $this->fatchDropdownData['departmentsCategory'] = [];
        $cacheKey = 'dept_cat' . '_' . $this->dataArray['dept_id'];
        $cacheHasDeptCat = Cache::get($cacheKey);
        if ($cacheHasDeptCat != '') {
            $this->fatchDropdownData['departmentsCategory'] = $cacheHasDeptCat;
        } else {
            $this->fatchDropdownData['departmentsCategory'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                return SorCategoryType::select('id', 'dept_category_name')->where('department_id', '=', $this->dataArray['dept_id'])->get();
            });
        }
    }
    public function getVolumn()
    {
        $this->fatchDropdownData['table_no'] = [];
        if ($this->editRowData['item_name'] == '') {
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
            $this->dataArray['volume'] = '';
            $this->dataArray['table_no'] = '';
            $this->dataArray['page_no'] = '';
            $this->dataArray['sor_id'] = '';
            $this->dataArray['description'] = '';
            $this->dataArray['unit_id'] = '';
            $this->dataArray['qty'] = '';
            $this->dataArray['rate'] = '';
            $this->dataArray['total_amount'] = '';
            $cacheKey = 'volume_' . $this->dataArray['dept_id'] . '_' . $this->dataArray['dept_category_id'];
            $getCacheData = Cache::get($cacheKey);
            $this->fatchDropdownData['volumes'] = [];
            if ($getCacheData != '') {
                $this->fatchDropdownData['volumes'] = $getCacheData;
            } else {
                $this->fatchDropdownData['volumes'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                    return DynamicSorHeader::where([['department_id', $this->dataArray['dept_id']], ['dept_category_id', $this->dataArray['dept_category_id']]])->select('volume_no')->groupBy('volume_no')->get();
                });
            }
        }
    }
    public function getDynamicSor($id = '')
    {
        $this->getSor = [];
        if ($this->editRowData['item_name'] == '') {
            $cacheKey = 'getSor_' . $this->selectSor['id'];
            $getCacheData = Cache::get($cacheKey);
            if ($getCacheData != '') {
                $this->getSor = $getCacheData;
            } else {
                $this->getSor = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                    return DynamicSorHeader::where('id', $this->selectSor['id'])->first();
                });
            }
            $this->dataArray['page_no'] = $this->selectSor['page_no'];
            $this->selectSor['sor_id'] = $this->getSor['id'];
        } else {
            $this->dataArray['page_no'] = '';
            $this->dataArray['description'] = '';
            $this->dataArray['unit_id'] = '';
            $this->dataArray['qty'] = '';
            $this->dataArray['rate'] = '';
            $this->dataArray['total_amount'] = '';
            $cacheKey = 'getSor_' . (($id != '') ? $id : $this->dataArray['sor_id']);
            $getCacheData = Cache::get($cacheKey);
            if ($getCacheData != '') {
                $this->getSor = $getCacheData;
            } else {
                $this->getSor = Cache::remember($cacheKey, now()->addMinutes(720), function () use ($id) {
                    return DynamicSorHeader::where('id', ($id != '') ? $id : $this->dataArray['sor_id'])->first();
                });
            }
            $this->dataArray['sor_id'] = $this->getSor['id'];
            $this->dataArray['page_no'] = $this->getSor['page_no'];
            $this->dataArray['qty'] = $this->editRowData['qty'];
            if ($this->searchKeyWord != '') {
                $this->dataArray['volume'] = $this->getSor['volume_no'];
                $this->dataArray['table_no'] = $this->getSor['table_no'];
            }
        }
        if ($this->getSor != null) {
            $this->viewModal = !$this->viewModal;
            $this->modalName = "dynamic-sor-modal_" . rand(1, 1000);
            $this->modalName = str_replace(' ', '_', $this->modalName);
        }
    }
    public function getTableNo()
    {
        $this->fatchDropdownData['table_no'] = [];
        if ($this->editRowData['item_name'] == '') {
            $this->selectSor['table_no'] = '';
            $this->selectSor['page_no'] = '';
            $this->dropdownData['table_no'] = [];
            $cacheKey = 'table_no_' . $this->dataArray['dept_id'] . '_' . $this->dataArray['dept_category_id'] . '_' . $this->dataArray['volume'];
            $getCacheData = Cache::get($cacheKey);
            if ($getCacheData != '') {
                $this->dropdownData['table_no'] = $getCacheData;
            } else {
                $this->dropdownData['table_no'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                    return DynamicSorHeader::where([['department_id', $this->dataArray['dept_id']], ['dept_category_id', $this->dataArray['dept_category_id']], ['volume_no', $this->dataArray['volume']]])
                        ->select('table_no')->groupBy('table_no')->get();
                });
            }
        } else {
            $this->dataArray['table_no'] = '';
            $this->dataArray['page_no'] = '';
            $this->dataArray['qty'] = '';
            $this->dataArray['rate'] = '';
            $this->dataArray['total_amount'] = '';
            $cacheKey = 'table_no_' . $this->dataArray['dept_id'] . '_' . $this->dataArray['dept_category_id'] . '_' . $this->dataArray['volume'];
            $getCacheData = Cache::get($cacheKey);
            if ($getCacheData != '') {
                $this->fatchDropdownData['table_no'] = $getCacheData;
            } else {
                $this->fatchDropdownData['table_no'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                    return DynamicSorHeader::where([['department_id', $this->dataArray['dept_id']], ['dept_category_id', $this->dataArray['dept_category_id']], ['volume_no', $this->dataArray['volume']]])
                        ->select('table_no')->groupBy('table_no')->get();
                });
            }
        }
    }
    public function getPageNo()
    {
        $this->fatchDropdownData['page_no'] = [];
        $this->dataArray['sor_id'] = '';
        $this->dataArray['qty'] = '';
        $this->dataArray['rate'] = '';
        $this->dataArray['total_amount'] = '';
        $this->dataArray['unit_id'] = '';
        $this->viewModal = false;
        $cacheKey = 'page_no_' . $this->dataArray['dept_id'] . '_' . $this->dataArray['dept_category_id'] . '_' . $this->dataArray['volume'] . '_' . $this->dataArray['table_no'];
        $getCacheData = Cache::get($cacheKey);
        if ($getCacheData != '') {
            $this->fatchDropdownData['page_no'] = $getCacheData;
        } else {
            $this->fatchDropdownData['page_no'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                return DynamicSorHeader::where([['department_id', $this->dataArray['dept_id']], ['dept_category_id', $this->dataArray['dept_category_id']], ['volume_no', $this->dataArray['volume']], ['table_no', $this->dataArray['table_no']]])
                    ->select('id', 'page_no', 'corrigenda_name')->orderBy('page_no', 'asc')->orderBy('corrigenda_name', 'asc')->get();
            });
        }
    }
    public function getRowValues($data)
    {
        $this->reset('counterForItemNo');
        $fetchRow[] = [];
        if ($this->editRowData['item_name'] == 'Carriages') {
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
            $selectedItemId = $data[0]['id'];
            $this->dataArray['item_index'] = $selectedItemId;
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
            $this->extractItemNoOfItems($fetchRow, $itemNo, $convertedArray, $this->counterForItemNo);
            $this->extractDescOfItems($fetchRow, $descriptions, $convertedArray);
            if ($data != null && $this->editRowData['item_name'] !== '' && $this->isParent == false) {
                $this->viewModal = !$this->viewModal;
                $this->dataArray['description'] = $descriptions . " " . $data[0]['desc'];
                $this->dataArray['rate'] = $data[0]['rowValue'];
                $this->dataArray['item_number'] = $itemNo;
                $this->dataArray['col_position'] = $data[0]['colPosition'];
                $this->dataArray['unit_id'] = $data[0]['unit'];
                $this->calculateValue();
            } else {
                $this->selectSor['selectedSOR'] = $itemNo;
                $this->selectSor['sor_id'] = $this->getSor['id'];
                $this->selectSor['page_no'] = $this->getSor['page_no'];
                $this->selectSor['selectedItemId'] = $selectedItemId;
                $this->selectSor['item_index'] = $data[0]['id'];
                $this->selectSor['col_position'] = $data[0]['colPosition'];
                $this->rateMasterDesc = $data[0]['desc'];
                $this->viewModal = !$this->viewModal;
                $this->isParent = !$this->isParent;
            }
        }
        if ($this->searchKeyWord != '') {
            $this->fatchDropdownData['searchDetails'] = [];
            $this->searchStyle = 'none';
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
    public function getDeptRates()
    {
        $this->fatchDropdownData['ratesList'] = '';
        $this->dataArray['rate_no'] = '';
        $this->dataArray['description'] = '';
        $this->dataArray['total_amount'] = '';
        $this->fatchDropdownData['ratesList'] = RatesAnalysis::where([['dept_id', $this->dataArray['dept_id']], ['operation', '!=', ''], ['operation', '!=', 'Exp Calculoation'], ['rate_no', 0]])
            ->select('description', 'rate_id')
            ->groupBy('description', 'rate_id')
            ->get();
    }

    public function getRateDetailsTypes()
    {
        $this->dataArray['total_amount'] = '';
        $this->dataArray['unit_id'] = '';
        $this->dataArray['rate'] = '';
        $this->dataArray['rate_type'] = '';
        $this->fatchDropdownData['rateDetailsTypes'] = RatesAnalysis::where([['rate_id', $this->dataArray['rate_no']], ['dept_id', $this->dataArray['dept_id']], ['operation', '!=', ''], ['operation', '!=', 'Exp Calculoation'], ['rate_no', 0]])->select('rate_id', 'operation')->get();
    }
    public function getRateDetails()
    {

        $this->dataArray['total_amount'] = '';
        $this->dataArray['rate'] = '';
        $this->fatchDropdownData['rateDetails'] = RatesAnalysis::where([['rate_no', 0], ['rate_id', $this->dataArray['rate_no']], ['operation', $this->dataArray['rate_type']], ['dept_id', $this->dataArray['dept_id']]])->select('description', 'rate_id', 'qty', 'total_amount')->first();
        $this->dataArray['total_amount'] = round($this->fatchDropdownData['rateDetails']['total_amount'], 2);
        $this->dataArray['description'] = $this->fatchDropdownData['rateDetails']['description'];
        if ($this->storedSessionData && isset($this->storedSessionData[$this->editRowId])) {
            $this->OpenConfirmModal();
        }
        $this->dataArray['rate'] = $this->fatchDropdownData['rateDetails']['total_amount'];
    }

    public function getRateDetailsCopyTypes()
    {
        $this->dataArray['total_amount'] = '';
        $this->dataArray['description'] = '';
        $this->dataArray['qty'] = '';
        $this->dataArray['rate'] = '';
        $this->dataArray['rate_type'] = '';
        $rateAnalysis = RatesAnalysis::where([
            ['rate_id', $this->dataArray['rate_no']],
            ['dept_id', $this->dataArray['dept_id']],
            ['operation', '!=', ''],
            ['operation', '!=', 'Exp Calculoation'],
            ['rate_no', 0]
        ])
            ->select('rate_id', 'operation', 'description')
            ->first();
        $ratesMasterData = RatesMaster::where('rate_id', $rateAnalysis->rate_id)->first();
        $rateMasterDesc = '';
        if ($ratesMasterData) {

            $rateMasterDesc .= ' ' . $ratesMasterData['rate_description'];
        }
    }
    public function textSearchSOR()
    {
        $this->fatchDropdownData['searchDetails'] = [];
        if (isset($this->editRowData['dept_id']) && $this->editRowData['dept_id'] != '') {
            if (isset($this->editRowData['category_id']) && $this->editRowData['category_id'] != '') {
                $this->fatchDropdownData['searchDetails'] = DynamicSorHeader::where([['department_id', $this->editRowData['dept_id']], ['dept_category_id', $this->editRowData['category_id']]])
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
    }
    public function clearSearch()
    {
        $this->reset('searchKeyWord');
        $this->editRowData['sor_id'] = '';
        $this->editRowData['page_no'] = '';
        $this->editRowData['table_no'] = '';
        $this->editRowData['volume'] = '';
        $this->editRowData['description'] = '';
        $this->editRowData['qty'] = '';
        $this->editRowData['rate'] = '';
        $this->editRowData['total_amount'] = '';
        $this->editRowData['unit_id'] = '';
        $this->searchStyle = 'none';
    }

    public function UpdateModalData()
    {
        $update_id = $this->editRowData['array_id'];
        if (empty($this->dataArray['page_no']) || $this->dataArray['page_no'] == "") {
            $this->dataArray['page_no'] = $this->editRowData['page_no'];
        }

        if ($this->dataArray['qtyUpdate'] == false) {
            if ($this->modalName == "RateAnalysisEditModal") {
                unset($this->storedSessionData[$this->editRowId]);
            } elseif ($this->modalName == "editModalData") {
                unset($this->storedSessionData[$this->editRowId]);
            } elseif ($this->modalName == "modalData") {
                unset($this->storedSessionData[$this->editRowId]);
            } elseif ($this->modalName == "modalDataV2") {
                unset($this->storedSessionData[$this->editRowId]);
            } elseif ($this->modalName == "editModalDataV2") {
                unset($this->storedSessionData[$this->editRowId]);
            } else {
                unset($this->storedSessionData[$this->editRowId]);
            }
            Session()->put($this->modalName, $this->storedSessionData);
        }
        $this->emit('updateSetFetchData', $this->dataArray, $update_id);
    }
    public function render()
    {
        return view('livewire.components.modal.item-modal.edit-row-wise');
    }
}
