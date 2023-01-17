<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-6 col-lg-12">
                            <div class="form-group">
                                <x-input label="{{ trans('cruds.designation.title') }}"
                                    placeholder="{{ trans('cruds.designation.title') }}"
                                    wire:model.defer="editRow.designation_name" />
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12"><button type="submit" wire:click='store'
                                        class="btn btn-warning rounded-pill float-right">{{ trans('global.update_btn') }}</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
