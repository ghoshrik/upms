<?php

namespace App\Http\Livewire\AbstructCosts;

use Livewire\Component;
use App\Models\Abstracts;

class AbstractModelCosts extends Component
{

    public $tableContent = [];
    public $viewModal = false, $abstract_id;
    protected $listeners = ['RowAbstractData' => 'ItemDataLists'];

    public function ItemDataLists($abstract_id)
    {
        $abstract_id = is_array($abstract_id) ? $abstract_id[0] : $abstract_id;
        $this->reset();
        $this->viewModal = !$this->viewModal;
        if ($abstract_id) {
            $this->abstract_id = $abstract_id;
            $this->tableContent = Abstracts::select('tableHeader', 'tableData', 'project_desc', 'total_amount')->where('id', $this->abstract_id)->first();
            $this->tableContent['tableHeader'] = json_decode($this->tableContent['tableHeader'], true);
            $this->tableContent['tableData'] = json_decode($this->tableContent['tableData'], true);
            $this->tableContent['description'] = $this->tableContent['project_desc'];
            $this->tableContent['total_amount'] = $this->tableContent['total_amount'];

            $this->emit('ListAbs', $this->tableContent);
        }
    }

    public function render()
    {
        return view('livewire.abstruct-costs.abstract-model-costs');
    }
}
