<?php

namespace App\Http\Livewire\EstimateProject;

use App\Models\EstimatePrepare;
use App\Models\EstimateUserAssignRecord;
use App\Models\SorMaster;
use ChrisKonnertz\StringCalc\StringCalc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use WireUi\Traits\Actions;

class EditEstimateProjectList extends Component
{
    use Actions;
    public $addedEstimateData = [];
    public $allAddedEstimatesData = [];
    public $expression, $remarks, $level = [], $openTotalButton = false, $arrayStore = [], $totalEstimate = 0, $arrayIndex, $arrayRow, $sorMasterDesc,$updateDataTableTracker;
    public $currentEstimateProjectData = [];
    public $updateEstimateprojectId;
    protected $listeners = ['updatedValue' => 'updateEstimateProjectData'];

    public function mount()
    {
        $this->setEstimateDataToSession();
    }

    public function resetSession()
    {
        Session()->forget('editEstimateProjectData');
        $this->reset();
    }
    public function viewModal($estimate_id)
    {
        $this->emit('openModal', $estimate_id);
    }
    //calculate estimate list
    public function insertAddEstimate($arrayIndex, $dept_id, $category_id, $sor_item_number, $item_name, $other_name, $description, $qty, $rate, $total_amount, $operation, $version, $remarks)
    {
        $this->addedEstimateData['row_index'] = $arrayIndex;
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
                            if ($this->allAddedEstimatesData[$alp_id-1]['row_id']) {
                                $this->expression = str_replace($info, $this->allAddedEstimatesData[$alp_id-1]['total_amount'], $this->expression, $key);
                            }
                        } else {
                            $this->notification()->error(
                                $title = $alphabet . ' is a invalid input'
                            );
                        }
                    } elseif (htmlspecialchars($info) == "%") {
                        $this->expression = str_replace($info, "/100*", $this->expression, $key);
                    }
                }
            }
            $result = $stringCalc->calculate($this->expression);
            $this->insertAddEstimate($row_index, '', '', '', '', '', '', '', '', $result, 'Exp Calculoation', '', $this->remarks);
        } catch (\Exception $exception) {
            $this->expression = $row_index;
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

    public function totalOnSelected()
    {
        if (count($this->level) >= 2) {
            $result = 0;
            foreach ($this->level as $key => $array) {
                $this->arrayStore[] = chr($array + 64);
                $result = $result + $this->allAddedEstimatesData[$array-1]['total_amount'];
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

    public function setEstimateDataToSession()
    {
        $this->reset('allAddedEstimatesData');
        if (Session()->has('editEstimateProjectData')) {
            $this->allAddedEstimatesData = Session()->get('editEstimateProjectData');
        }
        if ($this->currentEstimateProjectData != null) {
            $this->allAddedEstimatesData = $this->currentEstimateProjectData;
            Session()->put('editEstimateProjectData', $this->allAddedEstimatesData);
            $this->reset('currentEstimateProjectData');
        }
        if ($this->addedEstimateData != null) {
            $index = count($this->allAddedEstimatesData) + 1;
            if (!array_key_exists("operation", $this->addedEstimateData)) {
                $this->addedEstimateData['operation'] = '';
            }
            if (!array_key_exists("row_id", $this->addedEstimateData)) {
                $this->addedEstimateData['row_id'] = $index;
            }
            if (!array_key_exists("row_index", $this->addedEstimateData)) {
                $this->addedEstimateData['row_index'] = '';
            }
            if (!array_key_exists("comments", $this->addedEstimateData)) {
                $this->addedEstimateData['comments'] = '';
            }
            if (!array_key_exists("estimate_no", $this->addedEstimateData)) {
                $this->addedEstimateData['estimate_no'] = '';
            }
            foreach ($this->addedEstimateData as $key => $estimate) {
                $this->allAddedEstimatesData[$index][$key] = $estimate;
            }
            Session()->put('editEstimateProjectData', $this->allAddedEstimatesData);
            $this->reset('addedEstimateData');
        }
        // dd(Session('editEstimateProjectData'));
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
        Session()->forget('editEstimateProjectData');
        // dd(Session()->get('editEstimateProjectData'),$this->allAddedEstimatesData);
        Session()->put('editEstimateProjectData', $this->allAddedEstimatesData);
        // dd(Session()->get('editEstimateData'),$this->allAddedEstimatesData);

        // $this->addedEstimateUpdateTrack = rand(1, 1000);
        $this->level = [];
        $this->notification()->success(
            $title = 'Row Deleted Successfully'
        );
    }
    public function editEstimate($value)
    {
        $this->emit('openEditModal', $value,$this->allAddedEstimatesData);
    }
    public function updateEstimateProjectData($updateValue,$id)
    {
        $this->allAddedEstimatesData[$id-1] = $updateValue;
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
                    $this->allAddedEstimatesData[$value['row_id']-1]['total_amount'] = $result;
                    Session()->forget('editEstimateData');
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
// TODO::export word on project estimate
    public function exportWord()
    {
        $exportDatas = array_values($this->allAddedEstimatesData);
        // dd($exportDatas);
        $date = date('Y-m-d');
        $pw = new \PhpOffice\PhpWord\PhpWord();
        $section = $pw->addSection(
            array('marginLeft' => 600, 'marginRight' => 200,
                'marginTop' => 600, 'marginBottom' => 200)
        );
        $html = "<h1 style='font-size:24px;font-weight:600;text-align: center;'>Estimate Preparation Details</h1>";
        $html .= "<p>This is for test purpose</p>";
        $html .= "<table style='border: 1px solid black;width:auto'><tr>";
        $html .= "<th scope='col' style='text-align: center'>Serial No.</th>";
        $html .= "<th scope='col' style='text-align: center'>Item Number/<br/>Project No(Ver.)</th>";
        $html .= "<th scope='col' style='text-align: center'>Description</th>";
        $html .= "<th scope='col' style='text-align: center'>Quantity</th>";
        $html .= "<th scope='col' style='text-align: center'>Unit Price</th>";
        $html .= "<th scope='col' style='text-align: center' >Cost</th></tr>";
        foreach ($exportDatas as $key => $export) {
            $html .= "<tr><td style='text-align: center'>" . chr($export['row_id'] + 64) . "</td>&nbsp;";
            if ($export['sor_item_number']) {
                $html .= "<td style='text-align: center'>" . getSorItemNumber($export['sor_item_number']) . ' ( ' . $export['version'] . ' )' . "</td>&nbsp;";
            }elseif($export['estimate_no']){
                $html .= "<td style='text-align: center'>" . $export['estimate_no'] . "</td>&nbsp;";
            }
            else {
                $html .= "<td style='text-align: center'>--</td>&nbsp;";
            }
            if ($export['description']) {
                $html .= "<td style='text-align: center'>" . $export['description'] . "</td>&nbsp;";
            } elseif ($export['operation']) {
                if ($export['operation'] == 'Total') {
                    $html .= "<td style='text-align: center'> Total of (" . $export['row_index'] . " )</td>&nbsp;";
                } else {
                    if ($export['remarks'] != '') {
                        $html .= "<td style='text-align: center'> " . $export['row_index'] . " ( " . $export['remarks'] . " )" . "</td>&nbsp;";
                    } else {
                        $html .= "<td style='text-align: center'> " . $export['row_index'] . "</td>&nbsp;";
                    }
                }
            }elseif($export['other_name']){
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
        $html .= "<table style='border: 1px solid black;width:auto'><tr>";
        $html .= "<th scope='col' style='text-align: center'>Serial No.</th>";
        $html .= "<th scope='col' style='text-align: center'>Item Number(Ver.)</th>";
        $html .= "<th scope='col' style='text-align: center'>Description</th>";
        $html .= "<th scope='col' style='text-align: center'>Quantity</th>";
        $html .= "<th scope='col' style='text-align: center'>Unit Price</th>";
        $html .= "<th scope='col' style='text-align: center' >Cost</th></tr>";
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

    public function store($estimateStoreId)
    {
        try {
            if ($this->allAddedEstimatesData) {
                EstimatePrepare::where('estimate_id',$estimateStoreId)->delete();
                if (true) {
                    foreach ($this->allAddedEstimatesData as $key => $value) {
                        $insert = [
                            'estimate_id' => $estimateStoreId,
                            'estimate_no' => $value['estimate_no'],
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
                    SorMaster::where('estimate_id',$estimateStoreId)->update(['status'=>10]);
                    $data = [
                        'estimate_id' => $estimateStoreId,
                        // 'estimate_user_type' => 4,
                        'status' => 10,
                        'user_id' => Auth::user()->id,
                    ];
                    $assignDetails = EstimateUserAssignRecord::create($data);
                    if ($assignDetails) {
                        $returnId = $assignDetails->id;
                        EstimateUserAssignRecord::where([['estimate_id',$estimateStoreId],['id','!=',$returnId],['is_done',0]])->groupBy('estimate_id')->update(['is_done'=>1]);
                    }
                    $this->notification()->success(
                        $title = 'Project Estimate Created Successfully!!'
                    );
                    $this->resetSession();
                    $this->updateDataTableTracker = rand(1,1000);
                    $this->emit('openForm');
                }
            } else {
                $this->notification()->error(
                    $title = 'OOPS! Something went wrong'
                );
            }
        } catch (\Throwable $th) {
            // session()->flash('serverError', $th->getMessage());
            $this->emit('showError', $th->getMessage());
        }
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1,1000);
        $this->arrayRow = count($this->allAddedEstimatesData);
        return view('livewire.estimate-project.edit-estimate-project-list');
    }
}
