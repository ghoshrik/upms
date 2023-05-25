<div>
    <div class="iq-navbar-header" style="height: 180px;">
        <div class="container-fluid iq-container">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
                <div class="d-flex flex-column">
                    <h3 class="text-dark">{{ $titel }}</h3>
                    <p class="text-primary mb-0">{{ $subTitel }}</p>
                </div>
                {{-- @can('create role') --}}
                <div class="d-flex justify-content-between align-items-center rounded flex-wrap gap-3">
                    @if (!$isFromOpen)
                        <button wire:click="fromEntryControl('create')" type="button"
                            class="btn btn-primary">Create</button>
                    @else
                        <button wire:click="fromEntryControl" type="button" class="btn btn-danger">Close</button>
                    @endif
                </div>
                {{-- @endcan --}}
            </div>
        </div>
    </div>
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        @if ($isFromOpen && $openedFormType == 'create')
            <livewire:roles.role-create>
            @elseif($isFromOpen && $openedFormType == 'edit')
                <livewire:roles.roles-edit :id="$selectedIdForEdit">
                @else
                    {{-- <x-card-container> --}}
                    <x-card>
                        <livewire:roles.roles-table>
                    </x-card>
                    {{-- </x-card-container> --}}
        @endif
    </div>
</div>
