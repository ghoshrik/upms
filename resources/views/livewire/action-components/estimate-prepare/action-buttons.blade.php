@php
    $checkForDraft = App\Models\SORMaster::where('estimate_id', $value)->first();
    $user = Auth::user()->roles->first();
@endphp
@include('components.data-table-components.buttons.view')
@if ($checkForDraft['status'] != 12)
    @include('components.data-table-components.buttons.forward')
@endif
@if (Auth::user()->can('modify estimate'))
    @include('components.data-table-components.buttons.modify')
@else
    @include('components.data-table-components.buttons.edit')
@endif
@if($user['has_level_no'] != 6)
    @include('components.data-table-components.buttons.revert')
@endif
