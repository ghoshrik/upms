<div>
    <x-form-section submit='store'>
        <x-slot name='form'>
            <div class="iq-timeline0 m-0 d-flex align-items-center justify-content-between position-relative">
                <ul class="list-inline p-0 m-0 w-100">
                    <li>
                        <div class="timeline-dots1 border-primary text-primary">
                            <svg width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M19,3H5C3.89,3 3,3.89 3,5V9H5V5H19V19H5V15H3V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M10.08,15.58L11.5,17L16.5,12L11.5,7L10.08,8.41L12.67,11H3V13H12.67L10.08,15.58Z">
                                </path>
                            </svg>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-3">
                                <x-select label="Select Unit Type" placeholder="Select Unit Type" :options="['project_1', 'project_2', 'project_3', 'project_4']"
                                    wire:model.defer="project_name" />
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-3">
                                <x-textarea wire:model="description" rows="2" label="description"
                                    placeholder="Your description" />
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-3">
                                <button type="button" wire:click="addMileStep"
                                    class="btn btn-soft-success rounded-pill mt-3">Add</button>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit"
                                        class="btn btn-success rounded-pill float-right">Save</button>
                                </div>
                            </div>
                        </div>
                        <div class="iq-timeline1 m-0 d-flex align-items-center justify-content-between position-relative">
                            <ul class="list-inline p-0 m-0 w-100">

                                <li></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </x-slot>
    </x-form-section>
</div>
