<div>
    {{-- @section('webtitle',trans('cruds.designation.title')) --}}
    @if($updateMode)
        {{__('live')}}
    @else
        {{-- @include('livewire.designation.create-designation') --}}
        <livewire:designation.create-designation />
    @endif
    <x-cards title="{{ trans('cruds.designation.title') }}">
        <x-slot name="table">
            <livewire:designation-table />
        </x-slot>
    </x-cards>
</div>
