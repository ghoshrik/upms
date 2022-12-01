<div>
    @section("webtitle",'Designations')
    <div x-show="formOpen" class="row" x-transition.duration.500ms>
        {{-- <x-errors /> --}}
        <x-form-section submit="store">
            <x-slot name="form">
                <x-input wire:model="designation_name" label="{{trans('cruds.designation.title')}}" placeholder="{{trans('cruds.designation.title')}}" />




                <div class="row">
                    <div class="col mt-2">
                        <div class="form-group float-right">
                            <x-button type="submit" class="{{ trans('global.data_store_btn_color') }}">{{ trans('global.data_store_btn') }}</x-button>
                        </div>
                    </div>
                </div>
            </x-slot>
        </x-form-section>
        {{-- <x-notifications position="bottom-center" /> --}}
    </div>
</div>
