<div>
    <div class="conatiner-fluid content-inner mt-3 py-0">
        <div class="iq-navbar-header" style="height: 145px;">
            <div class="container-fluid iq-container">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
                    <div class="d-flex flex-column">
                        <h1>{{$titel}}</h1>
                        <p class="mb-0">{{$subTitel}}</p>
                    </div>
                    @canany(['create aafs-projects','edit aafs-projects'])
                    <div class="d-flex justify-content-between align-items-center rounded flex-wrap gap-3">
                        @if (!$isFromOpen)
                        <button wire:click="fromEntryControl('create')" class="btn btn-primary rounded-pill "
                            x-transition:enter.duration.600ms x-transition:leave.duration.10ms>
                            <span class="btn-inner">
                                <x-lucide-plus class="w-4 h-4 text-gray-500" /> Create
                            </span>
                        </button>
                        @else
                        <button wire:click="fromEntryControl" class="btn btn-danger rounded-pill "
                            x-transition:enter.duration.100ms x-transition:leave.duration.100ms>
                            <span class="btn-inner">
                                <x-lucide-x class="w-4 h-4 text-gray-500" /> Close
                            </span>
                        </button>
                        @endif
                    </div>
                    @endcanany
                </div>
            </div>
            <div class="iq-header-img">
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
            </div>
        </div>
         @section('webtitle',trans('cruds.aafs_project.title'))
            <div wire:loading.delay.long>
                <div class="spinner-border text-primary loader-position" role="status"></div>
            </div>
            <div wire:loading.delay.long.class="loading">
                <div x-transition.duration.900ms>
                @if($isFromOpen && $openedFormType == 'create')
                    <livewire:aafs.create-aafs-projects />
                @elseif($isFromOpen && $openedFormType == 'edit')

                @else
                <x-cards title="">
                    <x-slot name="table">
                        <livewire:data-table.aafs-data-table :wire:key="$updateDataTableTracker" />
                    </x-slot>
                </x-cards>
                @endif
            </div>
        </div>
    </div>
</div>
