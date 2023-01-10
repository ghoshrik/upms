@php
    $checkForModify = App\Models\Esrecommender::where('estimate_id', '=', $value)->get();
@endphp
@include('components.data-table-components.buttons.view')
{{-- @include('components.data-table-components.buttons.verify') --}}
@include('components.data-table-components.buttons.approve&forward')
@include('components.data-table-components.buttons.forward')
@include('components.data-table-components.buttons.revert')
@isset($checkForModify)
    @if (count($checkForModify) == 0)
        @include('components.data-table-components.buttons.modify')
    @endif
@endisset
