<div>
    <div class="py-0 conatiner-fluid content-inner">
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
                </div>
            </div>
        </div>
        <div wire:loading.delay.long>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>
        <div wire:loading.delay.long.class="loading">
            @if ($isFromOpen && $openedFormType == 'create')
            <div x-transition.duration.900ms>
                <livewire:groups.create-group />
            </div>
            @else
            <div x-transition.duration.900ms>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <table border="1" cellpadding="5" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Slno</th>
                                            <th>Department Name</th>
                                            <th>Department Category</th>
                                            <th>Group name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($groupLists as $key=> $group)
                                        <tr>
                                            <td>{{ $key+1}}</td>
                                            <td>{{ $group->getDeptName->department_name}}</td>
                                            <td>{{ $group->getDeptCategoryName->dept_category_name}}</td>
                                            <td>{{ $group['group_name']}}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4">
                                                no record found!
                                            </td>
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
