<?php

namespace App\Http\Livewire\Sor;

use App\Models\AttachDoc;
use App\Models\SOR;
use Livewire\Component;
use App\Models\Department;
use WireUi\Traits\Actions;
use Livewire\WithFileUploads;
use App\Models\SorCategoryType;
use Illuminate\Support\Facades\Auth;

class CreateSor extends Component
{
    use Actions,WithFileUploads;
    public $inputsData = [], $fetchDropDownData = [];
    //|regex:/^\d{2}\.\d{2}/
    protected $rules = [
        'inputsData.*.dept_category_id'=>'required|integer',
        'inputsData.*.item_details'=>'required|numeric',
        'inputsData.*.description'=>'required|string',
        'inputsData.*.unit'=>'required|numeric',
        'inputsData.*.cost'=>'required|numeric',
        'inputsData.*.version'=>'required|string',
        'inputsData.*.effect_from'=>'required',
        'inputsData.*.file_upload'=>'required'
    ];
    protected $messages = [
        'inputsData.*.dept_category_id.required'=>'This field is required',
        'inputsData.*.dept_category_id.required'=>'Invalid format',
        'inputsData.*.item_details.required'=> 'This field is required',
        'inputsData.*.item_details.numeric'=>'Only allow number',
        // 'inputsData.*.item_details.regex'=> 'The field invalid characters',
        'inputsData.*.description.required'=>'This field is required',
        'inputsData.*.description.string'=>'This field must be allow alphabet',
        'inputsData.*.unit.required'=>'This field is required',
        'inputsData.*.unit.numeric'=>'This field allow only numeric',
        'inputsData.*.unit.max:0'=>'Not allow any negative number',
        'inputsData.*.cost.required'=>'This field is required',
        'inputsData.*.cost.numeric'=>'This field allow only numeric',
        // 'inputsData.*.cost.max:0'=>'Not allow any negative number',
        'inputsData.*.version.required'=>'This field is required',
        'inputsData.*.version.string'=>'This field allow only alphabet',
        'inputsData.*.effect_from.required'=>'This field is required',
        // 'inputsData.*.effect_from.date_format'=>'This field must be valid only date format'
        'inputsData.*.file_upload.required'=>'This field is required',

    ];
    public function mount()
    {
        $this->inputsData = [
            [
                'item_details' => '',
                'department_id' => Auth::user()->department_id,
                'dept_category_id' => '',
                'description' => '',
                'unit' => '',
                'cost' => '',
                'version' => '',
                'effect_from' => '',
                'file_upload'=>''
            ]
        ];
        $this->fetchDropDownData['departmentCategory'] = SorCategoryType::where('department_id', Auth::user()->department_id)->get();
    }

    public function addNewRow()
    {
        $this->inputsData[] =
        [
            'item_details' => '',
            'department_id' => Auth::user()->department_id,
            'dept_category_id' => '',
            'description' => '',
            'unit' => '',
            'cost' => '',
            'version' => '',
            'effect_from' => '',
            'file_upload'=>''
        ];
    }
    public function updated($param)
    {
        $this->validateOnly($param);
    }
    public function store()
    {
        // dd($this->inputsData);
        $this->validate();
        try {
            foreach ($this->inputsData as $key => $data) {

                $last = SOR::create([
                    'Item_details'=>$data['item_details'],
                    'department_id'=>$data['department_id'],
                    'dept_category_id'=>$data['dept_category_id'],
                    'description'=>$data['description'],
                    'unit'=>$data['unit'],
                    'cost'=>$data['cost'],
                    'version'=>$data['version'],
                    'effect_from'=>$data['effect_from'],
                    'created_by_level'=>Auth::user()->id,
                ]);
                // dd($data['file_upload']);
                foreach($data['file_upload'] as $DataAttr)
                {
                    // dd($DataAttr->getRealPath());
                    $filePath = file_get_contents($DataAttr);
                    $fileSize = $DataAttr->getSize();
                    $filExt = $DataAttr->getClientOriginalExtension();
                    $mimeType = $DataAttr->getMimeType();
                    AttachDoc::create([
                        'sor_docu_id'=>$last->id,
                        'document_type'=>$filExt,
                        'document_mime'=>$mimeType,
                        'document_size'=>$fileSize,
                        'attach_doc'=>$filePath
                    ]);
                }
            }
            $this->notification()->success(
                $title = trans('cruds.sor.create_msg')
            );
            $this->reset();
            $this->emit('openEntryForm');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            $this->emit('showError', $th->getMessage());
        }
    }

    public function removeRow($index)
    {
        if (count($this->inputsData) > 1) {
            unset($this->inputsData[$index]);
            $this->inputsData =  array_values($this->inputsData);
            return;
        }
    }

    public function render()
    {

        return view('livewire.sor.create-sor');
    }
}
