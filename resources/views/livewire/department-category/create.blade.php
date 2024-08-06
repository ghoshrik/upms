<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-lg-3">
                            <div class="form-group">
                                <x-input label="{{ trans('cruds.dept_category.fields.category') }}"
                                    placeholder="{{ trans('cruds.dept_category.fields.category') }}"
                                    wire:model.defer="dept_category_name" />
                            </div>
                        </div>
                        {{-- <div class="col-md-3 col-sm-6 col-lg-3">
                            <div class="form-group">
                                <x-select wire:key="volumeNo" label="Volume No" placeholder="Select Volume No"
                                    wire:model.defer="volumeId">
                                    @foreach ($volumeNo as $volume)
                                        <x-select.option label="{{ $volume['volume_name'] }}"
                                            value="{{ $volume['id'] }}" />
                                    @endforeach
                                </x-select>
                            </div>
                        </div> --}}
                        <div class="col-md-3 col-sm-6 col-lg-3">
                            <div class="form-group">
                                <x-input label="Total SOR Page" placeholder="Total SOR Page"
                                    wire:model.defer="totalSorPage" oninput="this.value = this.value.replace(/[^0-9]/g, '')"/>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12"><button type="submit" wire:click='store'
                                        class="btn {{$selectedIdForEdit ? 'btn-warning':'btn-success'}} btn-sm rounded-pill float-right"> {{$selectedIdForEdit ? 'Update':trans('global.data_save_btn')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
