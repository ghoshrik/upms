<?php

use App\Models\SOR;
use App\Models\Office;
use App\Models\UnitType;
use App\Models\SORMaster;
use App\Models\Department;
use App\Models\UnitMaster;
use App\Models\Designation;
use App\Models\Esrecommender;
use App\Models\RatesAnalysis;
use App\Models\UsersHasRoles;
use App\Models\EstimateStatus;
use App\Models\EstimatePrepare;
use App\Models\SorCategoryType;
use App\Models\DynamicSorHeader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

function removeSession($session)
{
    if (Session::has($session)) {
        Session::forget($session);
    }
    return true;
}

function randomString($length, $type = 'token')
{
    if ($type == 'password') {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    } elseif ($type == 'username') {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    } else {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    }

    $token = substr(str_shuffle($chars), 0, $length);
    return $token;
}

function activeRoute($route, $isClass = false): string
{
    $requestUrl = request()->fullUrl() === $route ? true : false;

    if ($isClass) {
        return $requestUrl ? $isClass : '';
    } else {
        return $requestUrl ? 'active' : '';
    }
}

function checkRecordExist($table_list, $column_name, $id)
{
    if (count($table_list) > 0) {
        foreach ($table_list as $table) {
            $check_data = DB::table($table)->where($column_name, $id)->count();
            if ($check_data > 0) {
                return false;
            }

        }
        return true;
    }
    return true;
}

// Model file save to storage by spatie media library
function storeMediaFile($model, $file, $name)
{
    if ($file) {
        $model->clearMediaCollection($name);
        if (is_array($file)) {
            foreach ($file as $key => $value) {
                $model->addMedia($value)->toMediaCollection($name);
            }
        } else {
            $model->addMedia($file)->toMediaCollection($name);
        }
    }
    return true;
}

// Model file get by storage by spatie media library
function getSingleMedia($model, $collection = 'image_icon', $skip = true)
{
    if (!Auth::check() && $skip) {
        return asset('images/avatars/01.png');
    }
    if ($model !== null) {
        $media = $model->getFirstMedia($collection);
    }
    $imgurl = isset($media) ? $media->getPath() : '';
    if (file_exists($imgurl)) {
        return $media->getFullUrl();
    } else {
        switch ($collection) {
            case 'image_icon':
                $media = asset('images/avatars/01.png');
                break;
            case 'profile_image':
                $media = asset('images/avatars/01.png');
                break;
            default:
                $media = asset('images/common/add.png');
                break;
        }
        return $media;
    }
}

// File exist check
function getFileExistsCheck($media)
{
    $mediaCondition = false;
    if ($media) {
        if ($media->disk == 'public') {
            $mediaCondition = file_exists($media->getPath());
        } else {
            $mediaCondition = Storage::disk($media->disk)->exists($media->getPath());
        }
    }
    return $mediaCondition;
}

function getEstimateDescription($estimate_no)
{
    if ($estimate_no) {
        $estimateDescription = SorMaster::select('sorMasterDesc')->where('estimate_id', $estimate_no)->first();
    }
    return $estimateDescription['sorMasterDesc'];
}

function getRateDescription($rate_no, $rate)
{
    if ($rate_no) {
        $rateDescription = RatesAnalysis::where([['rate_id', $rate_no], ['total_amount', $rate]])->first();
    }
    return $rateDescription['description'];
}

function getSorItemNumber($sor_item_number)
{
    if ($sor_item_number) {
        $sorItemNo = SOR::select('Item_details')->where('id', $sor_item_number)->first();
    }
    return $sorItemNo['Item_details'];
}

