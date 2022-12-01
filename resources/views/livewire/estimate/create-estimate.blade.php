<div>
    <div x-show="formOpen" class="row" x-transition.duration.500ms>
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>

                <div wire:loading.class="loading" class="card-body">
                    <div class="row">
                        <form>
                            <div class="row">
                                <div class="col col-md-8 col-lg-8 mb-2">
                                    <x-textarea wire:model="comment" rows="2"
                                        label="{{ trans('cruds.estimate.fields.description') }}"
                                        placeholder="Your project {{ trans('cruds.estimate.fields.description') }}" />
                                </div>
                                <div class="col col-md-4 col-lg-4 mb-2">
                                    <div class="form-group">
                                        <x-select wire:key="category" label="{{ trans('cruds.estimate.fields.category') }}"
                                            placeholder="Select {{ trans('cruds.estimate.fields.category') }}"
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
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <x-select wire:key="departmant"
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
                                                <x-select label="{{ trans('cruds.estimate.fields.category') }}"
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
                                                <x-select label="{{ trans('cruds.estimate.fields.version') }}"
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
                                                <x-select label="Select {{ trans('cruds.estimate.fields.sor') }}"
                                                    placeholder="Select {{ trans('cruds.estimate.fields.sor') }}"
                                                    wire:model.defer="estimateData.item_number"
                                                    x-on:select="$wire.getItemDetails()">
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
                                                <x-input label="{{ trans('cruds.estimate.fields.description') }}"
                                                    placeholder="{{ trans('cruds.estimate.fields.description') }}" disabled wire:model.defer="estimateData.description"/>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <x-input label="{{ trans('cruds.estimate.fields.quantity') }}"
                                                    placeholder="{{ trans('cruds.estimate.fields.quantity') }}" wire:model.defer="estimateData.qty" wire:keyup="calculateValue"/>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <x-input label="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                                    placeholder="{{ trans('cruds.estimate.fields.per_unit_cost') }}" readonly wire:model.defer="estimateData.rate"/>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <x-input label="{{ trans('cruds.estimate.fields.cost') }}"
                                                    placeholder="{{ trans('cruds.estimate.fields.cost') }}" disabled wire:model.defer="estimateData.total_amount"/>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                                @if ($estimateData['item_name'] == 'Other')
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:model="" label="Item Name" placeholder="Item Name" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:model="" label="{{trans('cruds.estimate.fields.quantity')}}" placeholder="{{trans('cruds.estimate.fields.quantity')}}" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:model="" label="{{trans('cruds.estimate.fields.per_unit_cost')}}" placeholder="{{trans('cruds.estimate.fields.per_unit_cost')}}" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:model="" label="{{trans('cruds.estimate.fields.cost')}}" placeholder="{{trans('cruds.estimate.fields.cost')}}" />
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endif


                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <button @click="formOpen=false" type="button"
                                            class="btn btn-danger rounded-pill ">{{ trans('global.cancel_btn') }}</button>
                                        <button type="button" wire:click='addEstimate'
                                            class="{{ trans('global.add_btn_color') }} rounded-pill">{{ trans('global.add_btn') }}</button>
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div  class="col-md-12 col-lg-12"  x-transition.duration.500ms>
        <div class="card overflow-hidden">
        <div class="card-header d-flex justify-content-between flex-wrap">
            <div class="header-title">
                <h4 class="card-title mb-2">Added Estimates List</h4>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="flex items-center m-3 bg-secondary p-3 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path
                    d="M20.91 8.84 8.56 2.23a1.93 1.93 0 0 0-1.81 0L3.1 4.13a2.12 2.12 0 0 0-.05 3.69l12.22 6.93a2 2 0 0 0 1.94 0L21 12.51a2.12 2.12 0 0 0-.09-3.67Z">
                </path>
                <path
                    d="m3.09 8.84 12.35-6.61a1.93 1.93 0 0 1 1.81 0l3.65 1.9a2.12 2.12 0 0 1 .1 3.69L8.73 14.75a2 2 0 0 1-1.94 0L3 12.51a2.12 2.12 0 0 1 .09-3.67Z">
                </path>
                <line x1="12" y1="22" x2="12" y2="13">
                </line>
                <path
                    d="M20 13.5v3.37a2.06 2.06 0 0 1-1.11 1.83l-6 3.08a1.93 1.93 0 0 1-1.78 0l-6-3.08A2.06 2.06 0 0 1 4 16.87V13.5">
                </path>
            </svg>&nbsp {{ trans('cruds.estimate.fields.No_listMsg') }}
        </div>
            {{-- <div class="table-responsive mt-4">
                <table id="basic-table" class="table table-striped mb-0" role="grid">
                    <thead>
                    <tr>
                        <th>{{ trans('cruds.estimate.fields.id_helper') }}</th>
                        <th>{{ trans('cruds.estimate.fields.item_number') }}</th>
                        <th>{{ trans('cruds.estimate.fields.description') }}</th>
                        <th>{{ trans('cruds.estimate.fields.quantity') }}</th>
                        <th>{{ trans('cruds.estimate.fields.per_unit_cost') }}</th>
                        <th>{{ trans('cruds.estimate.fields.cost') }}</th>
                        <th>{{ trans('cruds.estimate.fields.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div> --}}
        </div>
        </div>
    </div>
</div>
