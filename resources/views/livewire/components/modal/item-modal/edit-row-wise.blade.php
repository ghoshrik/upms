<div>
    <div class="modal" id="{{ $editRowId }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Edit Row {{ $editRowId }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (!empty($dataArray))
                        @if ($dataArray['item_name'] == 'SOR')
                            <div class="row" wire:key='SOR' style="transition: all 2s ease-out"
                                x-data="{ showSearch: false }">
                                <div class="col">
                                    <div class="form-group">
                                        <x-select wire:key="dept" label="{{ trans('cruds.estimate.fields.dept') }}"
                                            placeholder="Select {{ trans('cruds.estimate.fields.dept') }}"
                                            wire:model.defer="dataArray.dept_id" x-on:select="$wire.getDeptCategory()">
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
                                            label="Department {{ trans('cruds.estimate.fields.category') }}"
                                            placeholder="Select Department {{ trans('cruds.estimate.fields.category') }}"
                                            wire:model.defer="dataArray.dept_category_id"
                                            x-on:select="$wire.getVolumn()">
                                            @isset($fatchDropdownData['departmentsCategory'])
                                                @foreach ($fatchDropdownData['departmentsCategory'] as $deptCategory)
                                                    <x-select.option label="{{ $deptCategory['dept_category_name'] }}"
                                                        value="{{ $deptCategory['id'] }}" />
                                                @endforeach
                                            @endisset
                                        </x-select>
                                    </div>
                                </div>
                                {{-- <div x-data="{ showSearch: false }"> --}}
                                <div class="col" x-show="!showSearch" style="margin-top: 26px">
                                    <div class="form-group" style="margin-left: 15%;">
                                        <button type="button" @click="showSearch = !showSearch"
                                            class="{{ trans('global.add_btn_color') }}">
                                            <x-lucide-search class="w-4 h-4 text-gray-500" />
                                            Search SOR
                                        </button>
                                    </div>
                                </div>
                                <div x-show="showSearch" class="col">
                                    <div class="form-group search-sor" style="position: relative;">
                                        <x-input wire:key="search" class="dropbtn" wire:model.defer="searchKeyWord"
                                            wire:keydown.tab="textSearchSOR" label="Search SOR"
                                            placeholder="Write Here and Tab" />
                                        <button type="button" class="clear-btn" wire:click="clearSearch"
                                            style="position: absolute; top: 68%; right: 8px; transform: translateY(-50%); cursor: pointer; background: none; border: none;">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 24 24" width="16" height="16">
                                                <path
                                                    d="M17.29 6.71a1 1 0 0 0-1.42 0L12 10.59 7.71 6.29a1 1 0 1 0-1.42 1.42L10.59 12 6.29 16.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0L12 13.41l4.29 4.3a1 1 0 0 0 1.42-1.42L13.41 12l4.3-4.29a1 1 0 0 0 0-1.42z">
                                                </path>
                                            </svg>
                                        </button>
                                        @isset($this->fatchDropdownData['searchDetails'])
                                            @if (count($this->fatchDropdownData['searchDetails']) > 0)
                                                <div class="dropdown-content"
                                                    style="display:{{ $searchDtaCount ? $searchStyle : $searchStyle }}; position: absolute; top: 100%; left: 0; right: 0; z-index: 100; background-color: white; border: 1px solid #ccc; max-height: 200px; overflow-x: auto;">
                                                    <ul style="list-style-type: none; padding: 0; margin: 0;">
                                                        @foreach ($this->fatchDropdownData['searchDetails'] as $list)
                                                            <li style="padding: 3px; border-bottom: 0.5px solid;">
                                                                <a href="javascript:void(0);"
                                                                    wire:click="getDynamicSor({{ $list['id'] }})">
                                                                    {{ $list['table_no'] }}<br />{!! $list['highlighted_row_data'] !!}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        @endisset
                                    </div>
                                </div>
                                <div class="col-md-2" x-show="showSearch" style="margin-top: 26px">
                                    <div class="form-group float-right">
                                        <button type="button" @click="showSearch = !showSearch; $wire.clearSearch()"
                                            class="btn btn-soft-danger rounded-pill"><x-lucide-x
                                                class="w-4 h-4 text-gray-500" />Close Search</button>
                                    </div>
                                </div>
                                <div x-show="!showSearch" class="col">
                                    <div class="form-group">
                                        <x-select wire:key="volume" label="Volume" placeholder="Select Volume"
                                            wire:model.defer="dataArray.volume" x-on:select="$wire.getTableNo()">
                                            @isset($fatchDropdownData['volumes'])
                                                @foreach ($fatchDropdownData['volumes'] as $volume)
                                                    <x-select.option label="{{ getVolumeName($volume['volume_no']) }}"
                                                        value="{{ $volume['volume_no'] }}" />
                                                @endforeach
                                            @endisset
                                        </x-select>
                                    </div>
                                </div>
                                <div x-show="!showSearch" class="col">
                                    <div class="form-group">
                                        <x-select wire:key="dept1" label="Table No" placeholder="Select Table No"
                                            wire:model.defer="dataArray.table_no" x-on:select="$wire.getPageNo()">
                                            @isset($fatchDropdownData['table_no'])
                                                @foreach ($fatchDropdownData['table_no'] as $table)
                                                    <x-select.option label="{{ $table['table_no'] }}"
                                                        value="{{ $table['table_no'] }}" />
                                                @endforeach
                                            @endisset

                                        </x-select>
                                    </div>
                                </div>
                                <div x-show="!showSearch" class="col">
                                    <div class="form-group">
                                        <x-select wire:key="dept" label="Page No" placeholder="Select Page No"
                                            wire:model.defer="dataArray.sor_id" x-on:select="$wire.getDynamicSor()">
                                            @foreach ($fatchDropdownData['page_no'] as $page)
                                                <x-select.option
                                                    label="{{ $page['page_no'] . ($page['corrigenda_name'] != null ? ' - ' . $page['corrigenda_name'] : '') }}"
                                                    value="{{ $page['id'] }}" />
                                            @endforeach
                                        </x-select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <x-input wire:key="sor_desc"
                                            label="{{ trans('cruds.estimate.fields.description') }}"
                                            placeholder="{{ trans('cruds.estimate.fields.description') }}" disabled
                                            wire:model.defer="dataArray.description" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        {{-- <x-input wire:key='unit_' label="Unit Name" placeholder="Unit Name"
                                            wire:model.defer="dataArray.unit_id" readonly /> --}}
                                        @if ($dataArray['unit_id'] == 0 || $dataArray['unit_id'] == '')
                                            <x-select wire:key="unit_{{ rand(1, 1000) }}" label="Unit"
                                                placeholder="Select Unit" wire:model.defer="dataArray.unit_id">
                                                @foreach ($fatchDropdownData['units'] as $unit)
                                                    <x-select.option label="{{ $unit['unit_name'] }}"
                                                        value="{{ $unit['id'] }}" />
                                                @endforeach
                                            </x-select>
                                        @else
                                            <x-input wire:key='unit_{{ rand(1, 1000) }}' label="Unit Name"
                                                placeholder="Unit Name" wire:model.defer="dataArray.unit_id"
                                                readonly />
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-input wire:key="sor_qty"
                                            label="{{ trans('cruds.estimate.fields.quantity') }}"
                                            placeholder="{{ trans('cruds.estimate.fields.quantity') }}"
                                            wire:model.defer="dataArray.qty" wire:blur="calculateValue"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-input wire:key="sor_rate"
                                            label="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                            placeholder="{{ trans('cruds.estimate.fields.per_unit_cost') }}" readonly
                                            wire:model.defer="dataArray.rate" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-input wire:key="sor_cost"
                                            label="{{ trans('cruds.estimate.fields.cost') }}"
                                            placeholder="{{ trans('cruds.estimate.fields.cost') }}" disabled
                                            wire:model.defer="dataArray.total_amount" />
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($dataArray['item_name'] == 'Other')
                            <div class="row" wire:key='others'>
                                <div class="col">
                                    <div class="form-group">
                                        <x-input wire:key="other_name" wire:model.defer="dataArray.other_name"
                                            label="Item Name" placeholder="Item Name" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-select wire:key="unit_" label="Unit" placeholder="Select Unit"
                                            wire:model.defer="dataArray.unit_id">
                                            @isset($fatchDropdownData['units'])
                                                @foreach ($fatchDropdownData['units'] as $value)
                                                    <x-select.option label="{{ $value['unit_name'] }}"
                                                        value="{{ $value['unit_name'] }}" />
                                                @endforeach
                                            @endisset
                                        </x-select>

                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-input wire:key="other_qty" wire:model.defer="dataArray.qty"
                                            wire:blur="calculateValue"
                                            label="{{ trans('cruds.estimate.fields.quantity') }}"
                                            placeholder="{{ trans('cruds.estimate.fields.quantity') }}"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-input wire:key="other_rate" wire:model.defer="dataArray.rate"
                                            wire:blur="calculateValue"
                                            label="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                            placeholder="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-input wire:key="other_cost" wire:model.defer="dataArray.total_amount"
                                            label="{{ trans('cruds.estimate.fields.cost') }}" disabled
                                            placeholder="{{ trans('cruds.estimate.fields.cost') }}" />
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- Others Field end --}}

                        {{-- Rate Field Start --}}
                        @if ($dataArray['item_name'] == 'Rate')
                            <div class="row" wire:key='Rate'>
                                <div class="col">
                                    <div class="form-group" wire:key="rateDeptGroup">
                                        <x-select wire:key="rateDept"
                                            label="{{ trans('cruds.estimate.fields.dept') }}"
                                            placeholder="Select {{ trans('cruds.estimate.fields.dept') }}"
                                            wire:model.defer="dataArray.dept_id" x-on:select="$wire.getDeptRates()">
                                            @isset($fatchDropdownData['departments'])
                                                @foreach ($fatchDropdownData['departments'] as $key => $department)
                                                    <x-select.option wire:key="{{ $key . 'aaaa' }}"
                                                        label="{{ $department['department_name'] }}"
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
                                            wire:model.defer="dataArray.rate_no"
                                            x-on:select="$wire.getRateDetailsTypes()">
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
                                <div class="col">
                                    <div class="form-group">
                                        <x-select wire:key="unit_" label="Unit" placeholder="Select Unit"
                                            wire:model.defer="dataArray.unit_id">
                                            @isset($fatchDropdownData['units'])
                                                @foreach ($fatchDropdownData['units'] as $value)
                                                    <x-select.option label="{{ $value['unit_name'] }}"
                                                        value="{{ $value['unit_name'] }}" />
                                                @endforeach
                                            @endisset
                                        </x-select>

                                    </div>
                                </div>
                                <div class="col">
                                    <div class="from-group">
                                        <x-select wire:key='rate_type' label="{{ __('Select Rate Type') }}"
                                            placeholder="Select{{ __('Type') }}"
                                            wire:model.defer="dataArray.rate_type"
                                            x-on:select="$wire.getRateDetails()">
                                            @isset($fatchDropdownData['rateDetailsTypes'])
                                                @foreach ($fatchDropdownData['rateDetailsTypes'] as $rateType)
                                                    <x-select.option label="{{ $rateType['operation'] }}"
                                                        value="{{ $rateType['operation'] }}" />
                                                @endforeach
                                            @endisset
                                        </x-select>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <x-input wire:key="other_qty" wire:model.defer="dataArray.qty"
                                            wire:blur="calculateValue"
                                            label="{{ trans('cruds.estimate.fields.quantity') }}"
                                            placeholder="{{ trans('cruds.estimate.fields.quantity') }}"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-input wire:key="sor_rate"
                                            label="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                            placeholder="{{ trans('cruds.estimate.fields.per_unit_cost') }}" readonly
                                            wire:model.defer="dataArray.rate" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-input wire:key="total_amount" wire:model.defer="dataArray.total_amount"
                                            label="Rate Total" disabled placeholder="Rate Total" />
                                    </div>
                                </div>
                                {{-- @endisset --}}

                            </div>
                        @endif
                        {{-- Rate Field End --}}

                        {{-- Composite SOR Field Start --}}
                        @if ($dataArray['item_name'] == 'Composite SOR')
                            <div class="row" wire:key='C-SOR' style="transition: all 2s ease-out">
                                <div class="col">
                                    <div class="form-group">
                                        <x-select wire:key="cSorDept"
                                            label="{{ trans('cruds.estimate.fields.dept') }}"
                                            placeholder="Select {{ trans('cruds.estimate.fields.dept') }}"
                                            wire:model.defer="dataArray.dept_id"
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
                                            label="Department {{ trans('cruds.estimate.fields.category') }}"
                                            placeholder="Select Department {{ trans('cruds.estimate.fields.category') }}"
                                            wire:model.defer="dataArray.dept_category_id"
                                            x-on:select="$wire.getVolumn()">
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
                                        <x-select wire:key="volume" label="Volume" placeholder="Select Volume"
                                            wire:model.defer="dataArray.volume" x-on:select="$wire.getTableNo()">
                                            @isset($fatchDropdownData['volumes'])
                                                @foreach ($fatchDropdownData['volumes'] as $volume)
                                                    <x-select.option label="{{ getVolumeName($volume['volume_no']) }}"
                                                        value="{{ $volume['volume_no'] }}" />
                                                @endforeach
                                            @endisset
                                        </x-select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-select wire:key="dept1" label="Table No" placeholder="Select Table No"
                                            wire:model.defer="dataArray.table_no" x-on:select="$wire.getPageNo()">
                                            @isset($fatchDropdownData['table_no'])
                                                @foreach ($fatchDropdownData['table_no'] as $table)
                                                    <x-select.option label="{{ $table['table_no'] }}"
                                                        value="{{ $table['table_no'] }}" />
                                                @endforeach
                                            @endisset

                                        </x-select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-select wire:key="dept" label="Page No" placeholder="Select Page No"
                                            wire:model.defer="dataArray.id" x-on:select="$wire.getDynamicSor()">
                                            @foreach ($fatchDropdownData['page_no'] as $page)
                                                <x-select.option
                                                    label="{{ $page['page_no'] . ($page['corrigenda_name'] != null ? ' - ' . $page['corrigenda_name'] : '') }}"
                                                    value="{{ $page['id'] }}" />
                                            @endforeach
                                        </x-select>
                                    </div>
                                </div>
                                @if ($fetchChildSor)
                                    <div class="col">
                                        <div class="form-group">
                                            {{-- <x-select wire:key='sor-child' label="Child Page No"
                                                placeHolder="Select Child Page"
                                                wire:model.defer="dataArray.childSorId"
                                                x-on:select="$wire.getPlaceWiseComposite()">
                                                <x-select.option label="{{ $getSor['page_no'] }}"
                                                    value="{{ $getSor['id'] }}" />
                                            </x-select> --}}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                        {{-- Composite SOR Field End --}}

                        {{-- Carriages Field Start --}}
                        @if ($dataArray['item_name'] == 'Carriages')
                            <div class="row" wire:key='Carriages' style="transition: all 2s ease-out">

                                <div class="col-md-2 col-lg-2 col-sm-3">
                                    <div class="form-group">
                                        <x-input label="Distance" placeholder="Distance"
                                            wire:model.defer="dataArray.distance" wire:key="distance"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-select wire:key="unit_" label="Unit" placeholder="Select Unit"
                                            wire:model.defer="dataArray.unit_id">
                                            @foreach ($fatchDropdownData['units'] as $unit)
                                                <x-select.option label="{{ $unit['unit_name'] }}"
                                                    value="{{ $unit['unit_name'] }}" />
                                            @endforeach
                                        </x-select>

                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <x-select wire:key="carrept"
                                            label="{{ trans('cruds.estimate.fields.dept') }}"
                                            placeholder="Select {{ trans('cruds.estimate.fields.dept') }}"
                                            wire:model.defer="dataArray.dept_id"
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
                                            label="Department {{ trans('cruds.estimate.fields.category') }}"
                                            placeholder="Select Department {{ trans('cruds.estimate.fields.category') }}"
                                            wire:model.defer="dataArray.dept_category_id"
                                            x-on:select="$wire.getVolumn()">
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
                                        <x-select wire:key="volume" label="Volume" placeholder="Select Volume"
                                            wire:model.defer="dataArray.volume" x-on:select="$wire.getTableNo()">
                                            @isset($fatchDropdownData['volumes'])
                                                @foreach ($fatchDropdownData['volumes'] as $volume)
                                                    <x-select.option label="{{ getVolumeName($volume['volume_no']) }}"
                                                        value="{{ $volume['volume_no'] }}" />
                                                @endforeach
                                            @endisset
                                        </x-select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-select wire:key="dept1" label="Table No" placeholder="Select Table No"
                                            wire:model.defer="dataArray.table_no" x-on:select="$wire.getPageNo()">
                                            @isset($fatchDropdownData['table_no'])
                                                @foreach ($fatchDropdownData['table_no'] as $table)
                                                    <x-select.option label="{{ $table['table_no'] }}"
                                                        value="{{ $table['table_no'] }}" />
                                                @endforeach
                                            @endisset

                                        </x-select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-select wire:key="dept" label="Page No" placeholder="Select Page No"
                                            wire:model.defer="dataArray.id" x-on:select="$wire.getDynamicSor()">
                                            @foreach ($fatchDropdownData['page_no'] as $page)
                                                <x-select.option
                                                    label="{{ $page['page_no'] . ($page['corrigenda_name'] != null ? ' - ' . $page['corrigenda_name'] : '') }}"
                                                    value="{{ $page['id'] }}" />
                                            @endforeach
                                        </x-select>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($dataArray['item_name'] == 'Copy Rate')
                            <div class="row" wire:key='copy_rate'>
                                <div class="col">
                                    <div class="form-group" wire:key="copyrateDeptGroup">
                                        <x-select wire:key="copyrateDept"
                                            label="{{ trans('cruds.estimate.fields.dept') }}"
                                            placeholder="Select {{ trans('cruds.estimate.fields.dept') }}"
                                            wire:model.defer="dataArray.dept_id" x-on:select="$wire.getDeptRates()">
                                            @isset($fatchDropdownData['departments'])
                                                @foreach ($fatchDropdownData['departments'] as $key => $department)
                                                    <x-select.option wire:key="{{ $key . 'aaaa' }}"
                                                        label="{{ $department['department_name'] }}"
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
                                            wire:model.defer="dataArray.rate_no"
                                            x-on:select="$wire.getRateDetailsCopyTypes()">
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
                            </div>
                        @endif
                        @if ($dataArray['item_name'] == 'Estimate')
                            <div class="row" wire:key='{{ $dataArray['item_name'] }}'>
                                <div class="col">
                                    <div class="form-group">
                                        <x-select wire:key="dept" label="{{ trans('cruds.estimate.fields.dept') }}"
                                            placeholder="Select {{ trans('cruds.estimate.fields.dept') }}"
                                            wire:model.defer="dataArray.dept_id"
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
                                            wire:model.defer="dataArray.estimate_no"
                                            x-on:select="$wire.getEstimateDetails()">
                                            @isset($fatchDropdownData['estimatesList'])
                                                @foreach ($fatchDropdownData['estimatesList'] as $estimate)
                                                    <x-select.option
                                                        label="{{ $estimate['estimate_id'] . ' - ' . $estimate['sorMasterDesc'] }}"
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
                                        wire:model.defer="dataArray.description"
                                        wire:blur="calculateValue"
                                        label="Estimate {{ trans('cruds.estimate.fields.description') }}"
                                        placeholder="Estimate {{ trans('cruds.estimate.fields.description') }}"
                                        disabled />
                                </div>
                                </div> --}}
                                <div class="col">
                                    <div class="form-group">
                                        <x-select wire:key="unit_" label="Unit" placeholder="Select Unit"
                                            wire:model.defer="dataArray.unit_id">
                                            @isset($fatchDropdownData['units'])
                                                @foreach ($fatchDropdownData['units'] as $value)
                                                    <x-select.option label="{{ $value['unit_name'] }}"
                                                        value="{{ $value['unit_name'] }}" />
                                                @endforeach
                                            @endisset
                                        </x-select>
                                        {{-- <x-input wire:key='unit_' label="Unit Name" placeholder="Unit Name"
                                            wire:model.defer="dataArray.unit_id" /> --}}
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-input wire:key="other_qty" wire:model.defer="dataArray.qty"
                                            wire:blur="calculateValue"
                                            label="{{ trans('cruds.estimate.fields.quantity') }}"
                                            placeholder="{{ trans('cruds.estimate.fields.quantity') }}"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-input wire:key="sor_rate"
                                            label="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                            placeholder="{{ trans('cruds.estimate.fields.per_unit_cost') }}" readonly
                                            wire:model.defer="dataArray.rate" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-input wire:key="total_amount" wire:model.defer="dataArray.total_amount"
                                            label="{{ trans('cruds.estimate.fields.estimate_total') }}" disabled
                                            placeholder="{{ trans('cruds.estimate.fields.estimate_total') }}" />
                                    </div>
                                </div>
                                {{-- @endisset --}}

                            </div>
                        @endif
                    @endif
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" id="close-edit-modalBtn" class="btn btn-soft-secondary mr-auto"
                        data-dismiss="modal">Close</button>
                    <button type="button" wire:click="UpdateModalData" id="update-edit-modalBtn"
                        class="btn btn-soft-success ml-auto">Update</button>
                </div>

            </div>
        </div>
    </div>
    @if ($viewModal)
        <div>
            {{-- @dd($editRowData); --}}
            <div class="modal" id="{{ $modalName }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                @isset($getSor->table_no)
                                    {{ $getSor->table_no . ' - ' . $getSor->title }}
                                @endisset
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                style="font-size:30px;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="tabulator_table"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"id="closeBtn" class="btn btn-secondary"
                                data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php
            $tableNo = isset($dataArray['table_no']) ? $dataArray['table_no'] : $selectSor['table_no'];
            $pageNo = isset($dataArray['page_no']) ? $dataArray['page_no'] : $selectSor['page_no'];
        @endphp
        <script>
            var editRowDataItemName = @json($editRowData['item_name']);
            document.getElementById("closeBtn").addEventListener("click", function() {
                closeModal();
            });

            function closeModal() {
                $('#' + @json($modalName)).modal('hide');
                window.Livewire.emit('closeModal');
            }
            $(document).ready(function() {
                var clickableCellValues = [];
                var editRowId = @json($editRowId);
                $("#" + @json($modalName)).modal({
                    backdrop: "static",
                    keyboard: false
                });

                var headerData = @json(json_decode($getSor['header_data']));
                var rowData = @json(json_decode($getSor['row_data']));
                headerData.forEach(function(column) {
                    var fun;
                    delete column.editor;
                    if (editRowDataItemName === 'Composite SOR' && column.field == 'desc_of_item' &&
                        @json($fetchChildSor) == false) {
                        // console.log('hi');
                        column.isClick = function(e, cell) {};
                    }
                    if (column.field === 'desc_of_item') {
                        column.frozen = true;
                    }
                    if (column.field === 'item_no') {
                        column.frozen = true;
                    }
                    if (column.field === 'unit') {
                        column.frozen = true;
                    }
                    if (column.isClick) {
                        column.isClick = eval('(' + column.isClick + ')');
                        fun = column.isClick;
                    }
                    if (column.cellClick) {
                        column.cellClick = eval('(' + column.isClick + ')');
                        fun = column.cellClick;
                    }
                    // alert(fun);
                    if (typeof fun === "function") {

                        column.cellClick = function(e, cell) {
                            // Overwritten cellClick function
                            var getData = cell.getRow().getData();
                            var colId = cell.getField();
                            var allColumn = cell.getTable().columnManager.getColumns();
                            var colIdx = -1;
                            var colName;
                            for (var i = 0; i < allColumn.length; i++) {
                                if (allColumn[i]['columns'] && allColumn[i]['columns'].length > 0) {
                                    var allGroupCol = allColumn[i]['columns'];
                                    for (var j = 0; j < allGroupCol.length; j++) {
                                        if (allGroupCol[j].getField() === colId) {
                                            colIdx = i + j;
                                            colName = allGroupCol[j].getField();
                                            colName = colName.replace(/_/g, ' ');
                                            break;
                                        }
                                    }
                                } else {
                                    if (allColumn[i].getField() === colId) {
                                        colIdx = i;
                                        colName = column.title;
                                        break;
                                    }
                                }
                            }
                            var getRowData = [{
                                id: getData['id'],
                                desc: (getData['desc_of_item']) ? getData['desc_of_item'] : '',
                                unit: (getData['unit']) ? getData['unit'] : '',
                                rowValue: cell.getValue(),
                                itemNo: cell.getRow().getIndex(),
                                colPosition: colIdx
                            }];
                            var cnf = confirm("Are you sure to select " + colName +
                                " Value = " + cell.getValue() + " ?");
                            if (cnf) {
                                if (@json($isParent)) {

                                    window.Livewire.emit('getRowValues', getRowData);


                                } else {
                                    if (editRowDataItemName === 'Composite SOR') {
                                        var cSor_data = [{
                                            parentId: @json($getSor['id']),
                                            item_index: getData['id'],
                                            colPosition: colIdx
                                        }];
                                        if (@json($fetchChildSor == true)) {
                                            // console.log('hi');
                                            window.Livewire.emit('getCompositePlaceWise', cSor_data)
                                        } else {
                                            // console.log('hlw');
                                            window.Livewire.emit('getComposite', cSor_data);
                                        }
                                    } else if (editRowDataItemName === 'Carriages') {


                                        window.Livewire.emit('getRowValues', getRowData);


                                    } else {

                                        window.Livewire.emit('getRowValues', getRowData);


                                    }
                                }


                                // window.Livewire.emit('getRowValues', getData);
                                // window.Livewire.emit('getRowValues', clickableCellValues);
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
                            subColumn.formatter = "textarea";
                            subColumn.variableHeight = true;
                            if (editRowDataItemName === 'Composite SOR' && column.field ==
                                'desc_of_item') {
                                // console.log('hi');
                                column.isClick = function(e, cell) {};
                            }
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
                                    var colId = cell.getField();
                                    var allColumn = cell.getTable().columnManager.getColumns();
                                    var colIdx = -1;
                                    var colName;
                                    var colTitle = column.title;
                                    for (var i = 0; i < allColumn.length; i++) {
                                        if (allColumn[i]['columns'] && allColumn[i]['columns']
                                            .length > 0) {
                                            var allGroupCol = allColumn[i]['columns'];
                                            for (var j = 0; j < allGroupCol.length; j++) {
                                                if (allGroupCol[j].getField() === colId) {
                                                    colIdx = i + j;
                                                    colName = allGroupCol[j].getField();
                                                    colName = colName.replace(/_/g, ' ');
                                                    break;
                                                }
                                            }
                                        } else {
                                            if (allColumn[i].getField() === colId) {
                                                colIdx = i;
                                                colName = column.title;
                                                break;
                                            }
                                        }
                                    }
                                    var getRowData = [{
                                        id: getData['id'],
                                        desc: (getData['desc_of_item']) ? getData[
                                            'desc_of_item'] : '',
                                        unit: (getData['unit']) ? getData['unit'] : (
                                            getData['unit_' + colTitle]) ? getData[
                                            'unit_' + colTitle] : '',
                                        rowValue: cell.getValue(),
                                        itemNo: subrowIndex,
                                        colPosition: colIdx
                                    }];
                                    var cnf = confirm("Are you sure to select " + colName +
                                        " Value = " + cell.getValue() + " ?");
                                    if (cnf) {
                                        if (@json($isParent)) {

                                            window.Livewire.emit('getRowValues', getRowData);


                                        } else {
                                            if (editRowDataItemName === 'Composite SOR') {
                                                var cSor_data = [{
                                                    parentId: @json($getSor['id']),
                                                    item_index: getData['id'],
                                                    colPosition: colIdx
                                                }];
                                                if (@json($fetchChildSor == true)) {

                                                    window.Livewire.emit('getCompositePlaceWise',
                                                        cSor_data)
                                                } else {

                                                    window.Livewire.emit('getComposite', cSor_data);
                                                }
                                            } else if (editRowDataItemName === 'Carriages') {

                                                window.Livewire.emit('getRowValues', getRowData);


                                            } else {

                                                window.Livewire.emit('getRowValues', getRowData);


                                            }
                                        }
                                        // window.Livewire.emit('getRowValues', getData);
                                        $('#' + @json($modalName)).modal('hide');
                                    }
                                };
                            }
                        });
                    } else {
                        column.formatter = "textarea";
                        column.variableHeight = true;
                    }
                });

                var delay = 1000; // Delay time in milliseconds

                var delayPromise = new Promise(function(resolve) {
                    setTimeout(function() {
                        resolve();
                    }, delay);
                });

                delayPromise.then(function() {
                    var table = new Tabulator("#tabulator_table", {
                        height: "711px",
                        columnVertAlign: "bottom",
                        layout: "fitDataFill",
                        columns: headerData,
                        columnHeaderVertAlign: "center",
                        data: rowData,
                        variableHeight: true,
                        variableWidth: true,
                        dataTree: true, // Enable the dataTree module
                        dataTreeStartExpanded: true, // Optional: Expand all rows by default
                        dataTreeChildField: "_subrow", // Specify the field name for subrows
                        dataTreeChildIndent: 10, // Optional: Adjust the indentation level of subrows
                    });

                    // Title of the modal
                    var tableNo = @json($tableNo);
                    var pageNo = @json($pageNo);
                    var modalId = "exampleModal_" + tableNo + "_" + pageNo;

                    $("#" + @json($modalName)).modal("show");
                });
            });
        </script>
    @endif

    @if ($qtyCnfModal)
        <livewire:components.modal.item-modal.confirm-modal :editRowId="$editRowId" :existingQty="$dataArray['existingQty']">
    @endif

    <script>
        $(document).ready(function() {
            var modalId = @json($editRowId);

            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === "style") {
                        $('#' + modalId).css('display', 'block');
                    }
                });
            });
            observer.observe(document.getElementById(modalId), {
                attributes: true
            });
            $("#" + modalId).modal({
                // backdrop: "static",
                keyboard: false
            }).modal("show");
            $(document).off("click", "#update-edit-modalBtn");
            $(document).on("click", "#update-edit-modalBtn", function() {
                hideModal();
            });
            $(document).off("click", "#close-edit-modalBtn");
            $(document).on("click", "#close-edit-modalBtn", function() {
                hideModal();
                window.Livewire.emit('closeEditModal');
            });

            function hideModal() {
                $("#" + modalId).removeClass('show').attr('aria-modal', 'false').css('display', 'none');
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $('body').css({
                    'overflow': 'scroll', // Set overflow to scroll
                    'padding-right': '0px' // Set padding-right to 0px
                });
            }
        });
    </script>
</div>
