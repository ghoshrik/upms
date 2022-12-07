@php
    $data = \App\Models\EstimatePrepare::select('total_amount')
        ->where('estimate_id', $value)
        ->where('operation', 'Total')
        ->first();
    Log::alert(json_encode($data));
@endphp
@if (isset($data['total_amount']))
    {{ $data['total_amount'] }}
@endif
{{-- {{ $data['total_amount'] }} --}}
