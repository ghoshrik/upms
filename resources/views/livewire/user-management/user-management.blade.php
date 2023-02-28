<div>
    <div wire:loading.delay.long>
        <div class="spinner-border text-primary loader-position" role="status"></div>
    </div>
    <div wire:loading.delay.long.class="loading" x-data="{ formOpen: @entangle('formOpen') }">

        <div x-show="formOpen" x-transition.duration.900ms>
            @if ($formOpen)
                <livewire:user-management.create-user>
            @endif
        </div>
        <div x-show="!formOpen" x-transition.duration.500ms>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            {{-- TODO:: CHANGE --}}
                            {{-- <h2>Designation wise user data list sorting pending</h2> --}}
                            <livewire:user-management.datatable.users-datatable :wire:key='$updateDataTableTracker' />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
