<div>
    <x-modal max-width="xl" blur wire:model.defer="modal">
        <x-card>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->name }}</h5>
                            <div class="row">
                                <div class="form-group">
                                    <x-input wire:key="title" label="Plan Title" placeholder="Enter Plan Title"
                                        wire:model.defer="title" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-slot name="footer">
                <div class="flex justify-between">
                    <div class="flex float-left">
                        <x-button class="rounded btn btn-soft-danger" flat label="Cancel" x-on:click="close" />
                    </div>
                    <div class="flex float-right">
                        <button type="button" wire:click="store" class="ml-auto rounded btn btn-soft-success">Save</button>
                    </div>
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
