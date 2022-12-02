<div>
    <livewire:estimate.create-estimate />
    <div x-show="!formOpen" class="row">
        <div class="col-md-6 col-sm-3 col-lg-12 ml-auto mr-auto">
            <div class="card">
                <div class="card-header">
                    <nav>
                        <div class="mb-3 nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                            <button class="nav-link align-items-center rounded-pill flex-sm-fill" id="nav-home-tab"
                                data-bs-toggle="tab" data-bs-target="#nav-home " type="button" role="tab"
                                aria-controls="nav-home" aria-selected="false">
                                Home <span class="badge bg-secondary">0</span>
                            </button>
                            <button class="nav-link align-items-center active flex-sm-fill rounded-pill"
                                id="nav-profile-tab " data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
                                role="tab" aria-controls="nav-profile" aria-selected="true">Profile <span class="badge bg-secondary">0</span></button>
                            <button class="nav-link align-items-center rounded-pill flex-sm-fill" id="nav-contact-tab "
                                data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab"
                                aria-controls="nav-contact" aria-selected="false">Contact
                                <span class="badge bg-secondary">0</span>
                            </button>
                        </div>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <p><strong>This is some placeholder content the Home tab's associated content.</strong>
                                Clicking another tab will toggle the visibility of this one for the next. The tab
                                JavaScript swaps classes to control the content visibility and styling. You can use it
                                with tabs, pills, and any other <code>.nav</code>-powered navigation.</p>
                        </div>
                        <div class="tab-pane fade active show" id="nav-profile" role="tabpanel"
                            aria-labelledby="nav-profile-tab">
                            <p><strong>This is some placeholder content the Profile tab's associated content.</strong>
                                Clicking another tab will toggle the visibility of this one for the next. The tab
                                JavaScript swaps classes to control the content visibility and styling. You can use it
                                with tabs, pills, and any other <code>.nav</code>-powered navigation.</p>
                        </div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <p><strong>This is some placeholder content the Contact tab's associated content.</strong>
                                Clicking another tab will toggle the visibility of this one for the next. The tab
                                JavaScript swaps classes to control the content visibility and styling. You can use it
                                with tabs, pills, and any other <code>.nav</code>-powered navigation.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
