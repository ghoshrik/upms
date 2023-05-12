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
        </div>
        @section('webtitle', trans('cruds.settings.title'))
        <div wire:loading.delay.long>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>
        <div wire:loading.delay.long.class="loading">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link rounded active" id="nav-home-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                        aria-selected="true">Web Title</button>
                    <button class="nav-link rounded" id="nav-profile-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                        aria-selected="false">Images</button>
                    <button class="nav-link rounded" id="nav-contact-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact"
                        aria-selected="false">Upload Data</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                    tabindex="0">
                    <div class="card card-body border-0 shadow-sm rounded p-4">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <x-input label="Title" wire:model="inputField.title" class="text-dark"
                                    placeholder="Website Title" />
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <x-input label="Sub Title" class="text-dark" wire:model="inputField.subtitle"
                                    placeholder="Website Subtitle" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-3"><button type="submit" wire:click='store'
                                    class="btn btn-success rounded-pill float-right">Save</button></div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"
                    tabindex="0">
                    <div class="card card-body border-0 shadow-sm rounded p-4">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <x-input type="file" label="Logo" wire:model="inputField.logo" class="text-dark"
                                    placeholder="Website Logo" />
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <x-input type="file" label="Favicon" class="text-dark"
                                    wire:model="inputField.favicon" placeholder="Website Subtitle" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-3"><button type="submit" wire:click='store'
                                    class="btn btn-success rounded-pill float-right">Save</button></div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab"
                    tabindex="0">...C</div>
            </div>
        </div>
    </div>
</div>
