<div>
    <div class="conatiner-fluid content-inner py-0 mt-3">
        <div class="iq-navbar-header" style="height: 124px;">
            @if ($errorMessage != null)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span> {{ $errorMessage }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="container-fluid iq-container">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
                    <div class="d-flex flex-column">
                        <h3 class="text-dark">{{ $titel }}</h3>
                        <p class="text-primary mb-0">{{ $subTitel }}</p>
                    </div>
                    @canany(['create user', 'edit user'])
                        <div class="d-flex justify-content-between align-items-center rounded flex-wrap gap-3">
                            @if (!$isFromOpen)
                                <button wire:click="fromEntryControl('create')" class="btn btn-primary rounded-pill"
                                    x-transition:enter.duration.600ms x-transition:leave.duration.10ms>
                                    <span class="btn-inner">
                                        <x-lucide-plus class="w-4 h-4 text-gray-500" /> Create
                                    </span>
                                </button>
                            @else
                                <button wire:click="fromEntryControl" class="btn btn-danger rounded-pill"
                                    x-transition:enter.duration.100ms x-transition:leave.duration.100ms>
                                    <span class="btn-inner">
                                        <x-lucide-x class="w-4 h-4 text-gray-500" /> Close
                                    </span>
                                </button>
                            @endif
                        </div>
                    @endcanany
                </div>
            </div>
            {{-- <div class="iq-header-img">
                <img src="{{ asset('images/dashboard/top-header.png') }}" alt="header"
                    class="theme-color-default-img  w-100  animated-scaleX">
                <img src="{{ asset('images/dashboard/top-header1.png') }}" alt="header"
                    class="theme-color-purple-img  w-100  animated-scaleX">
                <img src="{{ asset('images/dashboard/top-header2.png') }}" alt="header"
                    class="theme-color-blue-img  w-100  animated-scaleX">
                <img src="{{ asset('images/dashboard/top-header3.png') }}" alt="header"
                    class="theme-color-green-img  w-100  animated-scaleX">
                <img src="{{ asset('images/dashboard/top-header4.png') }}" alt="header"
                    class="theme-color-yellow-img  w-100  animated-scaleX">
                <img src="{{ asset('images/dashboard/top-header5.png') }}" alt="header"
                    class="theme-color-pink-img  w-100  animated-scaleX">
            </div> --}}
        </div>
        <div wire:loading.delay.shortest>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>
        <div>
            <style>
                ul>li>button {
                    border-radius: 30px;
                }
            </style>
            @if ($isFromOpen && $openedFormType == 'create')
                <livewire:user-management.create-user>
                @elseif ($isFromOpen && $openedFormType == 'edit')
                @else
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-3">
                            <div class="card">
                                <div class="card-body">

                                    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                                        @foreach ($tabs as $tab)
                                            <li class="nav-item" role="presentation">
                                                <button
                                                    class="nav-link rounded-pill {{ $activeTab === $tab['title'] ? 'active' : '' }}"
                                                    id="{{ $tab['id'] }}-tab" data-bs-toggle="tab"
                                                    data-bs-target="#{{ $tab['id'] }}" type="button" role="tab"
                                                    aria-controls="{{ $tab['id'] }}"
                                                    aria-selected="true">{{ $tab['title'] }}</button>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        @foreach ($tabs as $tab)
                                            <div class="tab-pane fade show {{ $activeTab === $tab['title'] ? 'active' : '' }}"
                                                id="{{ $tab['id'] }}" role="tabpanel"
                                                aria-labelledby="{{ $tab['id'] }}-tab">
                                                {{-- @foreach ($tab['data'] as $user)
                                    <tr>
                                        <td>
                                            {{ $user['Sl No'] }}
                                        </td>
                                        <td>
                                            {{ $user['name'] }}
                                        </td>
                                        <td>
                                            {{ $user['email'] }}
                                        </td>
                                    </tr>
                                @endforeach --}}
                                                {{--                                                <livewire:user-management.datatable.powergrid.users-data-table --}}
                                                {{--                                                    :userData="$tab['data']" :wire:key='$updateDataTableTracker' /> --}}
                                                <livewire:user-management.datatable.powergrid.users-data-table
                                                    :userData="$tab['data']" :wire:key='$updateDataTableTracker' />
                                                {{-- <livewire:user-management.datatable.powergrid.change-users-data-table :userData="$tab['data']" :wire:key='$updateDataTableTracker' /> --}}
                                            </div>
                                        @endforeach
                                    </div>







                                    {{-- TODO:: CHANGE --}}
                                    {{-- <h2>Designation wise user data list sorting pending</h2> --}}
                                    {{-- <livewire:user-management.datatable.users-datatable :wire:key='$updateDataTableTracker' /> --}}
                                    {{-- <livewire:user-management.datatable.powergrid.users-data-table
                                        :wire:key='$updateDataTableTracker' /> --}}
                                </div>
                            </div>
                        </div>
                    </div>
            @endif
        </div>
    </div>
    @if ($openRoleModalForm)
        <livewire:components.modal.user.assign-role :editUserRole='$editUserRole' />
        {{-- <x-modal wire:model.defer="openRoleModalForm">
            <x-card title="Add Remove Role">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="col-span-1 sm:col-span-2">
                        <x-select wire:key="role" label="Roles" placeholder="Select Role" wire:model.defer="userRoles"
                            multiselect>
                            @isset($fetchDropdownData['roles'])
                                @foreach ($fetchDropdownData['roles'] as $role)
                                    <x-select.option label="{{ $role['name'] }}" value="{{ $role['id'] }}" />
                                @endforeach
                            @endisset
                        </x-select>
                    </div>
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

                <x-slot name="footer">
                    <div class="flex justify-between">
                        <div class="flex float-left">
                            <x-button class="btn btn-soft-danger px-3 py-2.5 rounded" flat label="Cancel"
                                x-on:click="close" />
                        </div>
                        <div class="flex float-right">
                            <button wire:click="updateUserRole" class="btn btn-soft-success">
                                Save
                            </button>
                        </div>
                    </div>
                </x-slot>
            </x-card>
        </x-modal> --}}
    @endif
</div>
