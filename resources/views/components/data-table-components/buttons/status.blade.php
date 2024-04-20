@php
    if($type == 'Rate'){
        $getData = DB::select("SELECT rate_id,status FROM rates_master WHERE rate_id = ?", [$value]);
    }elseif($type == 'Estimate'){
        $getData = DB::select("SELECT estimate_id,status FROM sor_masters WHERE estimate_id = ?", [$value]);
    }else {
        $getData = '';
    }
@endphp
@if ($getData != '')
    <span class="badge badge-pill bg-success">{{ getStatusName($getData[0]->status) }}</span>
@endif

