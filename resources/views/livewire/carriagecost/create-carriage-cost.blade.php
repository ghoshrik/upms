<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    <div class="row">
                        <div class="col-md-5 col-lg-5 col-sm-3">
                            <div class="form-group">
                                {{-- <div class="col col-md-8 col-lg-8 col-sm-12 col-xs-12 mb-2"> --}}
                                <x-textarea wire:key='description' wire:model.defer="estimateData.Desc" rows="2"
                                    label="{{ trans('cruds.estimate.fields.description') }}"
                                    placeholder="Your project {{ trans('cruds.estimate.fields.description') }}" />
                                {{-- </div> --}}
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-3 col-lg-2">
                            <div class="form-group">
                                <x-select wire:key="category"
                                    label="Department {{ trans('cruds.estimate.fields.category') }}"
                                    placeholder="Department {{ trans('cruds.estimate.fields.category') }}"
                                    wire:model.defer="estimateData.dept_category_id" x-on:select="$wire.getDistSor()">
                                    @isset($fatchDropdownData['departmentsCategory'])
                                        @foreach ($fatchDropdownData['departmentsCategory'] as $deptCategory)
                                            <x-select.option label="{{ $deptCategory['dept_category_name'] }}"
                                                value="{{ $deptCategory['id'] }}" />
                                        @endforeach
                                    @endisset
                                </x-select>
                            </div>
                        </div>

                        <div class="col-md-2 col-lg-2 col-sm-3">
                            <div class="form-group">
                                <x-input wire:key="distance" label="Distance"
                                    placeholder="Distance"
                                    wire:model.defer="estimateData.distance" />
                            </div>
                        </div>

                        <div class="col-md-2 col-lg-2 col-sm-3">
                            <div class="form-group">
                                <x-select wire:key="sor" label="Select SOR" placeholder="Select SOR"
                                    wire:model.defer="estimateData.SelectSOR" x-on:select="$wire.getlistData()">
                                    @isset($this->fatchDropdownData['selectSOR'])
                                        @foreach ($this->fatchDropdownData['selectSOR'] as $list)
                                            <x-select.option label="{{ $list['ItemNo'] }}" value="{{ $list['sl_no'] }}" />
                                        @endforeach
                                    @endisset
                                </x-select>
                            </div>
                        </div>

                        <div class="col-md-1 col-lg-1 col-sm-3">
                            <div class="form-group">
                                <x-select wire:key="unit" label="Unit" placeholder="Select Unit"
                                    wire:model.defer="estimateData.unit" :options="[['name' => 'KM', 'id' => 1]]" option-label="name"
                                    option-value="id" />
                            </div>
                        </div>


                        {{-- <div class="col-md-4 col-sm-3 col-lg-4">
                            <div class="form-group">
                                <x-select wire:key="version" label="{{ trans('cruds.estimate.fields.version') }}"
                                    placeholder="Select {{ trans('cruds.estimate.fields.version') }}"
                                    wire:model.defer="estimateData.version" x-on:select="$wire.getVersion()">
                                    @isset($fatchDropdownData['versions'])
                                        @foreach ($fatchDropdownData['versions'] as $version)
                                            <x-select.option label="{{ $version['version'] }}"
                                                value="{{ $version['version'] }}" />
                                        @endforeach
                                    @endisset
                                </x-select>
                            </div>
                        </div> --}}
                        {{-- <div class="col-md-4 col-sm-3 col-lg-4">
                            <div class="form-group search-sor">
                                <div class="dropdown">
                                    <x-input wire:key="sor" label="{{ trans('cruds.estimate.fields.sor') }}"
                                        placeholder="{{ trans('cruds.estimate.fields.sor') }}"
                                        wire:model.defer="selectedSORKey" value="{{ $selectedSORKey }}"
                                        wire:keydown.escape="resetValus" wire:keydown.tab="autoSearch"
                                        class="dropbtn" />


                                    @isset($this->fatchDropdownData['items_number'])
                                        @if (count($this->fatchDropdownData['items_number']) > 0)
                                            <div class="dropdown-content"
                                                style="display:{{ $searchDtaCount ? $searchStyle : $searchStyle }}">
                                                @foreach ($this->fatchDropdownData['items_number'] as $list)
                                                    <a href="javascript:void(0);"
                                                        wire:click="getItemDetails({{ $list['id'] }})">{{ $list['Item_details'] }}</a>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endisset
                                </div>
                            </div>
                        </div>
                        @if (!empty($searchResData))
                            @if (count($searchResData) > 0)
                                <div class="row">
                                    <div class="col-md-3 col-lg-3 col-sm-3">
                                        <div class="form-group">
                                            <x-input wire:key="sor_desc"
                                                label="{{ trans('cruds.estimate.fields.description') }}"
                                                placeholder="{{ trans('cruds.estimate.fields.description') }}" disabled
                                                wire:model.defer="estimateData.description" />
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-lg-3 col-sm-3">
                                        <div class="form-group">
                                            <x-input wire:key="sor_qty"
                                                label="{{ trans('cruds.estimate.fields.quantity') }}"
                                                placeholder="{{ trans('cruds.estimate.fields.quantity') }}"
                                                wire:model.defer="estimateData.qty" wire:blur="calculateValue" />
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-lg-3 col-sm-3">
                                        <div class="form-group">
                                            <x-input wire:key="sor_rate"
                                                label="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                                placeholder="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                                readonly wire:model.defer="estimateData.rate" />
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-lg-3 col-sm-3">
                                        <div class="form-group">
                                            <x-input wire:key="sor_cost"
                                                label="{{ trans('cruds.estimate.fields.cost') }}"
                                                placeholder="{{ trans('cruds.estimate.fields.cost') }}" disabled
                                                wire:model.defer="estimateData.total_amount" />
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif --}}
                    </div>
                    <div class="form-group float-right">
                        <button type="button" wire:click='addEstimate' class="{{ trans('global.add_btn_color') }}">
                            <x-lucide-list-plus class="w-4 h-4 text-gray-500" />
                            {{ trans('global.add_btn') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{-- @if ($addedEstimate != null || Session::has('addedCarriageCostData'))
            <div x-transition.duration.500ms>
                <livewire:carriagecost.add-carriage-cost-list :addedEstimateData="$addedEstimate"
                    :wire:key="$addedEstimateUpdateTrack">
            </div>
        @endif --}}
        @if ($addedEstimate != null || Session::has('addedCarriageEstimateData'))
            <div x-transition.duration.500ms>
                <livewire:carriagecost.add-carriage-cost-list :addedEstimateData="$addedEstimate" :wire:key="$addedEstimateUpdateTrack" />
            </div>
        @endif
    </div>
</div>
