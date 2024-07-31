<?php

namespace App\Http\Livewire\EstimateSanctionLimit;

use App\Models\EstimateAcceptanceLimitMaster;
use App\Models\Levels;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class EstimateSanctionMasterCreate extends Component
{
    use Actions;
    public $levels = [], $Inputs = [];
    public function mount()
    {

        $this->levels = Levels::where('id', '!=', 6)->get();
        $this->Inputs[] = [
            'level' => '',
            'min_amount' => '',
            'max_amount' => '',
        ];
    }
    public function addMore()
    {
        // dd(count($this->levels));
        if (count($this->levels) > count($this->Inputs)) {

            $this->Inputs[] = [
                'level' => '',
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
                    if ($input['level'] == $this->Inputs[$value]['level']) {
                        $this->notification()->error(
                            $title = "Level Already Selected"
                        );
                        $this->Inputs[$value]['level'] = '';
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
        // dd($this->Inputs);
        foreach ($this->Inputs as $key => $input) {
            EstimateAcceptanceLimitMaster::create(
                [
                    'department_id' => Auth::user()->department_id,
                    'level_id' => $input['level'],
                    'min_amount' => $input['min_amount'],
                    'max_amount' => $input['max_amount'],
                ]
            );
        }
        $this->notification()->success(
            $title = "created successfully"
        );
        $this->reset();
        $this->emit('openEntryForm');
    }
    public function render()
    {
        return view('livewire.estimate-sanction-limit.estimate-sanction-master-create');
    }
}
