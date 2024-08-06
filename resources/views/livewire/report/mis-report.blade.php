<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    @section('webtitle')
        {{ __('Mis Reports') }}
    @endsection

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
                    {{-- @canany(['create mis-report'])
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
                    @endcanany --}}
                </div>
            </div>
        </div>
        <div wire:loading.delay.long.class="loading">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                        type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">SOR
                        Master</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                        type="button" role="tab" aria-controls="profile-tab-pane"
                        aria-selected="false">Estimates</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                    tabindex="0">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-left-bordered table-responsive mt-4">
                                <table class="table mb-0" role="grid">
                                    <thead>
                                        <tr class="bg-white">
                                            <th scope="col">#</th>
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
                                            <th scope="col"></th>
                                            <th scope="col">Enter Page</th>
                                            <th scope="col">Corrigendam Pages</th>
                                            <th scope="col">Verified</th>
                                            <th scope="col">Approved</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sorMasters as $master)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $master->department_name }}</td>
                                                <td>{{ $master->dept_category_name }}</td>
                                                <td>
                                                    @if ($master->volume_no == 1)
                                                        Volume I
                                                    @elseif($master->volume_no == 2)
                                                        Volume II
                                                    @else
                                                        Volume III
                                                    @endif
                                                </td>
                                                <td>{{ $master->target_pages }}</td>
                                                <td>{{ $master->total_pages }}</td>
                                                <td>{{ $master->total_corrigandam_pages }}</td>
                                                <td>{{ $master->total_verified }}</td>
                                                <td>{{ $master->total_approved }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                    tabindex="0">
                    <x-cards title="">
                        <x-slot name="table">
                            {{-- <div class="table-responsive mt-4">
                                <table id="basic-table" class="table table-striped mb-0" role="grid">
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
            </div>
        </div>
    </div>
</div>
