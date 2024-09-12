<x-modal.card title="Forward Estimate No : {{ $estimate_id }} " blur wire:model="forwardModal">
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12">
            <x-select wire:key="user" :label="$selectUserLabel" placeholder="Select User" wire:model.defer="assignUserDetails">
                @isset($assigenUsersList)
                    @foreach ($assigenUsersList as $user)
{{--                        <x-select.option--}}
{{--                            label="{{ '<strong>'.$user['office_name'].'</strong>'.$user['emp_name'] . ' ( ' . $user['designation'] . ')' }}"--}}
{{--                            value="{{ $user['id'] . '-' . $user['slm_id'].'-'.$user['sequence_no'] . '-' . $user['estimate_id'] }}" />--}}
                        <x-select.option
                            label="{!! '(<strong>' . $user['office_name'] . '</strong> ) ' . $user['emp_name'] . ' (' . $user['designation'] . ')' !!}"
                            value="{{ $user['id'] . '-' . $user['slm_id'] . '-' . $user['sequence_no'] . '-' . $user['estimate_id'] }}" />
                    @endforeach
                @endisset
            </x-select>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12" style="margin-top:33px;">
            <x-toggle left-label="Outside Office" wire:model="outsideOffice" />
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
    </x-slot>
</x-modal.card>
