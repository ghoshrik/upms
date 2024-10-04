<div>
    @if ($openProjectPlan)
        <div class="offcanvas offcanvas-end {{ $openProjectPlan ? 'show' : '' }}" tabindex="-1" id="offcanvasRight"
            aria-labelledby="offcanvasRightLabel" style="width: 470px;">
            <div class="offcanvas-header" style="background: #7f8fdc;">
                <h5 id="offcanvasRightLabel" class="text-white">Project Plans & Documents</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"
                    wire:click="closeProjectPlan"></button>
            </div>
            <div class="offcanvas-body">
                <div class="row">
                    <div class="text-2xl font-semibold col-12">
                        Project Name : {{ $project->name }}
                    </div>
                </div>
                <div class="row">
                    @if ($documentTypes == '')
                        <div class="float-right col form-group">
                            <button class="py-2 m-1 rounded btn btn-soft-success btn-sm" wire:click="viewDocuments">
                                Document Type
                            </button>
                        </div>
                    @else
                        <div class="float-right col form-group">
                            <button class="py-2 m-1 rounded btn btn-soft-success btn-sm" wire:click="viewProjectPlans">
                                Project Plans
                            </button>
                        </div>
                    @endif
                </div>
                @if ($documentTypes != '')
                    <div class="mt-2 table-responsive">
                        <table id="basic-table" class="table mb-0" role="grid">
                            <thead>
                                <tr>
                                    <th>Sl. No</th>
                                    <th>Name</th>
                                    <th>Upload File</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($documentTypes as $key=> $document)
                                    <tr style="background-color: {{ $document->document_count != 0 ? '#d4edda' : '#ffe9d9' }};color: #333;">
                                        <td class="wrap-text">{{ $loop->iteration }}</td>
                                        <td class="wrap-text">{{ $document->name }}</td>
                                        <td class="wrap-text">{{ $document->document_count }}</td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr style="color: #333;">
                                    <td class="wrap-text" colspan="2">TOTAL</td>
                                    <td class="wrap-text">
                                        {{ $documentTypes->sum('document_count') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="mt-2 table-responsive">
                        <table id="basic-table" class="table mb-0 table-striped" role="grid">
                            <thead>
                                <tr>
                                    <th>Sl. No</th>
                                    <th>Name</th>
                                    <th>Documents</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($plans as $key=> $plan)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="wrap-text">{{ $plan->title }}</td>
                                        <td class="wrap-text">
                                            @php
                                                $project_plan_documents = $plan->planDocuments;
                                            @endphp
                                            @if (count($project_plan_documents) > 0)
                                                <button
                                                    class="btn btn-soft-primary btn-sm px-3 py-2.5 m-1 rounded btn-link"
                                                    onclick="toggleDocumentList({{ $plan->id }})">
                                                    <x-lucide-eye class="w-4 h-4 text-gray-500" /> View
                                                    <span
                                                        class="top-0 position-absolute start-100 translate-middle badge rounded-pill bg-primary">
                                                        {{ count($project_plan_documents) }}
                                                        <span class="visually-hidden">unread messages</span>
                                                    </span>
                                                </button>
                                            @else
                                            @endif
                                        </td>
                                    </tr>
                                    @if ($project_plan_documents != '')
                                        <tr>
                                            <td colspan="3">
                                                <div id="documents-{{ $plan->id }}" style="display:none;">
                                                    <table class="table">
                                                        <tbody>
                                                            @foreach ($project_plan_documents as $k => $document)
                                                                <tr>
                                                                    <td>{{ $k + 1 }}</td>
                                                                    <td>{{ $document->title }}</td>
                                                                    <td>{{ $document->documentType->name }}</td>
                                                                    <td>
                                                                        <button {{-- wire:click="viewPlanDocuments({{ $document->id }})" --}}
                                                                            onclick="openPdf('{{ $document->plan_document }}')"
                                                                            type="button"
                                                                            class="btn btn-soft-primary btn-sm px-3 py-2.5 m-1 rounded">
                                                                            <x-lucide-eye
                                                                                class="w-4 h-4 text-gray-500" />
                                                                            View
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <th colspan="4">
                                            No Roles Attchaed to this Sanction
                                        </th>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
<script>
    function toggleDocumentList(planId) {
        const documentList = document.getElementById('documents-' + planId);
        if (documentList.style.display === "none") {
            documentList.style.display = "table-row"; // Display as table row
        } else {
            documentList.style.display = "none"; // Hide
        }
    }

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
