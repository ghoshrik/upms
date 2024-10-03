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
                        <x-cards title="" :wire:key="$updateDataTableTracker">
                            <x-slot name="table">
                                <div>
                                    <div class="table-responsive mt-4">
                                        <table id="basic-table" class="table table-striped mb-0" role="grid">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Upload</th>
                                                    <th>File Size</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($documents as $standredDocument)
                                                    <tr>
                                                        <td>{{ $standredDocument->title }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($standredDocument->created_at)->format('d/m/Y H:i A') }}
                                                        </td>
                                                        <td>{{ $standredDocument->formatFileSize() }}
                                                        </td>
                                                        <td>
                                                            <x-action-button class="btn-soft-danger"
                                                                onClick="deleteDocument({{ $standredDocument->id }})"
                                                                icon="trash">
                                                                Delete
                                                            </x-action-button>
                                                            <button type="button"
                                                                onclick="openPdf('{{ $standredDocument->upload_file }}')"
                                                                class="btn btn-soft-primary btn-sm px-3 py-2.5">
                                                                <x-lucide-eye class="w-4 h-4 text-gray-500" />
                                                                View
                                                            </button>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                            </x-slot>
                        </x-cards>
                    </div>
                    <script>
                        function openPdf(base64Data) {
                            const trimmedData = base64Data.trim();
                            const base64String = `data:application/pdf;base64,${trimmedData}`;
                            const newTab = window.open();
                            newTab.document.body.innerHTML =
                                `<iframe src="${base64String}" frameborder="0" style="width:100%; height:100%;"></iframe>`;
                            // window.open(base64String, '_blank');
                            // window.location.reload();
                        }
                    </script>
                @endif
            </div>
        </div>
    </div>
</div>
