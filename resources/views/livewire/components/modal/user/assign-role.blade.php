@if ($openRoleModalForm)
    <div class="offcanvas offcanvas-end {{ $openRoleModalForm ? 'show' : '' }}" tabindex="-1" id="offcanvasRight"
        aria-labelledby="offcanvasRightLabel" style="width: 470px;">
        <div class="offcanvas-header" style="background: #7f8fdc;">
            <h5 id="offcanvasRightLabel" class="text-white">User Roles</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"
                wire:click="closeRolePermissionDrawer"></button>
        </div>
        <div class="offcanvas-body">
            <div class="row">
                <div class="col-12 text-2xl font-semibold">
                    Employee Name : {{ $editUserRole->emp_name }}
                </div>
                <div class="col-12 text-2xl font-semibold">
                    Department : {{ $editUserRole->getDepartmentName->department_name }}
                </div>
                <div class="col-12 text-2xl font-semibold">
                    Designation : {{ $editUserRole->getDesignationName->designation_name }}
                </div>
            </div>
            <div class="row">
                <div class="col-12 mt-2" wire:key="Role_No_">
                    <x-select label="Roles" placeholder="Select Roles" wire:model.defer="role_id"
                        x-on:select="$wire.getRoleWiseData()">
                        @foreach ($fetchDropdownData['roles'] as $role)
                            <x-select.option label="{{ $role['name'] }}" value="{{ $role['id'] }}" />
                        @endforeach
                    </x-select>
                </div>
                @isset($fetchDropdownData['groups'])
                    <div class="col-12 mt-2" wire:key="Group_No_">
                        <x-select label="Groups" placeholder="Select Group" wire:model.defer="group_id" x-on:select="">
                            @foreach ($fetchDropdownData['groups'] as $key => $group)
                                <x-select.option label="{{ $group['group_name'] }}" value="{{ $group['id'] }}" />
                            @endforeach
                        </x-select>
                    </div>
                @endisset
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group float-right">
                        <button type="button" class="btn btn-soft-success rounded-pill mt-4"
                            wire:click='addSanctionRolePermission'><span class="btn-inner"><x-lucide-list-plus
                                    class="w-4 h-4 text-gray-500" />Add</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="table-responsive mt-2">
                <table id="basic-table" class="table table-striped mb-0" role="grid">
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
                                        <button wire:click="confDeleteDialogRolePermission({{ $item['id'] }})"
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
