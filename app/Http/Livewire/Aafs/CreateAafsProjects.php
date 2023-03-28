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
    // public $photo,$goId, $projectId, $goDate;
    public $InputStore = [], $projects_number = [];



    protected $rules = [
        'InputStore.photo' => 'required',
        'InputStore.goId' => 'required|numeric',
        'InputStore.projectId' => 'required|integer',
        'InputStore.goDate' => 'required',
    ];
    protected $messages = [
        'InputStore.photo.required' => 'This field is required',
        // 'InputStore.photo.mimes' => 'The uploaded file must be a PDF document.',
        'InputStore.goId.required' => 'This go field is required',
        'InputStore.projectId.required' => 'This project Number field is required',
        'InputStore.projectId.integer' => 'Data format mismatch',
        'InputStore.goDate.required' => 'This GO date field is required',
        // 'InputStore.goDate.date_format' => 'This field must be valid only date format'
    ];

    public function updated($param)
    {
        $this->validateOnly($param);
    }
    public function mount()
    {
        $this->projects_number = SorMaster::where('is_verified', '=', 1)->get();
        $this->InputStore = [
            'photo' => '',
            'goId' => '',
            'projectId' => '',
            'goDate' => ''
        ];
    }
    public function store()
    {

        $this->validate();
        try {
            $insert = [
                'project_id' => $this->InputStore['projectId'],
                'Go_id' => $this->InputStore['goId'],
                'go_date' => $this->InputStore['goDate'],
                'support_data' => base64_encode(file_get_contents($this->InputStore['photo']->getRealPath())),
                'status' => 0,
            ];
            AAFS::create($insert);

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