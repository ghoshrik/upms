<div>
    <div class="conatiner-fluid content-inner py-0 mt-5">
        <div class="iq-navbar-header" style="height: 160px;">
            <div class="container-fluid iq-container">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
                    <div class="d-flex flex-column">
                        <h3 class="text-dark">{{ $titel }}</h3>
                        <p class="text-primary mb-0">{{ $subTitel }}</p>
                    </div>
                    {{-- @can('create role') --}}
                    <div class="d-flex justify-content-between align-items-center rounded flex-wrap gap-3">
                        <div class="d-flex justify-content-between align-items-center rounded flex-wrap gap-3">
                            @if (!$isFromOpen)
                                <button wire:click="fromEntryControl('create')" class="btn btn-primary rounded-pill"
                                    x-transition:enter.duration.600ms x-transition:leave.duration.10ms>
                                    <span class="btn-inner">
                                        <x-lucide-plus class="w-4 h-4 text-gray-500" /> Create
                                    </span>
                                </button>
                            @else
                                <button wire:click="fromEntryControl" class="btn btn-danger rounded-pill"
                                    x-transition:enter.duration.100ms x-transition:leave.duration.100ms>
                                    <span class="btn-inner">
                                        <x-lucide-x class="w-4 h-4 text-gray-500" /> Close
                                    </span>
                                </button>
                            @endif
                        </div>
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
                    
                        <x-card>
                            <livewire:roles.roles-table >
                        </x-card>
                        
                    @endif
        </div>
    </div>
</div>