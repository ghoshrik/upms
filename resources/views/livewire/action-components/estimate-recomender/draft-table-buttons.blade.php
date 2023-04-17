@php
    $checkForModify = App\Models\Esrecommender::join('sor_masters', 'estimate_recomender.estimate_id', '=', 'sor_masters.estimate_id')
        ->where([['estimate_recomender.estimate_id', '=', $value], ['sor_masters.status', '=', 4]])
        ->get();
    $checkForApprove = App\Models\Esrecommender::join('sor_masters', 'estimate_recomender.estimate_id', '=', 'sor_masters.estimate_id')
        ->where([['estimate_recomender.estimate_id', '=', $value], ['sor_masters.status', '=', 6]])
        ->get();
@endphp
<div x-data="{ open: false }">
    <div x-show="!open" :class="open ? 'd-none' : 'd-inline'">
        @include('components.data-table-components.buttons.view')
        @isset($checkForApprove)
            @if (count($checkForApprove) == 0)
                @include('components.data-table-components.buttons.approve')
                @include('components.data-table-components.buttons.revert')
            @else
                @include('components.data-table-components.buttons.forward')
            @endif
        @endisset
    </div>
    @isset($checkForModify)
        @if (count($checkForModify) == 0 && count($checkForApprove) == 0)
            <div x-show="open" :class="open ? 'd-inline' : ''">
                @include('components.data-table-components.buttons.modify')
            </div>
            <a x-on:click="open = ! open" type="button" class="btn btn-soft-secondary btn-sm" :class="open ? '' : 'd-inline'">
                <x-lucide-more-vertical x-show="!open" class="w-4 h-4 text-gray-500" />
                <x-lucide-x x-show="open" class="w-4 h-4 text-gray-500" />
            </a>
        @endif
    @endisset
</div>
