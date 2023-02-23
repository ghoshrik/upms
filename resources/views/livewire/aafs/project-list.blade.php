<div>
    @section('webtitle',trans('cruds.aafs_project.title'))
    <div wire:loading.delay.long>
        <div class="spinner-border text-primary loader-position" role="status"></div>
    </div>
    <div wire:loading.delay.long.class="loading" x-data="{ formOpen: @entangle('formOpen') }">
        <div x-show="formOpen" x-transition.duration.900ms>
            @if ($formOpen)
                <livewire:aafs.create-proj />
            @endif
        </div>
        <div x-show="!formOpen" x-transition.duration.500ms>
            <x-cards title="">
                <x-slot name="table">
                    <livewire:aafs.datatable.a-a-f-s-datatable :wire:key="$updateDataTableTracker" />
                </x-slot>
            </x-cards>
        </div>
    </div>
</div>
