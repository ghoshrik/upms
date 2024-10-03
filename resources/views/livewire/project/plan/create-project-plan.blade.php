<div>
    <x-modal max-width="xl" blur wire:model.defer="modal">
        <x-card>
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">{{ $project->name }}</h5>
                <button type="button" class="close" aria-label="Close" x-on:click="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <x-input wire:key="title" label="Plan Title" placeholder="Enter Plan Title"
                                wire:model.defer="title" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <x-slot name="footer">
                <div class="flex justify-between">
                    <div>
                        <x-button class="rounded btn btn-soft-danger" flat label="Cancel" x-on:click="close" />
                    </div>
                    <div>
                        <button type="button" wire:click="store" class="ml-auto rounded btn btn-soft-success">Save</button>
                    </div>
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
