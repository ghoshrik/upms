<?php

namespace App\Http\Livewire\Sor;

use Livewire\Component;

class CreateSor extends Component
{
    public $inputsData = [];
    public function mount()
    {
        $this->inputsData = [
            [
                'item_details' => '',
                'dept_category_id' => '',
                'description' => '',
                'unit' => 0,
                'cost' => 0,
                'version' => '',
                'effect_from' => now(),
            ]
        ];
    }
    public function addNewRow()
    {
        $this->inputsData[] =
            [
                'item_details' => '',
                'dept_category_id' => '',
                'description' => '',
                'unit' => 0,
                'cost' => 0,
                'version' => '',
                'effect_from' => now(),
            ];
    }
    public function removeRow($index)
    {
        if (count($this->inputsData) > 1) {
            unset($this->inputsData[$index]);
            $this->inputsData =  array_values($this->inputsData);
            return;
        }
    }
    public function render()
    {
        return view('livewire.sor.create-sor');
    }
}
