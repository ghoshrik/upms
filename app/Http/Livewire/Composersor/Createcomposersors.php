<?php

namespace App\Http\Livewire\Composersor;

use App\Models\SOR;
use Livewire\Component;
use App\Models\UnitMaster;
use WireUi\Traits\Actions;
use App\Models\ComposerSor;
use App\Models\CompositSor;
use Livewire\WithFileUploads;
use App\Models\SorCategoryType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Createcomposersors extends Component
{
    use Actions, WithFileUploads;
    public $inputsData = [], $fetchDropDownData = [], $storeItem = [];

    protected $rules = [
        'storeItem.dept_category_id' => 'required',
        'storeItem.parentSorItemNo' => 'required',
        'storeItem.file_upload' => 'required',
        'storeItem.sor_Itemid' => 'required',
        // 'selectedCategoryId' => 'required|integer',
        'inputsData.*.childSorItemNo' => 'required',
        'inputsData.*.description' => 'required',
        'inputsData.*.unit_id' => 'required|integer',
        'inputsData.*.qty' => 'required|numeric|min:1',

    ];
    protected $messages = [
        // 'selectedCategoryId.required' => 'Selected at least one ',
        // 'selectedCategoryId.integer' => 'This Selected field is Invalid',
        'storeItem.dept_category_id.required' => 'This is required field',
        // 'storeItem.parentSorItemNo.required' => 'This is required field',
        'storeItem.file_upload.required' => 'This is required field',
        'storeItem.sor_Itemid.required' => 'This field is required',



        'inputsData.*.childSorItemNo.required' => 'This field is required',
        // 'inputsData.*.sorItemNo.integer' => 'Invalid format',
        'inputsData.*.description.required' => 'This field is required',
        'inputsData.*.unit_id.required' => 'This field is required',
        'inputsData.*.unit_id.integer' => 'Invalid format',
        'inputsData.*.qty.required' => 'This field is required',
        'inputsData.*.qty.numeric' => 'This field allow only numeric',
        'inputsData.*.qty.min' => 'The number must be at least 1.',
    ];


    // public function booted()
    // {
    //     if ($this->selectedCategoryId == 1) {

    //     }
    //     if ($this->selectedCategoryId == 2) {
    //         $this->rules = Arr::collapse([$this->rules, [
    //             'estimateData.other_name' => 'required|string',
    //         ]]);
    //     }
    // }

    // public function changeCategory($value)
    // {
    //     $value = $value['_x_bindings']['value'];
    //     $this->estimateData['item_name'] = $value;
    //     if ($this->estimateData['item_name'] == 'SOR')
    //     {

    //     }

    // }
    public function mount()
    {
        $this->inputsData = [
            [
                'childSorItemNo' => '',
                'description' => '',
                'unit_id' => '',
                'qty' => ''
            ]
        ];
        $this->storeItem['dept_category_id'] = '';
        $this->storeItem['parentSorItemNo'] = '';
        $this->storeItem['file_upload'] = '';
        $this->fetchDropDownData['departmentCategory'] = SorCategoryType::where('department_id', Auth::user()->department_id)->get();
        $this->fetchDropDownData['unitMaster'] =  UnitMaster::select('id', 'unit_name', 'short_name', 'is_active')->where('is_active', 1)->orderBy('id', 'desc')->get();
    }

    public function addNewRow()
    {
        $this->inputsData[] =
            [
                'childSorItemNo' => '',
                'description' => '',
                'unit_id' => '',
                'qty' => ''
            ];
    }
    public function updated($param)
    {
        $this->validateOnly($param);
    }

    public function removeRow($index)
    {
        if (count($this->inputsData) > 1) {
            unset($this->inputsData[$index]);
            $this->inputsData =  array_values($this->inputsData);
            return;
        }
    }
    public function getDeptCategorySORItem()
    {
        // dd($this->storeItem['dept_category_id']);
        $this->fetchDropDownData['SORItemNo'] = SOR::select('id', 'Item_details')->where('dept_category_id', $this->storeItem['dept_category_id'])->get();
        //$this->fatchDropdownData['departmentsCategory'] = SorCategoryType::select('id', 'dept_category_name')->where('department_id', '=', $this->estimateData['dept_id'])->get();
    }
    public $searchDtaCount, $searchStyle, $searchResData;
    public function autoSearch()
    {
        if ($this->storeItem['parentSorItemNo']) {
            $this->fetchDropDownData['items_number'] = SOR::select('Item_details', 'id')
                ->where('department_id', Auth::user()->department_id)
                ->where('dept_category_id', $this->storeItem['dept_category_id'])
                // ->where('version', $this->estimateData['version'])
                ->where('Item_details', 'like', $this->storeItem['parentSorItemNo'] . '%')
                ->where('is_approved', 1)
                ->get();

            // dd($this->fetchDropDownData['items_number']);
            // dd($this->fatchDropdownData['items_number']);

            if (count($this->fetchDropDownData['items_number']) > 0) {
                $this->searchDtaCount = (count($this->fetchDropDownData['items_number']) > 0);
                $this->searchStyle = 'block';
            } else {
                // $this->estimateData['description'] = '';
                // $this->estimateData['qty'] = '';
                // $this->estimateData['rate'] = '';
                $this->searchStyle = 'none';
                $this->notification()->error(
                    $title = 'Not data found !!' . $this->storeItem['parentSorItemNo']
                );
            }
        } else {
            $this->notification()->error(
                $title = 'Not found !!' . $this->storeItem['parentSorItemNo']
            );
        }
    }

    public function getItemDetails($value)
    {
        $this->searchResData = SOR::where('id', $value)->get();
        $this->searchDtaCount = count($this->searchResData) > 0;
        $this->searchStyle = 'none';
        if (count($this->searchResData) > 0) {
            foreach ($this->searchResData as $list) {
                // $this->estimateData['description'] = $list['description'];
                // $this->estimateData['qty'] = $list['unit'];
                // $this->estimateData['rate'] = $list['cost'];
                $this->storeItem['sor_Itemid'] = $list['id'];
                $this->storeItem['parentSorItemNo'] = $list['Item_details'];
            }
            // $this->calculateValue();
        } else {
            // $this->estimateData['description'] = '';
            // $this->estimateData['qty'] = '';
            // $this->estimateData['rate'] = '';
            $this->notification()->error(
                $title = "Not Found"
            );
        }
    }

    public function store()
    {
        $this->validate();
        try {
            // dd($this->inputsData, $this->storeItem);
            foreach ($this->inputsData as $key => $data) {

                $last = CompositSor::create([
                    'dept_category_id' => $this->storeItem['dept_category_id'],
                    'sor_itemno_parent_id' => $this->storeItem['sor_Itemid'],
                    'sor_itemno_child' => $data['childSorItemNo'],
                    'description' => $data['description'],
                    'unit_id' => $data['unit_id'],
                    'rate' => $data['qty']
                ]);

                /* Single File Upload*/
                $filePath = file_get_contents($this->storeItem['file_upload']->getRealPath());
                $fileSize = $this->storeItem['file_upload']->getSize();
                $filExt = $this->storeItem['file_upload']->getClientOriginalExtension();
                $mimeType = $this->storeItem['file_upload']->getMimeType();

                $db_ext = DB::connection('pgsql_docu_External');
                $db_ext->table('docu_composit_sors')->insert([
                    'composer_sor_id' => $last->id,
                    'document_type' => $filExt,
                    'document_mime' => $mimeType,
                    'document_size' => $fileSize,
                    'docufile' => base64_encode($filePath)
                ]);
            }

            $this->notification()->success(
                $title = trans('cruds.sor.create_msg')
            );
            $this->reset();
            $this->emit('openEntryForm');
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            $this->emit('showError', $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.composersor.createcomposersors');
    }
}
