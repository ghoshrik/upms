<x-modal.card title="Forward Estimate No : {{ $estimate_id }} " blur wire:model.defer="forwardModal">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="col-span-1 sm:col-span-2">
            <x-select wire:key="version" label="Select User"
                placeholder="Select User" wire:model.defer="">
                @isset($getUserList)
                    @foreach ($getUserList as $user)
                        <x-select.option label="{{ $user['emp_name'] .'-' .$user['access_name'] }}" value="{{ $user['id'] }}" />
                    @endforeach
                @endisset
            </x-select>
        </div>
        <div class="col-span-1 sm:col-span-2">

            <x-textarea wire:model="comment" label="Remarks" placeholder="Your Remarks" />

        </div>
    </div>
    <x-slot name="footer">
        <div class="flex justify-between float-right">
            <div class="flex">
                <x-button flat label="Cancel" x-on:click="close" />
                <button wire:click="save" class="btn btn-soft-success">
                    <x-lucide-send class="w-4 h-4 text-gray-500" /> Forward
                </button>
            </div>
        </div>
    </x-slot>
</x-modal.card>
