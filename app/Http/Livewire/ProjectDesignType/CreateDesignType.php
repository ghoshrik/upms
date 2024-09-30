<?php

namespace App\Http\Livewire\ProjectDesignType;

use Livewire\Component;
use App\Models\DesignType;
use WireUi\Traits\Actions;
class CreateDesignType extends Component
{
    use Actions;
    public $name,$editDesignTypeId;
    protected $listeners = ['editDesignType'];
    protected $rules = [
        'name' => 'required|string|max:255',
    ];
    public function editDesignType($id){
        $this->editDesignTypeId = $id;
      //  dd($id);
        $this->name = DesignType::where('id',$id)->pluck('name')->first();
    }
    public function store()
{
         $this->validate();
         if ($this->editDesignTypeId) {
            $designType = DesignType::find($this->editDesignTypeId);
            $designType->update(['name' => $this->name]);
            $this->notification()->success(
                $title = "updated successfully"
            );
         } else {
        DesignType::create([
            'name' => $this->name,
            'created_by' => auth()->user()->id,
        ]);
        $this->notification()->success(
            $title = "created successfully"
        );
        }
        $this->reset();
        $this->emit('openEntryForm');
}

public function resetForm()
{
    $this->name = '';
    $this->editDesignTypeId = null;
}
    public function render()
    {
        return view('livewire.project-design-type.create-design-type');
    }
}
