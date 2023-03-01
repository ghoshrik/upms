<div>
    <div class="iq-navbar-header" style="height: 180px;">
        <div class="container-fluid iq-container">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
                <div class="d-flex flex-column">
                    <h3 class="text-dark">{{$titel}}</h3>
                    <p class="text-primary mb-0">{{$subTitel}}</p>
                </div>
                {{-- @can('create application') --}}
                    <div class="d-flex justify-content-between align-items-center rounded flex-wrap gap-3">
                        @if (!$formOpen)
                        <button wire:click="formOCControl" type="button" class="btn btn-primary">Create</button>
                        @else
                        <button wire:click="formOCControl" type="button" class="btn btn-danger">Close</button>
                        @endif
                    </div>
                {{-- @endcan --}}
            </div>
        </div>
    </div>
    <div wire:loading.delay.long>
        <div class="spinner-border text-primary loader-position" role="status"></div>
    </div>
    <div wire:loading.delay.long.class="loading" x-data="{ formOpen: @entangle('formOpen') }">
        <div x-show="formOpen" x-transition.duration.900ms>
            @if ($formOpen)
                <livewire:tender.create-tender />
            @endif
        </div>
        <div x-show="!formOpen" x-transition.duration.500ms>
            <div class="col-md-12 col-lg-12 col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <livewire:data-table.tender-data-table :wire:key='$updateDataTableTracker'/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