function getSorItemNumberDesc($sor_item_number)
{
    if ($sor_item_number) {
        $sorItemDesc = SOR::select('description')->where('id', $sor_item_number)->first();
    }
    return $sorItemDesc['description'];
}
// download word file
function exportWord($estimate_id)
{
    if (Auth::user()->user_type == 1) {
        $exportDatas = Esrecommender::where('estimate_id', '=', $estimate_id)->get();
    } elseif (Auth::user()->user_type == 4) {
        $exportDatas = Esrecommender::where('estimate_id', '=', $estimate_id)->get();
    } else {
        $exportDatas = EstimatePrepare::where('estimate_id', '=', $estimate_id)->get();
    }
    // $exportDatas = array_values($exportDatas);
    // dd($exportDatas);
    $date = date('Y-m-d');
    $pw = new \PhpOffice\PhpWord\PhpWord();
    $section = $pw->addSection(
        array(
            'marginLeft' => 600, 'marginRight' => 200,
            'marginTop' => 600, 'marginBottom' => 200,
        )
    );
    $html = "<h1 style='font-size:24px;font-weight:600;text-align: center;'>Project Estimate Preparation Details</h1>";
    $html .= "<p>Projected Estimate Details List</p>";
    $html .= "<table style='border: 1px solid black;width:auto'><tr>";
    $html .= "<th scope='col' style='text-align: center'>Serial No.</th>";
    $html .= "<th scope='col' style='text-align: center'>Item Number/<br/>Project No(Ver.)</th>";
    $html .= "<th scope='col' style='text-align: center'>Description</th>";
    $html .= "<th scope='col' style='text-align: center'>Quantity</th>";
    $html .= "<th scope='col' style='text-align: center'>Unit Price</th>";
    $html .= "<th scope='col' style='text-align: center' >Cost</th></tr>";
    foreach ($exportDatas as $key => $export) {
        $html .= "<tr><td style='text-align: center'>" . chr($export['row_id'] + 64) . "</td>&nbsp;";
        if ($export['sor_item_number']) {
            $html .= "<td style='text-align: center'>" . getSorItemNumber($export['sor_item_number']) . ' ( ' . $export['version'] . ' )' . "</td>&nbsp;";
        } elseif ($export['estimate_no']) {
            $html .= "<td style='text-align: center'>" . $export['estimate_no'] . "</td>&nbsp;";
        } else {
            $html .= "<td style='text-align: center'>--</td>&nbsp;";
        }
        if ($export['description']) {
            $html .= "<td style='text-align: center'>" . getSorItemNumberDesc($export['description']) . "</td>&nbsp;";
        } elseif ($export['operation']) {
            if ($export['operation'] == 'Total') {
                $html .= "<td style='text-align: center'> Total of (" . $export['row_index'] . " )</td>&nbsp;";
            } else {
                if ($export['remarks'] != '') {
                    $html .= "<td style='text-align: center'> " . $export['row_index'] . " ( " . $export['remarks'] . " )" . "</td>&nbsp;";
                } else {
                    $html .= "<td style='text-align: center'> " . $export['row_index'] . "</td>&nbsp;";
                }
            }
        } elseif ($export['other_name']) {
            $html .= "<td style='text-align: center'>" . $export['other_name'] . "</td>&nbsp;";
        } else {
            // $html .= "<td style='text-align: center'>" . $export['name'] . "</td>&nbsp;";
            $html .= "<td style='text-align: center'>--</td>&nbsp;";
        }
        $html .= "<td style='text-align: center'>" . $export['qty'] . "</td>&nbsp;";
        $html .= "<td style='text-align: center'>" . $export['rate'] . "</td>&nbsp;";
        $html .= "<td style=''>" . $export['total_amount'] . "</td></tr>";
    }
    $html .= "</table>";
    foreach ($exportDatas as $key => $export) {
        if ($export['estimate_no']) {
            $html .= "<p>Estimate Packege " . $export['estimate_no'] . "</p>";
            $getEstimateDetails = EstimatePrepare::where('estimate_id', '=', $export['estimate_no'])->get();
            $html .= "<table style='border: 1px solid black;width:auto'><tr>";
            $html .= "<th scope='col' style='text-align: center'>Serial No.</th>";
            $html .= "<th scope='col' style='text-align: center'>Item Number(Ver.)</th>";
            $html .= "<th scope='col' style='text-align: center'>Description</th>";
            $html .= "<th scope='col' style='text-align: center'>Quantity</th>";
            $html .= "<th scope='col' style='text-align: center'>Unit Price</th>";
            $html .= "<th scope='col' style='text-align: center' >Cost</th></tr>";
            if (isset($getEstimateDetails)) {
                foreach ($getEstimateDetails as $estimateDetails) {
                    $html .= "<tr><td style='text-align: center'>" . chr($estimateDetails['row_id'] + 64) . "</td>&nbsp;";
                    if ($estimateDetails['sor_item_number']) {
                        $html .= "<td style='text-align: center'>" . getSorItemNumber($estimateDetails['sor_item_number']) . ' ( ' . $estimateDetails['version'] . ' )' . "</td>&nbsp;";
                    } else {
                        $html .= "<td style='text-align: center'>--</td>&nbsp;";
                    }
                    if ($estimateDetails['sor_item_number']) {
                        $html .= "<td style='text-align: center'>" . getSorItemNumberDesc($estimateDetails['sor_item_number']) . "</td>&nbsp;";
                    } elseif ($estimateDetails['operation']) {
                        if ($estimateDetails['operation'] == 'Total') {
                            $html .= "<td style='text-align: center'> Total of (" . $estimateDetails['row_index'] . " )</td>&nbsp;";
                        } else {
                            if ($estimateDetails['comments'] != '') {
                                $html .= "<td style='text-align: center'> " . $estimateDetails['row_index'] . " ( " . $estimateDetails['comments'] . " )" . "</td>&nbsp;";
                            } else {
                                $html .= "<td style='text-align: center'> " . $estimateDetails['row_index'] . "</td>&nbsp;";
                            }
                        }
                    } else {
                        $html .= "<td style='text-align: center'>" . $estimateDetails['other_name'] . "</td>&nbsp;";
                    }
                    $html .= "<td style='text-align: center'>" . $estimateDetails['qty'] . "</td>&nbsp;";
                    $html .= "<td style='text-align: center'>" . $estimateDetails['rate'] . "</td>&nbsp;";
                    $html .= "<td style=''>" . $estimateDetails['total_amount'] . "</td></tr>";
                }
            }

            $html .= "</table>";
        }
    }

    \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
    $pw->save($date . ".docx", "Word2007");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment;filename=\"convert.docx\"");
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($pw, "Word2007");
    dd($objWriter);
    $objWriter->save($date . '.docx');
    return response()->download($date . '.docx')->deleteFileAfterSend(true);
    // $this->reset('exportDatas');
}

