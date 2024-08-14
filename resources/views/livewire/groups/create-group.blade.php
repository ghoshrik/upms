<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <x-select wire:key="dept" label="{{ trans('cruds.estimate.fields.dept') }}"
                                    placeholder="Select {{ trans('cruds.estimate.fields.dept') }}"
                                    wire:model.defer="department_id" x-on:select="$wire.getDeptCategory()">
                                    @isset($fetchDropdownData['departments'])
                                        @foreach ($fetchDropdownData['departments'] as $department)
                                            <x-select.option label="{{ $department['department_name'] }}"
                                                value="{{ $department['id'] }}" />
                                        @endforeach
                                    @endisset
                                </x-select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <x-select wire:key="category" label="{{ trans('cruds.estimate.fields.category') }}"
                                    placeholder="Select {{ trans('cruds.estimate.fields.category') }}"
                                    wire:model.defer="dept_category_id" x-on:select="">
                                    @isset($fetchDropdownData['departmentsCategory'])
                                        @foreach ($fetchDropdownData['departmentsCategory'] as $deptCategory)
                                            <x-select.option label="{{ $deptCategory['dept_category_name'] }}"
                                                value="{{ $deptCategory['id'] }}" />
                                        @endforeach
                                    @endisset
                                </x-select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <x-input wire:key="dept_group" label="Group Name" placeholder="Enter Group Name"
                                    wire:model.defer="group_name" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="float-right form-group">
                                <button type="button" wire:click='storeGroup'
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
</div>
