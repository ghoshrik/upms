@if ($openRoleModalForm)
    <div class="offcanvas offcanvas-end {{ $openRoleModalForm ? 'show' : '' }}" tabindex="-1" id="offcanvasRight"
        aria-labelledby="offcanvasRightLabel" style="width: 470px;">
        <div class="offcanvas-header" style="background: #7f8fdc;">
            <h5 id="offcanvasRightLabel" class="text-white">User Roles</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"
                wire:click="closeAddRoleDrawer"></button>
        </div>
        <div class="offcanvas-body">
            <div class="row">
                <div class="text-2xl font-semibold col-12">
                    Employee Name : {{ $editUserRole->emp_name }}
                </div>
                <div class="text-2xl font-semibold col-12">
                    Department : {{ $editUserRole->getDepartmentName->department_name }}
                </div>
                <div class="text-2xl font-semibold col-12">
                    Designation : {{ $editUserRole->getDesignationName->designation_name }}
                </div>
            </div>
            <div class="row" wire:key='add_role'>
                <div class="mt-2 col-12">
                    <x-select label="Roles" placeholder="Select Roles" wire:model.defer="role_id"
                        x-on:select="$wire.getRoleWiseData()">
                        @isset($fetchDropdownData['roles'])
                            @foreach ($fetchDropdownData['roles'] as $role)
                                <x-select.option label="{{ $role['name'] }}" value="{{ $role['id'] }}" />
                            @endforeach
                        @endisset
                    </x-select>
                </div>
                @isset($fetchDropdownData['groups'])
                    <div class="mt-2 col-12" wire:key="Group_No_">
                        <x-select label="Groups" placeholder="Select Group" wire:model.defer="group_id" x-on:select="">
                            @foreach ($fetchDropdownData['groups'] as $key => $group)
                                <x-select.option label="{{ $group['group_name'] }}" value="{{ $group['id'] }}" />
                            @endforeach
                        </x-select>
                    </div>
                @endisset
                @isset($fetchDropdownData['offices'])
                    <div class="mt-2 col-12" wire:key="office_no">
                        <x-select label="Offices" placeholder="Select Office" wire:model.defer="office_id" x-on:select="">
                            @foreach ($fetchDropdownData['offices'] as $key => $office)
                                <x-select.option label="{{ $office['office_name'] }}" value="{{ $office['id'] }}" />
                            @endforeach
                        </x-select>
                    </div>
                @endisset
            </div>
            <div class="row">
                <div class="col">
                    <div class="float-right form-group">
                        <button type="button" class="mt-4 btn btn-soft-success rounded-pill"
                            wire:click='addUserRole'><span class="btn-inner"><x-lucide-list-plus
                                    class="w-4 h-4 text-gray-500" />Add</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-2 table-responsive">
                <table id="basic-table" class="table mb-0 table-striped" role="grid">
                    <thead>
                        <tr>
                            <th>Sl. No</th>
                            <th>Role Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($userRoles as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                {{-- <td>{{ $item->role->name }}</td> --}}
                                <td>{{ $item['name'] }}</td>
                                <td>
                                    @if (auth()->user()->roles[0]->id != $item['id'])
                                        <button wire:click="confDeleteDialogRole({{ $item['id'] }})"
                                            type="button" class="btn btn-soft-danger btn-sm">
                                            <span class="btn-inner">
                                                <x-lucide-trash-2 class="w-4 h-4 text-gray-500" />
                                            </span>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <th colspan="4">
                                    No Roles Attchaed to this Sanction
                                </th>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
