<?php

namespace App\Http\Livewire\Report;

use App\Models\SorMaster;
use Livewire\Component;

class MisReport extends Component
{
    public $titel, $errorMessage, $subTitel = "List";
    protected $listeners = ['openEntryForm' => 'fromEntryControl', 'showError' => 'setErrorAlert'];
    public $projectDtls = [];


    public function setErrorAlert($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
    public function mount()
    {
        $this->projectDtls = SorMaster::select('departments.department_name', 'departments.department_code', 'estimate_statuses.status', 'sor_masters.estimate_id', 'sor_masters.sorMasterDesc')
            ->join('estimate_statuses', 'sor_masters.status', '=', 'estimate_statuses.id')
            ->join('departments', 'sor_masters.dept_id', '=', 'departments.id')
            ->get();
        // dd($this->projectDtls);
    }
    public function render()
    {
        $assets = ['chart', 'animation'];
        $this->titel = 'Mis Reports';
        return view('livewire.report.mis-report', compact('assets'));
    }
}
