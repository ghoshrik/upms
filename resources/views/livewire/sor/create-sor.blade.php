<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    <div class="row">
                        <div class="col-md-11 col-sm-6 col-lg-11">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <x-select wire:key="deptCategory" label="{{ trans('cruds.sor.fields.dept_category') }}"
                                            placeholder="Select {{ trans('cruds.sor.fields.dept_category') }}"
                                            wire:model.defer=""
                                            x-on:select="$wire.changeCategory()">
                                            {{-- @foreach ($getCategory as $category)
                                            <x-select.option label="{{ $category['item_name'] }}"
                                                value="{{ $category['id'] }}" />
                                            @endforeach --}}
                                        </x-select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <x-input label="{{ trans('cruds.sor.fields.item_number') }}"
                                            placeholder="{{ trans('cruds.sor.fields.item_number') }}"
                                            wire:model.defer="" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <x-input label="{{ trans('cruds.sor.fields.unit') }}"
                                            placeholder="{{ trans('cruds.sor.fields.unit') }}"
                                            wire:model.defer="" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <x-input label="{{ trans('cruds.sor.fields.cost') }}"
                                            placeholder="{{ trans('cruds.sor.fields.cost') }}"
                                            wire:model.defer="" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <x-select wire:key="version" label="{{ trans('cruds.sor.fields.version') }}"
                                            placeholder="Select {{ trans('cruds.sor.fields.version') }}"
                                            wire:model.defer=""
                                            x-on:select="$wire.changeCategory()">
                                            {{-- @foreach ($getCategory as $category)
                                            <x-select.option label="{{ $category['item_name'] }}"
                                                value="{{ $category['id'] }}" />
                                            @endforeach --}}
                                        </x-select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <x-datetime-picker without-time label="{{ trans('cruds.sor.fields.effect_from') }}"
                                            placeholder="{{ trans('cruds.sor.fields.effect_from') }}"
                                            wire:model.defer="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-textarea rows="2" wire:model="" label="{{ trans('cruds.sor.fields.description') }}" placeholder="{{ trans('cruds.sor.fields.description') }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-6 col-lg-1">

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
