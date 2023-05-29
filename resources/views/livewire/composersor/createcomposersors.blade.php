<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-lg-3">
                    <div class="form-group">
                        <x-select wire:key="deptCategory" label="{{ trans('cruds.sor.fields.dept_category') }}"
                            placeholder="Select {{ trans('cruds.sor.fields.dept_category') }}"
                            wire:model.defer="storeItem.dept_category_id" x-on:select="$wire.getDeptCategorySORItem()">
                            @isset($fetchDropDownData['departmentCategory'])
                                @foreach ($fetchDropDownData['departmentCategory'] as $category)
                                    <x-select.option label="{{ $category['dept_category_name'] }}"
                                        value="{{ $category['id'] }}" />
                                @endforeach
                            @endisset
                        </x-select>
                    </div>
                </div>

                {{-- <div class="col-md-3 col-sm-3 col-lg-3">
                    <div class="form-group">
                        <x-select wire:key="categoryType"
                        label="{{ trans('cruds.estimate.fields.category') }}"
                        placeholder="Select {{ trans('cruds.estimate.fields.category') }}"
                        wire:model.defer="selectedCategoryId"
                        x-on:select="$wire.changeCategory($event.target)" :options="[
                            ['name' => 'SOR', 'id' => 1],
                            ['name' => 'Other', 'id' => 2],
                        ]"
                        option-label="name" option-value="id" />
                    </div>
                </div> --}}
                <div class="col-md-9 col-lg-9 col-sm-3">
                    <div class="form-group search-sor">
                        {{-- <x-select wire:key="deptCategory" label="SOR Item No" placeholder="Select SOR Item No"
                            wire:model.defer="storeItem.parentSorItemNo">
                            @isset($fetchDropDownData['SORItemNo'])
                                @foreach ($fetchDropDownData['SORItemNo'] as $sor)
                                    <x-select.option label="{{ $sor['Item_details'] }}" value="{{ $sor['id'] }}" />
                                @endforeach
                            @endisset
                        </x-select> --}}
                        <div class="dropdown">
                            <x-input wire:key="sor" label="{{ trans('cruds.estimate.fields.sor') }}"
                                placeholder="{{ trans('cruds.estimate.fields.sor') }}" wire:model="selectSOR"
                                value="{{ $selectSOR }}" wire:keydown.escape="resetValus"
                                wire:keydown.tab="autoSearch" class="dropbtn" />


                            @isset($this->fetchDropDownData['items_number'])
                                @if (count($this->fetchDropDownData['items_number']) > 0)
                                    <div class="dropdown-content"
                                        style="display:{{ $searchDtaCount ? $searchStyle : $searchStyle }}">
                                        @foreach ($this->fetchDropDownData['items_number'] as $list)
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
            @isset($this->fetchDropDownData['items_number'])
                @foreach ($inputsData as $key => $inputData)
                    <div class="row mutipal-add-row">
                        {{-- <div class="col-md-2 col-lg-2 col-sm-3">
                            <div class="form-group">
                                <x-select wire:key="categoryType.{{$key}}" label="{{ trans('cruds.estimate.fields.category') }}"
                                    placeholder="Select {{ trans('cruds.estimate.fields.category') }}"
                                    wire:model.defer="inputsData.{{$key}}.selectedCategoryId" x-on:select="$wire.changeCategory($event.target)"
                                    :options="[['name' => 'SOR', 'id' => 1], ['name' => 'Other', 'id' => 2]]" option-label="name" option-value="id" />
                            </div>
                        </div> --}}
                        {{-- @if (!empty($estimateData))
                        @if ($estimateData['item_name'] == 'SOR') --}}
                        <div class="col-md-3 col-lg-3 col-sm-3">
                            <div class="form-group">
                                {{-- <x-select wire:key="deptCategory.{{$key}}" label="SOR Item No" placeholder="Select SOR Item No"
                                    wire:model.defer="inputsData.{{$key}}.sorItemNo">
                                    @isset($fetchDropDownData['SORItemNo'])
                                        @foreach ($fetchDropDownData['SORItemNo'] as $sor)
                                            <x-select.option label="{{ $sor['Item_details'] }}" value="{{ $sor['id'] }}" />
                                        @endforeach
                                    @endisset
                                </x-select> --}}
                                {{-- <x-input wire:key='childSorItemNo.{{ $key }}'
                                    label="{{ trans('cruds.sor.fields.item_number') }}"
                                    placeholder="{{ trans('cruds.sor.fields.item_number') }}"
                                    wire:model="inputsData.{{ $key }}.childSorItemNo" /> --}}

                                <x-select wire:key="sorItemNo.{{ $key }}" label="SOR Item No"
                                    placeholder="Select SOR Item No"
                                    wire:model.defer="inputsData.{{ $key }}.childSorItemNo"
                                    x-on:select="$wire.getSORItem({{ $key }})">
                                    @isset($fetchDropDownData['SORItemNo'])
                                        @foreach ($fetchDropDownData['SORItemNo'] as $sor)
                                            <x-select.option label="{{ $sor['Item_details'] }}" value="{{ $sor['id'] }}" />
                                        @endforeach
                                    @endisset
                                </x-select>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-3">
                            <div class="form-group">
                                <x-textarea rows="2" wire:key="description.{{ $key }}"
                                    wire:model="inputsData.{{ $key }}.description"
                                    label="{{ trans('cruds.sor.fields.description') }}"
                                    placeholder="{{ trans('cruds.sor.fields.description') }}" />
                            </div>
                        </div>


                        <div class="col md-2 col-lg-2 col-sm-3">
                            <div class="form-group">
                                <x-select wire:key="unitmaster.{{ $key }}"
                                    label="{{ trans('cruds.sor.fields.unit') }}"
                                    placeholder="Select {{ trans('cruds.sor.fields.unit') }}"
                                    wire:model="inputsData.{{ $key }}.unit_id">
                                    @isset($fetchDropDownData['unitMaster'])
                                        @foreach ($fetchDropDownData['unitMaster'] as $units)
                                            <x-select.option label="{{ $units['unit_name'] }}" value="{{ $units['id'] }}" />
                                        @endforeach
                                    @endisset
                                </x-select>
                            </div>
                        </div>
                        <div class="col md-2 col-lg-2 col-sm-3">
                            <div class="form-group">
                                <x-input wire:key='qty.{{ $key }}' label="{{ trans('cruds.sor.fields.qty') }}"
                                    placeholder="{{ trans('cruds.sor.fields.qty') }}"
                                    wire:model="inputsData.{{ $key }}.qty" />
                            </div>
                        </div>
                        {{-- @endif
                        @if ($estimateData['item_name'] == 'Other')
                        <div class="col-md-3 col-lg-3 col-sm-3">
                            <div class="form-group">
                                <x-textarea rows="2" wire:key="description.{{ $key }}"
                                    wire:model="inputsData.{{ $key }}.description"
                                    label="{{ trans('cruds.sor.fields.description') }}"
                                    placeholder="{{ trans('cruds.sor.fields.description') }}" />
                            </div>
                        </div>


                        <div class="col md-2 col-lg-2 col-sm-3">
                            <div class="form-group">
                                <x-select wire:key="unitmaster.{{ $key }}"
                                    label="{{ trans('cruds.sor.fields.unit') }}"
                                    placeholder="Select {{ trans('cruds.sor.fields.unit') }}"
                                    wire:model="inputsData.{{ $key }}.unit_id">
                                    @isset($fetchDropDownData['unitMaster'])
                                        @foreach ($fetchDropDownData['unitMaster'] as $units)
                                            <x-select.option label="{{ $units['unit_name'] }}" value="{{ $units['id'] }}" />
                                        @endforeach
                                    @endisset
                                </x-select>
                            </div>
                        </div>
                        <div class="col md-2 col-lg-2 col-sm-3">
                            <div class="form-group">
                                <x-input wire:key='qty.{{ $key }}' label="{{ trans('cruds.sor.fields.qty') }}"
                                    placeholder="{{ trans('cruds.sor.fields.qty') }}"
                                    wire:model="inputsData.{{ $key }}.qty" />
                            </div>
                        </div>
                        @endif
                        @endif --}}
                        <div class="col-md-1 col-sm-6 col-lg-1 d-flex align-items-center">
                            <div class="col-md-12">
                                <button wire:click="removeRow({{ $key }})"
                                    class="btn btn-danger rounded-pill btn-ms"
                                    {{ count($inputsData) < 2 ? 'disabled' : '' }}>
                                    <span class="btn-inner">
                                        <x-lucide-trash-2 class="w-4 h-4 text-denger-500" />
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="col-md-3">
                    <button wire:click="addNewRow" class="btn btn-primary rounded-pill btn-ms mutipal-row-add-button mt-3">
                        <span class="btn-inner">
                            <x-lucide-plus class="w-4 h-4 text-denger-500" />
                        </span>
                    </button>
                </div>

                <div class="row mutipal-add-row">
                    <div class="col-md-3 col-lg-6 col-sm-3">
                        <div class="form-group">
                            <div class="relative rounded-md shadow-sm">
                                <x-input type="file" wire:model="storeItem.file_upload" label="Choose file"
                                    autocomplete="off" accept=".pdf"
                                    class="placeholder-secondary-400 dark:bg-secondary-800 dark:text-secondary-400 dark:placeholder-secondary-500 border border-secondary-300 focus:ring-primary-500 focus:border-primary-500 dark:border-secondary-600 form-input block w-full sm:text-sm rounded-md transition ease-in-out duration-100 focus:outline-none shadow-sm" />

                            </div>
                            <div wire:loading wire:target="storeItem.file_upload">
                                Uploading...
                            </div>
                        </div>
                    </div>

                </div>
            @endisset
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <button type="submit" wire:click='store'
                            class="btn btn-success rounded-pill float-right">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
