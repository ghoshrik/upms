<div>
    <x-modal blur wire:model.defer="openRevertModal">
        <x-card>
                    <div class="p-0 text-center">
                        <x-lucide-corner-up-left class="w-10 h-12 mx-auto text-warning" />
                        <div class="mt-5 text-3xl">Revert Estimate No : {{ $estimate_id }}</div>
                        <div class="mt-2 text-slate-500"> </div>
                        <div>
                            <x-textarea wire:model="userAssignRemarks" label="Remarks" placeholder="Your Remarks" />
                            <input type="hidden" value="">
                        </div>
                    </div>
            <x-slot name="footer">
                <div class="flex justify-between">
                    <div class="flex float-left">
                        <x-button class="btn btn-soft-secondary" flat icon="x-circle" negative label="Cancel" x-on:click="close" />
                    </div>
                    <div class="flex float-right">
                        <x-button class="btn btn-soft-warning" flat icon="x-circle" negative label="Revert" x-on:click="$wire.revertEstimate({{ $estimate_id }})"/>
                        {{-- <button wire:click="revertEstimate({{ $estimate_id }})" class="btn btn-soft-warning">
                            <x-lucide-corner-up-left class="w-4 h-4 text-gray-500" /> Revert
                        </button> --}}
                    </div>
                </div>
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
