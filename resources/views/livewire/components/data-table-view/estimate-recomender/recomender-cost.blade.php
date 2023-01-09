    @php
        $recomenderCost = App\Models\Esrecommender::where([['operation', 'Total'], ['estimate_id', '=', $value]])
            ->where('verified_by', '=', Auth::user()->id)
            ->first();
    @endphp
    @isset($recomenderCost)
        {{ round($recomenderCost['total_amount'], 10, 2) }}
    @endisset
