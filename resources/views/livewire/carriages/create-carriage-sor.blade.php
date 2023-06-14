<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div class="card-body">
                    {{-- <div class="row">
                        <div class="col-sm-8 col-lg-8 col-md-8">
                            <div class="form-group">
                                <x-textarea rows="2" wire:key="description" wire:model="inputText.description"
                                    label="{{ trans('cruds.sor.fields.description') }}"
                                    placeholder="{{ trans('cruds.sor.fields.description') }}" />
                            </div>
                        </div>
                        <div class="col-sm-2 col-lg-2 col-md-2">
                            <div class="form-group">
                                <x-select wire:key="unitmaster" label="{{ trans('cruds.sor.fields.unit') }}"
                                    placeholder="Select {{ trans('cruds.sor.fields.unit') }}"
                                    wire:model.defer="inputText.unit_id">
                                    @isset($fetchDropDownData['unitMaster'])
                                        @foreach ($fetchDropDownData['unitMaster'] as $units)
                                            <x-select.option label="{{ $units['unit_name'] }}"
                                                value="{{ $units['id'] }}" />
                                        @endforeach
                                    @endisset
                                </x-select>
                            </div>
                        </div>
                        <div class="col-sm-2 col-lg-2 col-md-2">
                            <div class="form-group">
                                <x-select wire:key="categoryType" label="Zone" placeholder="Select Zone"
                                    wire:model.defer="inputText.zone" :options="[['name' => 'A', 'id' => 1], ['name' => 'B', 'id' => 2]]" option-label="name"
                                    option-value="id" />
                            </div>
                        </div>
                    </div> --}}


                    @foreach ($inputsData as $key => $inputData)
                        <div class="row mutipal-add-row">
                            <div class="col-md-2 col-lg-2 col-sm-3">
                                <div class="form-group">
                                    <x-select wire:key="deptCategory.{{ $key }}"
                                        label="{{ trans('cruds.sor.fields.dept_category') }}"
                                        placeholder="Select {{ trans('cruds.sor.fields.dept_category') }}"
                                        wire:model.defer="inputsData.{{ $key }}.dept_cate_id"
                                        x-on:select="$wire.getDeptCategory({{$key}})">
                                        @isset($fetchDropDownData['departmentCategory'])
                                            @foreach ($fetchDropDownData['departmentCategory'] as $category)
                                                <x-select.option label="{{ $category['dept_category_name'] }}"
                                                    value="{{ $category['id'] }}" />
                                            @endforeach
                                        @endisset
                                    </x-select>
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2 col-sm-3">
                                <div class="form-group">
                                    <x-select wire:key="ItemNo.{{ $key }}"
                                        label="Parent {{ trans('cruds.sor.fields.item_number') }}"
                                        placeholder="Select Parent {{ trans('cruds.sor.fields.item_number') }}"
                                        wire:model.defer="inputsData.{{ $key }}.sor_parent_id" x-on:select="$wire.getItemNo({{$key}})">
                                        @isset($fetchDropDownData['sorParent_no'])
                                            @foreach ($fetchDropDownData['sorParent_no'] as $category)
                                            <x-select.option label="{{ $category['Item_details'] }}"
                                            value="{{ $category['id'] }}" />
                                            @endforeach
                                        @endisset
                                    </x-select>
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2 col-sm-3">
                                <div class="form-group">
                                    <x-select wire:key="ItemNo.{{ $key }}"
                                        label="child {{ trans('cruds.sor.fields.item_number') }}"
                                        placeholder="Select {{ trans('cruds.sor.fields.item_number') }}"
                                        wire:model.defer="inputsData.{{ $key }}.child_Item_no"/>


                                </div>
                            </div>
                            <div class="col-md-1 col-lg-1 col-sm-3">
                                <div class="form-group">
                                    <x-input label="Any Distance" wire:key='start-distance.{{ $key }}'
                                        placeholder="Any starting distance"
                                        wire:model.defer="inputsData.{{ $key }}.anyDistance" />
                                </div>
                            </div>
                            <div class="col-md-1 col-lg-1 col-sm-3">
                                <div class="form-group">
                                    <x-input label="Above Distance" wire:key='end-distance.{{ $key }}'
                                        placeholder="Any starting distance"
                                        wire:model.defer="inputsData.{{ $key }}.aboveDistance" />
                                </div>
                            </div>
                            <div class="col-md-1 col-lg-1 col-sm-3">
                                <div class="form-group">
                                    <x-input wire:key='cost.{{ $key }}'
                                        label="{{ trans('cruds.sor.fields.cost') }}"
                                        placeholder="{{ trans('cruds.sor.fields.cost') }}"
                                        wire:model.defer="inputsData.{{ $key }}.cost" />
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
