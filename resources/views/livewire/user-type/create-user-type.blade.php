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
                                <x-input label="{{ trans('cruds.user_type.fields.name') }}"
                                    placeholder="{{ trans('cruds.user_type.fields.name') }}"
                                    wire:model.defer="formData.user_type" />
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="form-group">
                                <x-select label="Parent Type"
                                    placeholder="Select Parent Type"
                                    wire:model.defer="formData.user_type_id">
                                    @foreach ($dropdownData['user_types_list'] as $user_type)
                                        <x-select.option label="{{ $user_type['type'] }}"
                                            value="{{ $user_type['id'] }}" />
                                    @endforeach
                                </x-select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {{-- <div class="col-6"> <button type="button" wire:click='resetSession'
                                        class="btn btn-soft-danger rounded-pill float-left">Reset</button>
                                </div> --}}
                                <div class="col-6"><button type="submit" wire:click='store'
                                        class="btn btn-success rounded-pill float-right">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
