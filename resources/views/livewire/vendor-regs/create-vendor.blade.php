<div>
    <x-form-section submit='store'>
        <x-slot name='form'>
            <div class="row">
                <div class="col-md-4 col-lg-4 col-sm-3 mb-2">
                    <x-input label="{{ trans('cruds.vendors.fields.comp_name') }}" wire:model.defer="vendorRegs.comp_name" placeholder="Enter {{ trans('cruds.vendors.fields.comp_name') }}" />
                </div>
                <div class="col-md-4 col-lg-4 col-sm-3 mb-2">
                    <x-input label="{{ trans('cruds.vendors.fields.tin') }}" wire:model.defer="vendorRegs.tin_number" placeholder="Enter {{ trans('cruds.vendors.fields.tin') }}" />
                </div>
                <div class="col-md-4 col-lg-4 col-sm-3 mb-2">
                    <x-input label="{{ trans('cruds.vendors.fields.pan') }}" wire:model.defer="vendorRegs.pan_number" onkeypress="return /[a-zA-Z0-9]/i.test(event.key)" placeholder="Enter {{ trans('cruds.vendors.fields.pan') }}" />
                </div>

                <div class="col-md-4 col-lg-4 col-sm-3 mb-2">
                    <x-input label="{{ trans('cruds.vendors.fields.mobile') }}" onkeypress="return /[0-9]/i.test(event.key)" wire:model.defer="vendorRegs.mobile" placeholder="Enter {{ trans('cruds.vendors.fields.mobile') }}" />
                </div>
                <div class="col-md-4 col-lg-8 col-sm-3 mb-2">
                    <x-textarea wire:model.defer="vendorRegs.address" rows="2" cols="3" label="{{ trans('cruds.vendors.fields.address') }}"
                        placeholder="Your {{ trans('cruds.vendors.fields.address') }}" />
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="{{ trans('global.data_store_btn_color') }} float-right mt-3">{{ trans('global.data_save_btn') }}</button>
                </div>
            </div>
        </x-slot>
    </x-form-section>
</div>
