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
    public $photo, $projects_number = [], $goId, $projectId, $goDate;



    protected $rules = [
        'photo' => 'required',
        'goId' => 'required|numeric',
        'projectId' => 'required|integer',
        'goDate' => 'required|date_format:Y-m-d',
    ];
    protected $messages = [
        'photo.required' => 'This company name field is required',
        'goId.required' => 'This go field is required',
        'projectId.required' => 'This project Number field is required',
        'goDate.required' => 'This GO date field is required',
        'goDate.date_format' => 'This field must be valid only date format'
    ];





    public function mount()
    {
        $this->projects_number = SorMaster::where('is_verified', '=', 1)->get();
    }
    public function store()
    {


        // dd("fd");
        // $this->validate([
        //     'photo' => 'pdf',
        // ]);
        // dd($this->photo);
        $this->validate();
        try {
            // $fileModel = Model::all();//select model Name
            // $fileName = time().'_'.$this->photo->getClientOriginalName(); //
            // $filePath = $this->photo('DPR')->storeAs('uploads', $fileName, 'public'); //client path
            // $fileModel->photo = time().'_'.$this->photo->getClientOriginalName();
            // $fileModel->file_path = '/storage/' . $filePath; //file path

            // $file = $this->photo->store('documents','public');
            // AAFS::create(['project_id'=>$this->projectId,'Go_id'=>$this->goId,'goDate'=>$this->goDate]);

            // dd(Storage::put('/files/'.$this->photo));
            // $path =  $this->photo->storeAs('public/avatars',$fileNameToStore);

            // $this->photo->

            $insert = [
                'project_id' => $this->projectId,
                'Go_id' => $this->goId,
                'go_date' => $this->goDate,
                'support_data' => base64_encode(file_get_contents($this->photo->getRealPath())),
                'status' => 0,
            ];
            // dd($insert);
            AAFS::csreate($insert);

            $this->notification()->success(
                $title = "Project Order Created Successfully"
            );
            $this->reset();
            $this->emit('openEntryForm');
        } catch (\Throwable $th) {
            $this->emit('showError', $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.aafs.create-aafs-projects');
    }
}
