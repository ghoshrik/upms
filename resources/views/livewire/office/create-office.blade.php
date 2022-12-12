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
                                <x-input label="{{ trans('cruds.office.fields.office_name') }}"
                                    placeholder="{{ trans('cruds.office.fields.office_name') }}"
                                    wire:model.defer="" />
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-3 col-lg-6">
                            <div class="form-group">
                                <x-select wire:key="district"
                                    label="Select {{ trans('cruds.office.fields.office_district') }}"
                                    placeholder="Select {{ trans('cruds.office.fields.office_district') }}"
                                    wire:model.defer="selectedOption.district" x-on:select="$wire.distChangeEvent()">
                                    @foreach ($fatchDropdownData['district'] as $district)
                                        <x-select.option label="{{ $district['district_name'] }}"
                                            value="{{ $district['district_code'] }}" />
                                    @endforeach
                                </x-select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-3 col-lg-6">
                            <div class="form-group">
                                <x-select wire:key='area' label="Select {{ trans('cruds.office.fields.area') }}"
                                    placeholder="Select {{ trans('cruds.office.fields.area') }}"
                                    wire:model.defer="selectedOption.area" :options="[['name' => 'Rural', 'id' => 1], ['name' => 'Urban', 'id' => 2]]" option-label="name"
                                    option-value="id" x-on:select="$wire.areaChangeEvent()" />
                            </div>
                        </div>
                        @isset($selectedOption['area'])
                            @if ($selectedOption['area'] == 1)
                            <div class="col-md-6 col-sm-3 col-lg-6">
                                <div class="form-group">
                                    <x-select wire:key="rural_block_code"
                                        label="Select {{ trans('cruds.office.fields.block_name') }}"
                                        placeholder="Select {{ trans('cruds.office.fields.block_name') }}"
                                        wire:model.defer="selectedOption.rural_block_code" x-on:select="$wire.changeRuralBlock()">
                                        {{-- @foreach (fatchDropdownData['district'] as $district)
                                        <x-select.option label="{{ $district['district_name'] }}" value="{{ $district['district_code'] }}" />
                                    @endforeach --}}
                                    </x-select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-3 col-lg-6">
                                <x-select wire:key="gp_code" label="Select {{ trans('cruds.office.fields.gp_name') }}"
                                    placeholder="Select {{ trans('cruds.office.fields.gp_name') }}"
                                    wire:model.defer="selectedOption.gp_code" >
                                    {{-- @foreach (fatchDropdownData['district'] as $district)
                                        <x-select.option label="{{ $district['district_name'] }}" value="{{ $district['district_code'] }}" />
                                    @endforeach --}}
                                </x-select>
                            </div>
                        @endif
                        @if ($selectedOption['area'] == 2)
                            <div class="col-md-6 col-sm-3 col-lg-6">
                                <div class="form-group">
                                    <x-select wire:key="urban_body_code"
                                        label="Select {{ trans('cruds.office.fields.urban_body_name') }}"
                                        placeholder="Select {{ trans('cruds.office.fields.urban_body_name') }}"
                                        wire:model.defer="selectedOption.urban_body_code" x-on:select="$wire.changeUrbanBody()">
                                        {{-- @foreach (fatchDropdownData['district'] as $district)
                                    <x-select.option label="{{ $district['district_name'] }}" value="{{ $district['district_code'] }}" />
                                @endforeach --}}
                                    </x-select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-3 col-lg-6">
                                <div class="form-group">
                                    <x-select wire:key="urban_word_no"
                                        label="Select {{ trans('cruds.office.fields.word_no') }}"
                                        placeholder="Select {{ trans('cruds.office.fields.word_no') }}"
                                        wire:model.defer="selectedOption.urban_word_no" >
                                        {{-- @foreach (fatchDropdownData['district'] as $district)
                                        <x-select.option label="{{ $district['district_name'] }}" value="{{ $district['district_code'] }}" />
                                    @endforeach --}}
                                    </x-select>
                                </div>
                            </div>
                        @endif
                        @endisset

                        <div class="col-md-12 col-sm-6 col-lg-12">
                            <x-textarea label="{{ trans('cruds.office.fields.office_address') }}"
                                placeholder="{{ trans('cruds.office.fields.office_address') }}" />
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6"> <button type="button" wire:click='resetSession'
                                        class="btn btn-soft-danger rounded-pill float-left">Reset</button></div>
                                <div class="col-6"><button type="submit" wire:click='store'
                                        class="btn btn-success rounded-pill float-right">Save</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
