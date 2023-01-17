<?php

use App\Models\SOR;
use App\Models\SorMaster;
use App\Models\UnitType;

function removeSession($session){
    if(\Session::has($session)){
        \Session::forget($session);
    }
    return true;
}

function randomString($length,$type = 'token'){
    if($type == 'password')
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    elseif($type == 'username')
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    else
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $token = substr( str_shuffle( $chars ), 0, $length );
    return $token;
}

function activeRoute($route, $isClass = false): string
{
    $requestUrl = request()->fullUrl() === $route ? true : false;

    if($isClass) {
        return $requestUrl ? $isClass : '';
    } else {
        return $requestUrl ? 'active' : '';
    }
}

function checkRecordExist($table_list,$column_name,$id){
    if(count($table_list) > 0){
        foreach($table_list as $table){
            $check_data = \DB::table($table)->where($column_name,$id)->count();
            if($check_data > 0) return false ;
        }
        return true;
    }
    return true;
}

// Model file save to storage by spatie media library
function storeMediaFile($model,$file,$name)
{
    if($file) {
        $model->clearMediaCollection($name);
        if (is_array($file)){
            foreach ($file as $key => $value){
                $model->addMedia($value)->toMediaCollection($name);
            }
        }else{
            $model->addMedia($file)->toMediaCollection($name);
        }
    }
    return true;
}

// Model file get by storage by spatie media library
function getSingleMedia($model, $collection = 'image_icon',$skip=true)
{
    if (!\Auth::check() && $skip) {
        return asset('images/avatars/01.png');
    }
    if ($model !== null) {
        $media = $model->getFirstMedia($collection);
    }
    $imgurl= isset($media)?$media->getPath():'';
    if (file_exists($imgurl)) {
        return $media->getFullUrl();
    }
    else
    {
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
    if($media) {
        if($media->disk == 'public') {
            $mediaCondition = file_exists($media->getPath());
        } else {
            $mediaCondition = \Storage::disk($media->disk)->exists($media->getPath());
        }
    }
    return $mediaCondition;
}

function getEstimateDescription($estimate_no)
{
    if($estimate_no)
    {
        $estimateDescription = SorMaster::select('sorMasterDesc')->where('estimate_id',$estimate_no)->first();
    }
    return $estimateDescription = $estimateDescription['sorMasterDesc'];

}

function getSorItemNumber($sor_item_number)
{
    if($sor_item_number)
    {
        $sorItemNo = SOR::select('Item_details')->where('id',$sor_item_number)->first();
    }
    return $sorItemNo = $sorItemNo['Item_details'];
}

function getSorItemNumberDesc($sor_item_number)
{
    if($sor_item_number)
    {
        $sorItemDesc = SOR::select('description')->where('id',$sor_item_number)->first();
    }
    return $sorItemDesc = $sorItemDesc['description'];
}
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
                        echo '<input type="text" class="form-control" placeholder="milestone name" wire:model="mileStoneData.'.$nodeModelIndex.'.m1" wire:key="mileStoneData.'.$nodeModelIndex.'.m1"/>';
                            // echo  "<x-input label='milestone_1' wire:key='inputsData." . $node['index'] . ".milestone_1'  placeholder='your Milestone_.$key" . $node['index'] . "' />";
                echo "</div>";

                    echo "<div class='col-md-2 col-lg-2 col-sm-3 ml-2 mt-1 mb-1'>";
                        echo '<input type="text" class="form-control" placeholder="weightage" wire:model="mileStoneData.'.$nodeModelIndex.'.m2" wire:key="mileStoneData.'.$nodeModelIndex.'.m2"/>';
                            // echo '<input type="text" class="form-control" placeholder="unit" wire:model="mileStoneData.'.$node["index"].'.mUnit" wire:key="mileStoneData.'.$node["index"].'.mUnit" />';
                                // echo  "<x-input label='milestone_1' wire:key='inputsData." . $node['index'] . ".milestone_3'  placeholder='your Milestone_.$key" . $node['index'] . "' />";
                    echo "</div>";

                    echo "<div class='col-md-2 col-lg-2 col-sm-3 ml-2 mt-1 mb-1'>";
                        echo '<select class="form-control" wire:model="mileStoneData.'.$nodeModelIndex.'.m3" wire:key="mileStoneData.'.$nodeModelIndex.'.m3" wire:click="chMileType($event.target.value)"><option value="">-- Select Unit --</option>';
                            if(count($unitDtls)>0){
                                foreach($unitDtls as $units){
                                    // echo '<input type="text" class="form-control" placeholder="value" wire:model="mileStoneData.'.$node["index"].'.mVal" wire:key="mileStoneData.'.$node["index"].'.mVal"/>';
                                        echo '<option value='.$units['type'].'>'.$units['type'].'</option>';
                                    }
                                }
                            echo '</select>';
                                // echo  "<x-input label='milestone_1' wire:key='inputsData.". $node['index'] .".milestone_2'  placeholder='your Milestone_.$key" . $node['index'] . "' />";
                        echo "</div>";


                        // if($Type=="cm"){
                        //     echo "<div class='col-md-2 col-lg-2 col-sm-3 ml-2 mt-1 mb-1'".$Type ? 'd-block':'d-none'.">";
                        //     echo $Type;
                        //     echo "</div>";
                        // }
                    echo "<div class='col-md-2 col-lg-2 col-sm-3 ml-2 mt-1 mb-1'>";
                        echo '<input type="text" class="form-control" placeholder="cost" wire:model="mileStoneData.'.$nodeModelIndex.'.m4" wire:key="mileStoneData.'.$nodeModelIndex.'.m4" />';
                            // echo  "<x-input label='milestone_1' wire:key='inputsData." . $node['index'] . ".milestone_4'  placeholder='your Milestone_.$key" . $node['index'] . "' />";
                    echo "</div>";

                    echo "<div class='col-md-2 col-lg-1 col-sm-3 ml-2 mt-1 mb-1'>";
                        // echo "<div class='row'>";
                        echo "<div class='d-flex'>";
                            echo "<button type='button' wire:click='addMilestone(" . $node['index'] . ")' class='d-inline btn btn-soft-success rounded-pill'>
                            <span class='btn-inner'>
                                <svg class='w-4 h-4 text-gray-500' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                                    <line x1='12' y1='5' x2='12' y2='19'></line>
                                    <line x1='5' y1='12' x2='19' y2='12'></line>
                                </svg>
                            </span>
                        </button>&nbsp;&nbsp;&nbsp;";
                        // echo "<button type='button' wire:click='removeMilestone(" . $node['parent_id'] . ")' class='d-inline btn btn-soft-danger rounded-pill'>
                        //     <span class='btn-inner'>
                        //         <svg class='w-4 h-4 text-gray-500' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                        //             <line x1='18' y1='6' x2='6' y2='18'></line>
                        //             <line x1='6' y1='6' x2='18' y2='18'></line>
                        //         </svg>
                        //     </span>
                        // </button>";
                        echo "</div>";
                        // echo "</div>";
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
