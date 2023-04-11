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
        {{-- @section('webtitle', trans('cruds.aocs.title')) --}}
        <div wire:loading.delay.long>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>


        <div wire:loading.delay.long.class="loading">
            <div x-transition.duration.900ms>
                <livewire:assign-office-admin.create-office-admin />
            </div>
        </div>
        @if ($viewMode)

            <div wire:loading.delay.long.class="loading">
                <div x-transition.duration.900ms>
                    {{-- <livewire:assign-office-admin.assign-admin :Assignusers="$Assignusers" /> --}}
                    <x-cards title="">
                        <x-slot name="table">
                            <div class="table-responsive mt-4">
                                <table id="basic-table" class="table table-striped mb-0" role="grid">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name of the HOO</th>
                                            <th scope="col">Designation</th>
                                            <th scope="col">Mobile No</th>
                                            <th scope="col">Mail ID</th>
                                            <th scope="col">Active/Inactive flag</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @isset($Assignusers)
                                            @foreach ($Assignusers as $list)
                                                <tr>
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td>{{ $list->emp_name }}</td>
                                                    <td>{{ $list->designation->designation_name }}</td>
                                                    <td>{{ $list->mobile }}</td>
                                                    <td>{{ $list->email }}</td>
                                                    <td>
                                                        <input type="checkbox" />
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endisset
                                    </tbody>
                                </table>
                            </div>
                        </x-slot>
                    </x-cards>
                </div>
            </div>
        @endif
    </div>
</div>
