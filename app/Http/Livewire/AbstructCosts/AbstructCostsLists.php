<?php

namespace App\Http\Livewire\AbstructCosts;

use Livewire\Component;
use App\Models\Abstracts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AbstructCostsLists extends Component
{
    public $formOpen = false, $title, $subTitle = "List", $updateDataTableTracker, $openedFormType = false, $isFromOpen, $errorMessage, $tableData = [], $tableContent = [];
    protected $listeners = ['openEntryForm' => 'fromEntryControl', 'showCostData', 'abstractData'];

    public function fromEntryControl($data = '')
    {
        $this->openedFormType = is_array($data) ? $data['formType'] : $data;
        $this->isFromOpen = !$this->isFromOpen;
        switch ($this->openedFormType) {
            case 'create':
                $this->subTitle = 'Create';
                break;
            case 'edit':
                $this->subTitle = 'Edit';
                break;
            default:
                $this->subTitle = 'List';
                break;
        }

        $this->updateDataTableTracker = rand(1, 1000);
    }

    public function mount()
    {
        $this->updateDataTableTracker = rand(1, 1000);
    }

    public function setErrorAlert($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
    public function abstractData($index)
    {
        $this->tableContent = Abstracts::select('tableHeader', 'tableData', 'project_desc', 'total_amount')->where('id', $index)->first();
        $this->tableContent['tableHeader'] = json_decode($this->tableContent['tableHeader'], true);
        $this->tableContent['tableData'] = json_decode($this->tableContent['tableData'], true);

        $this->emit('abstructs', $this->tableContent);
    }
    public function showCostData($index)
    {
        $lists = DB::table('abstruct_costs')->select('tableData', 'project_desc')->where('id', $index)->first();
        $listsData = json_decode($lists->tableData, true);
        // dd($lists);
    }
    public function render()
    {
        $this->tableData = Abstracts::where('department_id', Auth::user()->department_id)
            ->where('created_by', Auth::user()->id)
            ->get();
        // dd($this->tableData);
        $this->updateDataTableTracker = rand(1, 1000);
        $this->title = 'Abstracts of Cost';
        $assets = ['chart', 'animation'];
        return view('livewire.abstruct-costs.abstruct-costs-lists');
    }
}
