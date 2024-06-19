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
                                    <x-select label="Designation"
                                        placeholder="{{ trans('cruds.access-manager.fields.designation') }}"
                                        wire:model.defer="newAccessData.designation_id">
                                        @foreach ($dropDownData['designations'] as $designation)
                                            <x-select.option label="{{ $designation['designation_name'] }}"
                                                value="{{ $designation['id'] }}" />
                                        @endforeach
                                    </x-select>
                                @endisset
                            </div>
                        </div>
                        <div class="col col-md-2 col-lg-2 col-sm-12 col-xs-12 mb-2">
                            <div class="form-group pt-4">
                                <button type="button" wire:click='getUsers' class="btn btn-soft-primary ">
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @isset($dropDownData['users'])
        <div class="card" wire:loading.delay.longest.class="loading">
            <div class="card-body p-2">
                <div class="table-responsive mt-4">
                    <table id="basic-table" class="table table-striped mb-0" role="grid">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">EMP NAME</th>
                                {{-- <th scope="col">EMP ID</th> --}}
                                <th scope="col">DESIGNATION</th>
                                <th scope="col">OFFICE</th>
                                <th scope="col">MOBILE</th>
                                <th scope="col">MAIL</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($dropDownData['users'])
                                {{-- @dd($dropDownData['users']) --}}
                                @foreach ($dropDownData['users'] as $key => $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-wrap" style="width: 30rem">{{ $user['emp_name'] }}</td>
                                        {{-- <td class="text-wrap" style="width: 30rem">{{ $user['ehrms_id'] }}</td> --}}
                                        <td class="text-wrap" style="width: 30rem">
                                            {{ getDesignationName($user['designation_id']) }}
                                        </td>
                                        <td class="text-wrap" style="width: 30rem">
                                            {{ getOfficeName($user['office_id']) }}
                                        </td>
                                        <td class="text-wrap" style="width: 30rem">
                                            {{ $user['mobile'] }}
                                        </td>
                                        <td class="text-wrap" style="width: 30rem">
                                            {{ $user['email'] }}
                                        </td>
                                        <td>
                                            <button type="button" wire:click="assignRole({{ $user['id'] }})"
                                                class="btn btn-soft-primary btn-sm">
                                                Assign Role
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endisset
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
