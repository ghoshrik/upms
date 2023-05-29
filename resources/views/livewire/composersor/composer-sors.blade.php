<div>
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
                    @canany(['create sor', 'edit estimate'])
                        <div class="d-flex justify-content-between align-items-center rounded flex-wrap gap-3">
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
                    @endcanany
                </div>
            </div>
        </div>
        <div wire:loading.delay.long>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>
        <div>
            <div x-show="formOpen">
                @if ($isFromOpen && $openedFormType == 'create')
                    <livewire:composersor.createcomposersors />
                @elseif($isFromOpen && $openedFormType == 'edit')
                @else
                    <div class="col-md-12 col-lg-12 col-sm-3">
                        <div class="card">
                            <div class="card-header">
                                {{-- <button type="button" class="btn btn-sm btn-soft-warning px-2 py-2 notification"
                                    :wire:key="$updateDataTableTracker">
                                    <span>Pending Approval</span>
                                    <span class="badge">{{ $CountSorListPending }}</span>
                                </button> --}}

                            </div>
                            <div class="card-body">
                                <div class="table-responsive mt-4">
                                    <table id="basic-table" class="table table-striped mb-0" role="grid">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('cruds.sor.fields.id_helper') }}</th>
                                                <th>Dept Category</th>
                                                <th>SOR Item No</th>
                                                <th>Description</th>
                                                <th>{{ trans('cruds.sor.fields.unit') }}</th>
                                                <th>{{ trans('cruds.sor.fields.cost') }}</th>
                                                {{-- <th>Status</th>
                                                <th>File</th> --}}
                                                <th>{{ trans('cruds.sor.fields.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($composerSor as $lists)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $lists->getDeptCategoryName->dept_category_name }}</td>
                                                    <td>{{ $lists->ParentSORItemNo->Item_details }}</td>
                                                    <td>{{ $lists->description }} </td>
                                                    <td>{{ $lists->getUnit->unit_name }} </td>
                                                    <td>{{ $lists->rate }} </td>
                                                    <td>
                                                        <button class="btn btn-soft-primary btn-sm"
                                                            wire:click='$emit("viewModal",{{ $lists->id }})'>
                                                            <x-icon name="eye" class="w-5 h-5" />View
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                @endif
            </div>
        </div>
    </div>
    <livewire:composersor.view-model-composit-sor />
</div>
