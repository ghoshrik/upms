<?php

namespace App\Http\Livewire\SorBook;

use App\Models\DynamicSorHeader;
use Livewire\Component;

class CreateDynamicSor extends Component
{
    public $header_data,$selectedIdForEdit;
    public function render()
    {
        $getDatas = DynamicSorHeader::where('id',$this->selectedIdForEdit)->first();
        $this->header_data = json_decode($getDatas['header_data'],true);
        return view('livewire.sor-book.create-dynamic-sor');
    }
}
