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
                                {{-- <x-select label="Select Unit Type" placeholder="Select Unit Type"
                                :options="['project_1', 'project_2', 'project_3', 'project_4']"
                                    wire:model.defer="project_name" /> --}}

                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-3">
                                <x-textarea wire:model="description" rows="2" label="description"
                                    placeholder="Your description" />
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-3">
                                <button type="button" wire:click="addMileStep"
                                    class="btn btn-soft-success rounded-pill mt-3">Add</button>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-6">
                                <div class="iq-timeline1 m-0 d-flex align-items-center justify-content-between position-relative">
                                    <ul class="list-inline p-0 m-0 w-100 mt-2 mb-2 ml-2">
                                        @foreach($inputsData as $key => $inputData)
                                        <li>
                                            <div class="row">
                                                <div class="col-md-2 col-lg-2 col-sm-3">
                                                    <x-input label="milestone_1" wire:key="inputsData.{{$key}}.milestone_1" wire:model="inputsData.{{$key}}.milestone_1" placeholder="your Milestone_1{{$key}}" />
                                                </div>
                                                <div class="col-md-3 col-lg-3 col-sm-3">
                                                    <x-input label="milestone_2" wire:key="inputsData.{{$key}}.milestone_2" wire:model="inputsData.{{$key}}.milestone_2" placeholder="your Milestone_2{{$key}}" />
                                                </div>
                                                <div class="col-md-2 col-lg-2 col-sm-3">
                                                    <x-input label="milestone_3" wire:key="inputsData.{{$key}}.milestone_3" wire:model="inputsData.{{$key}}.milestone_3" placeholder="your Milestone_3{{$key}}" />
                                                </div>
                                                <div class="col-md-3 col-lg-3 col-sm-3">
                                                    <x-input label="milestone_4" wire:key="inputsData.{{$key}}.milestone_4" wire:model="inputsData.{{$key}}.milestone_4" placeholder="your Milestone_4{{$key}}" />
                                                </div>
                                                <div class="col-md-2 col-lg-2 col-sm-3">
                                                    <div class="row">
                                                        <div class="col-md-8 col-lg-8 col-sm-6">
                                                            <button type="button" wire:click="addSubMileStep({{$key}})"
                                                                class="btn btn-soft-success rounded-pill mt-3 w-100">Add Sub</button>
                                                        </div>
                                                        <div class="col-md-2 col-lg-2 col-sm-6">
                                                            <button type="button" wire:click="removeMileStep({{$key}})"
                                            class="btn btn-soft-danger rounded-pill mt-3 {{ count($inputData) < 2 ? 'disabled' : '' }}">
                                            <x-lucide-trash-2 class="w-4 h-4 text-denger-500" /></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @foreach($InputSubData as $Index => $inputsubData)
                                            <div class="row">
                                                <div class="col-md-12 col-lg-12 col-sm-6">
                                                    <div class="iq-timeline1 m-0 d-flex align-items-center justify-content-between position-relative">
                                                        <ul class="list-inline p-0 m-0 w-100 mt-2 mb-2 ml-2">
                                                            <li>
                                                                <div class="row">
                                                                    <div class="col-md-2 col-lg-2 col-sm-3">
                                                                        <x-input label="milestone_4" wire:key="milestone_4.{{$Index}}" wire:model="milestone_4.{{$inputsubData}}" placeholder="your Milestone_1{{$Index}}" />
                                                                    </div>
                                                                    <div class="col-md-3 col-lg-3 col-sm-3">
                                                                        <x-input label="milestone_5" wire:key="milestone_5.{{$Index}}" wire:model="milestone_5.{{$inputsubData}}" placeholder="your Milestone_1{{$Index}}" />
                                                                    </div>
                                                                    <div class="col-md-2 col-lg-2 col-sm-3">
                                                                        <x-input label="milestone_6" wire:key="milestone_6.{{$Index}}" wire:model="milestone_6.{{$inputsubData}}" placeholder="your Milestone_1{{$Index}}" />
                                                                    </div>
                                                                    <div class="col-md-3 col-lg-3 col-sm-3">
                                                                        <x-input label="milestone_7" wire:key="milestone_7.{{$Index}}" wire:model="milestone_7.{{$inputsubData}}" placeholder="your Milestone_1{{$Index}}" />
                                                                    </div>
                                                                    <div class="col-md-2 col-lg-2 col-sm-3">
                                                                        <div class="row">
                                                                            <div class="col-md-8 col-lg-8 col-sm-6">
                                                                                <button type="button" wire:click="addSubMileStep({{$Index}})"
                                                                                    class="btn btn-soft-success rounded-pill mt-3 w-100">Add Sub</button>
                                                                            </div>
                                                                            <div class="col-md-2 col-lg-2 col-sm-6">
                                                                                <button type="button" wire:click="removeSubMileStep({{$key.' '.$Index}})"
                                                                class="btn btn-soft-danger rounded-pill mt-3 {{ count($inputsubData) < 2 ? 'disabled' : '' }}">
                                                                <x-lucide-trash-2 class="w-4 h-4 text-denger-500" /></button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit"
                                    class="btn btn-success rounded-pill float-right">Save</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </x-slot>
    </x-form-section>
</div>
