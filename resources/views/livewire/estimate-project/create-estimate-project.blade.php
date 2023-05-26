<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                {{-- <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div> --}}
                {{-- <div wire:loading.delay.longest.class="loading" class="card-body"> --}}
                    <div class="card-body">
                    <div class="row">
                        <div class="row">
                            <div class="col col-md-8 col-lg-8 col-sm-12 col-xs-12 mb-2">
                                <x-textarea wire:model="sorMasterDesc" rows="2"
                                    label="{{ trans('cruds.estimate.fields.description') }}"
                                    placeholder="Your project {{ trans('cruds.estimate.fields.description') }}" />
                            </div>
                            <div class="col col-md-4 col-lg-4 col-sm-12 col-xs-12 mb-2">
                                <div class="form-group">
                                    <x-select wire:key="categoryType"
                                        label="{{ trans('cruds.estimate.fields.category') }}"
                                        placeholder="Select {{ trans('cruds.estimate.fields.category') }}"
                                        wire:model.defer="selectedCategoryId"
                                        x-on:select="$wire.changeCategory($event.target)" :options="[
                                            ['name' => 'SOR', 'id' => 1],
                                            ['name' => 'Other', 'id' => 2],
                                            ['name' => 'Estimate', 'id' => 3],
                                            ['name' => 'Rate', 'id' => 4],
                                        ]"
                                        option-label="name" option-value="id" />
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
                                        <div class="form-group search-sor">
                                            {{-- <x-select wire:key="sor"
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
                                            </x-select> --}}
                                            <div class="dropdown">
                                                <x-input wire:key="sor"
                                                    label="{{ trans('cruds.estimate.fields.sor') }}"
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
                                </div>
                                @if (!empty($searchResData))
                                        @if (count($searchResData) > 0)
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
                                                    readonly wire:model.defer="estimateData.rate" />
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
                            @if ($estimateData['item_name'] == 'Estimate')
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="dept"
                                                label="{{ trans('cruds.estimate.fields.dept') }}"
                                                placeholder="Select {{ trans('cruds.estimate.fields.dept') }}"
                                                wire:model.defer="estimateData.dept_id"
                                                x-on:select="$wire.getDeptEstimates()">
                                                @isset($fatchDropdownData['departments'])
                                                    @foreach ($fatchDropdownData['departments'] as $department)
                                                        <x-select.option label="{{ $department['department_name'] }}"
                                                            value="{{ $department['id'] }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="estimate_no" label="{{ __('Select Estimate') }}"
                                                placeholder="Select {{ __('Estimate') }}"
                                                wire:model.defer="estimateData.estimate_no"
                                                x-on:select="$wire.getEstimateDetails()">
                                                @isset($fatchDropdownData['estimatesList'])
                                                    @foreach ($fatchDropdownData['estimatesList'] as $estimate)
                                                        <x-select.option label="{{ $estimate['estimate_id'].' - '.$estimate['sorMasterDesc'] }}"
                                                            value="{{ $estimate['estimate_id'] }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select>
                                        </div>
                                    </div>
                                    {{-- @isset($fatchDropdownData['estimateDetails']) --}}
                                    {{-- <div class="col">
                                        <div class="form-group">
                                            <x-textarea rows="2" wire:key="other_rate"
                                                wire:model.defer="estimateData.description"
                                                wire:keyup="calculateValue"
                                                label="Estimate {{ trans('cruds.estimate.fields.description') }}"
                                                placeholder="Estimate {{ trans('cruds.estimate.fields.description') }}"
                                                disabled />
                                        </div>
                                    </div> --}}
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
                                            <x-input wire:key="sor_rate"
                                                label="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                                placeholder="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                                readonly wire:model.defer="estimateData.rate" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="total_amount"
                                                wire:model.defer="estimateData.total_amount"
                                                label="{{ trans('cruds.estimate.fields.estimate_total') }}" disabled
                                                placeholder="{{ trans('cruds.estimate.fields.estimate_total') }}" />
                                        </div>
                                    </div>
                                    {{-- @endisset --}}

                                </div>
                            @endif
                            @if ($estimateData['item_name'] == 'Rate')
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="dept"
                                                label="{{ trans('cruds.estimate.fields.dept') }}"
                                                placeholder="Select {{ trans('cruds.estimate.fields.dept') }}"
                                                wire:model.defer="estimateData.dept_id"
                                                x-on:select="$wire.getDeptRates()">
                                                @isset($fatchDropdownData['departments'])
                                                    @foreach ($fatchDropdownData['departments'] as $department)
                                                        <x-select.option label="{{ $department['department_name'] }}"
                                                            value="{{ $department['id'] }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="estimate_no" label="{{ __('Select Estimate') }}"
                                                placeholder="Select {{ __('Estimate') }}"
                                                wire:model.defer="estimateData.estimate_no"
                                                x-on:select="$wire.getRateDetails()">
                                                @isset($fatchDropdownData['estimatesList'])
                                                    @foreach ($fatchDropdownData['estimatesList'] as $estimate)
                                                        <x-select.option label="{{ $estimate['estimate_id'].' - '.$estimate['sorMasterDesc'] }}"
                                                            value="{{ $estimate['estimate_id'] }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select>
                                        </div>
                                    </div>
                                    {{-- @isset($fatchDropdownData['estimateDetails']) --}}
                                    {{-- <div class="col">
                                        <div class="form-group">
                                            <x-textarea rows="2" wire:key="other_rate"
                                                wire:model.defer="estimateData.description"
                                                wire:keyup="calculateValue"
                                                label="Estimate {{ trans('cruds.estimate.fields.description') }}"
                                                placeholder="Estimate {{ trans('cruds.estimate.fields.description') }}"
                                                disabled />
                                        </div>
                                    </div> --}}
                                    <div class="form-group">
                                        <x-select wire:key="qnty_type"
                                            label="{{  trans('cruds.estimate.fields.quantity') }}"
                                            placeholder="Select {{  trans('cruds.estimate.fields.quantity') }}"
                                            wire:model.defer="quntity_type_id"
                                            x-on:select="$wire.changeQuntity($event.target)" :options="[
                                                ['name' => 'Qutity Evaluation', 'id' => 1],
                                                ['name' => 'Menual', 'id' => 2],
                                            ]"
                                            option-label="name" option-value="id" />
                                    </div>
                                    @if ($quntity_type_id==2)
                                        <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="qty_menual" wire:model.defer="estimateData.qty"
                                                wire:keyup="calculateValue"
                                                label="{{ trans('cruds.estimate.fields.quantity') }}"
                                                placeholder="{{ trans('cruds.estimate.fields.quantity') }}" />
                                        </div>
                                    @else
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="qty_a_value" label="{{ __('Select Quantity') }}"
                                                placeholder="Select {{ __('Quantity') }}"
                                                wire:model.defer="estimateData.qty"
                                                x-on:select="$wire.calculateValue()">
                                                @isset($fatchDropdownData['qultiyEvaluation'])
                                                    @foreach ($fatchDropdownData['qultiyEvaluation'] as $estimate)
                                                        {{-- <x-select.option label="{{ $estimate['estimate_id'].' - '.$estimate['sorMasterDesc'] }}" --}}
                                                        <x-select.option label="{{ $estimate['total_amount']}}"
                                                            value="{{ $estimate['total_amount'] }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="sor_rate"
                                                label="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                                placeholder="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                                readonly wire:model.defer="estimateData.rate" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="total_amount"
                                                wire:model.defer="estimateData.total_amount"
                                                label="{{ trans('cruds.estimate.fields.estimate_total') }}" disabled
                                                placeholder="{{ trans('cruds.estimate.fields.estimate_total') }}" />
                                        </div>
                                    </div>
                                    {{-- @endisset --}}

                                </div>
                            @endif
                        @endif
                        <div class="row">
                            <div class="col">
                                <div class="form-group float-right">
                                    <button type="button" wire:click='addEstimate'
                                        class="{{ trans('global.add_btn_color') }}">
                                        <x-lucide-list-plus class="w-4 h-4 text-gray-500" />
                                        {{ trans('global.add_btn') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- @if ($showTableOne && $addedEstimate != null)
        <livewire:estimate.added-estimate-list :addedEstimateData="$addedEstimate" :key="1" />
        @endif
        @if (!$showTableOne && $addedEstimate != null)
        <livewire:estimate.added-estimate-list :addedEstimateData="$addedEstimate" :key="2" />
        @endif --}}
        @if ($addedEstimate != null || Session::has('addedProjectEstimateData'))
            <div x-transition.duration.500ms>
                <livewire:estimate-project.added-estimate-project-list :addedEstimateData="$addedEstimate" :sorMasterDesc="$sorMasterDesc"
                    :wire:key="$addedEstimateUpdateTrack" />
            </div>
        @endif
    </div>

</div>
