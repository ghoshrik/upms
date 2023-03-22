<?php

namespace App\Http\Livewire\Aafs;

use App\Models\AAFS;
use Livewire\Component;
use App\Models\SorMaster;
use Illuminate\Support\Facades\Storage;
use WireUi\Traits\Actions;
use Livewire\WithFileUploads;

class CreateAafsProjects extends Component
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
            // dd("fd");
            // $this->validate([
            //     'photo' => 'pdf',
            // ]);
            // dd($this->photo);
            try{
                // $fileModel = Model::all();//select model Name
                // $fileName = time().'_'.$this->photo->getClientOriginalName(); //
                // $filePath = $this->photo('DPR')->storeAs('uploads', $fileName, 'public'); //client path
                // $fileModel->photo = time().'_'.$this->photo->getClientOriginalName();
                // $fileModel->file_path = '/storage/' . $filePath; //file path

                // $file = $this->photo->store('documents','public');
                // AAFS::create(['project_id'=>$this->projectId,'Go_id'=>$this->goId,'goDate'=>$this->goDate]);

                // dd(Storage::put('/files/'.$this->photo));


                // dd(request()->hasFile($this->photo->store('app/uploads')));
                $filenameWithExt = $this->photo->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension =  $this->photo->getClientOriginalExtension();
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                $path =  $this->photo->storeAs('public/avatars',$fileNameToStore);

                // $this->photo->

                $insert = [
                    'project_id'=>$this->projectId,
                    'Go_id'=>$this->goId,
                    'go_date'=>$this->goDate,
                    'support_data'=>$fileNameToStore ,
                    'status'=>0,
                ];
                // dd($insert);
                AAFS::create($insert);

                $this->notification()->success(
                    $title = "Project Order Created Successfully"
                );
                $this->reset();
                $this->emit('openEntryForm');


            }
            catch (\Throwable $th) {

                dd( $th->getMessage());
                session()->flash('serverError', $th->getMessage());
            }
        }
    public function render()
    {
        return view('livewire.aafs.create-aafs-projects');
    }
}
