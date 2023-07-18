<?php

namespace App\Http\Livewire\SorBook;

use App\Models\DynamicSorHeader;
use Livewire\Component;

class CreateDynamicSor extends Component
{
    public $header_data,$row_data,$selectedIdForEdit,$selectedId;
    public function render()
    {
        $getDatas = DynamicSorHeader::where('id',$this->selectedIdForEdit)->first();
        $this->selectedId = $getDatas['id'];
        $this->header_data = json_decode($getDatas['header_data'],true);
        $this->row_data = json_decode($getDatas['row_data'],true);
        // dd($this->header_data,$this->row_data);
        return view('livewire.sor-book.create-dynamic-sor');
    }
}
