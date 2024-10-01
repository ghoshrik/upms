<div>
    <div class="py-0 mt-3 conatiner-fluid content-inner">
        <div class="iq-navbar-header" style="height: 124px;">
            <div class="container-fluid iq-container">
                @if ($errorMessage != null)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span> {{ $errorMessage }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="flex-wrap gap-3 mb-4 d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                        <h3 class="text-dark">{{ $titel }}</h3>
                        <p class="mb-0 text-primary">{{ $subTitel }}</p>
                    </div>
                    {{-- @canany(['create office', 'edit office']) --}}
                    <div class="flex-wrap gap-3 rounded d-flex justify-content-between align-items-center">
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
        @section('webtitle', 'Document Type')
        <div wire:loading.delay.long>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>
        <div wire:loading.delay.long.class="loading">
            <div x-transition.duration.900ms>
                @if ($isFromOpen && $openedFormType == 'create')
                <livewire:project-document-type.create-document-type />
                @elseif($isFromOpen && $openedFormType == 'edit')
                <livewire:project-document-type.create-document-type />
                @else
                <div class="card">
                    <div class="card-body">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($DocumentTypes as $designType)
                                <tr>
                                    <td>{{ $designType->name }}</td>
                                    <td>
                                        <button
                                            wire:click="fromEntryControl({ 'formType': 'edit', 'id': {{ $designType->id }} })"
                                            type="button" class="btn-soft-warning btn-sm">
                                            <x-lucide-edit class="w-4 h-4 text-gray-500" /> Edit
                                        </button>
                                        <button onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                            wire:click="deleteDocumentType({{ $designType->id }})" type="button"
                                            class="btn btn-soft-danger btn-sm">
                                            <x-lucide-trash-2 class="w-4 h-4 text-gray-500" /> Delete
                                        </button>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($DocumentTypes->isEmpty())
                        <p class="text-center">No Design Types Found.</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
</div>
