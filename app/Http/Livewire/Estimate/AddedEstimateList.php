<?php

namespace App\Http\Livewire\Estimate;

use App\Models\EstimatePrepare;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use ChrisKonnertz\StringCalc\StringCalc;
use App\Models\SORMaster as ModelsSORMaster;
use Illuminate\Support\Facades\Auth;
use App\Models\EstimateUserAssignRecord;
use ChrisKonnertz\StringCalc\Exceptions\StringCalcException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use WireUi\Traits\Actions;

class AddedEstimateList extends Component
{
    use Actions;
    public $addedEstimateData = [];
    public $allAddedEstimatesData = [];
    public $expression, $remarks, $level = [], $openTotalButton = false, $arrayStore = [], $totalEstimate = 0, $arrayIndex, $arrayRow, $sorMasterDesc;

    public function mount()
    {
        $this->setEstimateDataToSession();
    }
    public function resetSession()
    {
        Session()->forget('addedEstimateData');
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
                            if ($this->allAddedEstimatesData[$alp_id]['array_id']) {
                                $this->expression = str_replace($info, $this->allAddedEstimatesData[$alp_id]['total_amount'], $this->expression, $key);
                            }
                        } else {
                            $this->dispatchBrowserEvent('alert', [
                                'type' => 'error',
                                'message' => $alphabet . ' is a invalid input'
                            ]);
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
    public function setEstimateDataToSession()
    {
        $this->reset('allAddedEstimatesData');
        if (Session()->has('addedEstimateData')) {
            $this->allAddedEstimatesData = Session()->get('addedEstimateData');
        }
        if ($this->addedEstimateData != null) {
            $index = count($this->allAddedEstimatesData) + 1;
            if (!array_key_exists("operation", $this->addedEstimateData)) {
                $this->addedEstimateData['operation'] = '';
            }
            if (!array_key_exists("array_id", $this->addedEstimateData)) {
                $this->addedEstimateData['array_id'] = $index;
            }
            if (!array_key_exists("arrayIndex", $this->addedEstimateData)) {
                $this->addedEstimateData['arrayIndex'] = '';
            }
            if (!array_key_exists("remarks", $this->addedEstimateData)) {
                $this->addedEstimateData['remarks'] = '';
            }
            foreach ($this->addedEstimateData as $key => $estimate) {
                $this->allAddedEstimatesData[$index][$key] = $estimate;
            }
            Session()->put('addedEstimateData', $this->allAddedEstimatesData);
            $this->reset('addedEstimateData');
        }
    }
    public function openModal($value): void
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
        unset($this->allAddedEstimatesData[$value]);
        Session()->forget('addedEstimateData');
        Session()->put('addedEstimateData', $this->allAddedEstimatesData);
        $this->level = [];
        $this->notification()->error(
            $title = 'Row Deleted Successfully'
        );
    }
    public function store()
    {
        // dd($this->allAddedEstimatesData);
        try {
            if ($this->allAddedEstimatesData) {
                $intId = random_int(100000, 999999);
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
                    // dd($insert);
                    // DB::table('estimate_prepares')->insert($insert);
                    EstimatePrepare::create($insert);
                }
                ModelsSORMaster::create(['estimate_id' => $intId, 'sorMasterDesc' => $this->sorMasterDesc, 'status' => 1]);
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
                // $this->draftData();
                // sleep(2);//return redirect page after second later
                // return redirect()->route('estimate-prepare');
                $this->emit('openForm');

            } else {

                $this->notification()->error(
                    $title = 'please insert at list one item !!'
                );
            }
        } catch (\Throwable $th) {
            session()->flash('serverError', $th->getMessage());
        }
    }
    public function render()
    {
        $this->arrayRow = count($this->allAddedEstimatesData);
        return view('livewire.estimate.added-estimate-list');
    }
    public function logView($data, $of)
    {
        Log::alert('-----------------[Start OF' . $of . ']');
        Log::info(json_encode($data));
        Log::alert('-----------------[END OF' . $of . ']');
    }
}
