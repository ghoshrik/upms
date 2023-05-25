<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    @section('webtitle')
        {{ __('Mis Report') }}
    @endsection


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
                    @canany(['create designation', 'edit designation'])
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
        </div>
        <div wire:loading.delay.long.class="loading">
            <x-cards title="">
                <x-slot name="table">
                    {{-- <div class="table-responsive mt-4">
                        <table id="basic-table" class="table table-striped mb-0" role="grid">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Departmernt Name</th>
                                    <th scope="col">Department Code</th>
                                    <th scope="col">Current Status</th>
                                    <th scope="col">Project No</th>
                                    <th scope="col">Project Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projectDtls as $details)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $details->department_name }}
                                        </td>
                                        <td>
                                            {{ $details->department_code }}
                                        </td>
                                        <td>
                                            {{ $details->status }}
                                        </td>
                                        <td>
                                            {{ $details->estimate_id }}
                                        </td>
                                        <td>
                                            {{ $details->sorMasterDesc }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> --}}
                    <livewire:data-table.mis-report />
                </x-slot>
            </x-cards>
        </div>
    </div>
</div>
