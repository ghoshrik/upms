<div>
    <div class="conatiner-fluid content-inner py-0">
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
                    {{-- @canany(['create accessManager', 'edit accessManager']) --}}
                    <div class="d-flex justify-content-between align-items-center rounded flex-wrap gap-3">
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
                    {{-- @endcanany --}}
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
        <div wire:loading.delay.shortest.class="loading">

            <div x-show="formOpen" x-transition.duration.50ms>
                @if ($isFromOpen && $openedFormType == 'create')
                    <livewire:roles.assign-role.create />
                @elseif($isFromOpen && $openedFormType == 'edit')
                    <livewire:roles.assign-role.create :selectedIdForEdit="$selectedIdForEdit" />
                @else
                    <div>
                        <div class="col-md-12 col-lg-12 col-sm-3">
                            <div class="card">
                                {{-- <h2>Department & office wise Data Sorting is pending.</h2> --}}
                                <div class="card-body">
                                    {{-- TODO:: CHANGE --}}
                                    {{-- <livewire:roles.assign-role.datatable.assign-role-datatable
                                    :wire:key="$updateDataTableTracker" /> --}}
                                    <div class="card" wire:loading.delay.longest.class="loading">
                                        <div class="card-body p-2">
                                            <div class="table-responsive mt-4">
                                                <table id="basic-table" class="table table-striped mb-0" role="grid">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">EMP NAME</th>
                                                            <th scope="col">DEPARTMENT</th>
                                                            <th scope="col">DESIGNATION</th>
                                                            <th scope="col">OFFICE</th>
                                                            <th scope="col">Role</th>
                                                            {{-- <th scope="col">USER TYPE</th> --}}
                                                            <th scope="col">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @isset($assignUserList)
                                                            @foreach ($assignUserList as $key => $user)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td class="text-wrap" style="width: 30rem">
                                                                        {{ $user['emp_name'] }}</td>
                                                                    <td class="text-wrap" style="width: 30rem">
                                                                        {{ $user['department_id'] != 0 ? getDepartmentName($user['department_id']) : '' }}
                                                                    </td>
                                                                    <td class="text-wrap" style="width: 30rem">
                                                                        {{ $user['designation_id'] != 0 ? getDesignationName($user['designation_id']) : '' }}
                                                                    </td>
                                                                    <td class="text-wrap" style="width: 30rem">
                                                                        {{ $user['office_id'] != 0 ? getOfficeName($user['office_id']) : '' }}
                                                                    </td>
                                                                    <td class="text-wrap" style="width: 30rem">
                                                                        {{-- {{ $user->roles->isNotEmpty() ? $user->roles->first()->name : 'No role assigned' }} --}}
                                                                        {{-- {{ $user['roles'][0]['name'] }} --}}
                                                                        @foreach ($user['roles'] as $role)
                                                                            <span
                                                                                class="badge rounded-pill bg-secondary">{{ $role['name'] }}</span>
                                                                        @endforeach
                                                                    </td>
                                                                    {{-- <td class="text-wrap" style="width: 30rem">
                                                                    {{ $user['user_type'] }}
                                                                </td> --}}
                                                                    <td>
                                                                        <button type="button"
                                                                            wire:click="roleChangeConf({{ $user['id'] }})"
                                                                            class="btn btn-soft-secondary btn-sm ">
                                                                            Role Change
                                                                        </button>
                                                                        <button type="button"
                                                                            wire:click="roleRevokeConf({{ $user['id'] }})"
                                                                            class="btn btn-soft-warning btn-sm">
                                                                            Role Revoke
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

                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
