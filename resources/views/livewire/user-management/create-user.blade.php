<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    <div class="row">
                        @isset($dropDownData['departments'])
                            <div class="col-md-4 col-lg-4 col-sm-4">
                                <div class="form-group">
                                    <x-select label="Department" placeholder="Select Department"
                                        wire:model.defer="newUserData.department_id">
                                        @foreach ($dropDownData['departments'] as $department)
                                            <x-select.option label="{{ $department['department_name'] }}"
                                                value="{{ $department['id'] }}" />
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                        @endisset
                        @isset($dropDownData['level'])
                            <div class="col-md-4 col-lg-4 col-sm-4">
                                <x-select label="Select Office Level" placeholder="Select Office Level" :options="[
                                    ['name' => 'L1 Level', 'id' => 1],
                                    ['name' => 'L2 Level', 'id' => 2],
                                    ['name' => 'L3 Level', 'id' => 3],
                                    ['name' => 'L4 Level', 'id' => 4],
                                    ['name' => 'L5 Level', 'id' => 5],
                                    ['name' => 'L6 Level', 'id' => 6],
                                ]"
                                    option-label="name" option-value="id" wire:model.defer="selectLevel"
                                    x-on:select="$wire.fetchLevelWiseOffice()" />
                            </div>
                        @endisset

                        @isset($dropDownData['offices'])
                            <div class="col-md-4 col-lg-4 col-sm-4">
                                <div class="form-group">
                                    <x-select label="Office" placeholder="Select Office"
                                        wire:model.defer="newUserData.office_id">
                                        @foreach ($dropDownData['offices'] as $office)
                                            <x-select.option label="{{ $office['office_name'] }}"
                                                value="{{ $office['id'] }}" />
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                        @endisset
                        @isset($dropDownData['designations'])
                            <div class="col-md-4 col-lg-4 col-sm-4">
                                <div class="form-group">
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
                        <div class="col-md-4 col-lg-4 col-sm-3">
                            <div class="form-group">
                                <x-input wire:model.lazy="newUserData.ehrms_id" label="eHrms ID(optional)"
                                    placeholder="Enter HRMS ID" />
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-4">
                            <div class="form-group">
                                <x-input wire:model.lazy="newUserData.emp_name"
                                    label="{{ trans('cruds.user-management.fields.employee_name') }}"
                                    placeholder="Enter {{ trans('cruds.user-management.fields.employee_name') }}" />
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-4">
                            <div class="form-group">
                                <x-input wire:model.lazy="newUserData.username"
                                    label="{{ trans('cruds.user-management.fields.username') }}"
                                    placeholder="{{ trans('cruds.user-management.fields.username') }}" />
                            </div>
                        </div>




                        <div class="col-md-4 col-lg-4 col-sm-4">
                            <div class="form-group">
                                <x-input wire:model.lazy="newUserData.email" label="Email"
                                    placeholder="Enter Employee Email " />
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-4">
                            <div class="form-group">
                                <x-input wire:model.lazy="newUserData.mobile" label="Mobile"
                                    placeholder="Enter Employee Mobile No" />
                            </div>
                        </div>
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
