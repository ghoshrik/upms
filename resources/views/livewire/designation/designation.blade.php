<div>
    @section('webtitle',trans('cruds.designation.title'))
    <div wire:loading.delay.long>
        <div class="spinner-border text-primary loader-position" role="status"></div>
    </div>
    <div wire:loading.delay.long.class="loading" x-data="{ formOpen: @entangle('formOpen'), editFormOpen: @entangle('editFormOpen') }">
        <div x-show="formOpen" x-transition.duration.900ms>
            @if ($formOpen)
                <livewire:designation.create-designation />
            @endif
        </div>
        <div x-show="editFormOpen" x-transition.duration.900ms>
            @if ($editFormOpen)
                <livewire:designation.edit-designation />
            @endif
        </div>


        <div x-show="!formOpen" x-transition.duration.500ms>
            <x-cards title="{{ trans('cruds.designation.title') }}">
                <x-slot name="table">
                    <livewire:designation.designation-table />
                </x-slot>
            </x-cards>
        </div>
    </div>
</div>
