<div>
    <div wire:loading.delay.long>
        <div class="spinner-border text-primary loader-position" role="status"></div>
    </div>
    <div wire:loading.delay.long.class="loading" x-data="{ formOpen: @entangle('formOpen') }">

        <div x-show="formOpen" x-transition.duration.900ms>
            @if ($formOpen)
                <livewire:access-manager.create-access>
            @endif
        </div>
        <div x-show="!formOpen" x-transition.duration.500ms>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-3">
                    <div class="card">
                        {{-- <h2>Department & office wise Data Sorting is pending.</h2> --}}
                        <div class="card-body">
                            {{-- TODO:: CHANGE --}}
                            <livewire:access-manager.datatable.access-manager-datatable />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
