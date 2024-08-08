<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group" wire:key='ehrmsId'>
                                <x-input wire:model.lazy="newUserData.ehrms_id"
                                    label="{{ trans('cruds.user-management.fields.ehrms_id') }}"
                                    placeholder="{{ trans('cruds.user-management.fields.ehrms_id') }}" />
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group" wire:key='username'>
                                <x-input wire:model.defer="newUserData.username"
                                    label="{{ trans('cruds.user-management.fields.username') }}"
                                    placeholder="{{ trans('cruds.user-management.fields.username') }}" />
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group" wire:key='empName'>
                                <x-input wire:model.defer="newUserData.emp_name"
                                    label="{{ trans('cruds.user-management.fields.employee_name') }}"
                                    placeholder="Enter {{ trans('cruds.user-management.fields.employee_name') }}" />
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group" wire:key='email'>
                                <x-input wire:model.lazy="newUserData.email"
                                    label="{{ trans('cruds.user-management.fields.email_id') }}"
                                    placeholder="Enter Employee {{ trans('cruds.user-management.fields.email_id') }} " />
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <div class="form-group" wire:key='mobile'>
                                <x-input wire:model.lazy="newUserData.mobile"
                                    label="{{ trans('cruds.user-management.fields.mobile') }}"
                                    placeholder="Enter Employee {{ trans('cruds.user-management.fields.mobile') }}" />
                            </div>
                        </div>
                        @isset($dropDownData['states'])
                            <div class="col-md-4 col-lg-4 col-sm-12">
                                <div class="form-group" wire:key='state'>
                                    <x-select label="States List" placeholder="Select State"
                                        wire:model.defer="newUserData.state_code">
                                        @foreach ($dropDownData['states'] as $state)
                                            <x-select.option label="{{ $state['state_name'] }}"
                                                value="{{ $state['state_code'] }}" />
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                        @endisset
                        @isset($dropDownData['departments'])
                            <div class="col-md-4 col-lg-4 col-sm-12">
                                <div class="form-group" wire:key='dept'>
                                    <x-select label="{{ trans('cruds.user-management.fields.department') }}"
                                        placeholder="Select {{ trans('cruds.user-management.fields.department') }}"
                                        wire:model.defer="newUserData.department_id" x-on:select="$wire.fetchLevelWiseOffice()">
                                        @foreach ($dropDownData['departments'] as $department)
                                            <x-select.option label="{{ $department['department_name'] }}"
                                                value="{{ $department['id'] }}" />
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                        @endisset
                        {{-- @isset($dropDownData['levels'])
                            <div class="col-md-4 col-lg-4 col-sm-12">
                                <div class="form-group" wire:key='level'>
                                    <x-select label="Select Office {{ trans('cruds.office.fields.level') }}"
                                        placeholder="Select Office {{ trans('cruds.office.fields.level') }}"
                                        wire:model.defer="selectLevel" x-on:select="$wire.fetchLevelWiseOffice()">
                                        @foreach ($dropDownData['levels'] as $level)
                                            <x-select.option label="{{ $level['level_name'] }}" value="{{ $level['id'] }}" />
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                        @endisset --}}
                        @isset($dropDownData['departmentCategory'])
                        <div class="col-md-4 col-lg-4 col-sm-6" wire:key='departmentCategory_'>
                            <div class="form-group">
                                <x-select label="Department Category" placeholder="Select Department Category"
                                wire:model.defer="newUserData.dept_category_id">
                                @foreach ($dropDownData['departmentCategory'] as $category)
                                    <x-select.option label="{{ $category['dept_category_name'] }}"
                                        value="{{ $category['id'] }}" />
                                @endforeach
                            </x-select>
                            </div>
                        </div>
                        @endisset
                        @isset($dropDownData['designations'])
                            <div class="col-md-4 col-lg-4 col-sm-12">
                                <div class="form-group" wire:key='desig'>
                                    <x-select label="Designation" placeholder="Select Designation"
                                        wire:model.defer="newUserData.designation_id">
                                        @foreach ($dropDownData['designations'] as $designation)
                                            <x-select.option label="{{ $designation['designation_name'] }}"
                                                value="{{ $designation['id'] }}" />
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                        @endisset
                        @isset($dropDownData['offices'])
                            <div class="col-md-4 col-lg-4 col-sm-12">
                                <div class="form-group" wire:key='office'>
                                    <x-select label="{{ trans('cruds.user-management.fields.office_title') }}"
                                        placeholder="Select {{ trans('cruds.user-management.fields.office_name') }}"
                                        wire:model.defer="newUserData.office_id">
                                        @foreach ($dropDownData['offices'] as $office)
                                            <x-select.option label="{{ $office['office_name'] }}"
                                                value="{{ $office['id'] }}" />
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                        @endisset
                    </div>
                    {{-- <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-input wire:model.lazy="newUserData.password" type="password" label="Password"
                                    placeholder="Enter Password" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-input wire:model.lazy="newUserData.confirm_password" type="password"
                                    label="Confirm Password" placeholder="Enter Confirm Password" />
                            </div>
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col">
                            <div class="form-group float-right">
                                <button type="button" wire:click='store' class="btn btn-primary rounded-pill">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
