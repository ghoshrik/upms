<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    <div class="mb-2 row">
                        <div class="col" wire:key="title_">
                            <x-input label="Project Type Title" placeholder="Enter Project Title"
                                wire:model.defer="title"
                                wire:key='title_' />
                        </div>
                    </div>
                    <div class="row">
                        <div class="mt-3 col">
                            <div class="float-right form-group">
                                @if ($editProjectTypeId != '')
                                    <button type="submit" wire:click='update'
                                        class="float-right btn btn-success rounded-pill">Update</button>
                                @else
                                    <button type="submit" wire:click='store'
                                        class="float-right btn btn-success rounded-pill">Save</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
