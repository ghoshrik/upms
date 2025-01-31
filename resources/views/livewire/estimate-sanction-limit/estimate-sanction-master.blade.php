<div>
    <div class="py-0 conatiner-fluid content-inner">
        <div class="iq-navbar-header" style="height: 124px;">
            @if ($errorMessage != null)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span> {{ $errorMessage }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="container-fluid iq-container">
                <div class="flex-wrap gap-3 mb-4 d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                        <h3 class="text-dark">{{ $title }}</h3>
                        <p class="mb-0 text-primary">{{ $subTitle }}</p>
                    </div>
                    <div class="flex-wrap gap-3 rounded d-flex justify-content-between align-items-center">
                        @if (!$isFromOpen)
                            <button wire:click="fromEntryControl('create')" class="btn btn-primary rounded-pill "
                                x-transition:enter.duration.600ms x-transition:leave.duration.10ms>
                                <span class="btn-inner">
                                    <x-lucide-plus class="w-4 h-4 text-gray-500" /> Create
                                </span>
                            </button>
                        @else
                            <button wire:click="fromEntryControl" class="btn btn-danger rounded-pill "
                                x-transition:enter.duration.100ms x-transition:leave.duration.100ms>
                                <span class="btn-inner">
                                    <x-lucide-x class="w-4 h-4 text-gray-500" /> Close
                                </span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div wire:loading.delay.long>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>
        <div wire:loading.delay.long.class="loading">
            @if ($isFromOpen && $openedFormType == 'create')
                <div x-transition.duration.900ms>
                    <livewire:estimate-sanction-limit.estimate-sanction-master-create />
                </div>
            @elseif($isFromOpen && $openedFormType == 'edit')
                <div x-transition.duration.900ms>
                    <livewire:estimate-sanction-limit.estimate-sanction-master-create />
                </div>
            @else
                <div x-transition.duration.900ms>
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <livewire:estimate-sanction-limit.data-table.estimate-sanction-master-table
                                        :wire:key="$updateDataTableTracker" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @if ($openAddRolesForm)
        <div class="offcanvas offcanvas-end {{ $openAddRolesForm ? 'show' : '' }}" tabindex="-1" id="offcanvasRight"
            aria-labelledby="offcanvasRightLabel" style="width: 470px;">
            <div class="offcanvas-header" style="background: #7f8fdc;">
                <h5 id="offcanvasRightLabel" class="text-white">Add Role and Permission for Sanction Limit</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"
                    wire:click="closeRolePermissionDrawer"></button>
            </div>
            <div class="offcanvas-body">
                {{-- Sanction Limit Minimum Value  --}}
                {{-- Sanction Limit Maximum Value --}}
                <div class="row">
                    <div class="text-2xl font-semibold col-12">
                        Department : {{ $sanctionLimit->getDepartmentName->department_name }}
                    </div>
                    <div class="text-2xl font-semibold col-12">
                        Minimum Value : {{ $sanctionLimit->min_amount }}
                    </div>
                    <div class="text-2xl font-semibold col-12">
                        Maximum Value : {{ $sanctionLimit->max_amount }}
                    </div>
                </div>
                <div class="row">
                    {{-- Role Select Combo --}}
                    <div class="mt-2 col-12" wire:key="Role_No_">
                        <x-select label="Roles" placeholder="Select Roles" wire:model.defer="role_id" x-on:select="">
                            @foreach ($roles as $role)
                                <x-select.option label="{{ $role['name'] }}" value="{{ $role['id'] }}" />
                            @endforeach
                        </x-select>
                    </div>
                    {{-- Permission Select Combo --}}
                    <div class="mt-2 col-12" wire:key="Permission_No_">
                        <x-select label="Permissions" placeholder="Select Permission" wire:model.defer="permission_name"
                            x-on:select="">
                            @foreach ($permissions as $key => $value)
                                <x-select.option label="{{ $value }}" value="{{ $key }}" />
                            @endforeach
                        </x-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="float-right form-group">
                            <button type="button" class="mt-4 btn btn-soft-success rounded-pill"
                                wire:click='addSanctionRolePermission'><span class="btn-inner"><x-lucide-list-plus
                                        class="w-4 h-4 text-gray-500" />Add</span>
                            </button>
                        </div>
                    </div>
                </div>
                {{-- Table View of Sanction Limit -> Role Permissions --}}
                <div class="mt-2 table-responsive">
                    <table id="basic-table" class="table mb-0 table-striped" role="grid">
                        <thead>
                            <tr>
                                <th>Sequense</th>
                                <th>Role</th>
                                <th>Permission</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sanction_roles as $item)
                                <tr>
                                    <td>{{ $item['sequence_no'] }}</td>
                                    <td>{{ $item->role->name }}</td>
                                    <td>{{ $permissions->get($item->permission->name) }}</td>
                                    <td><button wire:click="confDeleteDialogRolePermission({{ $item['id'] }})"
                                            type="button" class="btn btn-soft-danger btn-sm">
                                            <span class="btn-inner">
                                                <x-lucide-trash-2 class="w-4 h-4 text-gray-500" />
                                            </span>
                                        </button></td>
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
</div>
