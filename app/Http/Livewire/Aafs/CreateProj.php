<?php

namespace App\Http\Livewire\Aafs;

use App\Models\SorMaster;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateProj extends Component
{
    use WithFileUploads;
    public $photo,$projects_number = [],$goId,$projectId;

    public function mount()
    {
        $this->projects_number = SorMaster::where('is_verified','=',1)->get();
    }
    public function store()
    {
        $this->validate([
            'photo' => 'pdf',
        ]);
        try{
            $fileModel = Model::all();//select model Name
            $fileName = time().'_'.$this->photo->getClientOriginalName(); //
            $filePath = $this->photo('DPR')->storeAs('uploads', $fileName, 'public'); //client path
            $fileModel->photo = time().'_'.$this->photo->getClientOriginalName();
            $fileModel->file_path = '/storage/' . $filePath; //file path

            // $file = $this->photo->store('documents','public');
        }
        catch (\Throwable $th) {
            session()->flash('serverError', $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.aafs.create-proj');
    }
}