function getFromDateAttribute($value)
{
    $date_format = date_create($value);
    return date_format($date_format, "Y/m/d");
}

function printTreeHTML($tree, $parent = 0)
{
    global $Type;
    // $type = "a";
    echo $Type;
    $unitDtls = UnitType::where('status', 1)->get();
    foreach ($tree as $key => $node) {
        $nodeModelIndex = $node["index"] - 1;
        // echo $Type;
        // echo $node["index"];
        // if($node['parent_id'] == 0){
        //     $parent = 0;
        //     $parent = $key++;
        //     echo $parent;
        //     $parent = 0;
        // }
        // else{
        //     $parent=$parent+1;
        //     echo $key.$parent;
        // }
        echo "<li class='tree'>";
        // echo "$key";
        echo "<div class='row mutipal-add-row'>
                    <div class='col-md-3 col-lg-3 col-sm-3 ml-2 mt-1 mb-1'>";
        echo '<input type="text" class="form-control" placeholder="milestone name" wire:model="mileStoneData.' . $nodeModelIndex . '.milestone_name" wire:key="mileStoneData.' . $nodeModelIndex . '.milestone_name"/>';
        echo "</div>";
        echo "<div class='col-md-2 col-lg-2 col-sm-3 ml-2 mt-1 mb-1'>";
        echo '<input type="text" class="form-control" placeholder="weightage" wire:model="mileStoneData.' . $nodeModelIndex . '.weight" wire:key="mileStoneData.' . $nodeModelIndex . '.weight"/>';
        echo "</div>";
        echo "<div class='col-md-2 col-lg-2 col-sm-3 ml-2 mt-1 mb-1'>";
        echo '<select class="form-control" wire:model="mileStoneData.' . $nodeModelIndex . '.unit_type" wire:key="mileStoneData.' . $nodeModelIndex . '.unit_type" wire:click="chMileType($event.target.value)"><option value="">-- Select Unit --</option>';
        if (count($unitDtls) > 0) {
            foreach ($unitDtls as $units) {
                echo '<option value=' . $units['type'] . '>' . $units['type'] . '</option>';
            }
        }
        echo '</select>';
        echo "</div>";
        // if($Type=="cm"){
        //     echo "<div class='col-md-2 col-lg-2 col-sm-3 ml-2 mt-1 mb-1'".$Type ? 'd-block':'d-none'.">";
        //     echo $Type;
        //     echo "</div>";
        // }
        echo "<div class='col-md-2 col-lg-2 col-sm-3 ml-2 mt-1 mb-1'>";
        echo '<input type="text" class="form-control" placeholder="cost" wire:model="mileStoneData.' . $nodeModelIndex . '.cost" wire:key="mileStoneData.' . $nodeModelIndex . '.cost" />';
        echo "</div>";
        echo "<div class='col-md-2 col-lg-1 col-sm-3 ml-2 mt-1 mb-1'>";
        echo "<div class='d-flex'>";
        echo "<button type='button' wire:click='addMilestone(" . $node['index'] . ")' class='d-inline btn btn-soft-success rounded-pill'>
                            <span class='btn-inner'>
                                <svg class='w-4 h-4 text-gray-500' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                                    <line x1='12' y1='5' x2='12' y2='19'></line>
                                    <line x1='5' y1='12' x2='19' y2='12'></line>
                                </svg>
                            </span>
                        </button>&nbsp;&nbsp;&nbsp;";
        echo "<button type='button' wire:click='removeMilestone(" . $node['index'] . ")' class='d-inline btn btn-soft-danger rounded-pill'>
                            <span class='btn-inner'>
                                <svg class='w-4 h-4 text-gray-500' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                                    <line x1='18' y1='6' x2='6' y2='18'></line>
                                    <line x1='6' y1='6' x2='18' y2='18'></line>
                                </svg>
                            </span>
                        </button>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        if (!empty($node['children'])) {
            echo "<ul class='tree'>";
            printTreeHTML($node['children'], $parent);
            echo "</ul>";
        }
        echo "</li>";
    }
}

