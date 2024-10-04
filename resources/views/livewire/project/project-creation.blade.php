<div>
    <div class="py-0 container-fluid content-inner">
        <div class="iq-navbar-header" style="height: 124px;">
            @if ($errorMessage != null)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span> {{ $errorMessage }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="container-fluid iq-container">
                <div class="flex-wrap gap-3 mb-4 d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                        <h3 class="text-dark">{{ $title }}</h3>
                        <p class="mb-0 text-primary">{{ $subTitle }}</p>
                    </div>
                    <div class="flex-wrap gap-3 rounded d-flex justify-content-between align-items-center">
                        @if (!$isFromOpen)
                            <button wire:click="fromEntryControl('create')" class="btn btn-primary rounded-pill">
                                <span class="btn-inner">
                                    <x-lucide-plus class="w-4 h-4 text-gray-500" /> Create
                                </span>
                            </button>
                        @else
                            <button wire:click="fromEntryControl" class="btn btn-danger rounded-pill">
                                <span class="btn-inner">
                                    <x-lucide-x class="w-4 h-4 text-gray-500" /> Close
                                </span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div wire:loading.delay.long>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>
        <div wire:loading.delay.long.class="loading">
            @if ($isFromOpen && $openedFormType == 'create')
                <div>
                    <livewire:project.create-project />
                </div>
            @elseif($isFromOpen && $openedFormType == 'edit')
                <div><livewire:project.create-project :selectedIdForEdit="$selectedIdForEdit" /></div>
            @elseif($isFromOpen && $openedFormType == 'plan')
            <div>
                <livewire:project.plan.project-plan :selectedProjectId="$selectedProjectId" />
            </div>
            @elseif($isFromOpen && $openedFormType == 'plan_document')
            <div>
                <livewire:plan-documents.plan-document :selectedProjectId="$selectedProjectId" :selectedProjectPlanId="$selectedProjectPlanId" />
            </div>
            @else
                <div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Sl. No</th>
                                                <th scope="col">Project Name</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Plans</th>
                                                <th scope="col">Estimate</th>
                                                <th scope="col" class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($projectTypes as $key => $projectType)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td class="text-wrap">{{ $projectType->name }}</td>
                                                    <td class="text-wrap">{{ $projectType->site }}</td>
                                                    <td>
                                                        @php
                                                            $project_plans = $projectType->plans;
                                                        @endphp
                                                        <button wire:click="fromEntryControl({ 'formType': 'plan', 'id': {{ $projectType->id }} })" type="button"
                                                            class="btn btn-soft-primary btn-sm px-3 py-2.5 m-1 rounded">
                                                            @if (count($project_plans) > 0)
                                                                <x-lucide-eye class="w-4 h-4 text-gray-500" /> View
                                                                <span
                                                                    class="top-0 position-absolute start-100 translate-middle badge rounded-pill bg-primary">
                                                                    {{ count($project_plans) }}
                                                                    <span class="visually-hidden">unread messages</span>
                                                                </span>
                                                            @else
                                                                <x-lucide-plus class="w-4 h-4 text-gray-500" /> Add
                                                            @endif
                                                        </button>
                                                    </td>
                                                    <td>{{ count($projectType->estimates) }}</td>
                                                    <td class="text-center">
                                                        <button
                                                            wire:click="fromEntryControl({ 'formType': 'edit', 'id': {{ $projectType->id }} })"
                                                            type="button" class="btn-soft-warning btn-sm">
                                                            <x-lucide-edit class="w-4 h-4 text-gray-500" /> Edit
                                                        </button>
                                                        <button wire:click="deleteProject({{ $projectType->id }})"
                                                            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                                            class="btn btn-soft-danger btn-sm">
                                                            <x-lucide-trash-2 class="w-4 h-4 text-gray-500" /> Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">No record found!</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div>
                                        {{ $projectTypes->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
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
