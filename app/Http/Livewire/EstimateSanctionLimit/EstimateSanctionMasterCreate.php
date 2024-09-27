<?php

namespace App\Http\Livewire\EstimateSanctionLimit;

use App\Models\Role;
use Livewire\Component;
use App\Models\Department;
use WireUi\Traits\Actions;
use App\Models\ProjectType;
use Illuminate\Support\Facades\DB;
use App\Models\SanctionLimitMaster;
use Illuminate\Support\Facades\Auth;

class EstimateSanctionMasterCreate extends Component
{
    use Actions;
    protected $listeners = ['editSLM'];
    public $levels = [], $Inputs = [], $roles = [], $projectTypes = [], $editSLMId = '';
    public function mount()
    {
        // $this->levels = Levels::where('id', '!=', 6)->get();
        $this->roles = Role::where('for_sanction', true)->get();
        // $this->projectTypes = ProjectTypes::where('department_id',Auth::user()->department_id)->get();
        $this->projectTypes = Department::find(Auth::user()->department_id)->projectTypes;
        $this->Inputs[] = [
            // 'level' => '',
            'role_id' => '',
            'project_type_id' => '',
            'min_amount' => '',
            'max_amount' => '',
        ];
    }
    public function editSLM($id)
    {
        $this->editSLMId = $id;
        $getSLM = SanctionLimitMaster::where('id', $id)->first();
        $this->Inputs[0] = [
            'project_type_id' => $getSLM->project_type_id,
            'min_amount' => $getSLM->min_amount,
            'max_amount' => $getSLM->max_amount,
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
                'project_type_id' => '',
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
                SanctionLimitMaster::create(
                    [
                        'department_id' => Auth::user()->department_id,
                        // 'role_id' => $input['role_id'],
                        'project_type_id' => $input['project_type_id'],
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
                $title = "Failed to create record",
                $description = $e->getMessage()
            );
            $this->emit('showError', $e->getMessage());
        }
    }
    public function update()
    {
        DB::beginTransaction();
        try {
            SanctionLimitMaster::where('id', $this->editSLMId)
                ->update([
                    'project_type_id' => $this->Inputs[0]['project_type_id'],
                    'min_amount' => $this->Inputs[0]['min_amount'],
                    'max_amount' => ($this->Inputs[0]['max_amount'] != "") ? $this->Inputs[0]['max_amount'] : null,
                ]);
            DB::commit();
            $this->notification()->success(
                $title = "Updated successfully"
            );
            $this->reset();
            $this->emit('openEntryForm');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->notification()->error(
                $title = "Failed to update record",
                $description = $e->getMessage()
            );
            $this->emit('showError', $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.estimate-sanction-limit.estimate-sanction-master-create');
    }
}
