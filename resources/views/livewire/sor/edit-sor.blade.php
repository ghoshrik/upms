<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    <div class="row mutipal-add-row">
                        <div class="col-md-12 col-sm-6 col-lg-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <x-input wire:key="deptCategory"
                                            label="{{ trans('cruds.sor.fields.dept_category') }}"
                                            placeholder="Select {{ trans('cruds.sor.fields.dept_category') }}"
                                            wire:model.defer="editRow.dept_category_id" disabled />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <x-input wire:key='item_details'
                                            label="{{ trans('cruds.sor.fields.item_number') }}"
                                            placeholder="{{ trans('cruds.sor.fields.item_number') }}"
                                            wire:model.defer="editRow.item_details" disabled />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <x-input wire:key='unit' label="{{ trans('cruds.sor.fields.unit') }}"
                                            placeholder="{{ trans('cruds.sor.fields.unit') }}"
                                            wire:model.defer="editRow.unit" disabled />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <x-input wire:key='cost' label="{{ trans('cruds.sor.fields.cost') }}"
                                            placeholder="{{ trans('cruds.sor.fields.cost') }}"
                                            wire:model.defer="editRow.cost" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <x-input wire:key='version' label="{{ trans('cruds.sor.fields.version') }}"
                                            placeholder="{{ trans('cruds.sor.fields.version') }}"
                                            wire:model.defer="editRow.version" disabled />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <x-datetime-picker without-time wire:key="effect_to"
                                            label="{{ trans('cruds.sor.fields.effect_to') }}"
                                            placeholder="{{ trans('cruds.sor.fields.effect_to') }}"
                                            wire:model.defer="effect_to" :min="now()->addDays(1)->hours(0)->minutes(0)" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-textarea rows="2" wire:key="description"
                                            wire:model="editRow.description"
                                            label="{{ trans('cruds.sor.fields.description') }}"
                                            placeholder="{{ trans('cruds.sor.fields.description') }}" disabled />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12"><button type="submit" wire:click='store'
                                    class="btn btn-success rounded-pill float-right">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
