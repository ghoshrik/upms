<div>
    <x-form-section submit='store'>
        <x-slot name='form'>
            <div class="row">
                <div class="col-md-4 col-lg-4 col-sm-3 mb-2">
                    <x-input label="{{ trans('cruds.vendors.fields.comp_name') }}" wire:model="vendorRegs.comp_name" placeholder="Enter {{ trans('cruds.vendors.fields.comp_name') }}" />
                </div>
                <div class="col-md-4 col-lg-4 col-sm-3 mb-2">
                    <x-input label="{{ trans('cruds.vendors.fields.tin') }}" wire:model="vendorRegs.tin_number" placeholder="Enter {{ trans('cruds.vendors.fields.tin') }}" />
                </div>
                <div class="col-md-4 col-lg-4 col-sm-3 mb-2">
                    <x-input label="{{ trans('cruds.vendors.fields.pan') }}" wire:model="vendorRegs.pan_number" onkeypress="return /[A-Z0-9]/i.test(event.key)" placeholder="Enter {{ trans('cruds.vendors.fields.pan') }}" />
                </div>
                <div class="col-md-4 col-lg-4 col-sm-3 mb-2">
                    <x-input label="{{ trans('cruds.vendors.fields.gstin') }}" wire:model="vendorRegs.gstin" placeholder="Enter {{ trans('cruds.vendors.fields.gstin') }}" />
                </div>
                <div class="col-md-4 col-lg-4 col-sm-3 mb-2">
                    <x-select
                            label="{{ trans('cruds.vendors.fields.class_vendor') }}"
                            placeholder="{{ trans('cruds.vendors.fields.class_vendor') }}"
                            :options="[
                                ['name' => 'Class 1',  'id' => 1],
                                ['name' => 'Class 2', 'id' => 2],
                                ['name' => 'Class 3',   'id' => 3],
                            ]"
                            option-label="name"
                            option-value="name"
                            wire:model.defer="vendorRegs.class_vendor"
                        />
                </div>
                <div class="col-md-4 col-lg-4 col-sm-3 mb-2">
                    <x-input label="{{ trans('cruds.vendors.fields.mobile') }}" onkeypress="return /[0-9]/i.test(event.key)" wire:model="vendorRegs.mobile" placeholder="Enter {{ trans('cruds.vendors.fields.mobile') }}" />
                </div>
                <div class="col-md-4 col-lg-8 col-sm-3 mb-2">
                    <x-textarea wire:model="vendorRegs.address" rows="2" cols="3" label="{{ trans('cruds.vendors.fields.address') }}"
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
