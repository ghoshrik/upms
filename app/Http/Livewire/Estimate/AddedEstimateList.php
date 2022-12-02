<?php

namespace App\Http\Livewire\Estimate;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use ChrisKonnertz\StringCalc\StringCalc;
use ChrisKonnertz\StringCalc\Exceptions\StringCalcException;
use Illuminate\Http\Request;

class AddedEstimateList extends Component
{
    public $addedEstimateData = [];
    public $allAddedEstimatesData = [];
    public $expression, $remarks;
    public function booted()
    {
        // $this->resetSession();
        if ($this->addedEstimateData == null) {
            return;
        }
        $this->setEstimateDataToSession();
    }
    public function resetSession()
    {
        Session()->forget('addedEstimateData');
        dd(Session()->get('addedEstimateData'));
    }
    public function expCalc()
    {
        $result = 0;
        $tempIndex = strtoupper($this->expression);
        $stringCalc = new StringCalc();
        try {
            if ($this->expression) {
                $amtTot = 0;
                $c = 1;
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
            $this->addedEstimateData['arrayIndex'] = $tempIndex;
            $this->addedEstimateData['dept_id'] = '';
            $this->addedEstimateData['category_id'] = '';
            $this->addedEstimateData['sor_item_number'] = '';
            $this->addedEstimateData['item_name'] = '';
            $this->addedEstimateData['other_name'] = '';
            $this->addedEstimateData['description'] = '';
            $this->addedEstimateData['qty'] = '';
            $this->addedEstimateData['rate'] = '';
            $this->addedEstimateData['total_amount'] = $result;
            $this->addedEstimateData['operation'] = 'Exp Calculoation';
            $this->addedEstimateData['version'] = '';
            $this->addedEstimateData['remarks'] = $this->remarks;
            $this->setEstimateDataToSession();
        } catch (\Exception $exception) {
            $this->expression = $tempIndex;
            $this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }
    public function setEstimateDataToSession()
    {
        // dd(Session()->get('addedEstimateData'));
        $this->reset('allAddedEstimatesData');
        $this->logView(Session()->get('addedEstimateData'),'sseion-top');
        $this->logView($this->addedEstimateData,'addedEstimateData');
        if (Session()->has('addedEstimateData')) {
            $this->allAddedEstimatesData = Session()->get('addedEstimateData');
        }
        // dd(Session()->get('addedEstimateData'));
        $index = count($this->allAddedEstimatesData) + 1;
        $this->logView($index,'index');
        if (!array_key_exists("operation", $this->addedEstimateData)) {
            $this->addedEstimateData['operation'] = '';
            $this->logView($this->addedEstimateData,'addedEstimateData-oparation');
        }
        if (!array_key_exists("array_id", $this->addedEstimateData)) {
            $this->addedEstimateData['array_id'] = '';
            $this->logView($this->addedEstimateData,'addedEstimateData-array_id');
        }
        if (!array_key_exists("arrayIndex", $this->addedEstimateData)) {
            $this->addedEstimateData['arrayIndex'] = '';
            $this->logView($this->addedEstimateData,'addedEstimateData-arr_in');
        }
        foreach ($this->addedEstimateData as $key => $estimate) {
            $this->allAddedEstimatesData[$index][$key] = $estimate;
        }
        $this->logView($this->allAddedEstimatesData,'$this->allAddedEstimatesData');
        $this->logView(Session()->get('addedEstimateData'),'sseion-buttom');
        Session()->put('addedEstimateData', $this->allAddedEstimatesData);
        // dd(Session()->get('addedEstimateData'));
        $this->reset('addedEstimateData');
        // dd($this->allAddedEstimatesData);
    }
    public function render()
    {
        return view('livewire.estimate.added-estimate-list');
    }
    public function logView($data,$of)
    {
        Log::alert('-----------------[Start OF'.$of.']');
        Log::info(json_encode($data));
        Log::alert('-----------------[END OF'.$of.']');
    }
}
