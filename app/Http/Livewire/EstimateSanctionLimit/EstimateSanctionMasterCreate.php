<?php

namespace App\Http\Livewire\EstimateSanctionLimit;

use App\Models\Role;
use App\Models\Levels;
use Livewire\Component;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\EstimateAcceptanceLimitMaster;

class EstimateSanctionMasterCreate extends Component
{
    use Actions;
    public $levels = [], $Inputs = [];
    public function mount()
    {
        // TODO: Replace level with role_id every where on database also
        // $this->levels = Levels::where('id', '!=', 6)->get();
        $this->levels = Role::whereNotNull('has_level_no')->whereNotIn('has_level_no', [6, 0])->orderBy('has_level_no')->get();
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
    public function getCheckRole($value)
    {
        if (count($this->Inputs) > 1) {
            foreach ($this->Inputs as $key => $input) {
                if ($key != $value) {
                    if ($input['level'] == $this->Inputs[$value]['level']) {
                        $this->notification()->error(
                            $title = "Role Already Selected"
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
        DB::beginTransaction();

        try {
            foreach ($this->Inputs as $input) {
                EstimateAcceptanceLimitMaster::create([
                    'department_id' => Auth::user()->department_id,
                    'level_id' => $input['level'],
                    'min_amount' => $input['min_amount'],
                    'max_amount' => ($input['max_amount'] != '') ? $input['max_amount'] : null,
                ]);
            }

            DB::commit();

            $this->notification()->success(
                $title = "Created Successfully"
            );
            $this->reset();
            $this->emit('openEntryForm');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('showError',$e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.estimate-sanction-limit.estimate-sanction-master-create');
    }
}
