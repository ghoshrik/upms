<x-app-layout>
    <div class="conatiner-fluid content-inner py-0 mt-5">
        <div class="iq-navbar-header" style="height: 124px;">
            {{-- alert message start --}}
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span> {{-- message show --}}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            {{-- alert message end --}}
            <div class="container-fluid iq-container">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
                    <div class="d-flex flex-column">
                        <h2 class="text-dark">{{ $title }}</h2>
                        <p class="text-primary mb-0">{{ $subTitle }}</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center rounded flex-wrap gap-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-danger rounded-pill "
                            x-transition:enter.duration.100ms x-transition:leave.duration.100ms>
                            <span class="btn-inner">
                                <x-lucide-x class="w-4 h-4 text-gray-500" /> Close
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <livewire:profile.auth-password :title="$title" :subTitle="$subTitle" />
    </div>
</x-app-layout>
