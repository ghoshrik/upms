
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
                                <x-input label="{{ trans('cruds.dept_category.fields.category') }}"
                                placeholder="{{ trans('cruds.dept_category.fields.category') }}"
                                wire:model.defer="dept_category_name" />
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12"><button type="submit" wire:click='store'
                                        class="btn btn-success rounded-pill float-right">Save</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


