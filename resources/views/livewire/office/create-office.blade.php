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
                                <x-input label="{{ trans('cruds.office.fields.office_name') }}"
                                    placeholder="{{ trans('cruds.office.fields.office_name') }}"
                                    wire:model.defer="officeData.office_name" />
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="form-group">
                                <x-input label="{{ trans('cruds.office.fields.office_code') }}"
                                    placeholder="{{ trans('cruds.office.fields.office_code') }}"
                                    wire:model.defer="officeData.office_code" />
                            </div>
                        </div>
                        {{-- <div class="col-md-6 col-lg-6 col-sm-6">
                            <x-select label="Select Office {{ trans('cruds.office.fields.level') }}"
                                placeholder="Select Office {{ trans('cruds.office.fields.level') }}" :options="[
                                    ['name' => 'L1 Level', 'id' => 1],
                                    ['name' => 'L2 Level', 'id' => 2],
                                    ['name' => 'L3 Level', 'id' => 3],
                                    ['name' => 'L4 Level', 'id' => 4],
                                    ['name' => 'L5 Level', 'id' => 5],
                                    ['name' => 'L6 Level', 'id' => 6],
                                ]"
                                option-label="name" option-value="id" wire:model.defer="selectedOption.level" />
                        </div> --}}
                        {{-- <div class="col-md-6 col-lg-6 col-sm-6">
                            <div class="form-group">
                                <x-select wire:key="group" label="Groups" placeholder="Select Group"
                                    wire:model.defer="selectedOption.group_id">
                                    @isset($fetchDropdownData['groups'])
                                        @foreach ($fetchDropdownData['groups'] as $group)
                                            <x-select.option label="{{ $group['group_name'] }}"
                                                value="{{ $group['id'] }}" />
                                        @endforeach
                                    @endisset
                                </x-select>
                            </div>
                        </div> --}}
                        <div class="col-md-6 col-sm-3 col-lg-6">
                            <div class="form-group">
                                <x-select wire:key="district"
                                    label="Select {{ trans('cruds.office.fields.office_district') }}"
                                    placeholder="Select {{ trans('cruds.office.fields.office_district') }}"
                                    wire:model.defer="selectedOption.dist_code">
                                    @foreach ($fetchDropdownData['district'] as $district)
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
                                    wire:model.defer="selectedOption.In_area" :options="[['name' => 'Rural', 'id' => 1], ['name' => 'Urban', 'id' => 2]]" option-label="name"
                                    option-value="id" x-on:select="$wire.areaChangeEvent()" />
                            </div>
                        </div>
                        @isset($selectedOption['In_area'])
                            @if ($selectedOption['In_area'] == 1)
                                <div class="col-md-6 col-sm-3 col-lg-6">
                                    <div class="form-group">
                                        <x-select wire:key="rural_block_code"
                                            label="Select {{ trans('cruds.office.fields.block_name') }}"
                                            placeholder="Select {{ trans('cruds.office.fields.block_name') }}"
                                            wire:model.defer="selectedOption.rural_block_code"
                                            x-on:select="$wire.changeRuralBlock()">
                                            @foreach ($fetchDropdownData['rural_block'] as $block)
                                                <x-select.option label="{{ $block['block_name'] }}"
                                                    value="{{ $block['block_code'] }}" />
                                            @endforeach
                                        </x-select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-3 col-lg-6">
                                    <x-select wire:key="gp_code" label="Select {{ trans('cruds.office.fields.gp_name') }}"
                                        placeholder="Select {{ trans('cruds.office.fields.gp_name') }}"
                                        wire:model.defer="selectedOption.gp_code">
                                        @isset($fetchDropdownData['rural_gp'])
                                            @foreach ($fetchDropdownData['rural_gp'] as $gp)
                                                <x-select.option label="{{ $gp['gram_panchyat_name'] }}"
                                                    value="{{ $gp['gram_panchyat_code'] }}" />
                                            @endforeach
                                        @endisset

                                    </x-select>
                                </div>
                            @endif
                            @if ($selectedOption['In_area'] == 2)
                                <div class="col-md-6 col-sm-3 col-lg-6">
                                    <div class="form-group">
                                        <x-select wire:key="urban_code"
                                            label="Select {{ trans('cruds.office.fields.urban_body_name') }}"
                                            placeholder="Select {{ trans('cruds.office.fields.urban_body_name') }}"
                                            wire:model.defer="selectedOption.urban_code"
                                            x-on:select="$wire.changeUrbanBody()">
                                            @isset($fetchDropdownData['urban_body'])
                                                @foreach ($fetchDropdownData['urban_body'] as $body)
                                                    <x-select.option label="{{ $body['urban_body_name'] }}"
                                                        value="{{ $body['urban_body_code'] }}" />
                                                @endforeach
                                            @endisset

                                        </x-select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-3 col-lg-6">
                                    <div class="form-group">
                                        <x-select wire:key="urban_word_no"
                                            label="Select {{ trans('cruds.office.fields.word_no') }}"
                                            placeholder="Select {{ trans('cruds.office.fields.word_no') }}"
                                            wire:model.defer="selectedOption.ward_code">
                                            @isset($fetchDropdownData['urban_word'])
                                                @foreach ($fetchDropdownData['urban_word'] as $ward)
                                                    <x-select.option label="{{ $ward['urban_body_ward_name'] }}"
                                                        value="{{ $ward['urban_body_ward_code'] }}" />
                                                @endforeach
                                            @endisset
                                        </x-select>
                                    </div>
                                </div>
                            @endif
                        @endisset

                        <div class="col-md-12 col-sm-6 col-lg-12">
                            <x-textarea label="{{ trans('cruds.office.fields.office_address') }}"
                                placeholder="{{ trans('cruds.office.fields.office_address') }}"
                                wire:model="officeData.office_address" />
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    {{-- <button type="button" wire:click='resetSession'
                                        class="float-left btn btn-soft-danger rounded-pill">Reset</button> --}}
                                </div>
                                <div class="col-6"><button type="submit" wire:click='store'
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
