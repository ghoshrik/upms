<?php

namespace App\Http\Livewire\Aafs;

use App\Models\AAFS;
use App\Models\SorMaster;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithFileUploads;

class CreateProj extends Component
{
    use WithFileUploads;
    use Actions;
    public $photo,$projects_number = [],$goId,$projectId,$goDate;

    public function mount()
    {
        $this->projects_number = SorMaster::where('is_verified','=',1)->get();
    }
    public function store()
    {
        // $this->validate([
        //     'photo' => 'pdf',
        // ]);
        try{
            // $fileModel = Model::all();//select model Name
            // $fileName = time().'_'.$this->photo->getClientOriginalName(); //
            // $filePath = $this->photo('DPR')->storeAs('uploads', $fileName, 'public'); //client path
            // $fileModel->photo = time().'_'.$this->photo->getClientOriginalName();
            // $fileModel->file_path = '/storage/' . $filePath; //file path

            // $file = $this->photo->store('documents','public');
            // AAFS::create(['project_id'=>$this->projectId,'Go_id'=>$this->goId,'goDate'=>$this->goDate]);

            $insert = [
                'project_id'=>$this->projectId,
                'Go_id'=>$this->goId,
                'go_date'=>getFromDateAttribute($this->goDate),
                'support_data'=>$this->photo->store('files', 'public'),
                'status'=>0,
            ];
            AAFS::create($insert);
            
            $this->notification()->success(
                $title = "Project Order Created Successfully"
            );
            $this->reset();
            $this->emit('openForm');

            
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
