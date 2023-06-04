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
                        <h6 class="text-dark">{{ $titel }}</h6>
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
                                                <livewire:user-management.datatable.powergrid.users-data-table
                                                    :userData="$tab['data']" :wire:key='$updateDataTableTracker' />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            @endif
        </div>
    </div>
</div>
