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
                        <h3 class="text-dark">{{ $titel }}</h3>
                        <h5 class="text-dark">{{ $project->name ?? '' }}</h5>
                        <p class="mb-0 text-primary">{{ $subTitel }}</p>
                    </div>
                    @can('create estimate')
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
                            <button wire:click="openProjectPlans({{ $project_id }})" class="btn btn-success rounded-pill "
                                x-transition:enter.duration.600ms x-transition:leave.duration.10ms>
                                <span class="btn-inner">
                                    <x-lucide-list class="w-4 h-4 text-gray-500" /> Plans
                                </span>
                            </button>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
        <div wire:loading.delay.long>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>
        <div wire:loading.delay.long.class="loading">
            @if ($isFromOpen && $openedFormType == 'create')
                <div x-transition.duration.900ms>
                    <livewire:estimate-project.create-estimate-project :project="$project" />
                </div>
            @elseif($isFromOpen && $openedFormType == 'edit')
                <div x-transition.duration.900ms>
                    <livewire:estimate-project.create-estimate-project />
                    {{-- <livewire:estimate-project.edit-estimate-project /> --}}
                </div>
            @else
                <div x-transition.duration.500ms>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="row row-cols-1">
                                <div class="overflow-hidden d-slider1 ">
                                    <div class="row">
                                        <div class="col-md-3 col-lg-3 col-sm-6">
                                            <li class="swiper-slide card card-tab card-slide {{ $this->selectedTab == 1 ? 'active' : '' }}"
                                                wire:click="draftData()">
                                                <div class="card-body">
                                                    <div class="progress-widget">
                                                        <div id="circle-progress-01"
                                                            class="text-center circle-progress-01 circle-progress circle-progress-primary"
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
                                        <div class="col-md-3 col-lg-3 col-sm-6">
                                            <li class="swiper-slide card card-tab card-slide {{ $this->selectedTab == 2 ? 'active' : '' }}"
                                                wire:click='forwardedData()'>
                                                <div class="card-body">
                                                    <div class="progress-widget">
                                                        <div id="circle-progress-02"
                                                            class="text-center circle-progress-01 circle-progress circle-progress-info"
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
                                        <div class="col-md-3 col-lg-3 col-sm-6">
                                            <li class="swiper-slide card card-tab card-slide {{ $this->selectedTab == 3 ? 'active' : '' }}"
                                                wire:click="revertedData()">
                                                <div class="card-body">
                                                    <div class="progress-widget">
                                                        <div id="circle-progress-03"
                                                            class="text-center circle-progress-01 circle-progress circle-progress-primary"
                                                            data-min-value="0"
                                                            data-max-value="{{ $counterData['totalDataCount'] }}"
                                                            data-value="{{ $counterData['revertedDataCount'] }}"
                                                            data-type="percent" wire:ignore>
                                                            <svg class="card-slie-arrow " width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
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
                                        <div class="col-md-3 col-lg-3 col-sm-6">
                                            <li class="swiper-slide card card-tab card-slide {{ $this->selectedTab == 4 ? 'active' : '' }}"
                                                wire:click="approvedData()">
                                                <div class="card-body">
                                                    <div class="progress-widget">
                                                        <div id="circle-progress-04"
                                                            class="text-center circle-progress-01 circle-progress circle-progress-primary"
                                                            data-min-value="0"
                                                            data-max-value="{{ $counterData['totalDataCount'] }}"
                                                            data-value="{{ $counterData['approveDataCount'] }}"
                                                            data-type="percent" wire:ignore>
                                                            <svg class="card-slie-arrow " width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <polyline points="9 14 4 9 9 4"></polyline>
                                                                <path d="M20 20v-7a4 4 0 0 0-4-4H4"></path>
                                                            </svg>
                                                        </div>
                                                        <div class="progress-detail">
                                                            <p class="mb-2">Total Approved</p>
                                                            <h4 class="counter" style="visibility: visible;"
                                                                wire:key="$updateDataTableTracker">
                                                                {{ $counterData['approveDataCount'] }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </div>
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
                                        <livewire:estimate-project.data-table.estimate-project-table
                                            :wire:key="$updateDataTableTracker" :project="$project" />
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
                                        {{-- <livewire:estimate-project.data-table.reverted-estimate-project-table :wire:key="$updateDataTableTracker" /> --}}
                                        {{-- <livewire:estimate-project.datatable.powergrid.estimate-revert-table :wire:key="$updateDataTableTracker" /> --}}
                                    </div>
                                </div>
                            @elseif($this->selectedTab == 4)
                                <div class="card">
                                    <div class="card-body">
                                        <livewire:estimate-project.data-table.powergrid.approved-estimate-project
                                            :wire:key="$updateDataTableTracker" />
                                    </div>
                                </div>
                            @else
                                <div
                                    class="flex flex-col items-center justify-end col-span-6 sm:col-span-3 xl:col-span-2">
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
                                    <div class="mt-2 text-xs text-center">Loading...</div>
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
<livewire:components.modal.estimate.edit-estimate-modal />
<livewire:project.plan.project-wise-plans />
