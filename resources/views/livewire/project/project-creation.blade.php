<div>
    <div class="py-0 container-fluid content-inner" x-data='{
        formData:{grouplists:"",officelists:""},
        selectLists:{groups:"",offices:""},
        showModal:false,
        closeModal:function()
        {
            this.showModal = false;
        },
        assignUser(id)
        {
            if (!this.showModal) {
                this.showModal = true;
                Livewire.emit("assignUserDetails",id),
                Livewire.on("GroupsLists",(data)=>{
                    this.selectLists.groups=data;
                    console.log(this.formData.grouplists);
                });
            }
        },
        fetchOffice()
        {
            if(this.formData.grouplists)
            {
                {{-- console.log(this.formData.grouplists); --}}
                Livewire.emit("officeId",this.formData.grouplists);
                Livewire.on("officeLists",(data)=>{
                    this.selectLists.office = data;
                    console.log(this.selectLists.office);
                });
            }
        },
        fetchUser()
        {
            console.log(this.formData.officelists);
        }
    }'>
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
            <div>
                <livewire:project.create-project :selectedIdForEdit="$selectedIdForEdit" />
            </div>
            @elseif($isFromOpen && $openedFormType == 'plan')
            <div>
                <livewire:project.plan.project-plan :selectedProjectId="$selectedProjectId" />
            </div>
            @elseif($isFromOpen && $openedFormType == 'plan_document')
            <div>
                <livewire:plan-documents.plan-document :selectedProjectId="$selectedProjectId"
                    :selectedProjectPlanId="$selectedProjectPlanId" />
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
                                            <th scope="col">Documents</th>
                                            <th scope="col">Estimate</th>
                                            <th scope="col" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($projectTypes as $key => $projectType)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-wrap">{{ $projectType->name }}</td>
                                            <td class="text-wrap">{{ $projectType->site }}</td>
                                            <td>
                                                @php
                                                $project_plans = $projectType->plans;
                                                @endphp
                                                <button
                                                    wire:click="fromEntryControl({ 'formType': 'plan', 'id': {{ $projectType->id }} })"
                                                    type="button"
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
                                            <td>
                                                <button
                                                    wire:click="fromEntryControl({ 'formType': 'mandocs', 'id': {{ $projectType->id }} })"
                                                    type="button"
                                                    class="btn btn-soft-primary btn-sm px-3 py-2.5 m-1 rounded">
                                                    <x-lucide-eye class="w-4 h-4 text-gray-500" /> View
                                                    <span
                                                        class="top-0 position-absolute start-100 translate-middle badge rounded-pill bg-primary">
                                                        {{$projectType->document_count}}

                                                    </span>
                                                </button>
                                            </td>
                                            <td>{{ count($projectType->estimates) }}</td>
                                            <td class="text-center">
                                                <button
                                                    wire:click="fromEntryControl({ 'formType': 'edit', 'id': {{ $projectType->id }} })"
                                                    type="button" class="btn-soft-warning btn-sm">
                                                    <x-lucide-edit class="w-4 h-4 text-gray-500" /> Edit
                                                </button>
                                                {{-- @dd($projectType->users->isNotEmpty); --}}
                                                @if($projectType->users->isNotEmpty())
                                                {{-- <x-action-button class="btn-soft-primary"
                                                    onClick="$emit('userDetails',{{$projectType->id}})">
                                                    View
                                                </x-action-button> --}}
                                                <button class="btn btn-soft-primary btn-sm" type="button"
                                                    wire:click="$emit('userDetails',{{$projectType->id}})">
                                                    <x-lucide-eye class="w-4 h-4 text-gray-500" />View
                                                </button>
                                                {{-- @foreach($projectType->users as $user)
                                                <li>{{ $user->name }}</li>
                                                <button class="btn btn-soft-primary btn-sm" type="button"
                                                    wire:click="$emit('userDetails',{{$projectType->id}})">
                                                    <x-lucide-eye class="w-4 h-4 text-gray-500" />View
                                                </button>
                                                @endforeach --}}
                                                @else
                                                <button {{-- @click="assignUser({{$projectType->id}})" --}}
                                                    wire:click="$emit('assignProjectuser',{{$projectType->id}})"
                                                    type="button" class="btn btn-soft-secondary btn-sm">
                                                    <x-lucide-user class="w-4 h-4 text-gray-500" /> Assign
                                                </button>
                                                {{-- @dd($projectuser->users) --}}
                                                @endif
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
                                    {{-- {{ $projectTypes->links() }} --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <livewire:components.modal.project.assign.users />
            <livewire:components.modal.project.assign.view-assign-user />
            @endif
        </div>
    </div>
    @if($open_man_docs_Form)

    <div class="offcanvas offcanvas-end {{ $open_man_docs_Form ? 'show' : 'mandocs' }}" tabindex="-1" id="offcanvasRight"
    aria-labelledby="offcanvasRightLabel" style="width: 470px;">
    <div class="offcanvas-header" style="background: #7f8fdc;">
        <h5 id="offcanvasRightLabel" class="text-white">Selected Mandatory Documents</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"
            wire:click="closeMandocsDrawer"></button>
    </div>
    <div class="offcanvas-body">
        @if ($mandetory_docs_list && $mandetory_docs_list->isNotEmpty())
            <ul class="list-group">
                @foreach ($mandetory_docs_list as $doc)
                    <li class="p-2 border border-gray-300 rounded-md">
                        <label class="flex items-center justify-between space-x-2">
                            <span>
                                {{ $doc->name }}
                                @if ($doc->uploaded_count > 0)
                                    <span class="text-success">({{ $doc->uploaded_count }} uploaded)</span>
                                @else
                                    <span class="text-danger">(No uploads)</span>
                                @endif
                            </span>
                            @if(in_array($doc->id, $selectedDocsIds))
                                <input type="checkbox" checked disabled class="text-green-500 form-checkbox">
                            @endif
                        </label>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No mandatory documents available.</p>
        @endif
    </div>


</div>
</div>

@endif
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
