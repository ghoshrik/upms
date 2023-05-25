<div>
    <div class="conatiner-fluid content-inner py-0">
        <div class="iq-navbar-header" style="height: 124px;">
            @if ($errorMessage != null)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span> {{ $errorMessage }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="container-fluid iq-container">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
                    <div class="d-flex flex-column">
                        <h3 class="text-dark">{{ $titel }}</h3>
                        <p class="text-primary mb-0">{{ $subTitel }}</p>
                    </div>
                    @canany(['create sor'])
                        <div class="d-flex justify-content-between align-items-center rounded flex-wrap gap-3">
                            @if (!$isFromOpen)
                                <button wire:click="fromEntryControl('create')" class="btn btn-primary rounded-pill">
                                    <span class="btn-inner">
                                        <x-lucide-plus class="w-4 h-4 text-gray-500" /> Create
                                    </span>
                                </button>
                            @else
                                <button wire:click="fromEntryControl" class="btn btn-danger rounded-pill">
                                    <span class="btn-inner">
                                        <x-lucide-x class="w-4 h-4 text-gray-500" /> Close
                                    </span>
                                </button>
                            @endif
                        </div>
                    @endcanany
                </div>
            </div>
            {{-- <div class="iq-header-img">
                <img src="{{ asset('images/dashboard/top-header.png') }}" alt="header"
                    class="theme-color-default-img  w-100  animated-scaleX">
                <img src="{{ asset('images/dashboard/top-header1.png') }}" alt="header"
                    class="theme-color-purple-img  w-100  animated-scaleX">
                <img src="{{ asset('images/dashboard/top-header2.png') }}" alt="header"
                    class="theme-color-blue-img  w-100  animated-scaleX">
                <img src="{{ asset('images/dashboard/top-header3.png') }}" alt="header"
                    class="theme-color-green-img  w-100  animated-scaleX">
                <img src="{{ asset('images/dashboard/top-header4.png') }}" alt="header"
                    class="theme-color-yellow-img  w-100  animated-scaleX">
                <img src="{{ asset('images/dashboard/top-header5.png') }}" alt="header"
                    class="theme-color-pink-img  w-100  animated-scaleX">
            </div> --}}
        </div>
        <div wire:loading.delay.long>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>
        {{-- x-data="{ formOpen: @entangle('formOpen'), editFormOpen: @entangle('editFormOpen') }" --}}

        <div>
            <div x-show="formOpen">
                @if ($isFromOpen && $openedFormType == 'create')
                    <livewire:sor.create-sor />
                @elseif($isFromOpen && $openedFormType == 'edit')
                    <livewire:sor.edit-sor />
                @else
                    <div class="col-md-12 col-lg-12 col-sm-3">
                        <div class="card">
                            <div class="card-header">
                                <button type="button" class="btn btn-sm btn-soft-warning px-2 py-2 notification"
                                    :wire:key="$updateDataTableTracker">
                                    <span>Pending Approval</span>
                                    <span class="badge">{{ $CountSorListPending }}</span>
                                </button>

                            </div>
                            <div class="card-body">
                                <livewire:sor.data-table.sor-data-table :wire:key="$updateDataTableTracker" />
                                {{-- <livewire:data-table.sordatatable :wire:key="$updateDataTableTracker" /> --}}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            {{-- <div x-show="editFormOpen" x-transition.duration.900ms>
                @if ($editFormOpen)

                @endif
            </div> --}}
            {{-- <div x-show="!formOpen && !editFormOpen" x-transition.duration.500ms>

            </div> --}}
        </div>
    </div>
</div>