function buildTree($nodes)
{
    $children = array();

    foreach ($nodes as $node) {
        $children[$node['index']] = $node;
        $children[$node['index']]['children'] = array();
    }
    foreach ($children as $child) {
        if (isset($children[$child['parent_id']])) {
            $children[$child['parent_id']]['children'][] = &$children[$child['index']];
        }
    }
    $rootNodes = array();
    foreach ($children as $child) {
        if ($child['parent_id'] == 0) {
            $rootNodes[] = $child;
        }
    }
    return $rootNodes;
}

//delete entries
function remove_element_by_value($arr, $val)
{
    $return = array();
    $array = array_values($arr);
    // dd($array);
    foreach ($array as $k => $v) {
        if ($v['index'] == $val) {
            // dd($v);
            unset($array[$k]);
            //   dd($array);
        }
        //    if(is_array($v[])) {
        //     // dd($v);

        //       $return[$k] = remove_element_by_value($v, $val); //recursion
        //       continue;
        //    }
        //    if($v == $val) continue;
        //    $return[$k] = $v;
    }
    return $array;
}

// if(!array_exists())
function delete_entries(&$array, $ids_to_delete)
{
    $children = array();
    foreach ($array as $node) {
        dd($array);
        $children[$node['index']] = $node;
        $children[$node['index']]['children'] = array();
    }
    foreach ($array['children'] as $index => &$child) {
        if (in_array($child['index']['parent_id'], $ids_to_delete)) {
            unset($array['children'][$index]);
        }
        delete_entries($child, $ids_to_delete);
    }
}
function getAllAssigenRoles()
{
    $userData = Session::get('user_data');
    $sessionKey = 'user_roles' . '_' . $userData->id;
    $getSessionRoles = Session::get($sessionKey);
    if ($getSessionRoles != '') {
        $roles = $getSessionRoles;
    } else {
        $roles = UsersHasRoles::join('roles', 'roles.id', '=', 'users_has_roles.role_id')
            ->where('users_has_roles.user_id', $userData->id)
            ->select('users_has_roles.role_id as id', 'roles.name as role_name')
            ->get();
    }
    $generatedHtml = '';
    foreach ($roles as $key => $role) {
        if ($userData->getRoleNames()[0] != $role->role_name) {
            $generatedHtml .= '<li><a class="dropdown-item badge rounded-pill bg-secondary" href="' . route('change-role', $role->id) . '">' . ucfirst($role->role_name) . '</a></li>';
        }
    }
    return $generatedHtml;
}

