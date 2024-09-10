<?php

namespace App\Http\Livewire\EstimateProjectV2;

use App\Models\EstimateMasterV2;
use App\Models\EstimatePrepare;
use App\Models\EstimatePrepareV2;
use App\Models\EstimateUserAssignRecord;
use ChrisKonnertz\StringCalc\StringCalc;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class AddedEstimateProjectList extends Component
{
    use Actions;
    protected $listeners = ['closeUnitModal', 'setFatchEstimateData', 'submitGrandTotal', 'closeAndReset', 'closeSubItemModal', 'updateSetFetchData', 'closeEditModal'];
    public $addedEstimateData = [];
    public $editRowId,$identifier = "V2";
    public $editRowData = [];

    public $allAddedEstimatesData = [];
    public $part_no;
    public $expression, $remarks, $level = [], $openTotalButton = false, $arrayStore = [], $totalEstimate = 0, $arrayIndex, $arrayRow, $sorMasterDesc, $updateDataTableTracker, $totalOnSelectedCount = 0;
    public $openQtyModal = false, $sendArrayKey = '', $sendArrayDesc = '',$sendRowNo='', $getQtySessionData = [], $editEstimate_id;
    public $arrayCount = 0, $selectCheckBoxs = false, $editRowModal = false ,$department_id;
    public function mount()
    {
         $this->department_id =Auth::user()->department_id;
        // if ($this->editEstimate_id == '') {
        $this->setEstimateDataToSession();
        // }
    }

    public function resetSession()
    {
        if ($this->editEstimate_id != '') {
            // dd($this->editEstimate_id);
            Session()->forget('editProjectEstimateV2Data' . $this->editEstimate_id);
            Session()->forget('editProjectEstimateDesc' . $this->editEstimate_id);
            Session()->forget('editProjectEstimatePartNo' . $this->editEstimate_id);
            Session()->forget('editModalDataV2');
        } else {
            Session()->forget('addedProjectEstimateV2Data');
            Session()->forget('modalDataV2');
            Session()->forget('projectEstimationTotal');
        }
        $this->reset();
    }

    public function setFatchEstimateData($fatchEstimateData)
    {
        // dd($fatchEstimateData);
        $this->reset('allAddedEstimatesData', 'getQtySessionData');
        if (Session()->has('editProjectEstimateV2Data' . $this->editEstimate_id)) {
            $this->allAddedEstimatesData = Session()->get('editProjectEstimateV2Data' . $this->editEstimate_id);
             //dd($this->allAddedEstimatesData);
        } else {
            foreach ($fatchEstimateData as $estimateData) {
                $count = count($this->allAddedEstimatesData) + 1;
                $this->allAddedEstimatesData[$count]['id'] = $estimateData['sl_no'];
                $this->allAddedEstimatesData[$count]['p_id'] = $estimateData['p_id'];
                $this->allAddedEstimatesData[$count]['estimate_no'] = $estimateData['estimate_no'];
                $this->allAddedEstimatesData[$count]['rate_no'] = $estimateData['rate_id'];
                $this->allAddedEstimatesData[$count]['dept_id'] = $estimateData['dept_id'];
                $this->allAddedEstimatesData[$count]['category_id'] = $estimateData['category_id'];
                $this->allAddedEstimatesData[$count]['sor_item_number'] = $estimateData['sor_item_number'];
                $this->allAddedEstimatesData[$count]['item_name'] = $estimateData['item_name'];
                $this->allAddedEstimatesData[$count]['other_name'] = $estimateData['other_name'];
                $this->allAddedEstimatesData[$count]['description'] = getTableDesc($estimateData['sor_id'], $estimateData['item_index']);
                $this->allAddedEstimatesData[$count]['unit_id'] = $estimateData['unit_id'];
                $this->allAddedEstimatesData[$count]['qty'] = $estimateData['qty'];
                $this->allAddedEstimatesData[$count]['rate'] = $estimateData['rate'];
                $this->allAddedEstimatesData[$count]['total_amount'] = $estimateData['total_amount'];
                // $this->allAddedEstimatesData[$count]['version'] = $estimateData['version'];
                $this->allAddedEstimatesData[$count]['page_no'] = $estimateData['page_no'];
                $this->allAddedEstimatesData[$count]['table_no'] = $estimateData['table_no'];
                $this->allAddedEstimatesData[$count]['volume_no'] = $estimateData['volume_no'];
                $this->allAddedEstimatesData[$count]['sor_id'] = $estimateData['sor_id'];
                $this->allAddedEstimatesData[$count]['item_index'] = $estimateData['item_index'];
                $this->allAddedEstimatesData[$count]['col_position'] = $estimateData['col_position'];
                $this->allAddedEstimatesData[$count]['rate_type'] = $estimateData['operation'];
                $this->allAddedEstimatesData[$count]['arrayIndex'] = $estimateData['row_index'];
                $this->allAddedEstimatesData[$count]['array_id'] = $estimateData['row_id'];
                $this->allAddedEstimatesData[$count]['operation'] = $estimateData['operation'];
                if ($this->allAddedEstimatesData[$count]['operation'] == "Total") {
                    $this->reset('totalOnSelectedCount');
                    $this->totalOnSelectedCount = $this->totalOnSelectedCount + 1;
                    Session()->put('editProjectEstimationTotal' . $this->editEstimate_id, $this->totalOnSelectedCount);
                }
                $this->allAddedEstimatesData[$count]['remarks'] = $estimateData['comments'];
                // $this->allAddedEstimatesData[count($this->allAddedEstimatesData) + 1]['created_by'] = $estimateData['created_by'];
                if ($estimateData['qty_analysis_data'] != '') {
                    $this->getQtySessionData[$estimateData['row_id']] = json_decode($estimateData['qty_analysis_data'], true);
                    if ($this->getQtySessionData[$estimateData['row_id']] != '') {
                        $this->allAddedEstimatesData[$count]['qtyUpdate'] = true;
                    }
                }
            }
            //dd($this->allAddedEstimatesData);
            Session()->put('editProjectEstimateV2Data' . $this->editEstimate_id, $this->allAddedEstimatesData);
            Session()->put('editProjectEstimateDesc' . $this->editEstimate_id, $this->sorMasterDesc);
            Session()->put('editProjectEstimatePartNo' . $this->editEstimate_id, $this->part_no);
            Session()->put('editModalDataV2', $this->getQtySessionData);
            $this->autoCalculateTotal();
        }
    }

    public function updateSetFetchData($fetchUpdateRateData, $update_id)
    {
       // dd($fetchUpdateRateData,$update_id);
        foreach ($this->allAddedEstimatesData as $key => $estimate) {
            if ($estimate['array_id'] == $update_id) {

                if (!empty($fetchUpdateRateData['estimate_no'])) {
                    $this->allAddedEstimatesData[$key]['estimate_no'] = $fetchUpdateRateData['estimate_no'];
                }
                if (!empty($fetchUpdateRateData['rate_no'])) {
                    $this->allAddedEstimatesData[$key]['rate_no'] = $fetchUpdateRateData['rate_no'];
                }
                if (!empty($fetchUpdateRateData['dept_id'])) {
                    $this->allAddedEstimatesData[$key]['dept_id'] = $fetchUpdateRateData['dept_id'];
                }
                if (!empty($fetchUpdateRateData['dept_category_id'])) {
                    $this->allAddedEstimatesData[$key]['category_id'] = $fetchUpdateRateData['dept_category_id'];
                }
                if (!empty($fetchUpdateRateData['item_number'])) {
                    $this->allAddedEstimatesData[$key]['sor_item_number'] = $fetchUpdateRateData['item_number'];
                }
                if (!empty($fetchUpdateRateData['volume'])) {
                    $this->allAddedEstimatesData[$key]['volume_no'] = $fetchUpdateRateData['volume'];
                }
                if (!empty($fetchUpdateRateData['table_no'])) {
                    $this->allAddedEstimatesData[$key]['table_no'] = $fetchUpdateRateData['table_no'];
                }
                if (!empty($fetchUpdateRateData['page_no'])) {
                    $this->allAddedEstimatesData[$key]['page_no'] = $fetchUpdateRateData['page_no'];
                }
                if (!empty($fetchUpdateRateData['sor_id'])) {
                    $this->allAddedEstimatesData[$key]['sor_id'] = $fetchUpdateRateData['sor_id'];
                }
                if (!empty($fetchUpdateRateData['item_index'])) {
                    $this->allAddedEstimatesData[$key]['item_index'] = $fetchUpdateRateData['item_index'];
                }
                if (!empty($fetchUpdateRateData['item_name'])) {
                    $this->allAddedEstimatesData[$key]['item_name'] = $fetchUpdateRateData['item_name'];
                }
                if (!empty($fetchUpdateRateData['other_name'])) {
                    $this->allAddedEstimatesData[$key]['other_name'] = $fetchUpdateRateData['other_name'];
                }
                if (!empty($fetchUpdateRateData['description'])) {
                    $this->allAddedEstimatesData[$key]['description'] = $fetchUpdateRateData['description'];
                }
                if (!empty($fetchUpdateRateData['qty'])) {
                    $this->allAddedEstimatesData[$key]['qty'] = $fetchUpdateRateData['qty'];
                }
                if (!empty($fetchUpdateRateData['rate'])) {
                    $this->allAddedEstimatesData[$key]['rate'] = $fetchUpdateRateData['rate'];
                }
                if (!empty($fetchUpdateRateData['total_amount'])) {
                    $this->allAddedEstimatesData[$key]['total_amount'] = $fetchUpdateRateData['total_amount'];
                }
                if (!empty($fetchUpdateRateData['operation'])) {
                    $this->allAddedEstimatesData[$key]['operation'] = $fetchUpdateRateData['operation'];
                }
                if (!empty($fetchUpdateRateData['col_position'])) {
                    $this->allAddedEstimatesData[$key]['col_position'] = $fetchUpdateRateData['col_position'];
                }
                if (!empty($fetchUpdateRateData['is_row'])) {
                    $this->allAddedEstimatesData[$key]['is_row'] = $fetchUpdateRateData['is_row'];
                }
                if (!empty($fetchUpdateRateData['rate_type'])) {
                    $this->allAddedEstimatesData[$key]['rate_type'] = $fetchUpdateRateData['rate_type'];
                }
                if (!empty($fetchUpdateRateData['unit_id'])) {
                    $this->allAddedEstimatesData[$key]['unit_id'] = $fetchUpdateRateData['unit_id'];
                }
                if(isset($this->allAddedEstimatesData[$key]['unit_id'][0]) && $this->allAddedEstimatesData[$key]['unit_id'][0] === '%' ){
                    $this->allAddedEstimatesData[$key]['total_amount'] = $this->allAddedEstimatesData[$key]['total_amount'] / 100;
                }
                if (isset($fetchUpdateRateData['qtyUpdate'])) {
                    $this->allAddedEstimatesData[$key]['qtyUpdate'] = $fetchUpdateRateData['qtyUpdate'];
                }
            }
        }
//dd($this->allAddedEstimatesData);
        if ($this->editEstimate_id != '') {
            Session()->put('editProjectEstimateV2Data' . $this->editEstimate_id, $this->allAddedEstimatesData);
        } else {
            Session()->put('addedProjectEstimateV2Data', $this->allAddedEstimatesData);
        }



        if ($fetchUpdateRateData != null) {
            $this->notification()->success(
                $title = 'Row Updated Successfully'
            );
        } else {
            $this->notification()->error(
                $title = 'Error Updating Row'
            );
        }

        $this->updatedEstimateRecalculate();
        $this->autoCalculateTotal();
        $this->editRowModal = !$this->editRowModal;
    }

    public function editRow($rowId)
    {

        $this->editRowId = $rowId;
        $matchedRow = null;
        if ($this->editEstimate_id != '') {
            $this->allAddedEstimatesData =  Session()->get('editProjectEstimateV2Data' . $this->editEstimate_id);
        } else {
            $this->allAddedEstimatesData = Session()->get('addedProjectEstimateV2Data', $this->allAddedEstimatesData);
        }

       // dd( $this->allAddedEstimatesData);
        foreach ($this->allAddedEstimatesData as $estimate) {
            if (isset($estimate['array_id']) && $estimate['array_id'] ==  $this->editRowId) {
                $matchedRow = $estimate;
                $matchedRow['is_v2_data'] = true;
                break;
            }
        }
        $this->editRowData = $matchedRow;

        $this->editRowModal = !$this->editRowModal;
    }
    public function closeEditModal()
    {
        $this->editRowModal = !$this->editRowModal;
    }
    public function viewModal($estimate_id)
    {
        $this->emit('openModal', $estimate_id);
    }

    public function viewRateModal($rate_no)
    {
        $this->emit('openRateAnalysisModal', $rate_no);
    }

    public function openQtyModal($key)
    {

        $this->openQtyModal = !$this->openQtyModal;
        $this->sendArrayKey = $this->allAddedEstimatesData[$key]['array_id'];
        foreach ($this->allAddedEstimatesData as $index => $estimateData) {
            if ($estimateData['array_id'] === $this->sendArrayKey) {
                if (!empty($this->allAddedEstimatesData[$key]['description'])) {
                    $this->sendArrayDesc = $this->allAddedEstimatesData[$key]['description'];
                } elseif (!empty($this->allAddedEstimatesData[$key]['other_name'])) {
                    $this->sendArrayDesc = $this->allAddedEstimatesData[$key]['other_name'];
                } elseif (!empty($this->allAddedEstimatesData[$key]['estimate_no'])) {
                    $this->sendArrayDesc = getEstimateDescription($this->allAddedEstimatesData[$key]['estimate_no']);
                }
                if (!empty($this->allAddedEstimatesData[$key]['id'])) {
                    $this->sendRowNo = $this->allAddedEstimatesData[$key]['id'];
                }

            }
        }
        $this->arrayCount = count($this->allAddedEstimatesData);
    }

    public function submitGrandTotal($grandtotal, $key)
    {
        if (!empty($grandtotal) || !empty($key)) {
            foreach ($this->allAddedEstimatesData as $index => $estimateData) {
                if ($estimateData['array_id'] === $this->sendArrayKey) {
                    //dd("submit grnad total");
                    $this->allAddedEstimatesData[$index]['qty'] = ($grandtotal == 0) ? 1 : $grandtotal;
                    $qtySessionData = ($this->editEstimate_id == '') ? session('modalDataV2') : session('editModalDataV2');
                    if ($grandtotal == 0) {

                        unset($qtySessionData[$key]);
                        if ($this->editEstimate_id == '') {
                            Session()->forget('modalDataV2');
                            Session()->put('modalDataV2', $qtySessionData);
                        } else {
                            Session()->forget('editModalDataV2');
                            Session()->put('editModalDataV2', $qtySessionData);
                        }
                        $this->allAddedEstimatesData[$index]['qtyUpdate'] = false;
                    } else {
                        if ($this->editEstimate_id == '') {
                           // Session()->forget('modalDataV2');
                            Session()->put('modalDataV2', $qtySessionData);
                        } else {
                          //  Session()->forget('editModalDataV2');
                            Session()->put('editModalDataV2', $qtySessionData);
                        }
                        $this->allAddedEstimatesData[$index]['qtyUpdate'] = true;
                    }
                    $this->calculateValue($index);
                }
            }
            if ($this->editEstimate_id == '') {
                Session()->put('addedProjectEstimateV2Data', $this->allAddedEstimatesData);
                $this->reset('addedEstimateData');
            } else {
                Session()->put('editProjectEstimateV2Data' . $this->editEstimate_id, $this->allAddedEstimatesData);
                $this->reset('addedEstimateData');
            }
            $this->updatedEstimateRecalculate();
            $this->autoCalculateTotal();
            $this->notification()->success(
                $title = 'Quantity Added Successfully'
            );
        }
    }
    public function closeAndReset($grandtotal, $key)
    {
        if (!empty($grandtotal) || !empty($key)) {
            $grandtotal = 0;
            foreach ($this->allAddedEstimatesData as $index => $estimateData) {
                if ($estimateData['array_id'] === $this->sendArrayKey) {
                    $this->allAddedEstimatesData[$index]['qty'] = ($grandtotal == 0) ? 1 : $grandtotal;
                    $sessionData = ($this->editEstimate_id == '') ? Session()->get('modalDataV2') : Session()->get('editModalDataV2');
                    if ($grandtotal == 0) {
                        $qtySessionData = ($this->editEstimate_id == '') ? session('modalDataV2') : session('editModalDataV2');
                        unset($qtySessionData[$key]);
                        if ($this->editEstimate_id == '') {
                            Session()->forget('modalDataV2');
                            Session()->put('modalDataV2', $qtySessionData);
                        } else {
                            Session()->forget('editModalDataV2');
                            Session()->put('editModalDataV2', $qtySessionData);
                        }
                        $this->allAddedEstimatesData[$index]['qtyUpdate'] = false;
                    } else {
                        $this->allAddedEstimatesData[$index]['qtyUpdate'] = true;
                    }
                    $this->calculateValue($index);
                }
            }
            if ($this->editEstimate_id == '') {
                Session()->put('addedProjectEstimateV2Data', $this->allAddedEstimatesData);
                $this->reset('addedEstimateData');
            } else {
                Session()->put('editProjectEstimateV2Data' . $this->editEstimate_id, $this->allAddedEstimatesData);
                $this->reset('addedEstimateData');
            }

        }
    }
    public function updatedEstimateRecalculate()
    {
        $result = 0;
        $stringCalc = new StringCalc();
        foreach ($this->allAddedEstimatesData as $key => $value) {
            if ($value['arrayIndex'] != '') {
                try {
                    if ($value['arrayIndex']) {
                        $pattern = '/([-+*\/%])|([a-zA-Z0-9]+)/';
                        preg_match_all($pattern, $value['arrayIndex'], $matches);
                        foreach (array_merge($matches[0]) as $k => $info) {
                            if (htmlspecialchars($info) == "%") {
                                $value['arrayIndex'] = str_replace($info, "/100*", $value['arrayIndex'], $k);
                            } else {
                                foreach ($this->allAddedEstimatesData as $data) {
                                    if ($data['array_id'] == $info) {
                                        if ($data['total_amount'] != '') {
                                            $value['arrayIndex'] = str_replace($info, $data['total_amount'], $value['arrayIndex'], $k);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $result = $stringCalc->calculate($value['arrayIndex']);
                    $this->allAddedEstimatesData[$key]['total_amount'] = round($result);
                    if ($this->editEstimate_id == '') {
                        Session()->put('addedProjectEstimateV2Data', $this->allAddedEstimatesData);
                        $this->reset('addedEstimateData');
                    } else {
                        Session()->put('editProjectEstimateV2Data' . $this->editEstimate_id, $this->allAddedEstimatesData);
                        $this->reset('addedEstimateData');
                    }
                } catch (\Exception $exception) {
                    $this->dispatchBrowserEvent('alert', [
                        'type' => 'error',
                        'message' => $exception->getMessage(),
                    ]);
                }
            }
        }
    }

    public function closeUnitModal()
    {
        $this->openQtyModal = !$this->openQtyModal;
    }

    private function findItemByArrayId($data, $arrayId)
    {
        foreach ($data as &$item) {
            if ($item['array_id'] === $arrayId) {
                return $item;
            }
        }

        return null;
    }

    public function calculateValue($key)
    {
        // dd($this->allAddedEstimatesData[$key]);
        if ($this->allAddedEstimatesData[$key]['rate'] > 0) {
            $this->allAddedEstimatesData[$key]['qty'] = number_format(round($this->allAddedEstimatesData[$key]['qty'], 3), 3);
            $this->allAddedEstimatesData[$key]['qty'] = str_replace(',', '', $this->allAddedEstimatesData[$key]['qty']);
            $this->allAddedEstimatesData[$key]['rate'] = number_format(round($this->allAddedEstimatesData[$key]['rate'], 2), 2);
            $this->allAddedEstimatesData[$key]['rate'] = str_replace(',', '', $this->allAddedEstimatesData[$key]['rate']);
            $this->allAddedEstimatesData[$key]['total_amount'] = (str_contains($this->allAddedEstimatesData[$key]['unit_id'], '%')) ? (($this->allAddedEstimatesData[$key]['qty'] * $this->allAddedEstimatesData[$key]['rate']) / 100) : $this->allAddedEstimatesData[$key]['qty'] * $this->allAddedEstimatesData[$key]['rate'];
            $this->allAddedEstimatesData[$key]['total_amount'] = number_format(round($this->allAddedEstimatesData[$key]['total_amount']), 2);
            $this->allAddedEstimatesData[$key]['total_amount'] = str_replace(',', '', $this->allAddedEstimatesData[$key]['total_amount']);
            // $this->allAddedEstimatesData[$key]['rate'] = $this->allAddedEstimatesData[$key]['rate'];
            // $this->reset('other_rate');
        } else {
            $this->allAddedEstimatesData[$key]['rate'] = 0;
            $this->allAddedEstimatesData[$key]['total_amount'] = 0;
        }
        // if ($this->allAddedEstimatesData[$key]['unit_id'][0] === '%') {
        //     $this->allAddedEstimatesData[$key]['total_amount'] = round($this->allAddedEstimatesData[$key]['total_amount'] / 100);
        // }
    }

    public function insertAddEstimate($arrayIndex, $dept_id, $category_id, $sor_item_number, $item_name, $other_name, $description, $qty, $rate, $total_amount, $operation, $version, $remarks)
    {
        $this->addedEstimateData['arrayIndex'] = $arrayIndex;
        $this->addedEstimateData['dept_id'] = $dept_id;
        $this->addedEstimateData['category_id'] = $category_id;
        $this->addedEstimateData['sor_item_number'] = $sor_item_number;
        $this->addedEstimateData['item_name'] = $item_name;
        $this->addedEstimateData['other_name'] = $other_name;
        $this->addedEstimateData['description'] = $description;
        $this->addedEstimateData['qty'] = $qty;
        $this->addedEstimateData['rate'] = $rate;
        $this->addedEstimateData['total_amount'] = $total_amount;
        $this->addedEstimateData['operation'] = $operation;
        $this->addedEstimateData['version'] = $version;
        $this->addedEstimateData['remarks'] = $remarks;
        $this->setEstimateDataToSession();
        $this->resetExcept('allAddedEstimatesData', 'sorMasterDesc', 'totalOnSelectedCount', 'part_no', 'getQtySessionData', 'editEstimate_id');
    }

    public function expCalc()
    {
        //dd($this->allAddedEstimatesData);

        $result = 0;
        $tempIndex = strtoupper($this->expression);
        $stringCalc = new StringCalc();
        try {
            $pattern = '/([-+*\/%])|([a-zA-Z0-9]+)/';
            preg_match_all($pattern, strtoupper($this->expression), $matches);
            $this->expression = strtoupper($this->expression);
            foreach (array_merge($matches[0]) as $key => $info) {
                foreach ($this->allAddedEstimatesData as $k => $data) {
                    if ($data['array_id'] == $info) {
                        $this->expression = str_replace($info, $this->allAddedEstimatesData[$k]['total_amount'], $this->expression, $key);
                    }
                }
                if (htmlspecialchars($info) == "%") {
                    $this->expression = str_replace($info, "/100*", $this->expression, $key);
                }
            }

            //dd($this->expression);
            $result = $stringCalc->calculate($this->expression);
            $this->insertAddEstimate($tempIndex, 0, 0, 0, '', '', '', 0, 0, round($result, 2), 'Exp Calculation', '', $this->remarks);
        } catch (\Exception $exception) {
            $this->expression = $tempIndex;
            $this->notification()->error(
                $title = $exception->getMessage()
            );
        }
    }

    public function selectAll()
    {
        if ($this->selectCheckBoxs) {
            $this->level = collect($this->allAddedEstimatesData)->pluck('array_id')->toArray();
        } else {
            $this->level = [];
        }
        $this->showTotalButton();
    }

    public function showTotalButton()
    {
        //for check select all check box
        if (count($this->level) != count($this->allAddedEstimatesData)) {
            $this->selectCheckBoxs = false;
        } else if (count($this->level) == count($this->allAddedEstimatesData)) {
            $this->selectCheckBoxs = true;
        } else {
            return;
        }
        if (count($this->level) >= 1 && $this->totalOnSelectedCount == 0) {
            $this->openTotalButton = true;
        } else {
            $this->openTotalButton = false;
        }
    }

    public function totalOnSelected()
    {
        if (count($this->level) >= 1) {
            $result = 0;
            foreach ($this->level as $key => $array) {
                // $this->arrayStore[] = chr($array + 64);
                $this->arrayStore[] = $array;
                foreach ($this->allAddedEstimatesData as $k => $value) {
                    if ($value['array_id'] == $array) {
                        $result = $result + $this->allAddedEstimatesData[$k]['total_amount'];
                    }
                }
            }
            $this->arrayIndex = implode('+', $this->arrayStore); //chr($this->indexCount + 64)
            $this->insertAddEstimate($this->arrayIndex, 0, 0, 0, '', '', '', 0, 0, round($result), 'Total', '', '');
            if ($this->editEstimate_id == '') {
                $this->totalOnSelectedCount = $this->totalOnSelectedCount + 1;
                Session()->put('projectEstimationTotal', $this->totalOnSelectedCount);
            } else {
                $this->totalOnSelectedCount = $this->totalOnSelectedCount + 1;
                Session()->put('editProjectEstimationTotal' . $this->editEstimate_id, $this->totalOnSelectedCount);
            }
        } else {
            $this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => "Minimum select Check boxes first",
            ]);
        }
    }

    public function setEstimateDataToSession()
    {
        $this->reset('allAddedEstimatesData');
        if ($this->editEstimate_id != '') {
            if (Session()->has('editProjectEstimateV2Data' . $this->editEstimate_id)) {
                $this->allAddedEstimatesData = Session()->get('editProjectEstimateV2Data' . $this->editEstimate_id);
            }
            if (Session()->has('editProjectEstimationTotal' . $this->editEstimate_id)) {
                $this->totalOnSelectedCount = Session()->get('editProjectEstimationTotal' . $this->editEstimate_id);
            }
            //Todo::change with editModalDataV2
            if (Session()->has('editModalDataV2')) {
                $this->getQtySessionData = Session()->get('editModalDataV2');
            }
        } else {
            if (Session()->has('addedProjectEstimateV2Data')) {
                $this->allAddedEstimatesData = Session()->get('addedProjectEstimateV2Data');
                if (Session()->has('projectEstimationTotal')) {
                    $this->totalOnSelectedCount = Session()->get('projectEstimationTotal');
                }
                if (Session()->has('modalDataV2')) {
                    $this->getQtySessionData = Session()->get('modalDataV2');
                }
            }
        }
        //  dd($this->allAddedEstimatesData);
        // dd($this->addedEstimateData);
        if ($this->addedEstimateData != null) {
            $index = count($this->allAddedEstimatesData) + 1;
            // dd($index);
            if (!array_key_exists("operation", $this->addedEstimateData)) {
                $this->addedEstimateData['operation'] = '';
            }
            if (!array_key_exists("array_id", $this->addedEstimateData)) {
                $this->addedEstimateData['array_id'] = $this->part_no . $index;
            }
            if (!array_key_exists("arrayIndex", $this->addedEstimateData)) {
                $this->addedEstimateData['arrayIndex'] = '';
            }
            if (!array_key_exists("remarks", $this->addedEstimateData)) {
                $this->addedEstimateData['remarks'] = '';
            }
            if (!array_key_exists("estimate_no", $this->addedEstimateData)) {
                $this->addedEstimateData['estimate_no'] = 0;
            }
            if (!array_key_exists("rate_no", $this->addedEstimateData)) {
                $this->addedEstimateData['rate_no'] = 0;
            }
            if (!array_key_exists("volume_no", $this->addedEstimateData)) {
                $this->addedEstimateData['volume_no'] = 0;
            }
            if (!array_key_exists("sor_id", $this->addedEstimateData)) {
                $this->addedEstimateData['sor_id'] = 0;
            }
            if (!array_key_exists("item_index", $this->addedEstimateData)) {
                $this->addedEstimateData['item_index'] = 0;
            }
            if (!array_key_exists("table_no", $this->addedEstimateData)) {
                $this->addedEstimateData['table_no'] = 0;
            }
            if (!array_key_exists("page_no", $this->addedEstimateData)) {
                $this->addedEstimateData['page_no'] = 0;
            }
            if (!array_key_exists("col_position", $this->addedEstimateData)) {
                $this->addedEstimateData['col_position'] = 0;
            }
            if (!array_key_exists("rate_type", $this->addedEstimateData)) {
                $this->addedEstimateData['rate_type'] = '';
            }
            if (!array_key_exists("unit_id", $this->addedEstimateData)) {
                $this->addedEstimateData['unit_id'] = '';
            }
            if (!array_key_exists("rate_det", $this->addedEstimateData)) {
                $this->addedEstimateData['rate_det'] = '';
            }
            foreach ($this->addedEstimateData as $key => $estimate) {
                if ($key == "p_id") {
                    if ($estimate == 0) {
                        $matchingCount = count(array_filter($this->allAddedEstimatesData, function ($item) use ($estimate) {
                            return isset($item['p_id']) && $item['p_id'] == 0;
                        }));
                        $this->allAddedEstimatesData[$index]['id'] = $matchingCount + 1;
                    } else {
                        $matchingCount = count(array_filter($this->allAddedEstimatesData, function ($item) use ($estimate) {
                            return isset($item['p_id']) && $item['p_id'] == $this->addedEstimateData['p_id'];
                        }));
                        $this->allAddedEstimatesData[$index]['id'] = $this->addedEstimateData['p_id'] . '.' . $matchingCount + 1;
                    }
                }
                $this->allAddedEstimatesData[$index][$key] = $estimate;
            }
            $grouped = [];
            foreach ($this->allAddedEstimatesData as $item) {
                $grouped[$item['p_id']][] = $item;
            }

            // Recursive function to build the sorted array
            $result = [];
            $this->addChildren($result, $grouped, 0);
            $this->allAddedEstimatesData = $result;

            if ($this->editEstimate_id == '') {
                Session()->put('addedProjectEstimateV2Data', $this->allAddedEstimatesData);
                Session()->put('projectEstimateDesc', $this->sorMasterDesc);
                Session()->put('projectEstimatePartNo', $this->part_no);
                $this->reset('addedEstimateData');
            } else {
                Session()->put('editProjectEstimateV2Data' . $this->editEstimate_id, $this->allAddedEstimatesData);
                Session()->put('editProjectEstimateDesc' . $this->editEstimate_id, $this->sorMasterDesc);
                Session()->put('editProjectEstimatePartNo' . $this->editEstimate_id, $this->part_no);
                $this->reset('addedEstimateData');
            }
        }
        $this->autoCalculateTotal();
        // dd($result);
        // dd($this->allAddedEstimatesData);

    }
    public function addChildren(&$result, $grouped, $parentId)
    {
        if (isset($grouped[$parentId])) {
            foreach ($grouped[$parentId] as $item) {
                $result[] = $item;
                $this->addChildren($result, $grouped, $item['id']);
            }
        }
    }

    public function confDeleteDialog($value): void
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'icon' => 'error',
            'accept' => [
                'label' => 'Yes, Delete it',
                'method' => 'deleteEstimate',
                'params' => $value,
            ],
            'reject' => [
                'label' => 'No, cancel',
                // 'method' => 'cancel',
            ],
        ]);
    }
    //----for sub item---//
    public $openSubItemModal = false, $rowParentId;
    public function addSubItem($p_id)
    {
       // dd($p_id);
        $this->rowParentId = $p_id;
        $this->openSubItemModal = !$this->openSubItemModal;
    }
    public function closeSubItemModal()
    {
        $this->openSubItemModal = !$this->openSubItemModal;
    }
    public $autoTotalValue = 0, $totalArray = [];
    public function autoCalculateTotal()
    {
        $this->reset('autoTotalValue');
        foreach ($this->allAddedEstimatesData as $key => $estimate) {
            $this->autoTotalValue = $this->autoTotalValue + $estimate['total_amount'];
        }
        $this->autoTotalValue = round($this->autoTotalValue);
    }
    public function deleteEstimate($value)
    {
        $sessionData = ($this->editEstimate_id == '') ? Session()->get('modalDataV2') : Session()->get('editModalDataV2');
        if (isset($sessionData[$value])) {
            unset($sessionData[$value]);
        }
        if (is_string($value) && strpos($value, '.') !== false) {
            $matchingArrays = [];
            $updatedArrays = [];
            $remainingArrays = [];
            $valueBeforeDecimal = substr($value, 0, strpos($value, '.'));
            foreach ($this->allAddedEstimatesData as $key => $item) {
                if ($item['id'] != $value) {
                    $remainingArrays[] = $item;
                    unset($matchingArrays[$key]);
                }
            }
            foreach ($remainingArrays as $item) {
                if ($item['p_id'] == $valueBeforeDecimal) {
                    $idParts = explode('.', $item['id']);
                    if (count($idParts) > 1) {
                        if (intval($idParts[1]) > 1) {
                            $idParts[1] = intval($idParts[1]) - 1;
                        }
                        $item['id'] = $idParts[0] . '.' . $idParts[1];
                    } else {
                        if (intval($idParts[0]) > 1) {
                            $item['id'] = intval($idParts[0]) - 1;
                        } else {
                            $item['id'] = $idParts[0];
                        }
                    }
                    $updatedArrays[] = $item;
                } else {
                    $updatedArrays[] = $item;
                }
            }
        } else {
            $filteredData = [];
            foreach ($this->allAddedEstimatesData as $estimate) {
                if ($estimate['id'] != $value && $estimate['p_id'] != $value) {
                    $filteredData[] = $estimate;
                }
            }
            $adjustedData = [];
            $idMap = [];
            foreach ($filteredData as $estimate) {
                $idParts = explode('.', $estimate['id']);
                $mainId = $idParts[0];
                if (is_numeric($mainId) && $mainId > 1) {
                    if (!isset($idMap[$mainId])) {
                        $idMap[$mainId] = count($idMap) + 1;
                    }
                    $newMainId = $idMap[$mainId];
                    if (count($idParts) > 1) {
                        $newId = $newMainId . '.' . $idParts[1];
                    } else {
                        $newId = (string) $newMainId;
                    }
                    $estimate['id'] = $newId;
                }
                $pIdParts = explode('.', $estimate['p_id']);
                $pMainId = $pIdParts[0];
                if (is_numeric($pMainId) && $pMainId > 0) {
                    if (!isset($idMap[$pMainId])) {
                        $idMap[$pMainId] = count($idMap) + 1;
                    }
                    $newPMainId = $idMap[$pMainId];
                    if (count($pIdParts) > 1) {
                        $newPId = $newPMainId . '.' . $pIdParts[1];
                    } else {
                        $newPId = (string) $newPMainId;
                    }
                    $estimate['p_id'] = $newPId;
                }
                $adjustedData[] = $estimate;
            }
        }
        if (!empty($updatedArrays)) {
            $this->allAddedEstimatesData = $updatedArrays;
        } else {
            $this->allAddedEstimatesData = $adjustedData;
        }
        if ($this->editEstimate_id == '') {
            Session()->forget('addedProjectEstimateV2Data');
            Session()->put('addedProjectEstimateV2Data', $this->allAddedEstimatesData);
            Session()->put('modalDataV2', $sessionData);
        } else {
            Session()->forget('editProjectEstimateV2Data' . $this->editEstimate_id);
            Session()->put('editProjectEstimateV2Data' . $this->editEstimate_id, $this->allAddedEstimatesData);
            Session()->put('editModalDataV2', $sessionData);
        }
        $this->level = [];
        if ($this->totalOnSelectedCount >= 1) {
            $this->reset('totalOnSelectedCount');
            ($this->editEstimate_id == '') ? Session()->forget('projectEstimationTotal') : Session()->forget('editProjectEstimationTotal' . $this->editEstimate_id);
        }
        $this->notification()->error(
            $title = 'Row Deleted Successfully'
        );
        $this->autoCalculateTotal();
    }

    public function exportWord()
    {
        $exportDatas = array_values($this->allAddedEstimatesData);
        // dd($exportDatas);
        $date = date('Y-m-d');
        $pw = new \PhpOffice\PhpWord\PhpWord();
        $section = $pw->addSection(
            array(
                'marginLeft' => 600,
                'marginRight' => 200,
                'marginTop' => 600,
                'marginBottom' => 200,
            )
        );
        $html = "<h1 style='font-size:24px;font-weight:600;text-align: center;'>Project Estimate Preparation Details</h1>";
        $html .= "<p>Projected Estimate Details List</p>";
        $html .= "<table style='border: 1px solid black;width:auto'><tr>";
        $html .= "<th scope='col' style='text-align: center'>Serial No.</th>";
        $html .= "<th scope='col' style='text-align: center'>Item Number/<br/>Project No(Ver.)</th>";
        $html .= "<th scope='col' style='text-align: center'>Description</th>";
        $html .= "<th scope='col' style='text-align: center'>Quantity</th>";
        $html .= "<th scope='col' style='text-align: center'>Unit Price</th>";
        $html .= "<th scope='col' style='text-align: center' >Cost</th></tr>";
        foreach ($exportDatas as $key => $export) {
            $html .= "<tr><td style='text-align: center'>" . chr($export['array_id'] + 64) . "</td>&nbsp;";
            if ($export['sor_item_number']) {
                $html .= "<td style='text-align: center'>" . getSorItemNumber($export['sor_item_number']) . ' ( ' . $export['version'] . ' )' . "</td>&nbsp;";
            } elseif ($export['estimate_no']) {
                $html .= "<td style='text-align: center'>" . $export['estimate_no'] . "</td>&nbsp;";
            } else {
                $html .= "<td style='text-align: center'>--</td>&nbsp;";
            }
            if ($export['description']) {
                $html .= "<td style='text-align: center'>" . $export['description'] . "</td>&nbsp;";
            } elseif ($export['operation']) {
                if ($export['operation'] == 'Total') {
                    $html .= "<td style='text-align: center'> Total of (" . $export['arrayIndex'] . " )</td>&nbsp;";
                } else {
                    if ($export['remarks'] != '') {
                        $html .= "<td style='text-align: center'> " . $export['arrayIndex'] . " ( " . $export['remarks'] . " )" . "</td>&nbsp;";
                    } else {
                        $html .= "<td style='text-align: center'> " . $export['arrayIndex'] . "</td>&nbsp;";
                    }
                }
            } elseif ($export['other_name']) {
                $html .= "<td style='text-align: center'>" . $export['other_name'] . "</td>&nbsp;";
            } else {
                // $html .= "<td style='text-align: center'>" . $export['name'] . "</td>&nbsp;";
                $html .= "<td style='text-align: center'>--</td>&nbsp;";
            }
            $html .= "<td style='text-align: center'>" . $export['qty'] . "</td>&nbsp;";
            $html .= "<td style='text-align: center'>" . $export['rate'] . "</td>&nbsp;";
            $html .= "<td style=''>" . $export['total_amount'] . "</td></tr>";
        }
        $html .= "</table>";
        foreach ($exportDatas as $key => $export) {
            if ($export['estimate_no']) {
                $html .= "<p>Estimate Packege " . $export['estimate_no'] . "</p>";
                $getEstimateDetails = EstimatePrepare::where('estimate_id', '=', $export['estimate_no'])->get();
                $html .= "<table style='border: 1px solid black;width:auto'><tr>";
                $html .= "<th scope='col' style='text-align: center'>Serial No.</th>";
                $html .= "<th scope='col' style='text-align: center'>Item Number(Ver.)</th>";
                $html .= "<th scope='col' style='text-align: center'>Description</th>";
                $html .= "<th scope='col' style='text-align: center'>Quantity</th>";
                $html .= "<th scope='col' style='text-align: center'>Unit Price</th>";
                $html .= "<th scope='col' style='text-align: center' >Cost</th></tr>";
                if (isset($getEstimateDetails)) {
                    foreach ($getEstimateDetails as $estimateDetails) {
                        $html .= "<tr><td style='text-align: center'>" . chr($estimateDetails['row_id'] + 64) . "</td>&nbsp;";
                        if ($estimateDetails['sor_item_number']) {
                            $html .= "<td style='text-align: center'>" . getSorItemNumber($estimateDetails['sor_item_number']) . ' ( ' . $estimateDetails['version'] . ' )' . "</td>&nbsp;";
                        } else {
                            $html .= "<td style='text-align: center'>--</td>&nbsp;";
                        }
                        if ($estimateDetails['sor_item_number']) {
                            $html .= "<td style='text-align: center'>" . getSorItemNumberDesc($estimateDetails['sor_item_number']) . "</td>&nbsp;";
                        } elseif ($estimateDetails['operation']) {
                            if ($estimateDetails['operation'] == 'Total') {
                                $html .= "<td style='text-align: center'> Total of (" . $estimateDetails['row_index'] . " )</td>&nbsp;";
                            } else {
                                if ($estimateDetails['comments'] != '') {
                                    $html .= "<td style='text-align: center'> " . $estimateDetails['row_index'] . " ( " . $estimateDetails['comments'] . " )" . "</td>&nbsp;";
                                } else {
                                    $html .= "<td style='text-align: center'> " . $estimateDetails['row_index'] . "</td>&nbsp;";
                                }
                            }
                        } else {
                            $html .= "<td style='text-align: center'>" . $estimateDetails['other_name'] . "</td>&nbsp;";
                        }
                        $html .= "<td style='text-align: center'>" . $estimateDetails['qty'] . "</td>&nbsp;";
                        $html .= "<td style='text-align: center'>" . $estimateDetails['rate'] . "</td>&nbsp;";
                        $html .= "<td style=''>" . $estimateDetails['total_amount'] . "</td></tr>";
                    }
                }

                $html .= "</table>";
            }
        }

        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
        $pw->save($date . ".docx", "Word2007");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment;filename=\"convert.docx\"");
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($pw, "Word2007");
        // dd($objWriter);
        $objWriter->save($date . '.docx');
        return response()->download($date . '.docx')->deleteFileAfterSend(true);
        $this->reset('exportDatas');
    }

    public function store($flag = '')
    {
        // dd($this->allAddedEstimatesData);
        $this->getQtySessionData = ($this->editEstimate_id == '') ? Session()->get('modalDataV2') : Session()->get('editModalDataV2');
        if ($this->autoTotalValue != 0 || $flag == 'draft') {
            try {
                if ($this->allAddedEstimatesData) {
                    $intId = ($this->editEstimate_id == '') ? random_int(100000, 999999) : $this->editEstimate_id;
                    if (($this->editEstimate_id != '') ? EstimateMasterV2::where('estimate_id', $intId)->update(['estimate_master_desc' => $this->sorMasterDesc, 'status' => ($flag == 'draft') ? 12 : 1, 'created_by' => Auth::user()->id, 'total_amount' => $this->autoTotalValue]) : EstimateMasterV2::create(['estimate_id' => $intId, 'estimate_master_desc' => $this->sorMasterDesc, 'status' => ($flag == 'draft') ? 12 : 1, 'dept_id' => Auth::user()->department_id, 'part_no' => $this->part_no, 'created_by' => Auth::user()->id, 'total_amount' => $this->autoTotalValue])) {
                        if ($this->editEstimate_id != '') {
                            EstimatePrepareV2::where('estimate_id', $intId)->delete();
                        }
                        foreach ($this->allAddedEstimatesData as $key => $value) {
                            $insert = [
                                'estimate_id' => $intId,
                                'estimate_no' => $value['estimate_no'],
                                'description' => $value['description'],
                                'rate_id' => $value['rate_no'],
                                'dept_id' => $value['dept_id'],
                                'category_id' => $value['category_id'],
                                'row_id' => $value['array_id'],
                                'sl_no' => $value['id'],
                                'p_id' => $value['p_id'],
                                'row_index' => $value['arrayIndex'],
                                'sor_item_number' => $value['sor_item_number'],
                                'item_name' => $value['item_name'],
                                'other_name' => $value['other_name'],
                                'qty' => $value['qty'],
                                'rate' => $value['rate'],
                                'rate_det' => (isset($value['rate_det'])) ? $value['rate_det'] : '',
                                'total_amount' => $value['total_amount'],
                                'operation' => $value['operation'],
                                'created_by' => Auth::user()->id,
                                'comments' => $value['remarks'],
                                'page_no' => $value['page_no'],
                                'table_no' => $value['table_no'],
                                'volume_no' => $value['volume_no'],
                                'sor_id' => $value['sor_id'],
                                'item_index' => $value['item_index'],
                                'col_position' => $value['col_position'],
                                'unit_id' => ($value['unit_id'] != '') ? $value['unit_id'] : 0,
                                'qty_analysis_data' => (isset($this->getQtySessionData[$value['array_id']])) ? json_encode($this->getQtySessionData[$value['array_id']]) : null,

                            ];
                            if (isset($value['qtyUpdate'])) {
                                $insert['qtyUpdate'] = $value['qtyUpdate'];
                            }

                            // dd($insert);
                            // $validateData = Validator::make($insert, [
                            //     'estimate_id' => 'required|integer',
                            //     'dept_id' => 'required|integer',
                            //     'category_id' => 'required|integer',
                            //     'row_id' => 'required|integer',
                            // ]);
                            // if ($validateData->fails()) {
                            //     $this->notification()->error(
                            //         $title = 'Please check all the fields'
                            //     );
                            // }
                            //-----------store on another table start----------//
                            // if (Session()->has('modalDataV2')) {
                            //     $modalQtyData = Session()->get('modalDataV2');
                            //     if (isset($modalQtyData[$value['array_id']])) {
                            //         $insertQtyAnalysisData = [
                            //             'estimate_id' => $intId,
                            //             'rate_id' => (isset($value['rate_no'])) ? $value['rate_no'] : '',
                            //             'row_id' => $value['array_id'],
                            //             'row_data' => json_encode($modalQtyData[$value['array_id']]),
                            //             'type' => $value['item_name'],
                            //             'sor_id' => (isset($value['sor_id'])) ? $value['sor_id'] : '',
                            //             'sor_item_index' => (isset($value['item_index'])) ? $value['item_index'] : '',
                            //             'created_by' => Auth::user()->id,
                            //         ];
                            //         SpecificQuantityAnalysis::create($insertQtyAnalysisData);
                            //     }
                            // }
                            //------------End-------------------------------//
                            // foreach ($existingEstimates as $i) {
                            //     $existingEstimate = array_filter($this->allAddedEstimatesData, function ($item) use ($i) {
                            //         return $item['array_id'] === $i['row_id'];
                            //     });
                            //     if ($existingEstimate!='') {
                            //         foreach ($existingEstimate as $e) {
                            //             $existingEstimate = $e;
                            //         }
                            //         // dd($existingEstimate[1]['array_id']);
                            //         $array_id = $existingEstimate['array_id'];
                            //         // dd($array_id);
                            //         $existingEstimate = $existingEstimates->where('row_id', $array_id)->first();
                            //         // Update existing row
                            //         $existingEstimate->update($insert);
                            //     } else {
                            //         // dd('else');
                            //         EstimatePrepare::where('estimate_id', $intId)->where('row_id', $i['row_id'])->delete();
                            // Create new row
                            EstimatePrepareV2::create($insert);
                            //     }
                            //     $existingEstimate = '';
                            // }
                            // EstimatePrepare::updateOrCreate(['estimate_id' => $intId],$insert);
                        }

                        $data = [
                            'estimate_id' => $intId,
                            'estimate_user_type' => 5,
                            'status' => 1,
                            'user_id' => Auth::user()->id,
                        ];
                        $getData = EstimateUserAssignRecord::where([['estimate_id', $intId], ['is_done', 0]])->get();
                        if (count($getData) == 1) {
                            EstimateUserAssignRecord::where([['estimate_id', $intId], ['is_done', 0]])->update(['status' => ($flag == 'draft') ? 12 : 1]);
                        } else {
                            EstimateUserAssignRecord::create($data);
                        }
                        $this->notification()->success(
                            $title = ($flag != 'draft') ? 'Project Estimatev2 Created Successfully!!' : 'Project Estimatev2 Drafted Successfully!!'
                        );
                        $this->resetSession();
                        $this->updateDataTableTracker = rand(1, 1000);
                        $this->emit('openForm');
                        $this->emit('refreshData');
                    }
                } else {
                    $this->notification()->error(
                        $title = 'please insert at list one item !!'
                    );
                }
            } catch (\Throwable $th) {
                // session()->flash('serverError', $th->getMessage());
                $this->emit('showError', $th->getMessage());
            }
        } else {
            $this->notification()->error(
                $title = 'Please Calculate total first !!'
            );
        }

    }

    public function render()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        $this->arrayRow = count($this->allAddedEstimatesData);
        return view('livewire.estimate-project-v2.added-estimate-project-list');
    }
}
