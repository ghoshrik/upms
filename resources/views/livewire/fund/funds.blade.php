<div>
    @section('webtitle', trans('cruds.funds.title'))
    <div wire:loading.delay.long>
        <div class="spinner-border text-primary loader-position" role="status"></div>
    </div>
    <div wire:loading.delay.long.class="loading" x-data="{ formOpen: @entangle('formOpen')}">
        <div x-show="formOpen" x-transition.duration.900ms>
            @if ($formOpen)
                <livewire:fund.create-funds />
            @endif
        </div>
        <div x-show="!formOpen " x-transition.duration.900ms>
            <x-cards title="">
                <x-slot name="table">
                    <livewire:data-table.fund-data-table :wire:key='$updateDataTableTracker'/>
                </x-slot>
            </x-cards>
        </div>
    </div>
</div>
