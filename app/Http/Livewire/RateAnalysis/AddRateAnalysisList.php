<?php

namespace App\Http\Livewire\RateAnalysis;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\RatesMaster;
use App\Models\RatesAnalysis;
use App\Models\EstimatePrepare;
use App\Models\DynamicSorHeader;
use App\Services\CommonFunction;
use Illuminate\Support\Facades\Session;
use ChrisKonnertz\StringCalc\StringCalc;
use Illuminate\Support\Facades\Validator;

class AddRateAnalysisList extends Component
{
    use Actions;
    protected $listeners = ['closeModal1', 'getRatePlaceWise', 'closeItemModal', 'submitItemModal', 'setFetchRateData'];
    public $addedRateData = [];
    public $allAddedRateData = [];
    public $expression, $remarks, $level = [], $openTotalButton = false, $arrayStore = [], $totalRate = 0, $arrayIndex, $arrayRow, $rateMasterDesc, $updateDataTableTracker, $totalOnSelectedCount = 0;
    public $selectSor, $totalDistance, $other_rate, $part_no, $selectCheckBoxs = false, $editRate_id;
    public function mount()
    {
        $this->setRateDataToSession();
    }
    public function setFetchRateData($fetchRateData)
    {
        $this->reset('allAddedRateData');
        if (Session()->has('editRateData' . $this->editRate_id)) {
            $this->allAddedRateData = Session()->get('editRateData' . $this->editRate_id);
        } else {
            // dd($fetchRateData);
            foreach ($fetchRateData as $rateData) {
                $count = count($this->allAddedRateData) + 1;
                $this->allAddedRateData[$count]['array_id'] = $rateData['row_id'];
                $this->allAddedRateData[$count]['rate_no'] = $rateData['rate_no'];
                $this->allAddedRateData[$count]['dept_id'] = $rateData['dept_id'];
                $this->allAddedRateData[$count]['category_id'] = $rateData['category_id'];
                $this->allAddedRateData[$count]['sor_item_number'] = $rateData['sor_item_number'];
                $this->allAddedRateData[$count]['volume_no'] = $rateData['volume_no'];
                $this->allAddedRateData[$count]['table_no'] = $rateData['table_no'];
                $this->allAddedRateData[$count]['page_no'] = $rateData['page_no'];
                $this->allAddedRateData[$count]['sor_id'] = $rateData['sor_id'];
                $this->allAddedRateData[$count]['item_index'] = $rateData['item_index'];
                $this->allAddedRateData[$count]['item_name'] = $rateData['item_name'];
                $this->allAddedRateData[$count]['other_name'] = $rateData['other_name'];
                $this->allAddedRateData[$count]['description'] = $rateData['description'];
                $this->allAddedRateData[$count]['qty'] = $rateData['qty'];
                $this->allAddedRateData[$count]['rate'] = $rateData['rate'];
                $this->allAddedRateData[$count]['total_amount'] = $rateData['total_amount'];
                // $this->allAddedRateData[$count]['version'] = $rateData['version'];
                $this->allAddedRateData[$count]['operation'] = $rateData['operation'];
                $this->allAddedRateData[$count]['col_position'] = $rateData['col_position'];
                $this->allAddedRateData[$count]['is_row'] = '';
                $this->allAddedRateData[$count]['unit_id'] = $rateData['unit_id'];
                $this->allAddedRateData[$count]['arrayIndex'] = $rateData['row_index'];
                $this->allAddedRateData[$count]['remarks'] = $rateData['comments'];
            }
            Session()->put('editRateData' . $this->editRate_id, $this->allAddedRateData);
        }
    }
    public function resetSession()
    {
        if ($this->editRate_id != '') {
            Session()->forget('editRateData' . $this->editRate_id);
        } else {
            Session()->forget('addedRateAnalysisData');
        }
        $this->reset();
    }
    public function viewModal($rate_id)
    {
        $this->emit('openModal', $rate_id);
    }
    //calculate estimate list
    public function insertAddRate($arrayIndex, $dept_id, $category_id, $sor_item_number, $item_name, $other_name, $description, $qty, $rate, $total_amount, $operation, $version, $remarks)
    {
        $this->addedRateData['arrayIndex'] = $arrayIndex;
        $this->addedRateData['dept_id'] = $dept_id;
        $this->addedRateData['category_id'] = $category_id;
        $this->addedRateData['sor_item_number'] = $sor_item_number;
        $this->addedRateData['item_name'] = $item_name;
        $this->addedRateData['other_name'] = $other_name;
        $this->addedRateData['description'] = $description;
        $this->addedRateData['qty'] = $qty;
        $this->addedRateData['rate'] = $rate;
        $this->addedRateData['total_amount'] = $total_amount;
        $this->addedRateData['operation'] = $operation;
        $this->addedRateData['version'] = $version;
        $this->addedRateData['remarks'] = $remarks;
        if ($this->selectSor['sor_id'] != '' && $this->addedRateData['operation'] == 'Total' || $this->addedRateData['operation'] == 'With Stacking' || $this->addedRateData['operation'] == 'Without Stacking') {
            $this->addedRateData['sor_id'] = $this->selectSor['sor_id'];
            $this->addedRateData['table_no'] = $this->selectSor['table_no'];
            $this->addedRateData['page_no'] = $this->selectSor['page_no'];
            $this->addedRateData['volume_no'] = $this->selectSor['volume'];
            $this->addedRateData['item_index'] = (isset($this->selectSor['item_index'])) ? $this->selectSor['item_index'] : 0;
            $this->addedRateData['col_position'] = (isset($this->selectSor['col_position'])) ? $this->selectSor['col_position'] : 0;
        }
        $this->setRateDataToSession();
        $this->resetExcept('allAddedRateData', 'rateMasterDesc', 'totalOnSelectedCount', 'selectSor', 'hideTotalbutton', 'hideWithStackBtn', 'hideWithoutStackBtn', 'part_no', 'editRate_id');
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
            //         $count0 = count($this->allAddedRateData);
            //         if (ctype_alpha($info)) {
            //             $alphabet = strtoupper($info);
            //             $alp_id = ord($alphabet) - 64;
            //             if ($alp_id <= $count0 ) {
            //                 if ($this->allAddedRateData[$alp_id]['array_id']) {
            //                     $this->expression = str_replace($info, $this->allAddedRateData[$alp_id]['total_amount'], $this->expression, $key);
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
                foreach ($this->allAddedRateData as $k => $data) {
                    if ($data['array_id'] == $info) {
                        $this->expression = str_replace($info, $this->allAddedRateData[$k]['total_amount'], $this->expression, $key);
                    }
                }
                if (htmlspecialchars($info) == "%") {
                    $this->expression = str_replace($info, "/100*", $this->expression, $key);
                }
            }
            $result = $stringCalc->calculate($this->expression);
            $this->insertAddRate($tempIndex, Session::get('user_data.department_id'), 0, 0, '', '', '', 0, 0, number_format(round($result, 2), 2, '.', ''), 'Exp Calculoation', '', $this->remarks);
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
        //for check select all check box
        if (count($this->level) != count($this->allAddedRateData)) {
            $this->selectCheckBoxs = false;
        } else if (count($this->level) == count($this->allAddedRateData)) {
            $this->selectCheckBoxs = true;
        } else {
            return;
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
        if (count($this->level) >= 1) { //bypass the condition
            $result = 0;
            foreach ($this->level as $key => $array) {
                // $this->arrayStore[] = chr($array + 64);
                $this->arrayStore[] = $array;
                foreach ($this->allAddedRateData as $k => $value) {
                    if ($value['array_id'] == $array) {
                        $result = $result + $this->allAddedRateData[$k]['total_amount'];
                    }
                }
            }
            $this->arrayIndex = implode('+', $this->arrayStore); //chr($this->indexCount + 64)
            if (!isset($this->selectSor['item_number'])) {
                $this->selectSor['item_number'] = 0;
            }
            $this->insertAddRate($this->arrayIndex, Session::get('user_data.department_id'), 0, $this->selectSor['selectedSOR'], '', '', $this->rateMasterDesc, ($this->totalDistance != '') ? $this->totalDistance : 0, 0, number_format(round($result), 2, '.', ''), $flag, '', '');
            $this->totalOnSelectedCount++;
        } else {
            $this->notification()->error(
                $title = 'Please select minimum 1 Check boxes'
            );
        }
    }
    public function calculateValue($key)
    {
        // dd($this->allAddedRateData[$key]);
        if ($this->allAddedRateData[$key]['rate'] > 0) {
            $this->allAddedRateData[$key]['qty'] = number_format(round($this->allAddedRateData[$key]['qty'], 3), 3, '.', '');
            $this->allAddedRateData[$key]['rate'] = number_format(round($this->allAddedRateData[$key]['rate'], 2), 2, '.', '');
            $this->allAddedRateData[$key]['total_amount'] = $this->allAddedRateData[$key]['qty'] * $this->allAddedRateData[$key]['rate'];
            $this->allAddedRateData[$key]['total_amount'] = number_format(round($this->allAddedRateData[$key]['total_amount'], 2), 2, '.', '');
            $this->allAddedRateData[$key]['rate'] = $this->allAddedRateData[$key]['rate'];
            // $this->reset('other_rate');
        } else {
            $this->allAddedRateData[$key]['rate'] = number_format(0, 2, '.', '');
            $this->allAddedRateData[$key]['total_amount'] = number_format(0, 2, '.', '');
        }
    }
    public function resetRate($key)
    {
        if ($this->allAddedRateData[$key]['rate'] > 0) {
            $this->allAddedRateData[$key]['rate'] = 0;
            $this->allAddedRateData[$key]['total_amount'] = 0;
        }
    }
    public function setRateDataToSession()
    {
        // dd($this->part_no);
        $this->reset('allAddedRateData');
        if ($this->editRate_id != '') {
            if (Session()->has('editRateData' . $this->editRate_id)) {
                $this->allAddedRateData = Session()->get('editRateData' . $this->editRate_id);
            }
        } else {
            if (Session()->has('addedRateAnalysisData')) {
                $this->allAddedRateData = Session()->get('addedRateAnalysisData');
                // dd( $this->allAddedRateData);
            }
        }

        if ($this->addedRateData != null) {
            // dd($this->addedRateData);
            if (CommonFunction::hasNestedArrays($this->addedRateData)) {
                foreach ($this->addedRateData as $addedRate) {
                    $index = count($this->allAddedRateData) + 1;
                    if (!array_key_exists("operation", $addedRate)) {
                        $addedRate['operation'] = '';
                    }
                    if (!array_key_exists("array_id", $addedRate)) {
                        $addedRate['array_id'] = $this->part_no . $index;
                    }
                    if (!array_key_exists("arrayIndex", $addedRate)) {
                        $addedRate['arrayIndex'] = '';
                    }
                    if (!array_key_exists("remarks", $addedRate)) {
                        $addedRate['remarks'] = '';
                    }
                    if (!array_key_exists("rate_no", $addedRate)) {
                        $addedRate['rate_no'] = 0;
                    }
                    if (!array_key_exists("volume_no", $this->addedRateData)) {
                        $this->addedRateData['volume_no'] = 0;
                    }
                    if (!array_key_exists("sor_id", $this->addedRateData)) {
                        $this->addedRateData['sor_id'] = 0;
                    }
                    if (!array_key_exists("item_index", $this->addedRateData)) {
                        $this->addedRateData['item_index'] = 0;
                    }
                    if (!array_key_exists("table_no", $this->addedRateData)) {
                        $this->addedRateData['table_no'] = 0;
                    }
                    if (!array_key_exists("page_no", $this->addedRateData)) {
                        $this->addedRateData['page_no'] = 0;
                    }
                    if (!array_key_exists("sor_itemno_child_id", $this->addedRateData)) {
                        $this->addedRateData['sor_itemno_child_id'] = 0;
                    }
                    if (!array_key_exists("is_row", $this->addedRateData)) {
                        $this->addedRateData['is_row'] = null;
                    }
                    if (!array_key_exists("unit_id", $this->addedRateData)) {
                        $this->addedRateData['unit_id'] = null;
                    }
                    // if (!array_key_exists("col_position", $this->addedRateData)) {
                    //     $this->addedRateData['col_position'] = 0;
                    // }
                    foreach ($addedRate as $key => $estimate) {
                        $this->allAddedRateData[$index][$key] = $estimate;
                    }
                    // Session()->put('addedRateAnalysisData', $this->allAddedRateData);
                }
            } else {
                $index = count($this->allAddedRateData) + 1;
                if (!array_key_exists("operation", $this->addedRateData)) {
                    $this->addedRateData['operation'] = '';
                }
                if (!array_key_exists("array_id", $this->addedRateData)) {
                    $this->addedRateData['array_id'] = $this->part_no . $index;
                }
                if (!array_key_exists("arrayIndex", $this->addedRateData)) {
                    $this->addedRateData['arrayIndex'] = '';
                }
                if (!array_key_exists("remarks", $this->addedRateData)) {
                    $this->addedRateData['remarks'] = '';
                }
                if (!array_key_exists("rate_no", $this->addedRateData)) {
                    $this->addedRateData['rate_no'] = 0;
                }
                if (!array_key_exists("volume_no", $this->addedRateData)) {
                    $this->addedRateData['volume_no'] = 0;
                }
                if (!array_key_exists("sor_id", $this->addedRateData)) {
                    $this->addedRateData['sor_id'] = 0;
                }
                if (!array_key_exists("item_index", $this->addedRateData)) {
                    $this->addedRateData['item_index'] = 0;
                }
                if (!array_key_exists("table_no", $this->addedRateData)) {
                    $this->addedRateData['table_no'] = 0;
                }
                if (!array_key_exists("page_no", $this->addedRateData)) {
                    $this->addedRateData['page_no'] = 0;
                }
                if (!array_key_exists("col_position", $this->addedRateData)) {
                    $this->addedRateData['col_position'] = 0;
                }
                if (!array_key_exists("is_row", $this->addedRateData)) {
                    $this->addedRateData['is_row'] = null;
                }
                if (!array_key_exists("unit_id", $this->addedRateData)) {
                    $this->addedRateData['unit_id'] = null;
                }
                foreach ($this->addedRateData as $key => $estimate) {
                    $this->allAddedRateData[$index][$key] = $estimate;
                }
                // Session()->put('addedRateAnalysisData', $this->allAddedRateData);
                // $this->reset('addedRateData');
            }
            if ($this->editRate_id != '') {
                Session()->put('editRateData' . $this->editRate_id, $this->allAddedRateData);
                // Session()->put('editRateDescription'. $this->editRate_id, $this->rateMasterDesc);
                // Session()->put('editRatePartNo'. $this->editRate_id, $this->part_no);
            } else {
                Session()->put('addedRateAnalysisData', $this->allAddedRateData);
                Session()->put('rateDescription', $this->rateMasterDesc);
                Session()->put('ratePartNo', $this->part_no);
            }

            $this->reset('addedRateData');
            // dd($this->allAddedRateData);
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

    public function deleteRate($value)
    {
        $numericValue = preg_replace('/[^0-9]/', '', $value);
        unset($this->allAddedRateData[$numericValue]);
        if ($this->editRate_id != '') {
            Session()->forget('editRateData' . $this->editRate_id);
            Session()->put('editRateData' . $this->editRate_id, $this->allAddedRateData);
        } else {
            Session()->forget('addedRateAnalysisData');
            Session()->put('addedRateAnalysisData', $this->allAddedRateData);
        }
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
        $exportDatas = array_values($this->allAddedRateData);
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
        //     $this->rateData['page_no'] = '';
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
            $this->allAddedRateData[$this->selectedArrKey]['rate'] = number_format(round($this->isItemModalData[0]['rowValue'], 2), 2, '.', '');
            $this->allAddedRateData[$this->selectedArrKey]['qty'] = number_format(round($this->allAddedRateData[$this->selectedArrKey]['qty'], 3), 3, '.', '');
            $this->allAddedRateData[$this->selectedArrKey]['total_amount'] = $this->allAddedRateData[$this->selectedArrKey]['qty'] * $this->allAddedRateData[$this->selectedArrKey]['rate'];
            $this->allAddedRateData[$this->selectedArrKey]['total_amount'] = number_format(round($this->allAddedRateData[$this->selectedArrKey]['total_amount'], 2), 2, '.', '');
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
        $tempValue = $this->allAddedRateData[$this->selectedArrKey]['rate'];
        if (count($this->fetchRatePlaceWise) > 0) {
            foreach ($this->fetchRatePlaceWise as $fetchRate) {
                if ($fetchRate['operation'] == $this->rateType) {
                    $this->allAddedRateData[$this->selectedArrKey]['rate'] = number_format($fetchRate['total_amount'], 2, '.', '');
                    if ($this->allAddedRateData[$this->selectedArrKey]['rate'] != $tempValue) {
                        $this->allAddedRateData[$this->selectedArrKey]['total_amount'] = $this->allAddedRateData[$this->selectedArrKey]['qty'] * $this->allAddedRateData[$this->selectedArrKey]['rate'];
                        $this->allAddedRateData[$this->selectedArrKey]['total_amount'] = number_format(round($this->allAddedRateData[$this->selectedArrKey]['total_amount'], 2), 2, '.', '');
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
    public function selectAll()
    {
        if ($this->selectCheckBoxs) {
            $this->level = collect($this->allAddedRateData)->pluck('array_id')->toArray();
        } else {
            $this->level = [];
        }
    }
    public function store($value = '')
    {
        // dd($this->allAddedRateData);
        $userData = Session::get('user_data');
        if ($this->totalOnSelectedCount >= 1) {
            try {
                if ($this->allAddedRateData) {
                    $intId = ($this->editRate_id != '') ? $this->editRate_id : random_int(100000, 999999);

                    if (true) {
                        // $insert[] = [];
                        RatesMaster::create(["rate_id"=>$intId,"rate_description"=>str_replace(',', ' ', $this->rateMasterDesc),"part_no"=>$this->part_no,"created_by"=>$userData->id,"dept_id"=>$userData->department_id,"status"=>1]);
                        RatesMaster::where('rate_id',$intId)->update(["rate_description"=>str_replace(',', ' ', $this->rateMasterDesc),"part_no"=>$this->part_no,"status"=>12]);
                        foreach ($this->allAddedRateData as $key => $value) {
                            $insert = [
                                'rate_id' => $intId,
                                'description' => (count($this->allAddedRateData) == $key) ? str_replace(',', ' ', $this->rateMasterDesc) : str_replace(',', ' ', $value['description']),
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
                                'unit_id' => ($value['unit_id'] != '') ? $value['unit_id'] : 0,
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
        $this->arrayRow = count($this->allAddedRateData);
        return view('livewire.rate-analysis.add-rate-analysis-list');
    }
}