function getStatusName($id)
{
    $getStatus = EstimateStatus::where('id', $id)->select('status')->first();
    return $getStatus['status'];
}
function getVersion($value)
{
    $getVersion = SOR::where('id', $value)->select('version')->first();
    return $getVersion['version'];
}

function getDesignationName($value)
{
    $designationName = Designation::where('id', $value)->select('designation_name')->first();
    return $designationName['designation_name'];
}
function getOfficeName($value)
{
    $officeName = Office::where('id', $value)->select('office_name')->first();
    return $officeName['office_name'];
}
function getDepartmentName($value)
{
    $departmentName = Department::where('id', $value)->select('department_name')->first();
    return $departmentName['department_name'];
}
function getDepartmentCategoryName($value)
{
    $categoryName = SorCategoryType::where('id', $value)->select('dept_category_name')->first();
    return $categoryName['dept_category_name'];
}
function getEstimateDesc($estimate_no)
{
    $getDescription = SORMaster::select('estimate_id', 'sorMasterDesc')->where('estimate_id', $estimate_no)->first();
    return $getDescription['sorMasterDesc'];
}
function generatePDF($list, $data, $title)
{
    // dd($list,$data,$title);
    // dd($data);
    $pdf = app('dompdf.wrapper');
    $pdf->loadView('pdfView', ['ModelList' => $list, 'data' => $data, 'Pdfitle' => $title]);
    // $pdf->loadHtml($data);
    // $pdf->render();
    $pdf->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif', 'isPhpEnabled' => true]);
    $pdf->setPaper('A4', 'landscape');
    $filename = $title . '.pdf';
    $file = $pdf->stream();
    $canvas = $pdf->get_canvas();
    // $font = Font_Metrics::get_font("helvetica", "bold");
    // $canvas->page_text(512, 10, "Página: {PAGE_NUM} de {PAGE_COUNT}",$font, 8, array(0,0,0));
    file_put_contents($filename, $file);
    return response()->download($filename)->deleteFileAfterSend(true);
}

function getunitName($unit_id)
{
    $unit_name = UnitMaster::select('unit_name')->where('id', $unit_id)->first();
    return $unit_name['unit_name'];
}

function getRateDesc($rate_id)
{
    $getRateDesc = RatesAnalysis::where('rate_id', $rate_id)->where('operation', 'Total')->first();
    return $getRateDesc['description'];
}

