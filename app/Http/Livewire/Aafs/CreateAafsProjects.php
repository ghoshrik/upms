<?php

namespace App\Http\Livewire\Aafs;

use App\Models\AAFS;
use App\Models\Department;
use Livewire\Component;
use App\Models\SorMaster;
use App\Models\Tender;
use Illuminate\Support\Facades\Storage;
use WireUi\Traits\Actions;
use Livewire\WithFileUploads;

class CreateAafsProjects extends Component
{
    use WithFileUploads;
    use Actions;
    // public $photo,$goId, $projectId, $goDate;
    public $InputStore = [], $projects_number = [], $departmentList = [];



    protected $rules = [
        // 'InputStore.photo' => 'required',
        // 'InputStore.goId' => 'required|numeric',
        'InputStore.projectId' => 'required|integer',
        'InputStore.departmentId' => 'required|integer',
        'InputStore.progressStatus' => 'required',
        'InputStore.projectAmount' => 'required|numeric',
        'InputStore.tenderAmount' => 'required|numeric',
        // 'InputStore.goDate' => 'required',

        'InputStore.aafsMotherId' => 'required|numeric',
        'InputStore.aafsSubId' => 'required|numeric',
        'InputStore.projectType' => 'required',
        'InputStore.status' => 'required',
        'InputStore.completePeriod' => 'required',
        'InputStore.unNo' => 'required',
        'InputStore.goNo' => 'required',
        'InputStore.preaafsExp' => 'required',
        'InputStore.postaafsExp' => 'required',
        'InputStore.Fundcty' => 'required',
        'InputStore.exeAuthority' => 'required',

    ];
    protected $messages = [
        'InputStore.photo.required' => 'This field is required',
        // 'InputStore.photo.mimes' => 'The uploaded file must be a PDF document.',
        'InputStore.goId.required' => 'This go field is required',
        'InputStore.projectId.required' => 'This project Number field is required',
        'InputStore.projectId.integer' => 'Data format mismatch',
        'InputStore.goDate.required' => 'This GO date field is required',
        'InputStore.departmentId.required' => 'This field is required',
        'InputStore.departmentId.integer' => 'This format Not Valid',
        'InputStore.progressStatus.required' => 'This field is required',
        // 'InputStore.progressStatus.integer' => 'Data Format Not Allow',
        'InputStore.projectAmount.required' => 'This field is required',
        'InputStore.projectAmount.numeric' => 'This field only allow number',
        'InputStore.tenderAmount.numeric' => 'This field only allow number',
        'InputStore.tenderAmount.required' => 'This field is required',


        'InputStore.aafsMotherId.required' => 'This field is required',
        'InputStore.aafsSubId.required' => 'This field is required',
        'InputStore.aafsMotherId.numeric' => 'Only Allow number',
        'InputStore.aafsSubId.numeric' => 'Only Allow number',
        'InputStore.projectType.required' => 'This field is required',
        'InputStore.status.required' => 'This field is required',
        'InputStore.completePeriod.required' => 'This field is required',
        'InputStore.unNo.required' => 'This field is required',
        'InputStore.goNo.required' => 'This field is required',
        'InputStore.preaafsExp.required' => 'This field is required',
        'InputStore.postaafsExp.required' => 'This field is required',
        'InputStore.Fundcty.required' => 'This field is required',
        'InputStore.exeAuthority.required' => 'This field is required',

        // 'InputStore.goDate.date_format' => 'This field must be valid only date format'
    ];

    public function updated($param)
    {
        $this->validateOnly($param);
    }
    public function mount()
    {
        $this->departmentList = Department::OrderBy('id', 'desc')->get();
        // $this->projects_number = Tender::select('project_no')->get();
        // select('tenders.project_no as projects_number')
        // ->join('sor_masters', 'sor_masters.estimate_id', '=', 'tenders.project_no')
        // ->join('estimate_prepares', 'estimate_prepares.estimate_id', '=', 'sor_masters.estimate_id')
        // ->join('estimate_statuses', 'estimate_statuses.id', '=', 'sor_masters.status')
        // ->where('sor_masters.is_verified', '=', 1)
        // ->where('estimate_prepares.operation', '=', 'Total')
        // ->get();

        $this->InputStore = [
            // 'photo' => '',
            // 'goId' => '',
            'projectId' => '',
            // 'goDate' => '',
            'departmentId' => '',
            'progressStatus' => '',
            'projectAmount' => '',
            'tenderAmount' => '',
            'aafsMotherId' => '',
            'aafsSubId' => '',
            'projectType' => '',
            'status' => '',
            'completePeriod' => '',
            'unNo' => '',
            'goNo' => '',
            'preaafsExp' => '',
            'postaafsExp' => '',
            'Fundcty' => '',
            'exeAuthority' => ''


        ];
    }
    public function store()
    {
        // dd($this->projectDtls['status_id']);

        $this->validate();
        try {
            $insert = [
                'project_no' => $this->InputStore['projectId'],
                // 'Go_id' => $this->InputStore['goId'],
                // 'go_date' => $this->InputStore['goDate'],
                // 'support_data' => base64_encode(file_get_contents($this->InputStore['photo']->getRealPath())),
                // 'status' => 0,
                'dept_id' => $this->InputStore['departmentId'],
                'status_id' => $this->InputStore['currentProStatus'],
                'project_cost' => $this->InputStore['projectAmount'],
                'tender_cost' => $this->InputStore['tenderAmount'],

                'aafs_mother_id' => $this->InputStore['aafsMotherId'],
                'aafs_sub_id' => $this->InputStore['aafsSubId'],
                'project_type' => $this->InputStore['projectType'],
                'status' => $this->InputStore['status'],
                'completePeriod' => $this->InputStore['completePeriod'],
                'unNo' => $this->InputStore['unNo'],
                'goNo' => $this->InputStore['goNo'],
                'preaafsExp' => $this->InputStore['preaafsExp'],
                'postaafsExp' => $this->InputStore['postaafsExp'],
                'Fundcty' => $this->InputStore['Fundcty'],
                'exeAuthority' => $this->InputStore['exeAuthority']
            ];
            // dd($insert);
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
    public $projectDtls;
    public function getProjectDetails()
    {
        // dd($this->InputStore['projectId']);

        $this->projectDtls = Tender::select('tenders.project_no as projects_number', 'estimate_prepares.total_amount as project_total_amount', 'estimate_statuses.status as project_status', 'tenders.tender_amount as tender_total_amount', 'estimate_statuses.id as status_id')
            ->join('sor_masters', 'sor_masters.estimate_id', '=', 'tenders.project_no')
            ->join('estimate_prepares', 'estimate_prepares.estimate_id', '=', 'sor_masters.estimate_id')
            ->join('estimate_statuses', 'estimate_statuses.id', '=', 'sor_masters.status')
            ->where('sor_masters.is_verified', '=', 1)
            ->where('estimate_prepares.operation', '=', 'Total')
            ->where('tenders.project_no', $this->InputStore['projectId'])
            ->first();
        $this->InputStore['projectId'] = $this->projectDtls['projects_number'];
        $this->InputStore['progressStatus'] = $this->projectDtls['project_status'];
        $this->InputStore['projectAmount'] = $this->projectDtls['project_total_amount'];
        $this->InputStore['tenderAmount'] = $this->projectDtls['tender_total_amount'];
        $this->InputStore['currentProStatus'] = $this->projectDtls['status_id'];

        // dd($this->InputStore['projectId']);
    }
    public function render()
    {
        $this->projects_number = Tender::select('project_no')->get();
        return view('livewire.aafs.create-aafs-projects');
    }
}
