<div>
    <!-- Navbar Header and Alert Section -->
    <div class="py-0 conatiner-fluid content-inner">
        <div class="iq-navbar-header" style="height: 124px;">
            @if ($errorMessage != null)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span>{{ $errorMessage }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <!-- Other header content -->
        </div>

        <!-- Content Section -->
        <div class="container-fluid iq-container">
            <div class="flex-wrap gap-3 mb-4 d-flex justify-content-between align-items-center">
                <!-- Form Controls -->
                <div class="d-flex flex-column">
                    <h3 class="text-dark">{{ $title }}</h3>
                    <p class="mb-0 text-primary">{{ $subTitle }}</p>
                </div>
                <div class="flex-wrap gap-3 rounded d-flex justify-content-between align-items-center">
                    @if (!$isFromOpen)
                        <button wire:click="fromEntryControl('create')" class="btn btn-primary rounded-pill"
                            x-transition:enter.duration.600ms x-transition:leave.duration.10ms>
                            <span class="btn-inner">
                                <x-lucide-plus class="w-4 h-4 text-gray-500" /> Create
                            </span>
                        </button>
                    @else
                        <button wire:click="fromEntryControl" class="btn btn-danger rounded-pill"
                            x-transition:enter.duration.100ms x-transition:leave.duration.100ms>
                            <span class="btn-inner">
                                <x-lucide-x class="w-4 h-4 text-gray-500" /> Close
                            </span>
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Conditional Form/Table Display -->
        <div wire:loading.delay.long>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>
        <div wire:loading.delay.long.class="loading">
            @if ($isFromOpen && $openedFormType == 'create')
                <div x-transition.duration.900ms>
                    <livewire:groups.create-group />
                </div>
            @elseif ($isFromOpen && $openedFormType == 'edit')
                <div x-transition.duration.900ms>
                    <livewire:groups.create-group :selectedIdForEdit="$selectedIdForEdit" />
                </div>
            @else
                <div x-transition.duration.900ms>
                    <!-- Your table or list view goes here -->
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Slno</th>
                                                <th scope="col">Department Name</th>
                                                <th scope="col">Department Category</th>
                                                <th scope="col">Group Name</th>
                                                <th scope="col" class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($groupLists as $key => $group)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $group->getDeptName->department_name }}</td>
                                                    <td>{{ $group->getDeptCategoryName->dept_category_name }}</td>
                                                    <td>{{ $group['group_name'] }}</td>
                                                    <td class="text-center">
                                                        <button wire:click="fromEntryControl({ 'formType': 'edit', 'id': {{ $group->id }} })" type="button" class="btn-soft-warning btn-sm">
                                                            <x-lucide-edit class="w-4 h-4 text-gray-500" /> Edit
                                                        </button>
                                                        <button onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="deleteRow({{ $group->id }})" type="button" class="btn btn-soft-danger btn-sm">
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
            @endif
        </div>
    </div>
</div>
