<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="form-group">
                                <x-input label="Name" placeholder="Enter Design type name" wire:model.defer="name" />
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                </div>
                                <div class="col-6">
                                    <button type="submit" wire:click.prevent='store'
                                        class="float-right btn btn-success rounded-pill">{{ trans('global.data_save_btn') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