function getVolumeName($volume_no)
{
    $volume = '';
    if ($volume_no == 1) {
        return $volume = 'Volume I';
    } elseif ($volume_no == 2) {
        return $volume = 'Volume II';
    } elseif ($volume_no == 3) {
        return $volume = 'Volume III';
    } else {
        return;
    }
}
function getTableItemNo($sor_id, $item_no)
{
    $fetchRow = DynamicSorHeader::where('id', $sor_id)->select('row_data')->first();
    // $fetchRow = json_decode($fetchRow['row_data']);
    $rowId = explode('.', $item_no)[0];
    // dd($item_no);
    foreach (json_decode($fetchRow['row_data']) as $row) {
        if ($row->id == $rowId) {
            $fetchRow = $row;
        }
    }
    $hierarchicalArray = explode(".", $item_no);
    $convertedArray = [];
    $partialItemId = "";
    foreach ($hierarchicalArray as $part) {
        if ($partialItemId !== "") {
            $partialItemId .= ".";
        }
        $partialItemId .= $part;
        $convertedArray[] = $partialItemId;
    }
    // dd($convertedArray);
    extractItemNoOfItems($fetchRow, $itemNo, $convertedArray);
    return $itemNo;
}
function extractItemNoOfItems($data, &$itemNo, $counter)
{
    // dd($this->counterForItemNo);
    if (count($counter) > 1) {
        if (isset($data->item_no) && $data->item_no != '') {
            $itemNo = $data->item_no . ' ';
        }
        if (isset($data->_subrow)) {
            foreach ($data->_subrow as $key => $item) {
                // dd(isset($item->id) == isset($counter[$key+1]));
                if (isset($item->id)) {
                    foreach ($counter as $c) {
                        if ($item->id == $c) {
                            $itemNo .= $item->item_no . ' ';
                        }
                    }
                    // if (isset($item->item_no) && isset($counter[$key+1]) ) {
                    //     if($item->id == $counter[$key+1]){
                    //         dd($item->item_no);
                    //         $itemNo .= $item->item_no . ' ';
                    //     }
                    // }
                    if (!empty($item->_subrow)) {
                        extractItemNoOfItems($item->_subrow, $itemNo, $counter);
                    }
                }
            }
        }
    } else {
        $itemNo = $data->item_no;
    }

}
function getTableDesc($sor_id, $item_no)
{
    $cacheKey = 'fetchRow_' . $sor_id . '_' . $item_no;
    $getCacheData = Cache::get($cacheKey);
    if ($getCacheData != '') {
        $fetchRow = $getCacheData;
    } else {
        $fetchRow = Cache::remember($cacheKey, now()->addMinutes(720), function () use ($sor_id) {
            return DynamicSorHeader::where('id', $sor_id)->select('row_data')->first();
        });
    }
    // $fetchRow = json_decode($fetchRow['row_data']);
    $rowId = explode('.', $item_no)[0];
    foreach (json_decode($fetchRow['row_data']) as $row) {
        if ($row->id == $rowId) {
            $fetchRow = $row;
        }
    }
    $hierarchicalArray = explode(".", $item_no);
    $convertedArray = [];
    $partialItemId = "";
    foreach ($hierarchicalArray as $part) {
        if ($partialItemId !== "") {
            $partialItemId .= ".";
        }
        $partialItemId .= $part;
        $convertedArray[] = $partialItemId;
    }
    $loopCount = 1;
    extractDescOfItems($fetchRow, $descriptions, $convertedArray, $loopCount);
    return $descriptions;
}
function extractDescOfItems($data, &$descriptions, $counter, $loopCount)
{
    // If need parent desc
    if (isset($data->desc_of_item) && $data->desc_of_item != '') {
        $descriptions .= $data->desc_of_item . ' ';
    }
    if (isset($data->_subrow)) {
        foreach ($data->_subrow as $item) {
            // dd($item,$counter[$loopCount],$item->id);
            if (isset($item->desc_of_item) && isset($counter[$loopCount]) == $item->id) {
                $descriptions .= $item->desc_of_item . ' ';
                $loopCount++;
            }
            if (!empty($item->_subrow)) {
                extractDescOfItems($item->_subrow, $descriptions, $counter, $loopCount);
            }
        }
    }
}
function getSorTableName($sor_id)
{
    $fetchRow = DynamicSorHeader::where('id', $sor_id)->select('table_no')->first();
    return $fetchRow['table_no'];
}
function getSorPageNo($sor_id)
{
    $fetchRow = DynamicSorHeader::where('id', $sor_id)->select('page_no')->first();
    return $fetchRow['page_no'];
}
function getSorCorrigenda($sor_id)
{
    $fetchRow = DynamicSorHeader::where('id', $sor_id)->select('corrigenda_name')->first();
    return $fetchRow['corrigenda_name'];
}
