<div>
    <div class="conatiner-fluid content-inner py-0 mt-2">
        <div class="iq-navbar-header" style="height: 100px;">
            {{-- alert message start --}}
            @if ($errorMessage != null)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span>{{ $errorMessage }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            {{-- alert message end --}}
            <div class="container-fluid iq-container">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
                    <div class="d-flex flex-column">
                        <h2 class="text-dark">{{ $title }}</h2>
                        <p class="text-primary mb-0">{{ $subTitle }}</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center rounded flex-wrap gap-3">
                        <a href="{{ route('dashboard') }}" class="btn btn-danger rounded-pill "
                            x-transition:enter.duration.100ms x-transition:leave.duration.100ms>
                            <span class="btn-inner">
                                <x-lucide-x class="w-4 h-4 text-gray-500" /> Close
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div wire:loading.delay.long.class="loading">
            <div x-transition.duration.900ms>
                <div class="col-md-7 offset-md-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center justify-content-between">
                                <div class="d-flex flex-wrap align-items-center">
                                    <div
                                        class="profile-img position-relative me-3 mb-3 mb-lg-0 profile-logo profile-logo1">
                                        <img src="{{ asset('images/avatars/profile.png') }}" alt="User-Profile"
                                            style='height:150px;width:150px;border-radius:50%;border:1px solid blue;'
                                            class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded">
                                    </div>
                                    <div class="d-flex flex-wrap align-items-center mb-3 mb-sm-0">
                                        <h4 class="me-2 h4">{{ Auth::user()->emp_name ?? '' }}</h4>
                                        <span> -
                                            <sub>
                                                <strong>{{ Auth::user()->getDesignationName?->designation_name ?? '' }}</strong>
                                            </sub>
                                            <sub>
                                                {{-- {{ Auth::user()->getDeptCategory?->category_name }} --}}
                                            </sub>
                                        </span>
                                    </div>
                                </div>

                                <ul class="nav nav-pills" data-toggle="slider-tab" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                            data-bs-target="#pills-home1" type="button" role="tab"
                                            aria-controls="home" aria-selected="true">Password</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                            data-bs-target="#pills-profile1" type="button" role="tab"
                                            aria-controls="profile" aria-selected="false">Profile</button>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 offset-md-2">

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="pills-home1" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <fieldset>
                                        <legend style="color: #000000">{{ $title }}</legend>

                                        {{-- <x-input wire:model.defer="formData.cur_password" label="Current Password"
                                            type="password"placeholder="Enter Perission Name" /> --}}
                                        <div class="form-group">
                                            <x-input wire:model.defer="formData.cur_password" type="password"
                                                label="Current Password" placeholder="Enter Current Password"
                                                style="color:#000000;" />
                                        </div>
                                        <div class="form-group">
                                            <x-input wire:model.defer="formData.pwd" type="password"
                                                style="color:#000000;" label=" New Password"
                                                placeholder="Enter New Password" />
                                        </div>
                                        <div class="form-group">
                                            <x-input wire:model.defer="formData.conf_pwd" style="color:#000000;"
                                                type="password" label="Confirm Password"
                                                placeholder="Enter Confirm Password" />
                                        </div>
                                    </fieldset>
                                    <x-action-button class="btn-soft-warning float-right" wire:click="updatePassword">
                                        Update
                                    </x-action-button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile1" role="tabpanel"
                            aria-labelledby="pills-profile-tab1">
                            <div class="card">
                                <div class="card-header">
                                    <div class="header-title">
                                        <h4 class="card-title">User Information</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {{-- <div class="text-center">

                                        <div class="mt-3">
                                            <h3 class="d-inline-block">{{ Auth::user()->emp_name ?? '' }}</h3>
                                            <p class="d-inline-block pl-3"> -
                                                {{ Auth::user()->getDepartmentName?->department_name }}</p>
                                            <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and
                                                typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                                text ever since the 1500s</p>
                                        </div>
                                    </div> --}}
                                    <fieldset>

                                        {{-- <x-input wire:model.defer="formData.cur_password" label="Current Password"
                                                    type="password"placeholder="Enter Perission Name" /> --}}
                                        <div class="form-group">
                                            <x-input wire:model.defer="formData.email" type="email" label="Email"
                                                style="color:#000000;" readonly />

                                        </div>
                                        <div class="form-group">
                                            <x-input wire:model.defer="formData.mobile" type="text"
                                                style="color:#000000;" label="Mobile No" />
                                        </div>
                                    </fieldset>
                                    <x-action-button class="btn-soft-warning float-right" wire:click="updateProfile">
                                        Update
                                    </x-action-button>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        Livewire.on('passwordUpdated', () => {
            setTimeout(() => {
                window.location.href = "{{ route('login') }}";
            }, 2000);
        });
    </script>


</div>
