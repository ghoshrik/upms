<x-modal.card title="Forward Non Schedule Items " blur wire:model="approveNonSchudule">
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12">
            <x-select wire:key="user" label="User Assign" placeholder="Select User" wire:model.defer="assignUserDetails">
                @isset($assignUsersList)
                    @foreach ($assignUsersList as $user)
                        <x-select.option
                            label="{!! '(<strong>' . $user['office_name'] . '</strong> ) ' . $user['emp_name'] . ' (' . $user['designation'] . ')' !!}"
                            value="{{ $user['id'] . '-'. $user['projectId']}}" />
                    @endforeach
                @endisset
            </x-select>
        </div>
    </div>
    <x-slot name="footer">
        <div class="flex justify-between">
            <div class="flex float-left">
                <x-button class="btn btn-soft-danger px-3 py-2.5 rounded" flat label="Cancel" x-on:click="close" />
            </div>
            <div class="flex float-right">
                <button wire:click="ForwardUser()" class="btn btn-soft-success px-3 py-2.5 rounded">
                    <x-lucide-send class="w-4 h-4 text-gray-500" /> Forwared
                </button>
            </div>
        </div>
    </x-slot>
</x-modal.card>
