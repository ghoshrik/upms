


<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    @section('webtitle')
        {{ __('Mis Reports') }}
    @endsection

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
                        <h3 class="text-dark">{{ $titel }}</h3>
                        <p class="mb-0 text-primary">{{ $subTitel }}</p>
                    </div>
                    {{-- @canany(['create mis-report'])
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
                    @endcanany --}}
                </div>
            </div>
        </div>
        <div wire:loading.delay.long.class="loading">
            <style>
                ul>li>button {
                    border-radius: 22px;
                }

                .nav-tabs .nav-link {
                    border-radius: 22px;
                }

                .nav {
                    background: none !important;
                }

                .table>
                .table>td {
                    border: 1px solid #000;
                    padding: 8px;
                }

                /* .table>thead>tr {
                    border-bottom: 1px solid black;
                } */

                /* .table>thead>tr>th:nth-last-child(-n+4) {
                    border-bottom: 4px solid black;
                    /* or any other border style you prefer */
                } */


                .table>thead>tr:first-child {
                    background-color: #f9f9f9;
                    border: 1px solid #000;
                }

                .table>thead>tr:nth-child(2) {
                    background-color: #f9f9f9;
                }

                .table>th {
                    text-align: center;
                }
            </style>

            <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab === 'home-tab' ? 'active' : '' }}" id="home-tab"
                        data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab"
                        aria-controls="home-tab-pane" aria-selected="true">Schedule of Rates</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab === 'profile-tab' ? 'active' : '' }}" id="profile-tab"
                        data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab"
                        aria-controls="profile-tab-pane" aria-selected="false">Estimates</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab === 'sanction-tab' ? 'active' : '' }}" id="sanction-tab"
                        data-bs-toggle="tab" data-bs-target="#sanction-tab-pane" type="button" role="tab"
                        aria-controls="sanction-tab-pane" aria-selected="false">Sanction Limit</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab === 'user-mis-tab' ? 'active' : '' }}" id="user-mis-tab"
                        data-bs-toggle="tab" data-bs-target="#user-mis-tab-pane" type="button" role="tab"
                        aria-controls="user-mis-tab-pane" aria-selected="false">Users</button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade {{ $activeTab === 'home-tab' ? 'show active' : '' }}" id="home-tab-pane"
                    role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                    <div class="card">
                        <div class="card-body">
                            <div class="mt-4 table-left-bordered table-responsive">
                                <table class="table mb-0" role="grid">
                                    <thead class="thead">
                                        <tr class="bg-white">
                                            <th scope="col">Departments</th>
                                            <th scope="col">Department Category</th>
                                            <th scope="col">Volume No</th>
                                            <th scope="col">Target Pages</th>
                                            <th colspan="4" scope="col" style="text-align: center">Pages</th>
                                        </tr>
                                        <tr class="bg-white">
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                            <th scope="col">Enter Page</th>
                                            <th scope="col">Corrigenda & Addenda</th>
                                            <th scope="col">Approved</th>
                                            <th scope="col">Verified</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sorMasters as $master)
                                            <tr>
                                                <td>{{ $master->department_name }}</td>
                                                <td>{{ $master->dept_category_name }}</td>
                                                <td>
                                                    {{ $master->volume_name }}
                                                </td>
                                                <td>{{ $master->target_pages }}</td>
                                                <td style="text-align: center">{{ $master->total_pages }}</td>
                                                <td style="text-align: center">{{ $master->total_corrigandam_pages }}
                                                </td>
                                                <td style="text-align: center">{{ $master->total_approved }}</td>
                                                <td style="text-align: center">{{ $master->total_verified }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade {{ $activeTab === 'profile-tab' ? 'show active' : '' }}"
                    id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                    <x-cards title="">
                        <x-slot name="table">
                            {{-- <div class="mt-4 table-responsive">
                                <table id="basic-table" class="table mb-0 table-striped" role="grid">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Departmernt Name</th>
                                            <th scope="col">Department Code</th>
                                            <th scope="col">Current Status</th>
                                            <th scope="col">Project No</th>
                                            <th scope="col">Project Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($projectDtls as $details)
                                            <tr>
                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    {{ $details->department_name }}
                                                </td>
                                                <td>
                                                    {{ $details->department_code }}
                                                </td>
                                                <td>
                                                    {{ $details->status }}
                                                </td>
                                                <td>
                                                    {{ $details->estimate_id }}
                                                </td>
                                                <td>
                                                    {{ $details->sorMasterDesc }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> --}}
                            <livewire:data-table.mis-report />
                        </x-slot>
                    </x-cards>
                </div>
                <div class="tab-pane fade {{ $activeTab === 'sanction-tab' ? 'show active' : '' }}"
                    id="sanction-tab-pane" role="tabpanel" aria-labelledby="sanction-tab" tabindex="0">
                    <x-cards title="">
                        <x-slot name="table">
                            <div class="mt-4 table-responsive">
                                <table id="basic-table" class="table mb-0 table-striped" role="grid">
                                    <thead>
                                        <tr>
                                            <th scope="col">SlNo</th>
                                            <th scope="col">Department Name</th>
                                            <th scope="col">Sanction Limits</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($departments as $department)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $department->department_name }}</td>
                                                <td>{{ $department->sanction_limit_count }}</td>
                                                <!-- Sanction limit count here -->
                                                <td>
                                                    <!-- Button to toggle accordion -->
                                                    <button class="btn btn-primary" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse{{ $loop->iteration }}"
                                                        aria-expanded="false"
                                                        aria-controls="collapse{{ $loop->iteration }}">
                                                        View
                                                    </button>
                                                </td>
                                            </tr>
                                            <!-- Accordion collapse -->
                                            <tr>
                                                <td colspan="4">
                                                    <div class="collapse" id="collapse{{ $loop->iteration }}">
                                                        <div class="card card-body">
                                                            <div class="mt-4 table-responsive">
                                                                <table class="table mb-0 table-striped"
                                                                    role="grid">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">SlNo</th>
                                                                            <th scope="col">Min Amount</th>
                                                                            <th scope="col">Max Amount</th>
                                                                            <th scope="col">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        {{-- @dd($sanctionLimitDetails); --}}
                                                                        @foreach ($sanctionLimitDetails as $sanctionLimitDetail)
                                                                            <tr>
                                                                                <td>{{ $loop->iteration }}</td>
                                                                                <td>{{ $sanctionLimitDetail->min_amount }}
                                                                                </td>
                                                                                <td>{{ $sanctionLimitDetail->max_amount }}
                                                                                </td>
                                                                                <td>
                                                                                    <button class="btn btn-primary"
                                                                                        wire:click="handleClick({{ $sanctionLimitDetail->id }})">
                                                                                        View details
                                                                                    </button>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </x-slot>
                    </x-cards>
                </div>
                <div class="tab-pane fade {{ $activeTab === 'user-mis-tab' ? 'show active' : '' }}"
                    id="user-mis-tab-pane" role="tabpanel" aria-labelledby="user-mis-tab" tabindex="0">
                    <livewire:mis-report.users.user-mis-report />
                </div>
            </div>
        </div>
    </div>

    @if ($showSidebarr)
        <div class="offcanvas offcanvas-end {{ $showSidebarr ? 'show' : '' }}" tabindex="-1" id="offcanvasRight"
            aria-labelledby="offcanvasRightLabel" style="width: 470px;">
            <div class="offcanvas-header" style="background: #7f8fdc;">
                <h5 id="offcanvasRightLabel" class="text-white">Sanction Limit Details</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"
                    wire:click="closeSidebar"></button>
            </div>
            <div class="offcanvas-body">
                <div class="row">
                    <div class="mb-2 text-2xl font-semibold col-12">
                        Department : {{ $sanctionLimitRowDetails->department_name }}
                    </div>
                    <div class="mb-2 text-2xl font-semibold col-12">
                        Minimum Value : {{ $sanctionLimitRowDetails->min_amount }}
                    </div>
                    <div class="mb-4 text-2xl font-semibold col-12">
                        Maximum Value : {{ $sanctionLimitRowDetails->max_amount }}
                    </div>
                </div>
                <div class="mt-2 table-responsive">
                    <table id="basic-table" class="table mb-0 table-striped table-bordered" role="grid">
                        <thead>
                            <tr>
                                <th>SLno</th>
                                <th>Sequence</th>
                                <th class="text-center">Role</th>
                                <th>Permission</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sanction_roles as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item['sequence_no'] }}</td>
                                    <td class="text-center">{{ $item->role->name }}</td>
                                    <td>{{ $permissions->get($item->permission->name) }}</td>
                                    {{-- <td>
                                        <button wire:click="confDeleteDialogRolePermission({{ $item['id'] }})"
                                            type="button" class="btn btn-soft-danger btn-sm">
                                            <span class="btn-inner">
                                                <x-lucide-trash-2 class="w-4 h-4 text-gray-500" />
                                            </span>
                                        </button>
                                    </td> --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No Roles Attached to this Sanction</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    @endif
</div>
