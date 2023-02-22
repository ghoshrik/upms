<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    @section('webtitle', trans('cruds.milestone.title_singular'))
    <div wire:loading.delay.long>
        <div class="spinner-border text-primary loader-position" role="status"></div>
    </div>
    <div wire:loading.delay.long.class="loading" x-data="{ formOpen: @entangle('formOpen')}">
        <div x-show="formOpen" x-transition.duration.900ms>
            @if ($formOpen)
                <livewire:milestone.create-milestone />
            @endif
        </div>
        <div x-show="!formOpen " x-transition.duration.900ms>
            <x-cards title="">
                <x-slot name="table">
                    @if($viewMode)
                        <livewire:milestone.milestone-view :milestones="$milestones"/>
                    @else
                        <livewire:milestone.milestone-lists :wire:key="$updateDataTableTracker"/>
                        {{-- <livewire:data-table.milestone-data-table :wire:key="$updateDataTableTracker"/> --}}
                    @endif
                </x-slot>
            </x-cards>
        </div>
    </div>
</div>
