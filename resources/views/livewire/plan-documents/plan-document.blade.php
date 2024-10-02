<div>
    <div>
        <div x-transition.duration.900ms>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Project Name : {{ $project->name }}</h4>
                            <h5 class="card-title">Plan : {{ $projectPlan->title }}</h5>
                            <button wire:click="addPlanDocument" type="button"
                                class="btn btn-soft-primary btn-sm px-3 py-2.5 m-1 rounded float-end">
                                <x-lucide-plus class="w-4 h-4 text-gray-500" /> Add
                            </button>
                            <div class="clearfix"></div>
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Sl. No</th>
                                        <th scope="col">Document Title</th>
                                        <th scope="col">Document Type</th>
                                        <th scope="col" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($planDocuments as $key => $planDocument)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $planDocument->title }}</td>
                                            <td>{{ $planDocument->documentType->name }}</td>
                                            <td class="text-center">
                                                <button wire:click="view({{ $planDocument->id }})" type="button"
                                                    class="btn-soft-primary btn-sm">
                                                    <x-lucide-eye class="w-4 h-4 text-gray-500" /> View
                                                    {{-- <a href="data:application/pdf;base64,{{ base64_encode($planDocument->) }}" target="_blank" id="openPdf">
                                                                View
                                                            </a> --}}
                                                </button>
                                                <button
                                                    wire:click="fromEntryControl({ 'formType': 'edit', 'id': {{ $planDocument->id }} })"
                                                    type="button" class="btn-soft-warning btn-sm">
                                                    <x-lucide-edit class="w-4 h-4 text-gray-500" /> Edit
                                                </button>
                                                <button
                                                    onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                                    wire:click="deleteProjectType({{ $planDocument->id }})"
                                                    type="button" class="btn btn-soft-danger btn-sm">
                                                    <x-lucide-trash-2 class="w-4 h-4 text-gray-500" /> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No record found!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @if ($planDocumentById)
            <button id="openPdfBtn">Open Document SOR</button>
            <iframe id="pdfFrame" title="Document SOR"
                src="data:application/pdf;base64,{{ base64_encode($planDocumentById) }}" width="100%" height="1000"
                style="display:none;"></iframe>

            <script>
                document.getElementById('openPdfBtn').onclick = function() {
                    const pdfData = "data:application/pdf;base64,{{ base64_encode($planDocumentById) }}";
                    window.open(pdfData, '_blank');
                };
            </script>
        @endif --}}
    {{-- </div> --}}
    <livewire:plan-documents.create-plan-document :project="$project" :projectPlan="$projectPlan" />
</div>
