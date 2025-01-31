<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div  class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="form-group">
                                <x-input label="{{ trans('cruds.department.fields.department_name') }}"
                                    placeholder="{{ trans('cruds.department.fields.department_name') }}"
                                    wire:model.defer="department_name" />
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="form-group">
                                <x-input label="{{ trans('cruds.department.fields.department_code') }}"
                                    placeholder="{{ trans('cruds.department.fields.department_code') }}"
                                    wire:model.defer="department_code" />
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
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').hide();
        }, 300);
    });
</script>
