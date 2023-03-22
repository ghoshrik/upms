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
                            {{-- <livewire:sor.data-table.sor-data-table :wire:key="$updateDataTableTracker" /> --}}
                            @if ($selectedSors)
                                <button type="button" class="btn btn-sm btn btn-soft-danger"
                                    wire:click="approvedSOR()">({{ count($selectedSors) }}) selected</button>
                            @endif
                            {{-- {{Auth::user()->department_id}} --}}
                            <div class="table-responsive mt-4">
                                <table id="basic-table" class="table table-striped mb-0" role="grid">
                                    <thead>
                                        <tr>
                                            <th>
                                            </th>
                                            <th>{{ trans('cruds.sor.fields.id_helper') }}</th>
                                            <th>{{ trans('cruds.sor.fields.item_number') }}</th>
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
                                            @php
                                                $SorId = DB::table('attach_docs')
                                                    ->where('sor_docu_id', $sors->id)
                                                    ->first();
                                                $bng_file = 'data:' . $SorId->document_mime . ';base64,' . base64_encode($SorId->attach_doc);
                                                // dd($SorId);
                                            @endphp
                                            {{-- @dd('data:application/pdf;base64'.$SorId->attach_doc); --}}
                                            <tr>
                                                <td> <input type="checkbox" value="{{ $sors->id }}"
                                                        wire:model="selectedSors" /></td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $sors->Item_details }}</td>
                                                <td>{{ $sors->getDepartmentName->department_name }}</td>
                                                <td>{{ $sors->unit }}</td>
                                                <td>{{ $sors->cost }}</td>
                                                <td>
                                                    <span
                                                        class="btn btn-{{ $sors->IsActive == '0' ? 'warning' : '' }} px-0 py-0 btn-sm">{{ $sors->IsActive == '0' ? 'pending' : '' }}</span>
                                                </td>
                                                <td>
                                                    {{-- <embed type="{{ $SorId->document_mime }}" width="100%"
                                                        height="100%"
                                                        src="data:application/pdf;base64,'.{{ $SorId->attach_doc }}.'" /> --}}

                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#approved-modal">
                                                        <x-icon name="eye" class="w-5 h-5" /> View
                                                    </button>
                                                    {{-- <a href="pdfView({{$sors->id}})">edasd</a> --}}
                                                    {{-- <x-button type="button" class="btn btn-soft-info btn-sm"
                                                        wire:click="pdfViewRow({{ $sors->id }})">
                                                        <span class="btn-inner">
                                                            <x-lucide-eye class="w-4 h-4 text-gray-500" /> View
                                                        </span>
                                                    </x-button> --}}
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-soft-info btn-sm"
                                                        wire:click="approvedSOR()">Approved</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">{{ __('No Record Found') }}</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                                <div wire:model.self id="approved-modal" class="modal" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Suported Data</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @forelse ($SorLists as $sors)
                                                    @php
                                                        $SorId = DB::table('attach_docs')
                                                            ->where('sor_docu_id', $sors->id)
                                                            ->first();
                                                        $bng_file = 'data:' . $SorId->document_mime . ';base64,' . base64_decode($SorId->attach_doc);
                                                    @endphp
                                                    <embed src="{{ $bng_file }}" type="application/pdf"
                                                        width="100%" height="600" />
                                                @endforeach

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // $(document).ready(function() {
        //     $("#approved-modal").on('hidden.bs.modal', function() {
        //         //livewire.emit('onCloseModal');
        //         $(this).modal('show');
        //     });
        // });
    </script>
</div>
