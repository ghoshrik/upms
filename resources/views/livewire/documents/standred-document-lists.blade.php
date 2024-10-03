<div>
    <div class="conatiner-fluid content-inner py-0 mt-3">
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
                        <h3 class="text-dark">{{ $title }}</h3>
                        <p class="text-primary mb-0">{{ $subTitle }}</p>
                    </div>
                    {{-- @canany(['create designation', 'edit designation']) --}}
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
                    {{-- @endcanany --}}
                </div>
            </div>
        </div>


        @section('webtitle', 'Standred Documents')

        <div wire:loading.delay.long>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>
        <div wire:loading.delay.long.class="loading">
            <div x-transition.duration.900ms>
                @if ($isFromOpen && $openedFormType == 'create')
                    {{-- <livewire:designation.create-designation /> --}}
                    <livewire:documents.create-standred-documents />
                @elseif ($isFromOpen && $openedFormType == 'edit')
                    {{-- <livewire:designation.edit-designation /> --}}
                @else
                    <div>
                        <x-cards title="">
                            <x-slot name="table">
                                <div>
                                    <div class="table-responsive mt-4">
                                        <table id="basic-table" class="table table-striped mb-0" role="grid">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($documents as $standredDocument)
                                                    <tr>
                                                        <td>{{ $standredDocument->title }}</td>
                                                        <td>
                                                            {{-- <x-view :id="{{ $standredDocument->id }}" /> --}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                            </x-slot>
                        </x-cards>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
