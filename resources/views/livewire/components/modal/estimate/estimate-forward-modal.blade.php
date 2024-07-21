<x-modal.card title="Forward Estimate No : {{ $estimate_id }} " blur wire:model="forwardModal">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" >
        <div class="col-span-1 sm:col-span-2" wire:key='office'>
            <x-select wire:key="office" label="Select Office" placeholder="Select Office" wire:model.defer="selectedOffice"
                x-on:select="$wire.OfficeUserList()">
                @isset($assignOfficeUserList['officeList'])
                    {{-- @dd($assignOfficeUserList['officeList']) --}}
                    @foreach ($assignOfficeUserList['officeList'] as $office)
                        <x-select.option label='{{ $office['office_name'] }}' value="{{ $office['id'] }}" />
                    @endforeach
                @endisset
            </x-select>
        </div>

        <div class="col-span-1 sm:col-span-2" wire:key='user'>
            <x-select wire:key="user" label="Select User" placeholder="Select User"
                wire:model.defer="assignUserDetails">
                @isset($assigenUsersList)
                    @foreach ($assigenUsersList as $user)
                        {{-- @dd($user->designation_id) --}}
                        <x-select.option
                            label="{{ $user['emp_name'] . ' [ ' . getDesignationName($user->designation_id) . ' ' . $user['level_name'] . ' ]' }}"
                            value="{{ $user['id'] . '-' . $user['role_id'] . '-' . $user['level_no'] . '-' . $estimate_id }}" />
                        {{-- <x-select.option label="{{ $user['id']. '-' . $user['access_type_id'] . '-' . $estimate_id }}" value="{{ $user['id']. '-' . $user['access_type_id'] . '-' . $estimate_id }}" /> --}}
                    @endforeach
                @endisset
            </x-select>
        </div>
        <div class="col-span-1 sm:col-span-2">
            <x-textarea wire:model.defer="userAssignRemarks" label="Remarks" placeholder="Your Remarks" />
        </div>
    </div>
    <x-slot name="footer">
        <div class="flex justify-between">
            <div class="flex float-left">
                <x-button class="btn btn-soft-danger px-3 py-2.5 rounded" flat label="Cancel" x-on:click="close" />
            </div>
            <div class="flex float-right">
                <button wire:click="forwardAssignUser()" class="btn btn-soft-success px-3 py-2.5 rounded">
                    <x-lucide-send class="w-4 h-4 text-gray-500" /> Forward
                </button>
            </div>
        </div>
        </div>
    </x-slot>
</x-modal.card>
