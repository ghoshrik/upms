<div>
    @section('webtitle',trans('cruds.milestone.title_singular'))
    <div wire:loading.delay.long>
        <div class="spinner-border text-primary loader-position" role="status"></div>
    </div>
    <div wire:loading.delay.long.class="loading" x-data="{ formOpen: @entangle('formOpen') }">
        <div x-show="formOpen" x-transition.duration.900ms>
            @if ($formOpen)
                <livewire:milestone.create-milestone />
            @endif
        </div>
        <div x-show="!formOpen" x-transition.duration.500ms>
            <div class="col-md-12 col-lg-12 col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <livewire:office.data-table.office-table />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
