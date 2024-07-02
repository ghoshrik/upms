<x-app-layout :assets="$assets ?? []">
    @section('webtitle',"Sor Documents")
    <div class="conatiner-fluid content-inner py-0 mt-5">
        <div class="iq-navbar-header" style="height: 124px;">
            {{-- <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Danger!</strong> This is a danger alert.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div> --}}
        </div>
        <div class="container-fluid iq-container">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
                <div class="d-flex flex-column">
                    <h4 class="text-dark">Document SOR</h4>
                    <p class="text-primary mb-0">List</p>
                </div>
                <div class="d-flex justify-content-between align-items-center rounded flex-wrap gap-3">
                    {{-- <a href="{{route('sor-document.create')}}" class="btn btn-secondary btn-sm rounded">Create</a>
                    --}}
                    {{-- @if (!$isFromOpen) --}}

                    {{-- {{!$isFromOpen}} --}}
                    <a href="{{route('sor-document.create')}}" class="btn btn-primary rounded-pill "
                        x-transition:enter.duration.600ms x-transition:leave.duration.10ms>
                        <span class="btn-inner">
                            <x-lucide-plus class="w-4 h-4 text-gray-500" /> Create
                        </span>
                    </a>
                    {{-- @else --}}
                    {{-- <button wire:click="fromEntryControl()" class="btn btn-danger rounded-pill "
                        x-transition:enter.duration.100ms x-transition:leave.duration.100ms>
                        <span class="btn-inner">
                            <x-lucide-x class="w-4 h-4 text-gray-500" /> Close
                        </span>
                    </button> --}}
                    {{-- @endif --}}
                </div>
            </div>
        </div>
        <div wire:loading.delay.long>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>
        <div wire:loading.delay.long.class="loading">
            <div x-transition.duration.900ms>
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12 col-lg-12 col-sm-12">
                                <livewire:document-sor.document-sor-table />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>