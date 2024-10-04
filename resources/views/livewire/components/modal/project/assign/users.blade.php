<x-modal.card title="Assign Maker" blur wire:model="assignModal" data-backdrop="static">
    <div class="grid grid-cols-12 gap-4 p-2">
        <!-- Input Fields -->
        @php
            $projectUser = DB::table('projects_users')
                ->where('projects_users.project_creation_id', $this->projectID)
                ->first();
            // ->find($this->projectID);
            // @dd($projectUser);
        @endphp
        {{-- @if ($projectUser->projects->exists())
            @dd('dasdas');
        @else --}}
        <div class="col-span-4">
            <x-select wire:key="office" label="Groups" placeholder="Select Groups" wire:model.defer="group"
                x-on:select="$wire.getDeptOffice()">
                @isset($grouplists)
                    @foreach ($grouplists as $group)
                        <x-select.option value="{{ $group->id }}" label="{{ $group->group_name }}" />
                    @endforeach
                @endisset
            </x-select>
        </div>
        <div class="col-span-4">
            <x-select wire:key="office" label="Office" placeholder="Select Office" wire:model.defer="office"
                x-on:select="$wire.getDeptUsers()">
                @isset($officeLists)
                    @foreach ($officeLists as $office)
                        <x-select.option value="{{ $office->id }}" label="{{ $office->office_name }}" />
                    @endforeach
                @endisset
            </x-select>
        </div>
        <div class="col-span-4">
            <x-select wire:key="office" label="User" placeholder="Select Users" wire:model.defer="user">
                @isset($userLists)
                    @foreach ($userLists as $user)
                        <x-select.option value="{{ $user->id }}" label="{{ $user->emp_name }}" />
                    @endforeach
                @endisset
            </x-select>
        </div>
        {{-- @endif --}}
    </div>

    <x-slot name="footer">
        <div class="flex justify-between">
            <div class="flex float-left">
                <x-button class="btn btn-soft-danger px-3 py-2.5 rounded" flat label="Cancel" x-on:click="close" />
            </div>
            <div class="flex float-right">
                <button class="btn btn-soft-success px-3 py-2.5 rounded" wire:click="assignUser()">
                    <x-lucide-send class="w-4 h-4 text-gray-500" /> Assign
                </button>
            </div>
        </div>
    </x-slot>
</x-modal.card>
