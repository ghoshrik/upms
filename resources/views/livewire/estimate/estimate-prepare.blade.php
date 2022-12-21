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
