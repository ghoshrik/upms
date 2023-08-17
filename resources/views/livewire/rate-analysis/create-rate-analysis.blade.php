<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    {{-- <div class="card-body"> --}}
                    <div class="row">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <x-select wire:key="sordept" label="{{ trans('cruds.estimate.fields.dept') }}"
                                        placeholder="Select {{ trans('cruds.estimate.fields.dept') }}"
                                        wire:model.defer="selectSor.dept_id" x-on:select="$wire.getSorDeptCategory()">
                                        @foreach ($dropdownData['allDept'] as $department)
                                            <x-select.option label="{{ $department['department_name'] }}"
                                                value="{{ $department['id'] }}" />
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <x-select wire:key="sorcategory"
                                        label="Department {{ trans('cruds.estimate.fields.category') }}"
                                        placeholder="Select Department {{ trans('cruds.estimate.fields.category') }}"
                                        wire:model.defer="selectSor.dept_category_id"
                                        x-on:select="$wire.getSorVersion()">
                                        @isset($dropdownData['sorDepartmentsCategory'])
                                            @foreach ($dropdownData['sorDepartmentsCategory'] as $deptCategory)
                                                <x-select.option label="{{ $deptCategory['dept_category_name'] }}"
                                                    value="{{ $deptCategory['id'] }}" />
                                            @endforeach
                                        @endisset
                                    </x-select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <x-select wire:key="sorversion" label="{{ trans('cruds.estimate.fields.version') }}"
                                        placeholder="Select {{ trans('cruds.estimate.fields.version') }}"
                                        wire:model.defer="selectSor.version">
                                        @isset($dropdownData['sorVersions'])
                                            @foreach ($dropdownData['sorVersions'] as $version)
                                                <x-select.option label="{{ $version['version'] }}"
                                                    value="{{ $version['version'] }}" />
                                            @endforeach
                                        @endisset
                                    </x-select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group search-sor">
                                    <div class="dropdown">
                                        <x-input wire:key="sorsor" label="{{ trans('cruds.estimate.fields.sor') }}"
                                            placeholder="{{ trans('cruds.estimate.fields.sor') }}"
                                            wire:model.defer="selectSor.selectedSOR"
                                            value="{{ $selectSor['selectedSOR'] }}" wire:keydown.escape="resetValus"
                                            wire:keydown.tab="autoSorSearch" class="dropbtn" />
                                        @isset($this->dropdownData['sor_items_number'])
                                            @if (count($this->dropdownData['sor_items_number']) > 0 && $selectedSORKey == null)
                                                <div class="dropdown-content"
                                                    style="display:{{ $searchDtaCount ? $searchStyle : $searchStyle }}">
                                                    @foreach ($this->dropdownData['sor_items_number'] as $list)
                                                        <a href="javascript:void(0);"
                                                            wire:click="getSorItemDetails({{ $list['id'] }})">{{ $list['Item_details'] }}</a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-md-8 col-lg-8 col-sm-12 col-xs-12 mb-2">
                                <x-textarea wire:model.defer="sorMasterDesc" rows="2"
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
                                            ['name' => 'Rate', 'id' => 3],
                                            ['name' => 'Composite SOR', 'id' => 4],
                                            ['name' => 'Carriages', 'id' => 5],
                                        ]"
                                        option-label="name" option-value="id" />
                                </div>
                            </div>
                        </div>

                        @if (!empty($estimateData))
                            {{-- SOR Field Start --}}
                            @if ($selectedCategoryId == 1)
                                <div class="row" wire:key='SOR' style="transition: all 2s ease-out">
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="dept1" label="Table No" placeholder="Select Table No"
                                                wire:model.defer="estimateData.table_no"
                                                x-on:select="$wire.getPageNo()">
                                                @foreach ($fatchDropdownData['table_no'] as $table)
                                                    <x-select.option label="{{ $table['table_no'] }}"
                                                        value="{{ $table['table_no'] }}" />
                                                @endforeach
                                            </x-select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="dept" label="Page No" placeholder="Select Page No"
                                                wire:model.defer="estimateData.page_no"
                                                x-on:select="$wire.getDynamicSor()">
                                                @foreach ($fatchDropdownData['page_no'] as $page)
                                                    <x-select.option label="{{ $page['page_no'] }}"
                                                        value="{{ $page['page_no'] }}" />
                                                @endforeach
                                            </x-select>
                                        </div>
                                    </div>
                                    {{-- <div class="col">
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
                                    </div> --}}
                                    {{-- <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="category"
                                                label="Department {{ trans('cruds.estimate.fields.category') }}"
                                                placeholder="Select Department {{ trans('cruds.estimate.fields.category') }}"
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
                                    </div> --}}
                                    {{-- <div class="col">
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
                                    </div> --}}
                                    {{-- <div class="col">
                                        <div class="form-group search-sor">
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
                                                                    wire:click="getItemDetails({{ $list['id'] }})"><b>{{ $list['Item_details'] }}</b> <sub>{{$list['description']}}</sub></a>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @endisset
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                {{-- @if (!empty($searchResData))
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
                                                        wire:model.defer="estimateData.qty"
                                                        wire:blur="calculateValue" />
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
                                                        placeholder="{{ trans('cruds.estimate.fields.cost') }}"
                                                        disabled wire:model.defer="estimateData.total_amount" />
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif --}}
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="sor_desc"
                                                label="{{ trans('cruds.estimate.fields.description') }}"
                                                placeholder="{{ trans('cruds.estimate.fields.description') }}" disabled
                                                wire:model.defer="estimateData.description" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="sor_qty"
                                                label="{{ trans('cruds.estimate.fields.quantity') }}"
                                                placeholder="{{ trans('cruds.estimate.fields.quantity') }}"
                                                wire:model.defer="estimateData.qty" wire:blur="calculateValue" />
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
                            {{-- SOR Field end --}}

                            {{-- Others Field Start --}}
                            @if ($selectedCategoryId == 2)
                                <div class="row" wire:key='others'>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="other_name" wire:model.defer="estimateData.other_name"
                                                label="Item Name" placeholder="Item Name" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="other_qty" wire:model.defer="estimateData.qty"
                                                wire:blur="calculateValue"
                                                label="{{ trans('cruds.estimate.fields.quantity') }}"
                                                placeholder="{{ trans('cruds.estimate.fields.quantity') }}" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="other_rate" wire:model.defer="estimateData.rate"
                                                wire:blur="calculateValue"
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
                            {{-- Others Field end --}}

                            {{-- Rate Field Start --}}
                            @if ($selectedCategoryId == 3)
                                <div class="row" wire:key='Rate'>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="rateDept"
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
                                            <x-select wire:key="rate_no" label="{{ __('Select Rate') }}"
                                                placeholder="Select {{ __('Rate') }}"
                                                wire:model.defer="estimateData.rate_no"
                                                x-on:select="$wire.getRateDetails()">
                                                @isset($fatchDropdownData['ratesList'])
                                                    @foreach ($fatchDropdownData['ratesList'] as $rate)
                                                        <x-select.option
                                                            label="{{ $rate['rate_id'] . ' - ' . $rate['description'] }}"
                                                            value="{{ $rate['rate_id'] }}" />
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
                                                wire:blur="calculateValue"
                                                label="Estimate {{ trans('cruds.estimate.fields.description') }}"
                                                placeholder="Estimate {{ trans('cruds.estimate.fields.description') }}"
                                                disabled />
                                        </div>
                                    </div> --}}
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="other_qty" wire:model.defer="estimateData.qty"
                                                wire:blur="calculateValue"
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
                                                wire:model.defer="estimateData.total_amount" label="Rate Total"
                                                disabled placeholder="Rate Total" />
                                        </div>
                                    </div>
                                    {{-- @endisset --}}

                                </div>
                            @endif
                            {{-- Rate Field End --}}

                            {{-- Composite SOR Field Start --}}
                            @if ($selectedCategoryId == 4)
                                <div class="row" wire:key='C-SOR' style="transition: all 2s ease-out">
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="compositeDept"
                                                label="{{ trans('cruds.estimate.fields.dept') }}"
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
                                            <x-select wire:key="compositeCategory"
                                                label="Department {{ trans('cruds.estimate.fields.category') }}"
                                                placeholder="Select Department {{ trans('cruds.estimate.fields.category') }}"
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
                                            <x-select wire:key="compositversion"
                                                label="{{ trans('cruds.estimate.fields.version') }}"
                                                placeholder="Select {{ trans('cruds.estimate.fields.version') }}"
                                                wire:model.defer="estimateData.version">
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
                                            <div class="dropdown">
                                                <x-input wire:key="compositsor"
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
                                                                    wire:click="getCompositSorItemDetails({{ $list['id'] }})"><b>{{ $list['Item_details'] }}</b>
                                                                    <sub>{{ $list['description'] }}</sub></a>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @endisset
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{-- Composite SOR Field End --}}

                            {{-- Carriages Field Start --}}
                            @if ($selectedCategoryId == 5)
                                <div class="row" wire:key='Carriages' style="transition: all 2s ease-out">
                                    {{-- <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <x-select wire:key="compositeDept"
                                                label="{{ trans('cruds.estimate.fields.dept') }}"
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
                                    <div class="col-lg-2 col-md-2 col-sm-3">
                                        <div class="form-group">
                                            <x-select wire:key="compositeCategory"
                                                label="Department {{ trans('cruds.estimate.fields.category') }}"
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
                                    <div class="col-md-2 col-lg-2 col-sm-3">
                                        <div class="form-group">
                                            <x-select wire:key="compositversion"
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
                                    </div> --}}
                                    <div class="col-md-2 col-lg-2 col-sm-3">
                                        <div class="form-group">
                                            <x-input label="Distance" placeholder="Distance"
                                                wire:model.defer="estimateData.distance" wire:key="distance" />
                                        </div>
                                    </div>
                                    {{--<div class="col-md-3 col-lg-3 col-sm-3">
                                        <div class="form-group search-sor">
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
                                                                    wire:click="getItemDetails1('{{ $list['Item_details'] }}')"><b>{{ $list['Item_details'] }}</b>
                                                                    <sub>{{ $list['description'] }}</sub></a>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @endisset
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <x-select wire:key="carriageSor"
                                                label="{{ trans('cruds.estimate.fields.item_number') }}"
                                                placeholder="Select {{ trans('cruds.estimate.fields.item_number') }}"
                                                wire:model.defer="estimateData.itemNo" x-on:select="$wire.getListData()">
                                                @isset($fatchDropdownData['selectSOR'])
                                                    @foreach ($fatchDropdownData['selectSOR'] as $sor)
                                                        <x-select.option label="{{ $sor['ItemNo'] }}"
                                                            value="{{ $sor['sl_no'] }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select>
                                        </div>
                                    </div> --}}
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="dept1" label="Table No" placeholder="Select Table No"
                                                wire:model.defer="estimateData.table_no"
                                                x-on:select="$wire.getPageNo()">
                                                @foreach ($fatchDropdownData['table_no'] as $table)
                                                    <x-select.option label="{{ $table['table_no'] }}"
                                                        value="{{ $table['table_no'] }}" />
                                                @endforeach
                                            </x-select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="dept" label="Page No" placeholder="Select Page No"
                                                wire:model.defer="estimateData.page_no"
                                                x-on:select="$wire.getDynamicSor()">
                                                @foreach ($fatchDropdownData['page_no'] as $page)
                                                    <x-select.option label="{{ $page['page_no'] }}"
                                                        value="{{ $page['page_no'] }}" />
                                                @endforeach
                                            </x-select>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{-- Carriages Field End --}}
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
        @if ($addedEstimate != null || Session::has('addedRateAnalysisData'))
            <div x-transition.duration.500ms>
                {{-- <livewire:estimate-project.added-estimate-project-list :addedEstimateData="$addedEstimate" :sorMasterDesc="$sorMasterDesc"
                    :wire:key="$addedEstimateUpdateTrack" /> --}}
                <livewire:rate-analysis.add-rate-analysis-list :addedEstimateData="$addedEstimate" :sorMasterDesc="$sorMasterDesc" :selectSor="$selectSor"
                    :totalDistance="$distance" :wire:key="$addedEstimateUpdateTrack">
            </div>
        @endif
    </div>
    @if ($viewModal)
        <div>
            <div class="modal fade" id="{{ $modalName }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="example-table"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"id="closeBtn" class="btn btn-secondary"
                                data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById("closeBtn").addEventListener("click", function() {
                closeModal();
            });

            function closeModal() {
                $('#' + @json($modalName)).modal('hide');
                window.Livewire.emit('closeModal');
            }
            $(document).ready(function() {
                var clickableCellValues = [];
                $("#" + @json($modalName)).modal({
                    backdrop: "static",
                    keyboard: false
                });
                var headerData = @json(json_decode($getSor['header_data']));
                var rowData = @json(json_decode($getSor['row_data']));
                headerData.forEach(function(column) {
                    var fun;
                    delete column.editor;
                    if (column.isClick) {
                        column.isClick = eval('(' + column.isClick + ')');
                        fun = column.isClick;
                    }
                    if (column.cellClick) {
                        column.cellClick = eval('(' + column.isClick + ')');
                        fun = column.cellClick;
                    }
                    if (typeof fun === "function") {
                        column.cellClick = function(e, cell) {
                            // Overwritten cellClick function
                            var getData = cell.getRow().getData();
                            var getRowData = [{
                                id: getData['id'],
                                desc: (getData['description']) ? getData['description'] : '',
                                rowValue: cell.getValue(),
                                itemNo: cell.getRow().getIndex()
                            }];
                            console.log(getData);
                            var cnf = confirm("Are you sure " + cell.getValue() + " ?");
                            if (cnf) {
                                if (@json($selectedCategoryId) == 5) {
                                    window.Livewire.emit('getRowValue', getData);
                                } else {
                                    window.Livewire.emit('getRowValue', getRowData);
                                }

                                // window.Livewire.emit('getRowValue', getData);
                                // window.Livewire.emit('getRowValue', clickableCellValues);
                                // var modalToggle = document.getElementById(@json($modalName));
                                $('#' + @json($modalName)).modal('hide');
                                // Add your custom code or logic here
                            }
                        };
                    }
                    if (column.columns) {
                        column.columns.forEach(function(subColumn) {
                            var subFun;
                            delete subColumn.editor;
                            if (subColumn.isClick) {
                                subFun = subColumn.isClick = eval('(' + subColumn.isClick + ')');
                            }
                            if (subColumn.cellClick) {
                                subFun = subColumn.cellClick = eval('(' + subColumn.cellClick + ')');
                            }
                            if (typeof subFun === "function") {
                                subColumn.cellClick = function(e, cell) {
                                    var subrowIndex = cell.getRow().getIndex();
                                    var getData = cell.getRow().getData();
                                    var getRowData = [{
                                        id: getData['id'],
                                        desc: (getData['description']) ? getData[
                                            'description'] : '',
                                        rowValue: cell.getValue(),
                                        itemNo: subrowIndex
                                    }];
                                    console.log(getData);
                                    var cnf = confirm("Are you sure " + cell.getValue() + " ?");
                                    if (cnf) {
                                        if (@json($selectedCategoryId) == 5) {
                                            window.Livewire.emit('getRowValue', getData);
                                        } else {
                                            window.Livewire.emit('getRowValue', getRowData);
                                        }
                                        // window.Livewire.emit('getRowValue', getData);
                                    }
                                };
                            }
                        });
                    }
                });

                var delay = 1000; // Delay time in milliseconds

                var delayPromise = new Promise(function(resolve) {
                    setTimeout(function() {
                        resolve();
                    }, delay);
                });

                delayPromise.then(function() {
                    var table = new Tabulator("#example-table", {
                        height: "auto",
                        layout: "fitColumns",
                        columns: headerData,
                        data: rowData,
                        dataTree: true, // Enable the dataTree module
                        dataTreeStartExpanded: true, // Optional: Expand all rows by default
                        dataTreeChildField: "_subrow", // Specify the field name for subrows
                        dataTreeChildIndent: 10, // Optional: Adjust the indentation level of subrows
                    });

                    // Open the modal
                    var tableNo = @json($estimateData['table_no']);
                    var pageNo = @json($estimateData['page_no']);
                    var modalId = "exampleModal_" + tableNo + "_" + pageNo;

                    $("#" + @json($modalName)).modal("show");
                });
            });
        </script>
    @endif
</div>
