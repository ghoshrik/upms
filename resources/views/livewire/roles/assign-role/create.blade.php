<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    <div class="row">
                        @isset($dropDownData['states'])
                            <div class="col-md-4 col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <x-select label="States List" placeholder="Select State"
                                        wire:model.defer="newAccessData.state_code">
                                        @foreach ($dropDownData['states'] as $state)
                                            <x-select.option label="{{ $state['state_name'] }}"
                                                value="{{ $state['state_code'] }}" />
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                        @endisset
                        {{-- @isset($dropDownData['levels'])
                            <div class="col-md-4 col-lg-4 col-sm-6" wire:key='level_'>
                                <div class="form-group">
                                    <x-select label="Level" placeholder="Select Level"
                                        wire:model.defer="newAccessData.level_id" :disabled="$selectedIdForEdit">
                                        @foreach ($dropDownData['levels'] as $level)
                                            <x-select.option label="{{ $level['level_name'] }}"
                                                value="{{ $level['id'] }}" />
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                        @endisset --}}

                        @isset($dropDownData['departments'])
                            <div class="col-md-4 col-lg-4 col-sm-6" wire:key='department_'>
                                <div class="form-group">
                                    <x-select label="Department" placeholder="Select Department"
                                        wire:model.defer="newAccessData.department_id"
                                        x-on:select="$wire.getOfficeDesignation()" :disabled="$selectedIdForEdit">
                                        @foreach ($dropDownData['departments'] as $department)
                                            <x-select.option label="{{ $department['department_name'] }}"
                                                value="{{ $department['id'] }}" />
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                        @endisset
                        {{-- @isset($dropDownData['departmentCategory'])
                        <div class="col-md-4 col-lg-4 col-sm-6" wire:key='departmentCategory_'>
                            <div class="form-group">
                                <x-select label="Department Category" placeholder="Select Department Category"
                                wire:model.defer="newAccessData.dept_category_id">
                                @foreach ($dropDownData['departmentCategory'] as $category)
                                    <x-select.option label="{{ $category['dept_category_name'] }}"
                                        value="{{ $category['id'] }}" />
                                @endforeach
                            </x-select>
                            </div>
                        </div>
                        @endisset --}}
                        @isset($dropDownData['designations'])
                            <div class="col-md-4 col-lg-4 col-sm-6" wire:key='desg_'>
                                <div class="form-group">
                                    <x-select label="Designation" placeholder="Select Designation"
                                        wire:model.defer="newAccessData.desg_id" x-on:select="$wire.getUserList()"
                                        :disabled="$selectedIdForEdit">
                                        @foreach ($dropDownData['designations'] as $designation)
                                            <x-select.option label="{{ $designation['designation_name'] }}"
                                                value="{{ $designation['id'] }}" />
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                        @endisset
                        @isset($dropDownData['offices'])
                            <div class="col-md-4 col-lg-4 col-sm-6" wire:key='office_'>
                                <div class="form-group">
                                    <x-select label="Office" placeholder="Select Office"
                                        wire:model.defer="newAccessData.office_id" x-on:select="$wire.getUserList()"
                                        :disabled="$selectedIdForEdit">
                                        @foreach ($dropDownData['offices'] as $office)
                                            <x-select.option label="{{ $office['office_name'] }}"
                                                value="{{ $office['id'] }}" />
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                        @endisset
                        @isset($dropDownData['users'])
                            <div class="col-md-4">
                                <div class="form-group" wire:key='user_'>
                                    <x-select label="User List" placeholder="Select User"
                                        wire:model.defer="newAccessData.users_id" x-on:select="$wire.getUserRoles()"
                                        :disabled="$selectedIdForEdit">
                                        @foreach ($dropDownData['users'] as $user)
                                        <x-select.option
                                        label="{{ $user['emp_name'] . ($user['dept_category_id'] !== null && $user['dept_category_id'] != 0 ? ' (' . getDepartmentCategoryName($user['dept_category_id']) . ')' : '') }}"
                                        value="{{ $user['id'] }}" />
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                        @endisset
                        <div class="col-md-4">
                            <div class="form-group" wire:key='userRole_'>
                                <x-select label="User Role" placeholder="Select User Role"
                                    wire:model.defer="newAccessData.role_type" multiselect>
                                    @isset($dropDownData['userTypes'])
                                        @foreach ($dropDownData['userTypes'] as $usertype)
                                            <x-select.option label="{{ $usertype['name'] }}"
                                                value="{{ $usertype['id'] }}" />
                                        @endforeach
                                    @endisset
                                </x-select>
                            </div>
                        </div>
                        <div class="col col-md-2 col-lg-2 col-sm-12 col-xs-12 mb-2">
                            <div class="form-group pt-4">
                                <button type="button" wire:click='store'
                                    class="btn {{ $selectedIdForEdit ? 'btn-soft-warning' : 'btn-soft-primary' }}  ">
                                    {{ $selectedIdForEdit ? 'Update' : 'Save' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-modal wire:model.defer="openAssignModal">
        <x-card title="Select Role">
            <div class="col-md-12">
                <div class="form-group">
                    @isset($dropDownData['roles'])
                        <x-select label="Role" placeholder="Select roles" wire:model.defer="newAccessData.roles_id"
                            multiselect>
                            @foreach ($dropDownData['roles'] as $roles)
                                <x-select.option label="{{ $roles['name'] }}" value="{{ $roles['id'] }}" />
                            @endforeach
                        </x-select>
                    @endisset
                </div>
            </div>
            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button wire:click="store" primary label="Save" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
