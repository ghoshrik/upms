<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8 col-lg-8 col-md-8">
                            <div class="form-group">
                                <x-select wire:key="deptCategory"
                                    label="{{ trans('cruds.sor.fields.dept_category') }}"
                                    placeholder="Select {{ trans('cruds.sor.fields.dept_category') }}"
                                    wire:model.defer="inputText.dept_cate_id"
                                    x-on:select="$wire.getDeptCategory()">
                                    @isset($fetchDropDownData['departmentCategory'])
                                        @foreach ($fetchDropDownData['departmentCategory'] as $category)
                                            <x-select.option label="{{ $category['dept_category_name'] }}"
                                                value="{{ $category['id'] }}" />
                                        @endforeach
                                    @endisset
                                </x-select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-4 col-md-4">
                            <div class="form-group">
                                <x-select wire:key="unitmaster" label="{{ trans('cruds.sor.fields.item_number') }}"
                                    placeholder="Select {{ trans('cruds.sor.fields.item_number') }}"
                                    wire:model.defer="inputText.item_Parent_no" x-on:select="$wire.getFilterItemNo()">
                                    @isset($fetchDropDownData['sorParent_no'])
                                        @foreach ($fetchDropDownData['sorParent_no'] as $itemno)
                                            <x-select.option label="{{ $itemno['Item_details'] }}"
                                                value="{{ $itemno['id'] }}" />
                                        @endforeach
                                    @endisset
                                </x-select>
                            </div>
                        </div>
                    </div>


                    @foreach ($inputsData as $key => $inputData)
                        <div class="row mutipal-add-row">
                            <div class="col-md-2 col-lg-2 col-sm-3">
                                <div class="form-group">
                                    <x-select wire:key="deptCategory.{{ $key }}"
                                        label="{{ trans('cruds.sor.fields.dept_category') }}"
                                        placeholder="Select {{ trans('cruds.sor.fields.dept_category') }}"
                                        wire:model.defer="inputsData.{{ $key }}.item_no"
                                        x-on:select="$wire.getItemDetails({{$key}})">
                                        @isset($fetchDropDownData['carriageSor'])
                                            @foreach ($fetchDropDownData['carriageSor'] as $item)
                                                <x-select.option label="{{ $item['Item_details'] }}"
                                                    value="{{ $item['id'] }}" />
                                            @endforeach
                                        @endisset
                                    </x-select>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-3">
                                <div class="form-group">
                                    {{-- <x-select wire:key="ItemNo.{{ $key }}"
                                        label="Parent {{ trans('cruds.sor.fields.item_number') }}"
                                        placeholder="Select Parent {{ trans('cruds.sor.fields.item_number') }}"
                                        wire:model.defer="inputsData.{{ $key }}.sor_parent_id" x-on:select="$wire.getItemNo({{$key}})">
                                        @isset($fetchDropDownData['sorParent_no'])
                                            @foreach ($fetchDropDownData['sorParent_no'] as $category)
                                            <x-select.option label="{{ $category['Item_details'] }}"
                                            value="{{ $category['id'] }}" />
                                            @endforeach
                                        @endisset
                                    </x-select> --}}
                                    <x-textarea rows="2" wire:key="description.{{ $key }}"
                                    wire:model="inputsData.{{ $key }}.description"
                                    label="{{ trans('cruds.sor.fields.description') }}"
                                    placeholder="{{ trans('cruds.sor.fields.description') }}" disabled/>
                                </div>
                            </div>
                            <div class="col-md-1 col-lg-1 col-sm-3">
                                <div class="form-group">
                                    <x-input wire:key='cost.{{ $key }}'
                                        label="{{ trans('cruds.sor.fields.cost') }}"
                                        placeholder="{{ trans('cruds.sor.fields.cost') }}"
                                        wire:model.defer="inputsData.{{ $key }}.cost" disabled/>
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2 col-sm-3">
                                <div class="form-group">
                                    <x-input label="Any Distance" wire:key='start-distance.{{ $key }}'
                                        placeholder="Any starting distance"
                                        wire:model.defer="inputsData.{{ $key }}.anyDistance" />
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2 col-sm-3">
                                <div class="form-group">
                                    <x-input label="Above Distance" wire:key='end-distance.{{ $key }}'
                                        placeholder="Any starting distance"
                                        wire:model.defer="inputsData.{{ $key }}.aboveDistance" />
                                </div>
                            </div>

                            <div class="col-md-1 col-lg-1 col-sm-3 mt-4">
                                <div class="form-group">
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
                    <div class="row">
                        <div class="col-md-3">
                            <button wire:click="addNewRow"
                                class="btn btn-primary rounded-pill btn-ms mutipal-row-add-button mt-3">
                                <span class="btn-inner">
                                    <x-lucide-plus class="w-4 h-4 text-denger-500" />
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
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
</div>
