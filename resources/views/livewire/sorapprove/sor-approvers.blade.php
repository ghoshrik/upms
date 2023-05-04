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
                </div>
            </div>
            {{-- <div class="iq-header-img">
                <img src="{{ asset('images/dashboard/top-header.png') }}" alt="header"
                    class="theme-color-default-img  w-100  animated-scaleX">
                <img src="{{ asset('images/dashboard/top-header1.png') }}" alt="header"
                    class="theme-color-purple-img  w-100  animated-scaleX">
                <img src="{{ asset('images/dashboard/top-header2.png') }}" alt="header"
                    class="theme-color-blue-img  w-100  animated-scaleX">
                <img src="{{ asset('images/dashboard/top-header3.png') }}" alt="header"
                    class="theme-color-green-img  w-100  animated-scaleX">
                <img src="{{ asset('images/dashboard/top-header4.png') }}" alt="header"
                    class="theme-color-yellow-img  w-100  animated-scaleX">
                <img src="{{ asset('images/dashboard/top-header5.png') }}" alt="header"
                    class="theme-color-pink-img  w-100  animated-scaleX">
            </div> --}}
        </div>
        @section('webtitle', trans('cruds.sor-approver.title_singular'))
        <div wire:loading.delay.long>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>
        <div wire:loading.delay.long.class="loading" x-transition.duration.900ms>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-3 col-xs-3">
                    <div class="card">
                        <div class="card-body">
                            @if ($selectedSors)
                                <button type="button" class="btn btn-sm btn btn-soft-danger"
                                    wire:click="approvedSOR()">({{ count($selectedSors) }}) selected</button>
                            @endif
                            <div class="table-responsive mt-4">
                                <table id="basic-table" class="table table-striped mb-0" role="grid">
                                    <thead>
                                        <tr>
                                            <th>
                                            </th>
                                            <th>{{ trans('cruds.sor.fields.id_helper') }}</th>
                                            <th>{{ trans('cruds.sor.fields.item_number') }}</th>
                                            <th>Description</th>
                                            <th>{{ trans('cruds.sor.fields.department') }}</th>
                                            <th>{{ trans('cruds.sor.fields.unit') }}</th>
                                            <th>{{ trans('cruds.sor.fields.cost') }}</th>
                                            <th>Status</th>
                                            <th>File</th>
                                            <th>{{ trans('cruds.sor.fields.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($SorLists as $sors)
                                            <tr>
                                                <td>
                                                    @if ($sors->is_approved == 1)
                                                    @else
                                                        <input type="checkbox" value="{{ $sors->id }}"
                                                            wire:model="selectedSors" />
                                                    @endif
                                                </td>


                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $sors->Item_details }}</td>
                                                <td class="text-wrap" style="width: 40rem">{{ $sors->description }}</td>
                                                <td>{{ $sors->getDepartmentName->department_name }}</td>
                                                <td>{{ $sors->unit }}</td>
                                                <td>{{ $sors->cost }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-pill bg-{{ $sors->is_approved == '0' ? 'warning' : 'success' }} px-1 py-1">{{ $sors->is_approved == '0' ? 'Pending' : 'Approved' }}</span>
                                                </td>
                                                <td>
                                                    <button wire:click="generatePdf({{ $sors->id }})">
                                                        <x-icon name="download" class="w-5 h-5" />download
                                                    </button>

                                                </td>
                                                <td>
                                                    @if ($sors->is_approved == 0)
                                                        <button type="button"
                                                            class="btn btn-soft-{{ $sors->is_approved == 0 ? 'info' : '' }} btn-sm {{ $sors->is_approved == 1 ? 'disabled' : '' }}"
                                                            wire:click="approvedselectSOR({{ $sors->id }})">{{ $sors->is_approved == 0 ? 'Approve' : '' }}</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    {{ trans('global.table_data_msg') }}</td>
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
    </div>
</div>
