<?php

namespace App\Http\Livewire\Components\Modal\Estimate;

use App\Models\EstimatePrepare;
use ChrisKonnertz\StringCalc\StringCalc;
use Livewire\Component;

class EditEstimateModal extends Component
{
    protected $listeners = ['openEditModal' => 'openEditEstimateModal'];
    public $editEstimateModal = false, $row_id, $editEstimateRow = [], $qty, $rate, $total_amount;

    public function openEditEstimateModal($id, $array)
    {
        $this->reset();
        $this->row_id = $id;
        $this->editEstimateModal = !$this->editEstimateModal;
        $this->editEstimateRow = $array[$id - 1];
        $this->qty = $this->editEstimateRow['qty'];
        $this->rate = $this->editEstimateRow['rate'];
        $this->total_amount = $this->editEstimateRow['total_amount'];
        // dd($this->editEstimateRow[$this->row_id-1]['estimate_id']);
    }
    public function calculateValue()
    {
        if (floatval($this->qty) >= 0 && floatval($this->rate) >= 0) {
            $this->total_amount = floatval($this->qty) * floatval($this->rate);
        }
    }
    public function updateEstimateRow()
    {
        if ($this->row_id != null) {
            $this->editEstimateRow['qty'] = $this->qty;
            $this->editEstimateRow['rate'] = $this->rate;
            $this->editEstimateRow['total_amount'] = $this->total_amount;
            // dd($this->row_id ,$this->editEstimateRow);
            $this->emit('updatedValue', $this->row_id, $this->editEstimateRow);
            $this->row_id = '';
            $this->editEstimateModal = !$this->editEstimateModal;
        }

        // $this->expCalc();

        // dd($this->editEstimateRow);
    }

    // public function expCalc()
    // {
    //     $result = 0;
    //     $tempIndex = strtoupper($this->expression);
    //     $stringCalc = new StringCalc();
    //     try {
    //         if ($this->expression) {
    //             foreach (str_split($this->expression) as $key => $info) {
    //                 $count0 = count($this->allAddedEstimatesData);
    //                 if (ctype_alpha($info)) {
    //                     $alphabet = strtoupper($info);
    //                     $alp_id = ord($alphabet) - 64;
    //                     if ($alp_id <= $count0) {
    //                         if ($this->allAddedEstimatesData[$alp_id]['array_id']) {
    //                             $this->expression = str_replace($info, $this->allAddedEstimatesData[$alp_id]['total_amount'], $this->expression, $key);
    //                         }
    //                     } else {
    //                         $this->notification()->error(
    //                             $title = 'Error !!!',
    //                             $description =  $alphabet . ' is a invalid input'
    //                         );
    //                     }
    //                 } elseif (htmlspecialchars($info) == "%") {
    //                     $this->expression = str_replace($info, "/100*", $this->expression, $key);
    //                 }
    //             }
    //         }
    //         $result = $stringCalc->calculate($this->expression);
    //         $this->insertAddEstimate($tempIndex, '', '', '', '', '', '', '', '', $result, 'Exp Calculoation', '', $this->remarks);
    //     } catch (\Exception $exception) {
    //         $this->expression = $tempIndex;
    //         $this->notification()->error(
    //             $title = $exception->getMessage()
    //         );
    //     }
    // }
    public function render()
    {
        return view('livewire.components.modal.estimate.edit-estimate-modal');
    }
}
