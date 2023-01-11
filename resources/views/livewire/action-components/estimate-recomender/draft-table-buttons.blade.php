@php
    $checkForModify = App\Models\Esrecommender::join('sor_masters', 'estimate_recomender.estimate_id', '=', 'sor_masters.estimate_id')
        ->where([['estimate_recomender.estimate_id', '=', $value], ['sor_masters.status', '=', 4]])
        ->get();
    $checkForApprove = App\Models\Esrecommender::join('sor_masters', 'estimate_recomender.estimate_id', '=', 'sor_masters.estimate_id')
        ->where([['estimate_recomender.estimate_id', '=', $value], ['sor_masters.status', '=', 8]])
        ->get();
@endphp

{{-- @include('components.data-table-components.buttons.view')
@include('components.data-table-components.buttons.verify')
@isset($checkForApprove)
    @if (count($checkForApprove) == 0)
        @include('components.data-table-components.buttons.approve')
    @else
        @include('components.data-table-components.buttons.forward')
    @endif
@endisset
@include('components.data-table-components.buttons.revert')
@isset($checkForModify)
    @if (count($checkForModify) == 0)
        @include('components.data-table-components.buttons.modify')
    @endif
@endisset --}}

<div x-data="{ open: false }">
    <div x-show="!open" x-transition:enter.duration.300ms x-transition:leave.duration.300ms :class="open ? 'd-none' : 'd-inline'">
        @include('components.data-table-components.buttons.view')
        @include('components.data-table-components.buttons.revert')
        @isset($checkForApprove)
            @if (count($checkForApprove) == 0)
                @include('components.data-table-components.buttons.approve')
            @else
                @include('components.data-table-components.buttons.forward')
            @endif
        @endisset
    </div>
    @isset($checkForModify)
        @if (count($checkForModify) == 0)
            <div x-show="open" x-transition:enter.duration.300ms x-transition:leave.duration.300ms :class="open ? 'd-inline' : ''">
                @include('components.data-table-components.buttons.modify')
            </div>
            <a x-on:click="open = ! open" type="button" class="btn btn-soft-secondary btn-sm" :class="open ? '' : 'd-inline'">
                <x-lucide-more-vertical x-show="!open" class="w-4 h-4 text-gray-500" />
                <x-lucide-x x-show="open" class="w-4 h-4 text-gray-500" />
            </a>
        @endif
    @endisset
</div>
{{-- /* TODO::if open wireui dropdown datatable button remove overflow hidden */ --}}
{{-- <x-dropdown>
    <x-dropdown.header label="Settings">
        <x-dropdown.item label="Preferences" />
        <x-dropdown.item label="My Profile" />
    </x-dropdown.header>

    <x-dropdown.item separator label="Help Center" />
    <x-dropdown.item label="Live Chat" />
    <x-dropdown.item label="Logout" />
</x-dropdown> --}}
