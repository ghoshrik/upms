<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                @isset($dropDownData['designations'])
                                <x-select label="Designation" placeholder="{{ trans('cruds.access-manager.fields.designation') }}"
                                    wire:model.defer="newAccessData.designation_id" x-on:select="$wire.getUsers()">
                                    @foreach ($dropDownData['designations'] as $designation)
                                    <x-select.option label="{{ $designation['designation_name'] }}"
                                        value="{{ $designation['id'] }}" />
                                    @endforeach
                                </x-select>
                                @endisset
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-select label="User" placeholder="Select User" wire:model.defer="newAccessData.users_id" multiselect>
                                    @isset($dropDownData['users'])
                                        @foreach ($dropDownData['users'] as $user)
                                        <x-select.option label="{{ $user['emp_name'] }}" value="{{ $user['id'] }}" />
                                        @endforeach
                                    @endisset
                                </x-select>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                @isset($dropDownData['roles'])
                                <x-select label="Role" placeholder="Select roles"
                                    wire:model.defer="newAccessData.roles_id" multiselect>
                                    @foreach ($dropDownData['roles'] as $roles)
                                    <x-select.option label="{{ $roles['name'] }}"
                                        value="{{ $roles['id'] }}" />
                                    @endforeach
                                </x-select>
                                @endisset
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group float-right">
                                <button type="button" wire:click='store'
                                    class="btn btn-primary rounded-pill">
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
