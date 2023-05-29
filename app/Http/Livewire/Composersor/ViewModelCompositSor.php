<?php

namespace App\Http\Livewire\Composersor;

use App\Models\SOR;
use Livewire\Component;

class ViewModelCompositSor extends Component
{
    public $listeners = ["viewModal" => "ViewProcess"];
    public $viewVerifyModal = false, $viewCompositSOR = [];

    public function ViewProcess($value)
    {
        $this->viewVerifyModal = !$this->viewVerifyModal;
        $this->viewCompositSOR = SOR::where('id', $value)->get();
    }
    public function render()
    {
        return view('livewire.composersor.view-model-composit-sor');
    }
}
