<?php
    // print_r($value)
    // $getEstimate = App\Models\SORMaster::where('estimate_id', $value)->where('status','!=',2)->get();
    // if(count($getEstimate) != 0){
        $estiamteTotal = App\Models\EstimatePrepare::where('estimate_id',$value)->where('operation','Total')->first();
        if($estiamteTotal != ''){
            print_r($estiamteTotal['total_amount']);
        }
    // }
?>
