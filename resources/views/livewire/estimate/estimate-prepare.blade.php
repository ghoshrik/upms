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
                <div class="col-md-4 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="progress-widget">

                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="4" width="20" height="5" rx="2">
                                    </rect>
                                    <path d="M4 9v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9"></path>
                                    <path d="M10 13h4"></path>
                                </svg>
                                <div class="progress-detail">
                                    <p class="mb-2">
                                        Draft
                                    </p>
                                    <h4 class="counter" style="visibility: visible;">0</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="progress-widget">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="15 17 20 12 15 7"></polyline>
                                    <path d="M4 18v-2a4 4 0 0 1 4-4h12"></path>
                                </svg>
                                <div class="progress-detail">
                                    <p class="mb-2">Forwared</p>
                                    <h4 class="counter" style="visibility: visible;">1</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="progress-widget">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 14 4 9 9 4"></polyline>
                                    <path d="M20 20v-7a4 4 0 0 0-4-4H4"></path>
                                </svg>
                                <div class="progress-detail">
                                    <p class="mb-2">Reverted</p>
                                    <h4 class="counter" style="visibility: visible;">2</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12 col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <livewire:estimate.estimated-data-table />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-modal wire:model.defer="simpleModal">
            <x-card title="Consent Terms">
                <p class="text-gray-600">
                    Lorem Ipsum...
                </p>
                <x-slot name="footer">
                    <div class="flex justify-end gap-x-4">
                        <x-button flat label="Cancel" x-on:click="close" />
                        <x-button primary label="I Agree" />
                    </div>
                </x-slot>
            </x-card>
        </x-modal>
    </div>
</div>
