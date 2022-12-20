<div>
    <div wire:loading.delay.long>
        <div class="spinner-border text-primary loader-position" role="status"></div>
    </div>
    <div wire:loading.delay.long.class="loading" x-data="{ formOpen: @entangle('formOpen'), editFormOpen: @entangle('editFormOpen') }">
        <div x-show="formOpen" x-transition.duration.900ms>
            @if ($formOpen)
                <livewire:estimate.create-estimate />
            @endif
        </div>
        <div x-show="editFormOpen" x-transition.duration.900ms>
            @if ($editFormOpen)
                <livewire:estimate.edit-estimate />
            @endif
        </div>
        <div x-show="!formOpen && !editFormOpen" x-transition.duration.500ms>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="row row-cols-1">
                        <div class="d-slider1 overflow-hidden ">
                            <div class="row">
                                <div class="col-md-4">
                                    <li class="swiper-slide card card-slide">
                                        <div class="card-body ">
                                            <div class="progress-widget">
                                                <div id="circle-progress-01"
                                                    class="circle-progress-01 circle-progress circle-progress-primary text-center"
                                                    data-min-value="0" data-max-value="100" data-value="90"
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
                                                    <h4 class="counter" style="visibility: visible;">1</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </div>
                                <div class="col-md-4">
                                    <li class="swiper-slide card card-slide">
                                        <div class="card-body">
                                            <div class="progress-widget">
                                                <div id="circle-progress-02"
                                                    class="circle-progress-01 circle-progress circle-progress-info text-center"
                                                    data-min-value="0" data-max-value="100" data-value="80"
                                                    data-type="percent">
                                                    <svg class="card-slie-arrow " width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <polyline points="15 17 20 12 15 7"></polyline>
                                                        <path d="M4 18v-2a4 4 0 0 1 4-4h12"></path>
                                                    </svg>
                                                </div>
                                                <div class="progress-detail">
                                                    <p class="mb-2"> Total Forwarded</p>
                                                    <h4 class="counter" style="visibility: visible;">2</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </div>
                                <div class="col-md-4">
                                    <li class="swiper-slide card card-slide">
                                        <div class="card-body">
                                            <div class="progress-widget">
                                                <div id="circle-progress-03"
                                                    class="circle-progress-01 circle-progress circle-progress-primary text-center"
                                                    data-min-value="0" data-max-value="100" data-value="70"
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
                                                    <h4 class="counter" style="visibility: visible;">3</h4>
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
                    <div class="card">
                        <div class="card-body">
                            <livewire:estimate.estimated-data-table :wire:key="$updateDataTableTracker" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <livewire:components.modal.estimate.estimate-view-modal />
        <livewire:components.modal.estimate.estimate-forward-modal />
    </div>
</div>
