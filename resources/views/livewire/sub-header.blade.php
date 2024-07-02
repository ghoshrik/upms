<div class="iq-navbar-header" style="block-size: 215px;">
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
                        <h5>{{ $titel }}</h5>
                        <p>{{ $subTitel }}</p>
                    </div>
                    <div>
                        <button wire:click="$emit('openForm')" class="btn btn-primary rounded-pill ">
                            <span class="btn-inner">
                                <x-lucide-plus class="w-4 h-4 text-gray-500" /> Create
                            </span>
                        </button>
                        <button wire:click="$emit('openForm')" class="btn btn-danger rounded-pill ">
                            <span class="btn-inner">
                                <x-lucide-x class="w-4 h-4 text-gray-500" /> Close
                            </span>
                        </button>
                    </div>
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
