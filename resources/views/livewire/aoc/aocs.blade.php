<div>
    {{-- Stop trying to control. --}}
    @section('webtitle', trans('cruds.aoc.title'))
    <div wire:loading.delay.long>
        <div class="spinner-border text-primary loader-position" role="status"></div>
    </div>
    <div wire:loading.delay.long.class="loading" x-data="{ formOpen: @entangle('formOpen')}">
        <div x-show="formOpen" x-transition.duration.900ms>
            @if ($formOpen)
                <livewire:aoc.create-aoc/>
            @endif
        </div>
        <div x-show="!formOpen " x-transition.duration.900ms>
            <x-cards title="">
                <x-slot name="table">
                    <livewire:data-table.aoc-table/>
                </x-slot>
            </x-cards>
        </div>
    </div>
</div>
