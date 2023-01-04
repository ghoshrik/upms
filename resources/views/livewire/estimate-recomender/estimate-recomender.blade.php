<div>
    <div wire:loading.delay.long>
        <div class="spinner-border text-primary loader-position" role="status"></div>
    </div>
    <div wire:loading.delay.long.class="loading" x-data="{ formOpen: @entangle('formOpen'), editFormOpen: @entangle('editFormOpen') }">
        <div x-show="!formOpen && !editFormOpen" x-transition.duration.500ms>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="row row-cols-1">
                        <div class="d-slider1 overflow-hidden ">
                            <div class="row">
                                <div class="col-md-4">
                                    <li class="swiper-slide card card-tab card-slide {{ $this->selectedEstTab == 1 ? 'active' : '' }}"
                                        wire:click="draftData()">
                                        <div class="card-body" wire:ignore>
                                            <div class="progress-widget">
                                                <div id="circle-progress-01"
                                                    class="circle-progress-01 circle-progress circle-progress-primary text-center"
                                                    data-min-value="0" data-max-value="100"
                                                    data-value="{{ $counterData['draftDataCount'] }}"
                                                    data-type="percent">
                                                    <svg class="card-slie-arrow" width="24" height="24px"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <rect x="2" y="4" width="20"
                                                            height="5" rx="2"></rect>
                                                        <path d="M4 9v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9"></path>
                                                        <path d="M10 13h4"></path>
                                                    </svg>
                                                </div>
                                                <div class="progress-detail">
                                                    <p class="mb-2">Total Draft</p>
                                                    <h4 class="counter" style="visibility: visible;">
                                                        {{ $counterData['draftDataCount'] }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </div>
                                <div class="col-md-4">
                                    <li class="swiper-slide card card-tab card-slide {{ $this->selectedEstTab == 2 ? 'active' : '' }}"
                                        wire:click='verifiedData()'>
                                        <div class="card-body" wire:ignore>
                                            <div class="progress-widget">
                                                <div id="circle-progress-02"
                                                    class="circle-progress-01 circle-progress circle-progress-info text-center"
                                                    data-min-value="0" data-max-value="100"
                                                    data-value="{{ $counterData['verifiedDataCount'] }}"
                                                    data-type="percent">
                                                    <svg class="card-slie-arrow " width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <polyline points="15 17 20 12 15 7"></polyline>
                                                        <path d="M4 18v-2a4 4 0 0 1 4-4h12"></path>
                                                    </svg>
                                                </div>
                                                <div class="progress-detail">
                                                    <p class="mb-2"> Total Verified</p>
                                                    <h4 class="counter" style="visibility: visible;">
                                                        {{ $counterData['verifiedDataCount'] }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </div>
                                {{-- <div class="col-md-4">
                                    <li class="swiper-slide card card-tab card-slide {{ $this->selectedEstTab == 3 ? 'active' : '' }}"
                                        wire:click="revertedData()">
                                        <div class="card-body" wire:ignore>
                                            <div class="progress-widget">
                                                <div id="circle-progress-03"
                                                    class="circle-progress-01 circle-progress circle-progress-primary text-center"
                                                    data-min-value="0" data-max-value="100"
                                                    data-value="{{ $counterData['revertedDataCount'] }}"
                                                    data-type="percent">
                                                    <svg class="card-slie-arrow " width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <polyline points="9 14 4 9 9 4"></polyline>
                                                        <path d="M20 20v-7a4 4 0 0 0-4-4H4"></path>
                                                    </svg>
                                                </div>
                                                <div class="progress-detail">
                                                    <p class="mb-2">Total Reverted</p>
                                                    <h4 class="counter" style="visibility: visible;">
                                                        {{ $counterData['revertedDataCount'] }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12 col-sm-3">
                    @if ($this->selectedEstTab == 1)
                        <div class="card">
                            <div class="card-body">
                                <livewire:estimate-recomender.datatable.recomender-draft-table
                                    :wire:key="$updateDataTableTracker" />
                            </div>
                        </div>
                    @elseif ($this->selectedEstTab == 2)
                        <div class="card">
                            <div class="card-body">
                                <livewire:estimate-recomender.datatable.recomender-verified-table
                                    :wire:key="$updateDataTableTracker" />
                            </div>
                        </div>
                    {{-- @elseif ($this->selectedEstTab == 3)
                        <div class="card">
                            <div class="card-body">
                                <livewire:estimate.datatable.reverted-data-table :wire:key="$updateDataTableTracker" />
                            </div>
                        </div> --}}
                    @else
                        <div class="col-span-6 sm:col-span-3 xl:col-span-2 flex flex-col justify-end items-center">
                            <svg width="10%" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg"
                                stroke="rgb(30, 41, 59)" class="w-36 h-36">
                                <g fill="none" fill-rule="evenodd" stroke-width="4">
                                    <circle cx="22" cy="22" r="1">
                                        <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20"
                                            calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1"
                                            repeatCount="indefinite"></animate>
                                        <animate attributeName="stroke-opacity" begin="0s" dur="1.8s"
                                            values="1; 0" calcMode="spline" keyTimes="0; 1"
                                            keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate>
                                    </circle>
                                    <circle cx="22" cy="22" r="1">
                                        <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20"
                                            calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1"
                                            repeatCount="indefinite"></animate>
                                        <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s"
                                            values="1; 0" calcMode="spline" keyTimes="0; 1"
                                            keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite"></animate>
                                    </circle>
                                </g>
                            </svg>
                            <div class="text-center text-xs mt-2">Loading...</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div>
        <livewire:components.modal.estimate.estimate-view-modal />
        <livewire:components.modal.estimate.verified-estimate-view-modal />
        <livewire:components.modal.estimate.estimate-verify-modal />
        <livewire:components.modal.estimate.estimate-revert-modal />
    </div>

</div>
