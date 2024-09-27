<?php

namespace App\Http\Livewire\ProjectType;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\ProjectType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CreateProjectType extends Component
{
    use Actions;
    protected $listeners = ['editProjectType'];
    public $title;
    public $editProjectTypeId = '';
    public function editProjectType($id){
        $this->editProjectTypeId = $id;
        $this->title = ProjectType::where('id',$id)->pluck('title')->first();
    }
    public function store(){
        DB::beginTransaction();
        try {
            $insert = [
                'department_id' => Auth::user()->department_id,
                'title' => $this->title
            ];
            ProjectType::create($insert);
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
    public function update(){
        DB::beginTransaction();
        try {
            ProjectType::where('id',$this->editProjectTypeId)->update(['title' => $this->title]);
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
        return view('livewire.project-type.create-project-type');
    }
}
