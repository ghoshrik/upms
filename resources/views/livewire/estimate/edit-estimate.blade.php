<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.long>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.long.class="loading" class="card-body">
                    <div class="row">
                        {{-- <form> --}}
                        <div class="row">
                            <div class="col col-md-8 col-lg-8 col-sm-12 col-xs-12 mb-2">
                                <x-textarea wire:model="sorMasterDesc" rows="2"
                                    label="{{ trans('cruds.estimate.fields.description') }}"
                                    value="{{ $sorMasterDesc }}"
                                    placeholder="Your project {{ trans('cruds.estimate.fields.description') }}" disabled/>
                            </div>
                            <div class="col col-md-4 col-lg-4 col-sm-12 col-xs-12 mb-2">
                                <div class="form-group">
                                    <x-select wire:key="categoryType"
                                        label="{{ trans('cruds.estimate.fields.category') }}"
                                        placeholder="Select {{ trans('cruds.estimate.fields.category') }}"
                                        wire:model.defer="selectedCategoryId"
                                        x-on:select="$wire.changeCategory($event.target)">
                                        @foreach ($getCategory as $category)
                                            <x-select.option label="{{ $category['item_name'] }}"
                                                value="{{ $category['id'] }}" />
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                        </div>
                        @if (!empty($estimateData))
                            @if ($estimateData['item_name'] == 'SOR')
                                <div class="row" style="transition: all 2s ease-out">
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="dept" label="{{ trans('cruds.estimate.fields.dept') }}"
                                                placeholder="Select {{ trans('cruds.estimate.fields.dept') }}"
                                                wire:model.defer="estimateData.dept_id"
                                                x-on:select="$wire.getDeptCategory()">
                                                @foreach ($fatchDropdownData['departments'] as $department)
                                                    <x-select.option label="{{ $department['department_name'] }}"
                                                        value="{{ $department['id'] }}" />
                                                @endforeach
                                            </x-select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="category"
                                                label="{{ trans('cruds.estimate.fields.category') }}"
                                                placeholder="Select {{ trans('cruds.estimate.fields.category') }}"
                                                wire:model.defer="estimateData.dept_category_id"
                                                x-on:select="$wire.getVersion()">
                                                @isset($fatchDropdownData['departmentsCategory'])
                                                    @foreach ($fatchDropdownData['departmentsCategory'] as $deptCategory)
                                                        <x-select.option label="{{ $deptCategory['dept_category_name'] }}"
                                                            value="{{ $deptCategory['id'] }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="version"
                                                label="{{ trans('cruds.estimate.fields.version') }}"
                                                placeholder="Select {{ trans('cruds.estimate.fields.version') }}"
                                                wire:model.defer="estimateData.version"
                                                x-on:select="$wire.getVersion()">
                                                @isset($fatchDropdownData['versions'])
                                                    @foreach ($fatchDropdownData['versions'] as $version)
                                                        <x-select.option label="{{ $version['version'] }}"
                                                            value="{{ $version['version'] }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="sor"
                                                label="Select {{ trans('cruds.estimate.fields.sor') }}"
                                                placeholder="Select {{ trans('cruds.estimate.fields.sor') }}"
                                                wire:model.defer="selectedSORKey" x-on:select="$wire.getItemDetails()"
                                                dynamicSearch=true>
                                                @isset($this->fatchDropdownData['items_number'])
                                                    @foreach ($this->fatchDropdownData['items_number'] as $key => $item)
                                                        <x-select.option label="{{ $item['Item_details'] }}"
                                                            value="{{ $key }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select>
                                        </div>
                                    </div>
                                </div>
                                @if (!empty($estimateData['item_number']))
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <x-input wire:key="sor_desc"
                                                    label="{{ trans('cruds.estimate.fields.description') }}"
                                                    placeholder="{{ trans('cruds.estimate.fields.description') }}"
                                                    disabled wire:model.defer="estimateData.description" />
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <x-input wire:key="sor_qty"
                                                    label="{{ trans('cruds.estimate.fields.quantity') }}"
                                                    placeholder="{{ trans('cruds.estimate.fields.quantity') }}"
                                                    wire:model.defer="estimateData.qty" wire:keyup="calculateValue" />
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <x-input wire:key="sor_rate"
                                                    label="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                                    placeholder="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                                    disabled wire:model.defer="estimateData.rate" />
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <x-input wire:key="sor_cost"
                                                    label="{{ trans('cruds.estimate.fields.cost') }}"
                                                    placeholder="{{ trans('cruds.estimate.fields.cost') }}" disabled
                                                    wire:model.defer="estimateData.total_amount" />
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            @if ($estimateData['item_name'] == 'Other')
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="other_name" wire:model.defer="estimateData.other_name"
                                                label="Item Name" placeholder="Item Name" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="other_qty" wire:model.defer="estimateData.qty"
                                                wire:keyup="calculateValue"
                                                label="{{ trans('cruds.estimate.fields.quantity') }}"
                                                placeholder="{{ trans('cruds.estimate.fields.quantity') }}" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="other_rate" wire:model.defer="estimateData.rate"
                                                wire:keyup="calculateValue"
                                                label="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                                placeholder="{{ trans('cruds.estimate.fields.per_unit_cost') }}" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="other_cost"
                                                wire:model.defer="estimateData.total_amount"
                                                label="{{ trans('cruds.estimate.fields.cost') }}" disabled
                                                placeholder="{{ trans('cruds.estimate.fields.cost') }}" />
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        <div class="row">
                            <div class="col">
                                <div class="form-group float-right">
                                    <button type="button" wire:click='addEstimate'
                                        class="{{ trans('global.add_btn_color') }}">
                                        {{-- <span class="btn-inner"> --}}
                                        <x-lucide-list-plus class="w-4 h-4 text-gray-500" />
                                        {{--
                                            </span> --}}
                                        {{ trans('global.add_btn') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- @dd($estimate_id) --}}
        @if ($addedEstimate != null || $currentEstimate != null || Session::has('editEstimateData') || $estimate_id!=null)
            <div x-transition.duration.500ms>
                <livewire:estimate.edit-estimate-list :addedEstimateData="$addedEstimate" :currentEstimateData="$currentEstimate" :sorMasterDesc="$sorMasterDesc" :updateEstimate_id="$estimate_id"
                    :wire:key="$addedEstimateUpdateTrack" />
            </div>
        @endif
    </div>

</div>
