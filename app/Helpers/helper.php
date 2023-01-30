<?php

use App\Models\SOR;
use App\Models\SorMaster;
use App\Models\UnitType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Mockery\Matcher\Type;

function removeSession($session)
{
    if (Session::has($session)) {
        Session::forget($session);
    }
    return true;
}

function randomString($length, $type = 'token')
{
    if ($type == 'password')
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    elseif ($type == 'username')
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    else
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
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
            if ($check_data > 0) return false;
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


$Type;
// function printTreeHTML($tree,$parent = 0)
// {
//     global $Type;
//     // $type = "a";
//     echo $Type;
//     $unitDtls = UnitType::where('status',1)->get();
//     foreach ($tree as $key => $node) {
//         // echo $Type;
//         // echo $node["index"];
//         // if($node['parent_id'] == 0){
//         //     $parent = 0;
//         //     $parent = $key++;
//         //     echo $parent;
//         //     $parent = 0;
//         // }
//         // else{
//         //     $parent=$parent+1;
//         //     echo $key.$parent;
//         // }
//         echo "<li class='tree'>";
//             // echo "$key";
//             echo "<div class='row mutipal-add-row'>
//                     <div class='col-md-3 col-lg-3 col-sm-3 ml-2 mt-1 mb-1'>";
//                         echo '<input type="text" class="form-control" placeholder="milestone name" wire:model="arrayData.'.$node["index"].'.mStone_name" wire:key="arrayData.'.$node["index"].'.mStone_name"/>';
//                             // echo  "<x-input label='milestone_1' wire:key='inputsData." . $node['index'] . ".milestone_1'  placeholder='your Milestone_.$key" . $node['index'] . "' />";
//                 echo "</div>";

//                     echo "<div class='col-md-2 col-lg-2 col-sm-3 ml-2 mt-1 mb-1'>";
//                         echo '<input type="text" class="form-control" placeholder="weightage" wire:model="arrayData.'.$node["index"].'.mVal" wire:key="arrayData.'.$node["index"].'.mVal"/>';
//                             // echo '<input type="text" class="form-control" placeholder="unit" wire:model="arrayData.'.$node["index"].'.mUnit" wire:key="arrayData.'.$node["index"].'.mUnit" />';
//                                 // echo  "<x-input label='milestone_1' wire:key='inputsData." . $node['index'] . ".milestone_3'  placeholder='your Milestone_.$key" . $node['index'] . "' />";
//                     echo "</div>";

//                     echo "<div class='col-md-2 col-lg-2 col-sm-3 ml-2 mt-1 mb-1'>";
//                         echo '<select class="form-control" wire:model="arrayData.'.$node["index"].'.mUnit" wire:key="arrayData.'.$node["index"].'.mUnit" wire:click="chMileType($event.target.value)"><option value="">-- Select Unit --</option>';
//                             if(count($unitDtls)>0){
//                                 foreach($unitDtls as $units){
//                                     // echo '<input type="text" class="form-control" placeholder="value" wire:model="arrayData.'.$node["index"].'.mVal" wire:key="arrayData.'.$node["index"].'.mVal"/>';
//                                         echo '<option value='.$units['type'].'>'.$units['type'].'</option>';
//                                     }
//                                 }
//                             echo '</select>';
//                                 // echo  "<x-input label='milestone_1' wire:key='inputsData.". $node['index'] .".milestone_2'  placeholder='your Milestone_.$key" . $node['index'] . "' />";
//                         echo "</div>";


//                         // if($Type=="cm"){
//                         //     echo "<div class='col-md-2 col-lg-2 col-sm-3 ml-2 mt-1 mb-1'".$Type ? 'd-block':'d-none'.">";
//                         //     echo $Type;
//                         //     echo "</div>";
//                         // }
//                     echo "<div class='col-md-2 col-lg-2 col-sm-3 ml-2 mt-1 mb-1'>";
//                         echo '<input type="text" class="form-control" placeholder="cost" wire:model="arrayData.'.$node["index"].'.mCost" wire:key="arrayData.'.$node["index"].'.mCost" />';
//                             // echo  "<x-input label='milestone_1' wire:key='inputsData." . $node['index'] . ".milestone_4'  placeholder='your Milestone_.$key" . $node['index'] . "' />";
//                     echo "</div>";

//                     echo "<div class='col-md-2 col-lg-1 col-sm-3 ml-2 mt-1 mb-1'>";
//                         // echo "<div class='row'>";
//                         echo "<div class='d-flex'>";
//                             echo "<button type='button' wire:click='addMilestone(" . $node['index'] . ")' class='d-inline btn btn-soft-success rounded-pill'>
//                             <span class='btn-inner'>
//                                 <svg class='w-4 h-4 text-gray-500' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
//                                     <line x1='12' y1='5' x2='12' y2='19'></line>
//                                     <line x1='5' y1='12' x2='19' y2='12'></line>
//                                 </svg>
//                             </span>
//                         </button>&nbsp;&nbsp;&nbsp;";
//                         echo "<button type='button' wire:click='removeMilestone(" . $node['parent_id'] . ")' class='d-inline btn btn-soft-danger rounded-pill'>
//                             <span class='btn-inner'>
//                                 <svg class='w-4 h-4 text-gray-500' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
//                                     <line x1='18' y1='6' x2='6' y2='18'></line>
//                                     <line x1='6' y1='6' x2='18' y2='18'></line>
//                                 </svg>
//                             </span>
//                         </button>";
//                         echo "</div>";
//                         // echo "</div>";
//                     echo "</div>";
//                 echo "</div>";
//         if (!empty($node['children'])) {
//             echo "<ul class='tree'>";
//             printTreeHTML($node['children'],$parent);
//             echo "</ul>";
//         }
//         echo "</li>";
//     }
// }

function printTreeHTML($tree,$parent = 0)
{
    global $Type;
    // $type = "a";
    echo $Type;
    $unitDtls = UnitType::where('status',1)->get();
    foreach ($tree as $key => $node) {
        $nodeModelIndex = $node["index"]-1;
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
                        echo '<input type="text" class="form-control" placeholder="milestone name" wire:model="mileStoneData.'.$nodeModelIndex.'.milestone_name" wire:key="mileStoneData.'.$nodeModelIndex.'.milestone_name"/>';
                echo "</div>";
                    echo "<div class='col-md-2 col-lg-2 col-sm-3 ml-2 mt-1 mb-1'>";
                        echo '<input type="text" class="form-control" placeholder="weightage" wire:model="mileStoneData.'.$nodeModelIndex.'.weight" wire:key="mileStoneData.'.$nodeModelIndex.'.weight"/>';
                    echo "</div>";
                    echo "<div class='col-md-2 col-lg-2 col-sm-3 ml-2 mt-1 mb-1'>";
                        echo '<select class="form-control" wire:model="mileStoneData.'.$nodeModelIndex.'.unit_type" wire:key="mileStoneData.'.$nodeModelIndex.'.unit_type" wire:click="chMileType($event.target.value)"><option value="">-- Select Unit --</option>';
                            if(count($unitDtls)>0)
                            {
                                foreach($unitDtls as $units)
                                {
                                    echo '<option value='.$units['type'].'>'.$units['type'].'</option>';
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
                        echo '<input type="text" class="form-control" placeholder="cost" wire:model="mileStoneData.'.$nodeModelIndex.'.cost" wire:key="mileStoneData.'.$nodeModelIndex.'.cost" />';
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
                        echo "<button type='button' wire:click='removeMilestone(".$node['index'].")' class='d-inline btn btn-soft-danger rounded-pill'>
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
            printTreeHTML($node['children'],$parent);
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
        if ($child['parent_id']==0) {
            $rootNodes[] = $child;
        }
    }
    return $rootNodes;
}

//delete entries
function remove_element_by_value($arr, $val) {
    $return = array();
    $array = array_values($arr);
    // dd($array);
    foreach($array as $k => $v) {
        if($v['index']==$val)
        {
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
function delete_entries(&$array, $ids_to_delete) {
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
//pending for design reponsive problem
