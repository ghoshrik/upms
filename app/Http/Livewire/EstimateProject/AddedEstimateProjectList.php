<?php

namespace App\Http\Livewire\EstimateProject;

use App\Models\EstimatePrepare;
use App\Models\EstimateUserAssignRecord;
use App\Models\SORMaster as ModelsSORMaster;
use App\Models\SpecificQuantityAnalysis;
use ChrisKonnertz\StringCalc\StringCalc;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class AddedEstimateProjectList extends Component
{
    use Actions;
    protected $listeners = ['unitQtyAdded', 'closeUnitModal'];
    public $addedEstimateData = [];
    public $allAddedEstimatesData = [];
    public $part_no;
    public $expression, $remarks, $level = [], $openTotalButton = false, $arrayStore = [], $totalEstimate = 0, $arrayIndex, $arrayRow, $sorMasterDesc, $updateDataTableTracker, $totalOnSelectedCount = 0;
    public $openQtyModal = false, $sendArrayKey = '', $sendArrayDesc = '', $getQtySessionData = [];

    public function mount()
    {
        $this->setEstimateDataToSession();
    }

    public function resetSession()
    {
        Session()->forget('addedProjectEstimateData');
        Session()->forget('modalData');
        Session()->forget('projectEstimationTotal');
        $this->reset();
    }
    public function viewModal($estimate_id)
    {
        $this->emit('openModal', $estimate_id);
    }
    public function openQtyAnanysisModal($key)
    {
        $this->openQtyModal = !$this->openQtyModal;
        $this->sendArrayKey = $this->allAddedEstimatesData[$key]['array_id'];
        foreach ($this->allAddedEstimatesData as $index => $estimateData) {
            if ($estimateData['array_id'] === $this->sendArrayKey) {
                if (!empty($this->allAddedEstimatesData[$key]['description'])) {
                    $this->sendArrayDesc = $this->allAddedEstimatesData[$key]['description'];
                } elseif (!empty($this->allAddedEstimatesData[$key]['other_name'])) {
                    $this->sendArrayDesc = $this->allAddedEstimatesData[$key]['other_name'];
                }
            }
        }
    }
    public function unitQtyAdded($data, $overallTotal)
    {
        try {
            $sessionData = session('modalData');
            if (!is_array($sessionData)) {
                $sessionData = [];
            }
            foreach ($data as $item) {
                $parentId = $item['parent_id'];
                $childId = $item['child_id'];
                $uniqueKey = $parentId . '_' . $childId;
                if (array_key_exists($parentId, $sessionData)) {
                    if (array_key_exists($childId, $sessionData[$parentId])) {
                        $sessionData[$parentId][$childId] = $item;
                    } else {
                        $sessionData[$parentId][$childId] = $item;
                    }
                } else {
                    $sessionData[$parentId] = [$childId => $item];
                }
            }
            Session()->put('modalData', $sessionData);
            $this->getQtySessionData = $sessionData;
            foreach ($this->allAddedEstimatesData as $index => $estimateData) {
                if ($estimateData['array_id'] === $this->sendArrayKey) {
                    $this->allAddedEstimatesData[$index]['qty'] = $overallTotal;
                    $this->allAddedEstimatesData[$index]['qtyUpdate'] = true;
                    $this->calculateValue($index);
                }
            }
            Session()->put('addedProjectEstimateData', $this->allAddedEstimatesData);
        } catch (\Exception $e) {
            dd($e);
        }
    }
    public function closeUnitModal()
    {
        $this->openQtyModal = !$this->openQtyModal;
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
        $this->setEstimateDataToSession();
        $this->resetExcept('allAddedEstimatesData', 'sorMasterDesc', 'totalOnSelectedCount', 'part_no','getQtySessionData');
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
            // if ($this->expression) {
            //     foreach (str_split($this->expression) as $key => $info) {
            //         $count0 = count($this->allAddedEstimatesData);
            //         if (ctype_alpha($info)) {
            //             $alphabet = strtoupper($info);
            //             $alp_id = ord($alphabet) - 64;
            //             if ($alp_id <= $count0) {
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
            $result = $stringCalc->calculate($this->expression);
            $this->insertAddEstimate($tempIndex, 0, 0, 0, '', '', '', 0, 0, round($result, 2), 'Exp Calculoation', '', $this->remarks);
        } catch (\Exception $exception) {
            $this->expression = $tempIndex;
            $this->notification()->error(
                $title = $exception->getMessage()
            );
        }
    }

    public function showTotalButton()
    {
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
            $this->totalOnSelectedCount = $this->totalOnSelectedCount + 1;
            Session()->put('projectEstimationTotal', $this->totalOnSelectedCount);
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
        if (Session()->has('addedProjectEstimateData')) {
            $this->allAddedEstimatesData = Session()->get('addedProjectEstimateData');
            if (Session()->has('projectEstimationTotal')) {
                $this->totalOnSelectedCount = Session()->get('projectEstimationTotal');
            }
            if (Session()->has('modalData')) {
                $this->getQtySessionData = Session()->get('modalData');
            }
        }
        // dd($this->totalOnSelectedCount);
        if ($this->addedEstimateData != null) {
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
            foreach ($this->addedEstimateData as $key => $estimate) {
                $this->allAddedEstimatesData[$index][$key] = $estimate;
            }
            Session()->put('addedProjectEstimateData', $this->allAddedEstimatesData);
            Session()->put('projectEstimateDesc', $this->sorMasterDesc);
            Session()->put('projectEstimatePartNo', $this->part_no);
            $this->reset('addedEstimateData');

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
        $sessionData = Session()->get('modalData');
        if (isset($sessionData[$value])) {
            unset($sessionData[$value]);
        }
        Session()->put('modalData', $sessionData);
        $numericValue = preg_replace('/[^0-9]/', '', $value);
        unset($this->allAddedEstimatesData[$numericValue]);
        Session()->forget('addedProjectEstimateData');
        Session()->put('addedProjectEstimateData', $this->allAddedEstimatesData);
        $this->level = [];
        if ($this->totalOnSelectedCount >= 1) {
            $this->reset('totalOnSelectedCount');
            Session()->forget('projectEstimationTotal');
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

    public function store()
    {
        if ($this->totalOnSelectedCount == 1) {
            try {
                // dd($this->allAddedEstimatesData);
                if ($this->allAddedEstimatesData) {
                    $intId = random_int(100000, 999999);
                    if (ModelsSORMaster::create(['estimate_id' => $intId, 'sorMasterDesc' => $this->sorMasterDesc, 'status' => 1, 'dept_id' => Auth::user()->department_id])) {
                        // if (true) {
                        foreach ($this->allAddedEstimatesData as $key => $value) {
                            $insert = [
                                'estimate_id' => $intId,
                                'estimate_no' => $value['estimate_no'],
                                'rate_id' => $value['rate_no'],
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
                            // if (Session()->has('modalData')) {
                            //     $modalQtyData = Session()->get('modalData');
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
                            EstimatePrepare::create($insert);
                        }
                        $data = [
                            'estimate_id' => $intId,
                            'estimate_user_type' => 5,
                            'status' => 1,
                            'user_id' => Auth::user()->id,
                        ];
                        EstimateUserAssignRecord::create($data);
                        $this->notification()->success(
                            $title = 'Project Estimate Created Successfully!!'
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
        return view('livewire.estimate-project.added-estimate-project-list');
    }
}
