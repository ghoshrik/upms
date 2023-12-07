<div>
    @section('webtitle',"Sor Documents")
    <div class="conatiner-fluid content-inner py-0 mt-5">
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
                        <h4 class="text-dark">{{ $titel }}</h4>
                        <p class="text-primary mb-0">{{ $subTitel }}</p>
                    </div>
                    {{-- @canany(['create dynamic-sor']) --}}
                    <div class="d-flex justify-content-between align-items-center rounded flex-wrap gap-3">
                        @if (!$isFromOpen)
                        <button wire:click="fromEntryControl('create')" class="btn btn-primary rounded-pill "
                            x-transition:enter.duration.600ms x-transition:leave.duration.10ms>
                            <span class="btn-inner">
                                <x-lucide-plus class="w-4 h-4 text-gray-500" /> Create
                            </span>
                        </button>
                        @else
                        <button wire:click="fromEntryControl()" class="btn btn-danger rounded-pill "
                            x-transition:enter.duration.100ms x-transition:leave.duration.100ms>
                            <span class="btn-inner">
                                <x-lucide-x class="w-4 h-4 text-gray-500" /> Close
                            </span>
                        </button>
                        @endif
                    </div>
                    {{-- @endcanany --}}
                </div>
            </div>
        </div>
        <div wire:loading.delay.long>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>
        <div wire:loading.delay.long.class="loading">
            <div x-transition.duration.900ms>
                @if ($isFromOpen && $openedFormType == 'create')
                <livewire:document-sor.create-document-sor />
                @else
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12 col-lg-12 col-sm-12">
                               <livewire:document-sor.document-sor-table :wire:key='$updateDataTableTracker'/> 
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>