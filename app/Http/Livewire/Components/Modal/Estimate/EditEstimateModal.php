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
        // dd($this->editEstimateRow['qty']);
        // dd($this->editEstimateRow[$this->row_id-1]['estimate_id']);
    }
    public function calculateValue()
    {
        if (floatval($this->qty) >= 0 && floatval($this->rate) >= 0) {
            $this->total_amount = round(floatval($this->qty) * floatval($this->rate), 2);
        }
    }
    public function updateEstimateRow()
    {
        if ($this->row_id != null) {
            $this->editEstimateRow['qty'] = $this->qty;
            $this->editEstimateRow['rate'] = $this->rate;
            $this->editEstimateRow['total_amount'] = $this->total_amount;
            // dd($this->row_id ,$this->editEstimateRow);
            $this->emit('updatedValue', $this->editEstimateRow, $this->row_id);
            $this->row_id = '';
            $this->editEstimateModal = !$this->editEstimateModal;
        }
    }

    public function render()
    {
        return view('livewire.components.modal.estimate.edit-estimate-modal');
    }
}
