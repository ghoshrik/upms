<?php

namespace App\Http\Livewire\RateAnalysis;

use App\Models\DynamicSorHeader;
use App\Models\EstimatePrepare;
use App\Models\RatesAnalysis;
use App\Services\CommonFunction;
use ChrisKonnertz\StringCalc\StringCalc;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use WireUi\Traits\Actions;

class AddRateAnalysisList extends Component
{
    use Actions;
    protected $listeners = ['closeModal1', 'getRatePlaceWise', 'closeItemModal', 'submitItemModal'];
    public $addedEstimateData = [];
    public $allAddedEstimatesData = [];
    public $expression, $remarks, $level = [], $openTotalButton = false, $arrayStore = [], $totalEstimate = 0, $arrayIndex, $arrayRow, $sorMasterDesc, $updateDataTableTracker, $totalOnSelectedCount = 0;
    public $selectSor, $totalDistance, $other_rate,$part_no;
    public function mount()
    {
        $this->setEstimateDataToSession();
    }

    public function resetSession()
    {
        Session()->forget('addedRateAnalysisData');
        $this->reset();
    }
    public function viewModal($rate_id)
    {
        $this->emit('openModal', $rate_id);
    }
    //calculate estimate list
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
        if ($this->selectSor['sor_id'] != '' && $this->addedEstimateData['operation'] == 'Total' || $this->addedEstimateData['operation'] == 'With Stacking' || $this->addedEstimateData['operation'] == 'Without Stacking') {
            $this->addedEstimateData['sor_id'] = $this->selectSor['sor_id'];
            $this->addedEstimateData['table_no'] = $this->selectSor['table_no'];
            $this->addedEstimateData['page_no'] = $this->selectSor['page_no'];
            $this->addedEstimateData['volume_no'] = $this->selectSor['volume'];
            $this->addedEstimateData['item_index'] = (isset($this->selectSor['item_index'])) ? $this->selectSor['item_index'] : 0;
            $this->addedEstimateData['col_position'] = (isset($this->selectSor['col_position'])) ? $this->selectSor['col_position'] : 0;
        }
        $this->setEstimateDataToSession();
        $this->resetExcept('allAddedEstimatesData', 'sorMasterDesc', 'totalOnSelectedCount', 'selectSor', 'hideTotalbutton', 'hideWithStackBtn', 'hideWithoutStackBtn','part_no');
    }

    public function expCalc()
    {
        $result = 0;
        $tempIndex = strtoupper($this->expression);
        $stringCalc = new StringCalc();
        try {
            $pattern = '/([-+*\/%])|([a-zA-Z0-9]+)/';
            preg_match_all($pattern, strtoupper($this->expression), $matches);
            $this->expression = strtoupper($this->expression);
            // dd(array_merge($matches[0]));
            // $result = preg_split($pattern, $this->expression, -1, PREG_SPLIT_NO_EMPTY);
            // dd($result);
            // if ($this->expression) {
            //     foreach (str_split($this->expression) as $key => $info) {
            //         dd(str_split($this->expression));
            //         $count0 = count($this->allAddedEstimatesData);
            //         if (ctype_alpha($info)) {
            //             $alphabet = strtoupper($info);
            //             $alp_id = ord($alphabet) - 64;
            //             if ($alp_id <= $count0 ) {
            //                 if ($this->allAddedEstimatesData[$alp_id]['array_id']) {
            //                     $this->expression = str_replace($info, $this->allAddedEstimatesData[$alp_id]['total_amount'], $this->expression, $key);
            //                 }
            //             } else {
            //                 $this->notification()->error(
            //                     $title = $alphabet . ' is a invalid input'
            //                 );
            //             }
            //         } elseif (htmlspecialchars($info) == "%") {
            //             $this->expression = str_replace($info, "/100*", $this->expression, $key);
            //         }
            //     }
            // }
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
            $result = $stringCalc->calculate($this->expression);
            $this->insertAddEstimate($tempIndex, Session::get('user_data.department_id'), 0, 0, '', '', '', 0, 0, round($result, 2), 'Exp Calculoation', '', $this->remarks);
        } catch (\Exception $exception) {
            $this->expression = $tempIndex;
            $this->notification()->error(
                $title = $exception->getMessage()
            );
        }
    }

    public function showTotalButton()
    {
        if (count($this->level) > 1) {
            $this->openTotalButton = true;
        } else {
            $this->openTotalButton = false;
        }
    }
    public $hideTotalbutton = true, $hideWithStackBtn = true, $hideWithoutStackBtn = true;
    public function totalOnSelected($flag)
    {
        if ($flag == 'With Stacking') {
            $this->hideTotalbutton = false;
            $this->hideWithStackBtn = false;
        } elseif ($flag == 'Without Stacking') {
            $this->hideTotalbutton = false;
            $this->hideWithoutStackBtn = false;
        } else {
            $this->hideWithStackBtn = false;
            $this->hideWithoutStackBtn = false;
        }
        // dd($this->hideTotalbutton,$this->hideWithStackBtn,$this->hideWithoutStackBtn);
        // sort($this->level);
        if (count($this->level) >= 1 ) { //bypass the condition
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
            if (!isset($this->selectSor['item_number'])) {
                $this->selectSor['item_number'] = 0;
            }
            $this->insertAddEstimate($this->arrayIndex, Session::get('user_data.department_id'), 0, $this->selectSor['selectedSOR'], '', '', $this->sorMasterDesc, ($this->totalDistance != '') ? $this->totalDistance : 0, 0, round($result,2), $flag, '', '');
            $this->totalOnSelectedCount++;
        } else {
            $this->notification()->error(
                $title = 'Please select minimum 2 Check boxes'
            );
        }
    }
    public function calculateValue($key)
    {
        // dd($this->allAddedEstimatesData[$key]);
        if ($this->allAddedEstimatesData[$key]['rate'] > 0) {
            $this->allAddedEstimatesData[$key]['qty'] = round($this->allAddedEstimatesData[$key]['qty'], 3);
            $this->allAddedEstimatesData[$key]['rate'] = round($this->allAddedEstimatesData[$key]['rate'], 2);
            $this->allAddedEstimatesData[$key]['total_amount'] = $this->allAddedEstimatesData[$key]['qty'] * $this->allAddedEstimatesData[$key]['rate'];
            $this->allAddedEstimatesData[$key]['total_amount'] = round($this->allAddedEstimatesData[$key]['total_amount'], 2);
            $this->allAddedEstimatesData[$key]['rate'] = $this->allAddedEstimatesData[$key]['rate'];
            // $this->reset('other_rate');
        } else {
            $this->allAddedEstimatesData[$key]['rate'] = 0;
            $this->allAddedEstimatesData[$key]['total_amount'] = 0;
        }
    }
    public function resetRate($key)
    {
        if ($this->allAddedEstimatesData[$key]['rate'] > 0) {
            $this->allAddedEstimatesData[$key]['rate'] = 0;
            $this->allAddedEstimatesData[$key]['total_amount'] = 0;
        }
    }
    public function setEstimateDataToSession()
    {
        // dd($this->part_no);
        $this->reset('allAddedEstimatesData');
        if (Session()->has('addedRateAnalysisData')) {
            $this->allAddedEstimatesData = Session()->get('addedRateAnalysisData');
            // dd( $this->allAddedEstimatesData);
        }
        if ($this->addedEstimateData != null) {
            // dd($this->addedEstimateData);
            if (CommonFunction::hasNestedArrays($this->addedEstimateData)) {
                foreach ($this->addedEstimateData as $addedEstimate) {
                    $index = count($this->allAddedEstimatesData) + 1;
                    if (!array_key_exists("operation", $addedEstimate)) {
                        $addedEstimate['operation'] = '';
                    }
                    if (!array_key_exists("array_id", $addedEstimate)) {
                        $addedEstimate['array_id'] = $this->part_no . $index;
                    }
                    if (!array_key_exists("arrayIndex", $addedEstimate)) {
                        $addedEstimate['arrayIndex'] = '';
                    }
                    if (!array_key_exists("remarks", $addedEstimate)) {
                        $addedEstimate['remarks'] = '';
                    }
                    if (!array_key_exists("rate_no", $addedEstimate)) {
                        $addedEstimate['rate_no'] = 0;
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
                    if (!array_key_exists("sor_itemno_child_id", $this->addedEstimateData)) {
                        $this->addedEstimateData['sor_itemno_child_id'] = 0;
                    }
                    if (!array_key_exists("is_row", $this->addedEstimateData)) {
                        $this->addedEstimateData['is_row'] = null;
                    }
                    if (!array_key_exists("unit_id", $this->addedEstimateData)) {
                        $this->addedEstimateData['unit_id'] = null;
                    }
                    // if (!array_key_exists("col_position", $this->addedEstimateData)) {
                    //     $this->addedEstimateData['col_position'] = 0;
                    // }
                    foreach ($addedEstimate as $key => $estimate) {
                        $this->allAddedEstimatesData[$index][$key] = $estimate;
                    }
                    Session()->put('addedRateAnalysisData', $this->allAddedEstimatesData);
                }
            } else {
                $index = count($this->allAddedEstimatesData) + 1;
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
                if (!array_key_exists("is_row", $this->addedEstimateData)) {
                    $this->addedEstimateData['is_row'] = null;
                }
                if (!array_key_exists("unit_id", $this->addedEstimateData)) {
                    $this->addedEstimateData['unit_id'] = null;
                }
                foreach ($this->addedEstimateData as $key => $estimate) {
                    $this->allAddedEstimatesData[$index][$key] = $estimate;
                }
                Session()->put('addedRateAnalysisData', $this->allAddedEstimatesData);
                $this->reset('addedEstimateData');
            }
            Session()->put('rateDescription', $this->sorMasterDesc);
            Session()->put('ratePartNo',$this->part_no);
            $this->reset('addedEstimateData');
            // dd($this->allAddedEstimatesData);
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

    public function deleteEstimate($value)
    {
        $numericValue = preg_replace('/[^0-9]/', '', $value);
        unset($this->allAddedEstimatesData[$numericValue]);
        Session()->forget('addedRateAnalysisData');
        Session()->put('addedRateAnalysisData', $this->allAddedEstimatesData);
        $this->level = [];
        if ($this->totalOnSelectedCount == 1) {
            $this->reset('totalOnSelectedCount');
        }
        $this->notification()->error(
            $title = 'Row Deleted Successfully'
        );
    }
    // TODO::export word on project estimate
    public function exportWord()
    {
        $exportDatas = array_values($this->allAddedEstimatesData);
        // dd($exportDatas);
        $date = date('Y-m-d');
        $pw = new \PhpOffice\PhpWord\PhpWord();
        $section = $pw->addSection(
            array(
                'marginLeft' => 600, 'marginRight' => 200,
                'marginTop' => 600, 'marginBottom' => 200,
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
            } elseif ($export['rate_no']) {
                $html .= "<td style='text-align: center'>" . $export['rate_no'] . "</td>&nbsp;";
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
            if ($export['rate_no']) {
                $html .= "<p>Estimate Packege " . $export['rate_no'] . "</p>";
                $getEstimateDetails = EstimatePrepare::where('rate_id', '=', $export['rate_no'])->get();
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
    public function viewRateModal($rate_id)
    {
        $this->emit('openRateAnalysisModal', $rate_id);
    }
    public $openSorModal = false, $openSorModalName, $getSingleSor = [], $selectedArrKey;
    public function viewDynamicSor($sorChildId, $sorItemNo, $arrKey)
    {
        $this->getSingleSor = DynamicSorHeader::where('id', (int) $sorChildId)->first();
        // dd($this->getSingleSor);
        if ($sorItemNo != 0) {
            $rdata = [];
            foreach (json_decode($this->getSingleSor['row_data']) as $json) {
                if ($json->id == $sorItemNo) {
                    $rdata[] = $json;
                }
            }
            $this->getSingleSor['row_data'] = json_encode($rdata);
        }

        $this->selectedArrKey = $arrKey;
        $this->openSorModal = !$this->openSorModal;
        $this->openSorModalName = "item-specific-dynamic-sor-modal_" . rand(1, 1000);
        $this->openSorModalName = str_replace(' ', '_', $this->openSorModalName);
        // dd($getSingleSor['row_data']);
    }
    public function closeModal1()
    {
        if ($this->openSorModal) {
            $this->openSorModal = !$this->openSorModal;
        }
        if ($this->isRateType) {
            $this->isRateType = !$this->isRateType;
        }
        $this->reset('selectedArrKey');
        // if ($this->selectedCategoryId == '') {
        //     $this->selectSor['page_no'] = '';
        // } else {
        //     $this->estimateData['page_no'] = '';
        // }
    }
    public $fetchRatePlaceWise;
    public $isRateType = false, $rateTypeModalName, $rateType = '', $isItemModal = false, $isItemModalName, $isItemModalData;
    public function getRatePlaceWise($data)
    {
        // dd($data[0]);
        $this->fetchRatePlaceWise = [];
        // if($data){

        // }
        $this->fetchRatePlaceWise = RatesAnalysis::where([['sor_id', $data[0]['id']], ['item_index', $data[0]['itemNo']], ['col_position', $data[0]['colPosition']], ['operation', '!=', '']])->get();
        // dd($this->fetchRatePlaceWise);
        if (count($this->fetchRatePlaceWise) > 0) {
            $this->isRateType = !$this->isRateType;
            $this->rateTypeModalName = "item-wise-rate-type-modal_" . rand(1, 1000);
            $this->rateTypeModalName = str_replace(' ', '_', $this->rateTypeModalName);
        } else {
            $this->notification()->error(
                $title = 'No Rate Found !!'
            );
            $this->isItemModal = !$this->isItemModal;
            $this->isItemModalData = $data;
            $this->isItemModalName = "item-wise-rate-type-modal_" . rand(1, 1000);
            $this->isItemModalName = str_replace(' ', '_', $this->isItemModalName);
            // $this->reset('selectedArrKey', 'openSorModal');
        }
    }
    public function submitItemModal()
    {
        if (count($this->isItemModalData) > 0) {
            $this->allAddedEstimatesData[$this->selectedArrKey]['rate'] = round($this->isItemModalData[0]['rowValue'], 2);
            $this->allAddedEstimatesData[$this->selectedArrKey]['qty'] = round($this->allAddedEstimatesData[$this->selectedArrKey]['qty'], 3);
            $this->allAddedEstimatesData[$this->selectedArrKey]['total_amount'] = $this->allAddedEstimatesData[$this->selectedArrKey]['qty'] * $this->allAddedEstimatesData[$this->selectedArrKey]['rate'];
            $this->allAddedEstimatesData[$this->selectedArrKey]['total_amount'] = round($this->allAddedEstimatesData[$this->selectedArrKey]['total_amount'], 2);
            $this->updateDataTableTracker = rand(1, 1000);
            $this->reset('selectedArrKey', 'openSorModal', 'isItemModalData', 'isItemModalName', 'isItemModal');
        }
    }
    public function closeItemModal()
    {
        $this->isItemModal = !$this->isItemModal;
        $this->reset('selectedArrKey', 'openSorModal');
    }
    public function getTypeWiseRate()
    {
        $tempValue = $this->allAddedEstimatesData[$this->selectedArrKey]['rate'];
        if (count($this->fetchRatePlaceWise) > 0) {
            foreach ($this->fetchRatePlaceWise as $fetchRate) {
                if ($fetchRate['operation'] == $this->rateType) {
                    $this->allAddedEstimatesData[$this->selectedArrKey]['rate'] = $fetchRate['total_amount'];
                    if ($this->allAddedEstimatesData[$this->selectedArrKey]['rate'] != $tempValue) {
                        $this->allAddedEstimatesData[$this->selectedArrKey]['total_amount'] = $this->allAddedEstimatesData[$this->selectedArrKey]['qty'] * $this->allAddedEstimatesData[$this->selectedArrKey]['rate'];
                        $this->allAddedEstimatesData[$this->selectedArrKey]['total_amount'] = round($this->allAddedEstimatesData[$this->selectedArrKey]['total_amount'], 2);
                    }
                }
            }
            $this->updateDataTableTracker = rand(1, 1000);
            // $this->isRateType = !$this->isRateType;
            $this->reset('selectedArrKey', 'openSorModal', 'isRateType', 'rateType');
        } else {
            $this->reset('selectedArrKey', 'openSorModal', 'isRateType', 'rateType');
            $this->notification()->error(
                $title = 'No Rate Found !!'
            );
        }
    }
    public function store()
    {
        // dd($this->allAddedEstimatesData);
        $userData = Session::get('user_data');
        if ($this->totalOnSelectedCount >= 1 ) {
            try {
                if ($this->allAddedEstimatesData) {
                    $intId = random_int(100000, 999999);
                    if (true) {
                        // $insert[] = [];
                        foreach ($this->allAddedEstimatesData as $key => $value) {
                            $insert = [
                                'rate_id' => $intId,
                                'description' => (count($this->allAddedEstimatesData) == $key) ? str_replace(',', ' ', $this->sorMasterDesc) : str_replace(',', ' ', $value['description']),
                                'rate_no' => (int) $value['rate_no'],
                                'dept_id' => $value['dept_id'],
                                'category_id' => $value['category_id'],
                                'row_id' => $value['array_id'],
                                'row_index' => $value['arrayIndex'],
                                'sor_item_number' => $value['sor_item_number'],
                                'item_name' => $value['item_name'],
                                'other_name' => $value['other_name'],
                                'qty' => $value['qty'],
                                'rate' => $value['rate'],
                                'total_amount' => $value['total_amount'],
                                'operation' => $value['operation'],
                                'created_by' => $userData->id,
                                'comments' => $value['remarks'],
                                'sor_id' => ($value['sor_id'] != '') ? $value['sor_id'] : 0,
                                'page_no' => ($value['page_no'] != '') ? $value['page_no'] : 0,
                                'table_no' => $value['table_no'],
                                'volume_no' => ($value['volume_no'] != '') ? $value['volume_no'] : 0,
                                'item_index' => $value['item_index'],
                                'col_position' => (isset($value['col_position'])) ? $value['col_position'] : 0,
                            ];
                            $validateData = Validator::make($insert, [
                                'rate_id' => 'required|integer',
                                'dept_id' => 'required|integer',
                                'category_id' => 'required|integer',
                                'row_id' => 'required|integer',
                            ]);
                            if ($validateData->fails()) {
                                // dd($validateData->messages());
                            }
                            RatesAnalysis::create($insert);
                        }
                        // dd($insert);
                        $this->notification()->success(
                            $title = 'Created Successfully!!'
                        );
                        $this->resetSession();
                        // $sessionKey = 'rate_data' . '_' . $userData->id . '_' . $userData->department_id;
                        // Session()->forget($sessionKey);
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
                $title = 'Please Calculate any of three first !!'
            );
        }

    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        $this->arrayRow = count($this->allAddedEstimatesData);
        return view('livewire.rate-analysis.add-rate-analysis-list');
    }
}
