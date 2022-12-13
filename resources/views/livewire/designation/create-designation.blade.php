<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" wire:loading.delay.longest.class="loading">
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
    </div>
</div>
