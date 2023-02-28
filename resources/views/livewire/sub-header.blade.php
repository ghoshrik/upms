<div class="iq-navbar-header" style="height: 215px;">
    @if ($errorMessage != null)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span> {{ $errorMessage }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container-fluid iq-container">

        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h1>{{ (Route::has('dashboard')? $titel: $titel) }}</h1>
                        <p>{{ $subTitel }}</p>
                    </div>
                    {{-- @if(Request()->route('dashboard')) --}}
                    <div x-data="{ createButtonOn: @entangle('createButtonOn') }">
                        <button x-show="!createButtonOn" wire:click="$emit('openForm')"
                            class="btn btn-primary rounded-pill " x-transition:enter.duration.600ms
                            x-transition:leave.duration.10ms>
                            <span class="btn-inner">
                                <x-lucide-plus class="w-4 h-4 text-gray-500" /> Create
                            </span>
                        </button>
                        <button x-show="createButtonOn" wire:click="$emit('openForm')"
                            class="btn btn-danger rounded-pill " x-transition:enter.duration.100ms
                            x-transition:leave.duration.100ms>
                            <span class="btn-inner">
                                <x-lucide-x class="w-4 h-4 text-gray-500" /> Close
                            </span>
                        </button>
                    </div>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
    </div>
    <div class="iq-header-img">
        <img src="{{ asset('images/dashboard/top-header.png') }}" alt="header"
            class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
        <img src="{{ asset('images/dashboard/top-header1.png') }}" alt="header"
            class="theme-color-purple-img img-fluid w-100 h-100 animated-scaleX">
        <img src="{{ asset('images/dashboard/top-header2.png') }}" alt="header"
            class="theme-color-blue-img img-fluid w-100 h-100 animated-scaleX">
        <img src="{{ asset('images/dashboard/top-header3.png') }}" alt="header"
            class="theme-color-green-img img-fluid w-100 h-100 animated-scaleX">
        <img src="{{ asset('images/dashboard/top-header4.png') }}" alt="header"
            class="theme-color-yellow-img img-fluid w-100 h-100 animated-scaleX">
        <img src="{{ asset('images/dashboard/top-header5.png') }}" alt="header"
            class="theme-color-pink-img img-fluid w-100 h-100 animated-scaleX">
    </div>
</div>
