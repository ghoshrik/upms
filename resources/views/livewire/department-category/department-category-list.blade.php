<div>
    @section('webtitle',trans('cruds.dept_category.title'))
    <div wire:loading.delay.long>
        <div class="spinner-border text-primary loader-position" role="status"></div>
    </div>
    <div wire:loading.delay.long.class="loading" x-data="{ formOpen: @entangle('formOpen') }">
        <div x-show="formOpen" x-transition.duration.900ms>
            @if ($formOpen)
                <livewire:department-category.create />
            @endif
        </div>
        <div x-show="!formOpen" x-transition.duration.500ms>
            <x-cards title="{{ trans('cruds.dept_category.title') }}">
                <x-slot name="table">

                </x-slot>
            </x-cards>
        </div>
    </div>

    {{-- @if($updateMode)
        {{__('live')}}
    @else
        @include('livewire.designation.create-designation') --}}
        {{-- <livewire:designation.create-designation /> --}}
    {{-- @endif --}}

</div>
