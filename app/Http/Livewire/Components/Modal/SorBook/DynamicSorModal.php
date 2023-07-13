<?php

namespace App\Http\Livewire\Components\Modal\SorBook;

use App\Models\DynamicSorHeader;
use Livewire\Component;

class DynamicSorModal extends Component
{
    protected $listeners = ['openSorModal' => 'getData'];
    public $header_data,$viewModal=false,$selectedIdForEdit;
    public $table_no,$page_no;
    public function getData($id)
    {
        $this->reset();
        $this->viewModal = !$this->viewModal;
        // $getDatas = DynamicSorHeader::where('id',$id)->first();
        // $this->table_no = $getDatas['table_no'];
        // $this->page_no = $getDatas['page_no'];
        // $this->header_data = json_decode($getDatas['header_data'],true);
        // dd($this->header_data);
    }
    public function render()
    {
        if($this->selectedIdForEdit != ''){
            $getDatas = DynamicSorHeader::where('id',$this->selectedIdForEdit)->first();
        $this->header_data = json_decode($getDatas['header_data'],true);
        }

        return view('livewire.components.modal.sor-book.dynamic-sor-modal');
    }
}
