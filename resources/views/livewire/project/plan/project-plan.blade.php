<div>
    {{-- <div wire:loading.delay.long>
        <div class="spinner-border text-primary loader-position" role="status"></div>
    </div> --}}
    <div wire:loading.delay.long.class="loading">
        <div>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->name }}</h5>
                            <button wire:click="addPlan" type="button"
                                class="btn btn-soft-primary btn-sm px-3 py-2.5 m-1 rounded float-end">
                                <x-lucide-plus class="w-4 h-4 text-gray-500" /> Add
                            </button>
                            <div class="clearfix"></div>
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Sl. No</th>
                                        <th scope="col">Plan Name</th>
                                        <th scope="col">Plan Documents</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($projectPlans as $key => $projectPlan)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td class="wrap-text">{{ $projectPlan->title }}</td>
                                            <td class="wrap-text">
                                                @php
                                                    $project_plan_documents = $projectPlan->planDocuments;
                                                @endphp
                                                <button
                                                    wire:click="addPlanDocument({{ $projectPlan->id }})"
                                                    type="button"
                                                    class="btn btn-soft-primary btn-sm px-3 py-2.5 m-1 rounded">
                                                    @if (count($project_plan_documents) > 0)
                                                        <x-lucide-eye class="w-4 h-4 text-gray-500" /> View
                                                        <span
                                                            class="top-0 position-absolute start-100 translate-middle badge rounded-pill bg-primary">
                                                            {{ count($project_plan_documents) }}
                                                            <span class="visually-hidden">unread messages</span>
                                                        </span>
                                                    @else
                                                        <x-lucide-plus class="w-4 h-4 text-gray-500" /> Add
                                                    @endif
                                                </button>
                                            </td>
                                            <td class="wrap-text"></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No record found!</td>
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
    <livewire:project.plan.create-project-plan :project="$project" />
</div>
