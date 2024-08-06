<?php

namespace App\Http\Livewire\EstimateSanctionLimit;

use App\Models\Role;
use Livewire\Component;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\EstimateAcceptanceLimitMaster;

class EstimateSanctionMasterCreate extends Component
{
    use Actions;
    public $levels = [], $Inputs = [],$roles = [];
    public function mount()
    {
        // $this->levels = Levels::where('id', '!=', 6)->get();
        $this->roles = Role::where('has_level_no','!=',null)->where('has_level_no','!=',6)->orderBy('has_level_no')->get();
        $this->Inputs[] = [
            // 'level' => '',
            'role_id' => '',
            'min_amount' => '',
            'max_amount' => '',
        ];
    }
    public function addMore()
    {
        // dd(count($this->levels));
        // if (count($this->levels) > count($this->Inputs)) {
            if (count($this->roles) > count($this->Inputs)) {
            $this->Inputs[] = [
                // 'level' => '',
                'role_id' => '',
                'min_amount' => '',
                'max_amount' => '',
            ];
        }
        // dd($this->Inputs);
    }
    public function getCheckLevel($value)
    {
        if (count($this->Inputs) > 1) {
            foreach ($this->Inputs as $key => $input) {
                if ($key != $value) {
                    if ($input['role_id'] == $this->Inputs[$value]['role_id']) {
                        $this->notification()->error(
                            $title = "Role Already Selected"
                        );
                        $this->Inputs[$value]['role_id'] = '';
                    }
                }
            }
        }
    }
    public function deleteMore($index)
    {
        unset($this->Inputs[$index]);

    }
    public function store()
    {
        DB::beginTransaction();
        try {
            foreach ($this->Inputs as $key => $input) {
                EstimateAcceptanceLimitMaster::create(
                    [
                        'department_id' => Auth::user()->department_id,
                        'role_id' => $input['role_id'],
                        'min_amount' => $input['min_amount'],
                        'max_amount' => ($input['max_amount'] != "") ? $input['max_amount'] : null,
                    ]
                );
            }
            DB::commit();
            $this->notification()->success(
                $title = "Created successfully"
            );
            $this->reset();
            $this->emit('openEntryForm');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->notification()->error(
                $title = "Failed to create records",
                $description = $e->getMessage()
            );
            $this->emit('showError',$e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.estimate-sanction-limit.estimate-sanction-master-create');
    }
}
