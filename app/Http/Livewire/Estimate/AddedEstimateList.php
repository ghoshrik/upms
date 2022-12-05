<?php

namespace App\Http\Livewire\Estimate;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use ChrisKonnertz\StringCalc\StringCalc;
use ChrisKonnertz\StringCalc\Exceptions\StringCalcException;
use Illuminate\Http\Request;
use WireUi\Traits\Actions;

class AddedEstimateList extends Component
{
    use Actions;
    
    public $addedEstimateData = [];
    public $allAddedEstimatesData = [];
    public $expression, $remarks;

    public function mount()
    {
        $this->setEstimateDataToSession();
    }
    public function resetSession()
    {
        Session()->forget('addedEstimateData');
        $this->reset();
    }
    public function expCalc()
    {
        $result = 0;
        $tempIndex = strtoupper($this->expression);
        $stringCalc = new StringCalc();
        try {
            if ($this->expression) {
                // dd($this->expression,'if');
                // dd(str_split($this->expression),'str_s');
                $amtTot = 0;
                $c = 1;
                foreach (str_split($this->expression) as $key => $info) {
                    $count0 = count($this->allAddedEstimatesData);
                    // dd(ctype_alpha($info),'ctpe');
                    if (ctype_alpha($info)) {
                        $alphabet = strtoupper($info);
                        $alp_id = ord($alphabet) - 64;
                        // dd($alp_id,'alp');
                        if ($alp_id <= $count0) {
                            if ($this->allAddedEstimatesData[$alp_id]['array_id']) {
                                $this->expression = str_replace($info, $this->allAddedEstimatesData[$alp_id]['total_amount'], $this->expression, $key);
                                // dd($this->expression);
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
            $this->resetExcept('allAddedEstimatesData');
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
            foreach ($this->addedEstimateData as $key => $estimate) {
                $this->allAddedEstimatesData[$index][$key] = $estimate;
            }
            Session()->put('addedEstimateData', $this->allAddedEstimatesData);
            $this->reset('addedEstimateData');
        }
    }
    public function render()
    {
        return view('livewire.estimate.added-estimate-list');
    }
    public function logView($data, $of)
    {
        Log::alert('-----------------[Start OF' . $of . ']');
        Log::info(json_encode($data));
        Log::alert('-----------------[END OF' . $of . ']');
    }
}
