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
        {{-- @section('webtitle', trans('cruds.aocs.title')) --}}
        <div wire:loading.delay.shortest>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>


        <div wire:loading.delay.shortest.class="loading">
            <div x-transition.duration.900ms>
                <livewire:assign-office-admin.create-office-admin />
            </div>
        </div>

        {{-- <livewire:assign-office-admin.assign-office-list /> --}}
        {{-- @if ($openAssignAdminId) --}}

        <x-cards title="">
            <x-slot name="table">
                {{-- <livewire:assign-office-admin :openAssignAdminId="$openAssignAdminId" /> --}}
                <livewire:assign-office-admin.user-assign-model :openAssignAdminId="$openAssignAdminId" />

                {{-- <x-modal wire:model.defer="openFormModel">
                    <x-card title="Select Role">
                        <div class="col-md-12">
                            <div class="form-group">
                                asdfasd
                            </div>
                        </div>
                        <x-slot name="footer">
                            <div class="flex justify-end gap-x-4">
                                <x-button flat label="Cancel" x-on:click="close" />
                                <x-button wire:click="store" primary label="Save" />
                            </div>
                        </x-slot>
                    </x-card>
                </x-modal> --}}
            </x-slot>
        </x-cards>
        {{-- @endif --}}
    </div>
</div>
