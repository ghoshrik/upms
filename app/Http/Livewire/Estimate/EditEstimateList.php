<?php

namespace App\Http\Livewire\Estimate;

use App\Models\EstimateUserAssignRecord;
use App\Models\SORMaster as ModelsSORMaster;
use ChrisKonnertz\StringCalc\StringCalc;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class EditEstimateList extends Component
{
    use Actions;
    protected $listeners = ['updatedValue' => 'updateEstimateData'];
    public $eid = 0;
    public $addedEstimateData = [];
    public $allAddedEstimatesData = [];
    public $currentEstimateData = [];
    public $expression, $remarks, $level = [], $openTotalButton = false, $arrayStore = [], $totalEstimate = 0, $arrayIndex, $arrayRow, $sorMasterDesc,$addedEstimateUpdateTrack;

    public function mount()
    {
        $this->setEstimateDataToSession();
    }
    public function resetSession()
    {
        Session()->forget('editEstimateData');
        $this->reset();
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
        $this->resetExcept('allAddedEstimatesData', 'sorMasterDesc');
    }
    public function expCalc()
    {
        $result = 0;
        $tempIndex = strtoupper($this->expression);
        $stringCalc = new StringCalc();
        try {
            if ($this->expression) {
                foreach (str_split($this->expression) as $key => $info) {
                    $count0 = count($this->allAddedEstimatesData);
                    if (ctype_alpha($info)) {
                        $alphabet = strtoupper($info);
                        $alp_id = ord($alphabet) - 64;
                        if ($alp_id <= $count0) {
                            if ($this->allAddedEstimatesData[$alp_id-1]['row_id']) {
                                $this->expression = str_replace($info, $this->allAddedEstimatesData[$alp_id-1]['total_amount'], $this->expression, $key);
                            }
                        } else {
                            $this->notification()->error(
                                $title = 'Error !!!',
                                $description =  $alphabet . ' is a invalid input'
                            );
                        }
                    } elseif (htmlspecialchars($info) == "%") {
                        $this->expression = str_replace($info, "/100*", $this->expression, $key);
                    }
                }
            }
            $result = $stringCalc->calculate($this->expression);
            $this->insertAddEstimate($tempIndex, '', '', '', '', '', '', '', '', $result, 'Exp Calculoation', '', $this->remarks);
        } catch (\Exception $exception) {
            $this->expression = $tempIndex;
            $this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => $exception->getMessage()
            ]);
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
    public function totalOnSelected()
    {
        if (count($this->level) >= 2) {
            $result = 0;
            foreach ($this->level as $key => $array) {
                $this->arrayStore[] = chr($array + 64);
                $result = $result + $this->allAddedEstimatesData[$array]['total_amount'];
            }
            $this->arrayIndex = implode('+', $this->arrayStore); //chr($this->indexCount + 64)
            $this->insertAddEstimate($this->arrayIndex, '', '', '', '', '', '', '', '', $result, 'Total', '', '');
        } else {
            $this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => "Minimum select 2 Check boxes"
            ]);
        }
    }
    // public function setEstimateDataToSession()
    // {
    //     dd(count($this->addedEstimateData),$this->addedEstimateData,Session('editEstimateData'));
    //     $this->reset('allAddedEstimatesData');
    //     if (Session()->has('editEstimateData')) {
    //         $this->allAddedEstimatesData = Session()->get('editEstimateData');
    //     }
    //     if(count($this->addedEstimateData)>1)
    //     {
    //         $index = count($this->allAddedEstimatesData) + 1;
    //         foreach ($this->addedEstimateData as $key => $estimate) {
    //             $this->allAddedEstimatesData[$key] = $estimate;
    //         }
    //         Session()->put('editEstimateData', $this->allAddedEstimatesData);
    //         $this->reset('addedEstimateData');
    //     }else{
    //         if ($this->addedEstimateData != null) {
    //             $index = count($this->allAddedEstimatesData) + 1;
    //             if (!array_key_exists("operation", $this->addedEstimateData)) {
    //                 $this->addedEstimateData['operation'] = '';
    //             }
    //             if (!array_key_exists("row_id", $this->addedEstimateData)) {
    //                 $this->addedEstimateData['row_id'] = $index;
    //             }
    //             if (!array_key_exists("row_index", $this->addedEstimateData)) {
    //                 $this->addedEstimateData['row_index'] = '';
    //             }
    //             if (!array_key_exists("remarks", $this->addedEstimateData)) {
    //                 $this->addedEstimateData['remarks'] = '';
    //             }
    //             foreach ($this->addedEstimateData as $key => $estimate) {
    //                 $this->allAddedEstimatesData[$index][$key] = $estimate;
    //             }
    //             Session()->put('editEstimateData', $this->allAddedEstimatesData);
    //             $this->reset('addedEstimateData');
    //         }
    //     }


    //     // dd($this->allAddedEstimatesData);
    // }

    public function setEstimateDataToSession()
    {
        // dd($this->currentEstimateData);
        $this->reset('allAddedEstimatesData');
        if (Session()->has('editEstimateData')) {
            $this->allAddedEstimatesData = Session()->get('editEstimateData');
        }
        if ($this->currentEstimateData != null) {
            $this->allAddedEstimatesData = $this->currentEstimateData;
            Session()->put('editEstimateData', $this->allAddedEstimatesData);
            $this->reset('currentEstimateData');
        }
        if ($this->addedEstimateData != null) {
            $index = count($this->allAddedEstimatesData) ;
            if (!array_key_exists("operation", $this->addedEstimateData)) {
                $this->addedEstimateData['operation'] = '';
            }

            if (!array_key_exists("row_id", $this->addedEstimateData)) {
                $this->addedEstimateData['row_id'] = $index+1;
            }

            if (!array_key_exists("row_index", $this->addedEstimateData)) {
                $this->addedEstimateData['row_index'] = '';
            }
            if (!array_key_exists("comments", $this->addedEstimateData)) {
                $this->addedEstimateData['comments'] = '';
            }
            $this->allAddedEstimatesData[$index] = $this->addedEstimateData;
            Session()->put('editEstimateData',  $this->allAddedEstimatesData);
            $this->reset('addedEstimateData');
        }
    }
    public function confDeleteDialog($value): void
    {
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'icon'        => 'error',
            'accept'      => [
                'label'  => 'Yes, Delete it',
                'method' => 'deleteEstimate',
                'params' => $value,
            ],
            'reject' => [
                'label'  => 'No, cancel'
                // 'method' => 'cancel',
            ],
        ]);
    }
    public function deleteEstimate($value)
    {
        unset($this->allAddedEstimatesData[$value-1]);
        Session()->forget('editEstimateData');
        Session()->put('editEstimateData', $this->allAddedEstimatesData);
        $this->addedEstimateUpdateTrack = rand(1, 1000);
        $this->level = [];
        $this->notification()->error(
            $title = 'Row Deleted Successfully'
        );
    }
    public function editEstimate($value)
    {
        $this->emit('openEditModal', $value,$this->allAddedEstimatesData);
    }
    public function updateEstimateData($id,$updateValue)
    {
        // dd($id,$updateValue);
        $this->allAddedEstimatesData[$id-1] = $updateValue;
        Session()->put('editEstimateData',  $this->allAddedEstimatesData);
        $this->updatedEstimateRecalculate();
    }
    public function updatedEstimateRecalculate()
    {
        $result = 0;
        $stringCalc = new StringCalc();
        foreach ($this->allAddedEstimatesData as $key => $value) {
            if ($value['row_index'] != '') {
                try {
                    if ($value['row_index']) {
                        $amtTot = 0;
                        $c = 1;
                        foreach (str_split($value['row_index']) as $key => $info) {
                            if (ctype_alpha($info)) {

                                $alphabet = strtoupper($info);
                                $alp_id = ord($alphabet) - 64;
                                if ($this->allAddedEstimatesData[$alp_id - 1]['total_amount'] != '') {
                                    $value['row_index'] = str_replace($info, $this->allAddedEstimatesData[$alp_id - 1]['total_amount'], $value['row_index'], $key);
                                }
                            } elseif (htmlspecialchars($info) == "%") {
                                $value['row_index'] = str_replace($info, "/100*", $value['row_index'], $key);
                            }
                        }
                    }
                    $result = $stringCalc->calculate($value['row_index']);
                    $this->allAddedEstimatesData[$alp_id]['total_amount'] = $result;
                    Session()->put('editEstimateData',  $this->allAddedEstimatesData);
                } catch (\Exception $exception) {
                    $this->dispatchBrowserEvent('alert', [
                        'type' => 'error',
                        'message' => $exception->getMessage()
                    ]);
                }
            }
        }
    }
    public function exportWord()
    {
        $exportDatas = array_values($this->allAddedEstimatesData);
        // dd($exportDatas);
        $date = date('Y-m-d');
        $pw = new \PhpOffice\PhpWord\PhpWord();
        $section = $pw->addSection();
        $html = "<h1 style='font-size:24px;font-weight:600;text-align: center;'>Estimate Preparation Details</h1>";
        $html .= "<p>This is for test purpose</p>";
        $html .= "<table style='border: 1px solid black;width:auto'><tr>";
        $html .= "<th scope='col' style='text-align: center'>Serial No.</th>";
        $html .= "<th scope='col' style='text-align: center'>Item Number(Ver.)</th>";
        $html .= "<th scope='col' style='text-align: center'>Description</th>";
        $html .= "<th scope='col' style='text-align: center'>Quantity</th>";
        $html .= "<th scope='col' style='text-align: center'>Unit Price</th>";
        $html .= "<th scope='col' style='text-align: center' >Cost</th></tr>";
        foreach ($exportDatas as $key => $export) {
            $html .= "<tr><td style='text-align: center'>" . chr($export['array_id'] + 64) . "</td>&nbsp;";
            if ($export['sor_item_number']) {
                $html .= "<td style='text-align: center'>" . $export['sor_item_number'] . ' ( ' . $export['version'] . ' )' . "</td>&nbsp;";
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
            } else {
                $html .= "<td style='text-align: center'>" . $export['name'] . "</td>&nbsp;";
            }
            $html .= "<td style='text-align: center'>" . $export['qty'] . "</td>&nbsp;";
            $html .= "<td style='text-align: center'>" . $export['rate'] . "</td>&nbsp;";
            $html .= "<td style=''>" . $export['total_amount'] . "</td></tr>";
        }
        // $html .= "<tr align='right'><td colspan='5' align='right'>Total</td>";
        // foreach ($exportDatas as $key => $export) {
        //     if ($export['operation'] == 'Total') {
        //         $estTotal =  $export['total_amount'];
        //     } else {
        //         $estTotal = '--';
        //     }
        // }
        // $html .= "<td colspan='1' align='right'>" . $estTotal . "</td>";
        // $html .= "</tr>";
        $html .= "</table>";
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
        try {
            if ($this->allAddedEstimatesData) {
                dd('test validation');
                $intId = random_int(100000, 999999);
                if (ModelsSORMaster::create(['estimate_id' => $intId, 'sorMasterDesc' => $this->sorMasterDesc, 'status' => 1])) {
                    foreach ($this->allAddedEstimatesData as $key => $value) {
                        $insert = [
                            'estimate_id' => $intId,
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
                        ];
                        EstimatePrepare::create($insert);
                    }
                    $data = [
                        'estimate_id' => $intId,
                        'estimate_user_type' => 2,
                        'estimate_user_id' => Auth::user()->id,
                    ];
                    EstimateUserAssignRecord::create($data);

                    $this->notification()->success(
                        $title = 'Estimate Prepare Created Successfully!!'
                    );
                    $this->resetSession();
                    $this->emit('openForm');
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
    }
    public function render()
    {
        $this->arrayRow = count($this->allAddedEstimatesData);
        return view('livewire.estimate.edit-estimate-list');
    }
}
