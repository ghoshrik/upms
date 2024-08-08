<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <x-input label="{{ trans('cruds.designation.fields.designation_name') }}"
                                    placeholder="{{ trans('cruds.designation.fields.designation_name') }}"
                                    wire:model.defer="designation_name" />
                            </div>
                        </div>
                        {{-- <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="form-group">
                                <x-select wire:key="level" label="Level List" placeholder="Select Level"
                                    wire:model.defer="level_no">
                                    @isset($dropdownData['levels'])
                                        @foreach ($dropdownData['levels'] as $level)
                                            <x-select.option label="{{ $level['level_name'] }}"
                                                value="{{ $level['id'] }}" />
                                        @endforeach
                                    @endisset
                                </x-select>
                            </div>
                        </div> --}}
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
