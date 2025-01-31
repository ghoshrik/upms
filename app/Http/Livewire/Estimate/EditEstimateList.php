<?php

namespace App\Http\Livewire\Estimate;

use App\Models\EstimatePrepare;
use App\Models\EstimateUserAssignRecord;
use App\Models\SorMaster;
use ChrisKonnertz\StringCalc\StringCalc;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class EditEstimateList extends Component
{
    use Actions;
    protected $listeners = ['updatedValue' => 'updateEstimateData'];
    public $eid = 0;
    public $updateEstimate_id;
    public $addedEstimateData = [];
    public $allAddedEstimatesData = [];
    public $currentEstimateData = [];
    public $expression, $remarks, $level = [], $openTotalButton = false, $arrayStore = [], $totalEstimate = 0, $arrayIndex, $arrayRow, $sorMasterDesc, $addedEstimateUpdateTrack;

    public function mount()
    {
        $this->setEstimateDataToSession();
    }
    public function resetSession()
    {
        Session()->forget('editEstimateData');
        $this->reset();
    }
    public function insertAddEstimate($row_index, $dept_id, $category_id, $sor_item_number, $item_name, $other_name, $description, $qty, $rate, $total_amount, $operation, $version, $remarks)
    {
        $this->addedEstimateData['row_index'] = $row_index;
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
        $this->resetExcept('allAddedEstimatesData', 'sorMasterDesc', 'updateEstimate_id');
    }
    //calculate estimate list
    public function expCalc()
    {
        $result = 0;
        $row_index = strtoupper($this->expression);
        $stringCalc = new StringCalc();
        try {
            if ($this->expression) {
                foreach (str_split($this->expression) as $key => $info) {
                    $count0 = count($this->allAddedEstimatesData);
                    if (ctype_alpha($info)) {
                        $alphabet = strtoupper($info);
                        $alp_id = ord($alphabet) - 64;
                        if ($alp_id <= $count0) {
                            if ($this->allAddedEstimatesData[$alp_id - 1]['row_id']) {
                                $this->expression = str_replace($info, $this->allAddedEstimatesData[$alp_id - 1]['total_amount'], $this->expression, $key);
                            }
                        } else {
                            $this->notification()->error(
                                $title = 'Error !!!',
                                $description = $alphabet . ' is a invalid input'
                            );
                        }
                    } elseif (htmlspecialchars($info) == "%") {
                        $this->expression = str_replace($info, "/100*", $this->expression, $key);
                    }
                }
            }
            $result = $stringCalc->calculate($this->expression);
            $this->insertAddEstimate($row_index, '', '', '', '', '', '', '', '', $result, 'Exp Calculation', '', $this->remarks);
        } catch (\Exception$exception) {
            $this->expression = $row_index;
            $this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => $exception->getMessage(),
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
                $result = $result + $this->allAddedEstimatesData[$array - 1]['total_amount'];
            }
            $this->arrayIndex = implode('+', $this->arrayStore); //chr($this->indexCount + 64)
            $this->insertAddEstimate($this->arrayIndex, '', '', '', '', '', '', '', '', $result, 'Total', '', '');
        } else {
            $this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => "Minimum select 2 Check boxes",
            ]);
        }
    }

    public function setEstimateDataToSession()
    {
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
            $index = count($this->allAddedEstimatesData);
            if (!array_key_exists("operation", $this->addedEstimateData)) {
                $this->addedEstimateData['operation'] = '';
            }

            if (!array_key_exists("row_id", $this->addedEstimateData)) {
                $this->addedEstimateData['row_id'] = $index + 1;
            }

            if (!array_key_exists("row_index", $this->addedEstimateData)) {
                $this->addedEstimateData['row_index'] = '';
            }
            if (!array_key_exists("comments", $this->addedEstimateData)) {
                $this->addedEstimateData['comments'] = '';
            }
            $this->allAddedEstimatesData[$index] = $this->addedEstimateData;
            Session()->put('editEstimateData', $this->allAddedEstimatesData);
            $this->reset('addedEstimateData');
        }
    }
    public function confDeleteDialog($value): void
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => "Delete can't be undo!",
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
        unset($this->allAddedEstimatesData[$value - 1]);
        Session()->forget('editEstimateData');
        Session()->put('editEstimateData', $this->allAddedEstimatesData);
        // $this->addedEstimateUpdateTrack = rand(1, 1000);
        $this->level = [];
        $this->notification()->success(
            $title = 'Row Deleted Successfully'
        );
    }
    public function editEstimate($value)
    {
        $this->emit('openEditModal', $value, $this->allAddedEstimatesData);
    }
    public function updateEstimateData($updateValue, $id)
    {
        $this->allAddedEstimatesData[$id - 1] = $updateValue;
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
                    $this->allAddedEstimatesData[$value['row_id'] - 1]['total_amount'] = $result;
                    Session()->forget('editEstimateData');
                    Session()->put('editEstimateData', $this->allAddedEstimatesData);
                } catch (\Exception$exception) {
                    $this->dispatchBrowserEvent('alert', [
                        'type' => 'error',
                        'message' => $exception->getMessage(),
                    ]);
                }
            }
        }
    }
    public function exportWord()
    {
        // $this->notification()->error(
        //     $title = 'Under Process'
        // );
        $exportDatas = array_values($this->allAddedEstimatesData);
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

            $html .= "<tr><td style='text-align: center'>" . chr($export['row_id'] + 64) . "</td>&nbsp;";
            if ($export['sor_item_number']) {
                $html .= "<td style='text-align: center'>" . getSorItemNumber($export['sor_item_number']) . ' ( ' . getVersion($export['sor_item_number']) . ' )' . "</td>&nbsp;";
            } else {
                $html .= "<td style='text-align: center'>--</td>&nbsp;";
            }
            if ($export['sor_item_number']) {
                $html .= "<td style='text-align: center'>" . getSorItemNumberDesc($export['sor_item_number']) . "</td>&nbsp;";
            } elseif ($export['operation']) {
                if ($export['operation'] == 'Total') {
                    $html .= "<td style='text-align: center'> Total of (" . $export['row_index'] . " )</td>&nbsp;";
                } else {
                    if ($export['comments'] != '') {
                        $html .= "<td style='text-align: center'> " . $export['row_index'] . " ( " . $export['comments'] . " )" . "</td>&nbsp;";
                    } else {
                        $html .= "<td style='text-align: center'> " . $export['row_index'] . "</td>&nbsp;";
                    }
                }
            } else {
                $html .= "<td style='text-align: center'>" . $export['other_name'] . "</td>&nbsp;";
            }
            $html .= "<td style='text-align: center'>" . $export['qty'] . "</td>&nbsp;";
            $html .= "<td style='text-align: center'>" . $export['rate'] . "</td>&nbsp;";
            $html .= "<td style=''>" . $export['total_amount'] . "</td></tr>";
        }
        $html .= "<tr align='right'><td colspan='5' align='right'>Total</td>";
        foreach ($exportDatas as $key => $export) {
            if ($export['operation'] == 'Total') {
                $estTotal = $export['total_amount'];
            } else {
                $estTotal = '--';
            }
        }
        $html .= "<td colspan='1' align='right'>" . $estTotal . "</td>";
        $html .= "</tr>";
        $html .= "</table>";
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
        $pw->save('estimate item ' . $date . '.docx', "Word2007");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment;filename=\"convert.docx\"");
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($pw, "Word2007");
        // dd($objWriter);
        $objWriter->save('estimate item ' . $date . '.docx');
        return response()->download('estimate item ' . $date . '.docx')->deleteFileAfterSend(true);
        $this->reset('exportDatas');
    }
    public function store($estimateStoreId)
    {
        try {
            if ($this->allAddedEstimatesData) {
                // if (count(SorMaster::where('estimate_id',$estimateStoreId)->where('status',1)->get()) == 1) {
                if (true) {
                    EstimatePrepare::where('estimate_id', $estimateStoreId)->delete();
                    foreach ($this->allAddedEstimatesData as $key => $value) {
                        $insert = [
                            'estimate_id' => $estimateStoreId,
                            'dept_id' => $value['dept_id'],
                            'category_id' => $value['category_id'],
                            'row_id' => $value['row_id'],
                            'row_index' => $value['row_index'],
                            'sor_item_number' => $value['sor_item_number'],
                            'item_name' => $value['item_name'],
                            'other_name' => $value['other_name'],
                            'qty' => $value['qty'],
                            'rate' => $value['rate'],
                            'total_amount' => $value['total_amount'],
                            'operation' => $value['operation'],
                            'created_by' => Auth::user()->id,
                            'comments' => $value['comments'],
                        ];
                        EstimatePrepare::create($insert);
                    }
                    SorMaster::where('estimate_id', $estimateStoreId)->update(['status' => 5]);
                    $data = [
                        'estimate_id' => $estimateStoreId,
                        // 'estimate_user_type' => 4,
                        'status' => 5,
                        'user_id' => Auth::user()->id,
                    ];
                    $assignDetails = EstimateUserAssignRecord::create($data);
                    if ($assignDetails) {
                        $returnId = $assignDetails->id;
                        EstimateUserAssignRecord::where([['estimate_id', $estimateStoreId], ['id', '!=', $returnId], ['is_done', 0]])->groupBy('estimate_id')->update(['is_done' => 1]);
                    }
                    $this->notification()->success(
                        $title = 'Estimate Prepare Updated Successfully!!'
                    );
                    $this->resetSession();
                    $this->emit('openForm');
                } else {
                    // if(SorMaster::where('estimate_id', $value)->update(['status' => 1])){
                    //     foreach ($this->allAddedEstimatesData as $key => $value) {
                    //         $insert = [
                    //             'estimate_id' => $value,
                    //             'dept_id' => $value['dept_id'],
                    //             'category_id' => $value['category_id'],
                    //             'row_id' => $value['row_id'],
                    //             'row_index' => $value['row_index'],
                    //             'sor_item_number' => $value['sor_item_number'],
                    //             'item_name' => $value['item_name'],
                    //             'other_name' => $value['other_name'],
                    //             'qty' => $value['qty'],
                    //             'rate' => $value['rate'],
                    //             'total_amount' => $value['total_amount'],
                    //             'operation' => $value['operation'],
                    //             'created_by' => Auth::user()->id,
                    //             'comments' => $value['comments'],
                    //         ];
                    //         EstimatePrepare::create($insert);
                    //     }
                    //     $this->notification()->success(
                    //         $title = 'Estimate Prepare Updated Successfully!!'
                    //     );
                    // }
                    $this->notification()->error(
                        $title = 'please select correct data !!'
                    );
                }
            } else {
                $this->notification()->error(
                    $title = 'please insert at list one item !!'
                );
            }
        } catch (\Throwable$th) {
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
