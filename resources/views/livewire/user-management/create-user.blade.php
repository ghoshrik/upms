<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-input wire:model="newUserData.emp_id" label="Employee ID"
                                    placeholder="Enter HRMS ID" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-input wire:model="newUserData.emp_name" label="Employee Name"
                                    placeholder="Enter Employee Full Name" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-input wire:model="newUserData.username" label="Username"
                                    placeholder="Enter Employee Username" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                @isset($dropDownData['departments'])
                                    <x-select label="Department" placeholder="Select Department"
                                        wire:model.defer="newUserData.department_id">
                                        @foreach ($dropDownData['departments'] as $department)
                                            <x-select.option label="{{ $department['department_name'] }}"
                                                value="{{ $department['id'] }}" />
                                        @endforeach
                                    </x-select>
                                @endisset
                                @isset($dropDownData['designations'])
                                    <x-select label="Designation" placeholder="Select Department"
                                        wire:model.defer="newUserData.designation_id">
                                        @foreach ($dropDownData['designations'] as $designation)
                                            <x-select.option label="{{ $designation['designation_name'] }}"
                                                value="{{ $designation['id'] }}" />
                                        @endforeach
                                    </x-select>
                                @endisset
                                @isset($dropDownData['offices'])
                                    <x-select label="Office" placeholder="Select Department"
                                        wire:model.defer="newUserData.office_id">
                                        @foreach ($dropDownData['offices'] as $office)
                                            <x-select.option label="{{ $office['office_name'] }}"
                                                value="{{ $office['id'] }}" />
                                        @endforeach
                                    </x-select>
                                @endisset
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <x-input wire:model="newUserData.mobile" label="Mobile"
                                    placeholder="Enter Employee Mobile No" />
                            </div>
                        </div> --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-input wire:model="newUserData.email" label="Email"
                                    placeholder="Enter Employee Email " />
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-input wire:model="newUserData.password" type="password" label="Password" placeholder="Enter Password" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-input wire:model="newUserData.confirm_password" type="password" label="Confirm Password" placeholder="Enter Confirm Password" />
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
