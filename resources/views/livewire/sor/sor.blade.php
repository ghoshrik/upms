<div>
    <div wire:loading.delay.long>
        <div class="spinner-border text-primary loader-position" role="status"></div>
    </div>
    <div wire:loading.delay.long.class="loading" x-data="{ formOpen: @entangle('formOpen'), editFormOpen: @entangle('editFormOpen') }">
        <div x-show="formOpen" x-transition.duration.900ms>
            @if ($formOpen)
                <livewire:sor.create-sor />
            @endif
        </div>
        <div x-show="editFormOpen" x-transition.duration.900ms>
            @if ($editFormOpen)
                <livewire:sor.edit-sor />
            @endif
        </div>
        <div x-show="!formOpen && !editFormOpen" x-transition.duration.500ms>
            <div class="col-md-12 col-lg-12 col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <livewire:sor.data-table.sor-data-table :wire:key="$sorUpdateTrack" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
