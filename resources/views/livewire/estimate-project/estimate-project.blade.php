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
                    @can(['create estimate'])
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
                    @endcan
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
        <div wire:loading.delay.long>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>
        <div wire:loading.delay.long.class="loading">
            @if ($isFromOpen && $openedFormType == 'create')
                <div x-transition.duration.900ms>
                    <livewire:estimate-project.create-estimate-project />
                </div>
            @elseif($isFromOpen && ($openedFormType == 'edit' || $openedFormType == 'modify'))
                <div x-transition.duration.900ms>
                    <livewire:estimate-project.create-estimate-project />
                    {{-- <livewire:estimate-project.edit-estimate-project /> --}}
                </div>
            @else
                <div x-transition.duration.500ms>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="row row-cols-1">
                                <div class="d-slider1 overflow-hidden ">
                                    <div class="row">
                                        <div class="col">
                                            <li class="swiper-slide card card-tab card-slide {{ $this->selectedTab == 1 ? 'active' : '' }}"
                                                wire:click="draftData()">
                                                <div class="card-body">
                                                    <div class="progress-widget">
                                                        <div id="circle-progress-01"
                                                            class="circle-progress-01 circle-progress circle-progress-primary text-center"
                                                            data-min-value="0"
                                                            data-max-value="{{ $counterData['totalDataCount'] }}"
                                                            data-value="{{ $counterData['draftDataCount'] }}"
                                                            data-type="percent" wire:ignore>
                                                            <svg class="card-slie-arrow" width="24" height="24px"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <rect x="2" y="4" width="20" height="5"
                                                                    rx="2"></rect>
                                                                <path d="M4 9v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9">
                                                                </path>
                                                                <path d="M10 13h4"></path>
                                                            </svg>
                                                        </div>
                                                        <div class="progress-detail" wire:key="$updateDataTableTracker">
                                                            <p class="mb-2">Total Draft</p>
                                                            <h4 class="counter" style="visibility: visible;">
                                                                {{ $counterData['draftDataCount'] }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </div>
                                        <div class="col">
                                            <li class="swiper-slide card card-tab card-slide {{ $this->selectedTab == 2 ? 'active' : '' }}"
                                                wire:click='forwardedData()'>
                                                <div class="card-body">
                                                    <div class="progress-widget">
                                                        <div id="circle-progress-02"
                                                            class="circle-progress-01 circle-progress circle-progress-info text-center"
                                                            data-min-value="0"
                                                            data-max-value="{{ $counterData['totalDataCount'] }}"
                                                            data-value="{{ $counterData['fwdDataCount'] }}"
                                                            data-type="percent" wire:ignore>
                                                            <svg class="card-slie-arrow " width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <polyline points="15 17 20 12 15 7"></polyline>
                                                                <path d="M4 18v-2a4 4 0 0 1 4-4h12"></path>
                                                            </svg>
                                                        </div>
                                                        <div class="progress-detail">
                                                            <p class="mb-2"> Total Forwarded</p>
                                                            <h4 class="counter" style="visibility: visible;"
                                                                wire:key="$updateDataTableTracker">
                                                                {{ $counterData['fwdDataCount'] }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </div>
                                        <div class="col">
                                            <li class="swiper-slide card card-tab card-slide {{ $this->selectedTab == 3 ? 'active' : '' }}"
                                                wire:click="revertedData()">
                                                <div class="card-body">
                                                    <div class="progress-widget">
                                                        <div id="circle-progress-03"
                                                            class="circle-progress-01 circle-progress circle-progress-primary text-center"
                                                            data-min-value="0"
                                                            data-max-value="{{ $counterData['totalDataCount'] }}"
                                                            data-value="{{ $counterData['revertedDataCount'] }}"
                                                            data-type="percent" wire:ignore>
                                                            <svg class="card-slie-arrow " width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <polyline points="9 14 4 9 9 4"></polyline>
                                                                <path d="M20 20v-7a4 4 0 0 0-4-4H4"></path>
                                                            </svg>
                                                        </div>
                                                        <div class="progress-detail">
                                                            <p class="mb-2">Total Reverted</p>
                                                            <h4 class="counter" style="visibility: visible;"
                                                                wire:key="$updateDataTableTracker">
                                                                {{ $counterData['revertedDataCount'] }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </div>
                                        @can('approve estimate')
                                            <div class="col">
                                                <li class="swiper-slide card card-tab card-slide {{ $this->selectedTab == 4 ? 'active' : '' }}"
                                                    wire:click="approvedData()">
                                                    <div class="card-body">
                                                        <div class="progress-widget">
                                                            <div id="circle-progress-04"
                                                                class="circle-progress-01 circle-progress circle-progress-primary text-center"
                                                                data-min-value="0" data-max-value="0" data-value="0"
                                                                data-type="percent" wire:ignore>
                                                                {{-- <svg class="card-slie-arrow " width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <polyline points="9 14 4 9 9 4"></polyline>
                                                                <path d="M20 20v-7a4 4 0 0 0-4-4H4"></path>
                                                            </svg> --}}
                                                                <svg class="card-slie-arrow " width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path class="st0"
                                                                        d="M25.14,53.37c-1.51,0-2.75,1.24-2.75,2.77s1.23,2.77,2.75,2.77h20.11c1.51,0,2.75-1.24,2.75-2.77 s-1.23-2.77-2.75-2.77H25.14L25.14,53.37L25.14,53.37z M77.77,0c17.06,0,30.9,13.83,30.9,30.9c0,12.32-7.21,22.95-17.64,27.92 v57.69c0,1.76-0.71,3.35-1.87,4.5c-1.16,1.16-2.75,1.87-4.5,1.87H6.37c-1.76,0-3.35-0.71-4.5-1.87c-1.16-1.16-1.87-2.75-1.87-4.5 V22.4c0-1.76,0.71-3.35,1.87-4.5c1.16-1.16,2.75-1.87,4.5-1.87h44.3C55.93,6.47,66.09,0,77.77,0L77.77,0z M85.55,60.81 c-2.48,0.65-5.09,0.99-7.78,0.99c-17.06,0-30.9-13.83-30.9-30.9c0-3.27,0.51-6.42,1.45-9.38H6.37c-0.24,0-0.47,0.1-0.63,0.26 c-0.16,0.17-0.26,0.39-0.26,0.63v94.09c0,0.24,0.1,0.46,0.26,0.63c0.17,0.16,0.39,0.26,0.63,0.26h78.28c0.24,0,0.47-0.1,0.63-0.26 c0.16-0.17,0.26-0.39,0.26-0.63V60.81L85.55,60.81z M25.14,92.22c-1.51,0-2.74,1.23-2.74,2.74c0,1.51,1.23,2.74,2.74,2.74h38.47 c1.51,0,2.74-1.23,2.74-2.74c0-1.51-1.23-2.74-2.74-2.74L25.14,92.22L25.14,92.22L25.14,92.22z M25.14,72.81 c-1.51,0-2.74,1.23-2.74,2.74s1.23,2.74,2.74,2.74h38.47c1.51,0,2.74-1.23,2.74-2.74s-1.23-2.74-2.74-2.74H25.14L25.14,72.81 L25.14,72.81z M68.71,25.78l5.67,5.4l11.76-11.92c0.97-0.98,1.57-1.77,2.77-0.54l3.87,3.96c1.27,1.26,1.21,1.99,0.01,3.16 l-16.2,15.94c-2.53,2.48-2.09,2.63-4.65,0.09l-9.75-9.7c-0.53-0.58-0.47-1.16,0.11-1.74l4.49-4.66 C67.46,25.07,68.01,25.11,68.71,25.78L68.71,25.78L68.71,25.78z" />
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                            <div class="progress-detail">
                                                                <p class="mb-2">Total Approved</p>
                                                                <h4 class="counter" style="visibility: visible;"
                                                                    wire:key="$updateDataTableTracker">
                                                                    0</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </div>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12 col-sm-3">
                            @if ($this->selectedTab == 1)
                                <div class="card">
                                    <div class="card-body">
                                        {{-- <livewire:estimate-project.data-table.estimate-project-table
                                            :wire:key="$updateDataTableTracker" /> --}}
                                        {{-- <livewire:estimate-project.data-table.estimate-project-table
                                            :wire:key="$updateDataTableTracker" /> --}}
                                        <livewire:estimate-project.data-table.project-estimate-table
                                            :wire:key="$updateDataTableTracker">
                                    </div>
                                </div>
                            @elseif ($this->selectedTab == 2)
                                <div class="card">
                                    <div class="card-body">
                                        {{-- <livewire:estimate-project.data-table.forwarded-estimate-project-table :wire:key="$updateDataTableTracker" /> --}}
                                        <livewire:estimate-project.datatable.powergrid.forwarded-estimate-project-table
                                            :wire:key="$updateDataTableTracker" />
                                    </div>
                                </div>
                            @elseif ($this->selectedTab == 3)
                                <div class="card">
                                    <div class="card-body">
                                        {{-- <livewire:estimate-project.data-table.reverted-estimate-project-table
                                            :wire:key="$updateDataTableTracker" /> --}}
                                        <livewire:estimate-project.datatable.powergrid.estimate-revert-table
                                            :wire:key="$updateDataTableTracker" />
                                    </div>
                                </div>
                            @elseif($this->selectedTab == 4)
                                <div class="card">
                                    <div class="card-body">
                                        <livewire:estimate-project.data-table.approved-estimate-data-table
                                            :wire:key="$updateDataTableTracker" />
                                    </div>
                                </div>
                            @else
                                <div
                                    class="col-span-6 sm:col-span-3 xl:col-span-2 flex flex-col justify-end items-center">
                                    <svg width="10%" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg"
                                        stroke="rgb(30, 41, 59)" class="w-36 h-36">
                                        <g fill="none" fill-rule="evenodd" stroke-width="4">
                                            <circle cx="22" cy="22" r="1">
                                                <animate attributeName="r" begin="0s" dur="1.8s"
                                                    values="1; 20" calcMode="spline" keyTimes="0; 1"
                                                    keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite">
                                                </animate>
                                                <animate attributeName="stroke-opacity" begin="0s" dur="1.8s"
                                                    values="1; 0" calcMode="spline" keyTimes="0; 1"
                                                    keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite">
                                                </animate>
                                            </circle>
                                            <circle cx="22" cy="22" r="1">
                                                <animate attributeName="r" begin="-0.9s" dur="1.8s"
                                                    values="1; 20" calcMode="spline" keyTimes="0; 1"
                                                    keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite">
                                                </animate>
                                                <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s"
                                                    values="1; 0" calcMode="spline" keyTimes="0; 1"
                                                    keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite">
                                                </animate>
                                            </circle>
                                        </g>
                                    </svg>
                                    <div class="text-center text-xs mt-2">Loading...</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
<livewire:components.modal.estimate.estimate-view-modal />
<livewire:components.modal.rate-analysis.rate-analysis-view-modal />
<livewire:components.modal.estimate.estimate-forward-modal />
<livewire:components.modal.estimate.estimate-approve-modal />
<livewire:components.modal.estimate.edit-estimate-modal />
<livewire:components.modal.estimate.estimate-revert-modal />
