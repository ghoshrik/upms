<div>
    @section('webtitle',trans('cruds.designation.title'))
    @if($updateMode)
        {{__('live')}}
    @else
        @include('livewire.designation.create-designation')
    @endif
    <livewire:designation-table />
</div>
