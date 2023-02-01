<x-modal.card title="Forward Estimate No : {{ $estimate_id }} " blur wire:model="forwardModal">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="col-span-1 sm:col-span-2">
            <x-select wire:key="user" label="Select User" placeholder="Select User" wire:model.defer="assignUserDetails">
                @isset($assigenUsersList)
                    @foreach ($assigenUsersList as $user)
                        <x-select.option
                            label="{{ $user['emp_name'] . ' - ' . $user['access_name'] . ' [ ' . $user->getDesignationName->designation_name . ' ]' }}"
                            value="{{ $user['user_id'] . '-' . $user['access_type_id'] . '-' . $estimate_id }}" />
                        {{-- <x-select.option label="{{ $user['id']. '-' . $user['access_type_id'] . '-' . $estimate_id }}" value="{{ $user['id']. '-' . $user['access_type_id'] . '-' . $estimate_id }}" /> --}}
                    @endforeach
                @endisset
            </x-select>
        </div>
        <div class="col-span-1 sm:col-span-2">

            <x-textarea wire:model="userAssignRemarks" label="Remarks" placeholder="Your Remarks" />

        </div>
    </div>
    <x-slot name="footer">
        <div class="flex justify-between">
            <div class="flex float-left">
                <x-button class="btn btn-soft-danger" flat label="Cancel" x-on:click="close" />
            </div>
            <div class="flex float-right">
                <button wire:click="forwardAssignUser()" class="btn btn-soft-success">
                    <x-lucide-send class="w-4 h-4 text-gray-500" /> Forward
                </button>
            </div>
        </div>
        </div>
    </x-slot>
</x-modal.card>
