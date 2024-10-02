<div>
    <x-modal max-width="" blur wire:model.defer="openPlanDocumentModal">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    {{-- <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div> --}}
                    <div wire:loading.delay.longest.class="loading" class="card-body">
                        <div class="mb-2 row">
                            <h4 class="card-title">Project Name : {{ $project->name }}</h4>
                            <h5 class="card-title">Project Plan : {{ $projectPlan->title }}</h5>
                        </div>
                        @foreach ($inputs as $key => $input)
                            <div class="mb-2 row" wire:key="{{ $key }}">
                                <div class="col" wire:key="title_{{ $key }}">
                                    <x-input label="Design Title" placeholder="Enter Design Title"
                                        wire:model.defer="inputs.{{ $key }}.title"
                                        wire:key='title_{{ $key }}' />
                                </div>
                                <div class="col" wire:key="design_type_id_{{ $key }}">
                                    <x-select label="Document Type" placeholder="Select Document Type"
                                        wire:model.defer="inputs.{{ $key }}.document_type_id">
                                        @foreach ($fetchDropdownData['document_types'] as $document_type)
                                            <x-select.option label="{{ $document_type['name'] }}"
                                                value="{{ $document_type['id'] }}" />
                                        @endforeach
                                    </x-select>
                                </div>
                                <div class="mt-2 col" wire:key="plan_document_{{ $key }}">
                                    <label for="dept category" style="color:#000;">Upload files<span style="color:red;">
                                            *</span></label>
                                    <input class="form-control" type="file" placeholder="file upload"
                                        wire:model.defer="inputs.{{ $key }}.plan_document"
                                        wire:loading.attr="disabled" required id="plan_document"
                                        wire:key="plan_document_{{ $key }}" />

                                    <div wire:loading wire:target="inputs.{{ $key }}.plan_document">
                                        <progress max="100" value="{{ $progress }}"></progress>
                                    </div>
                                </div>
                                @if (count($inputs) > 1)
                                <div class="col-lg-1 col-md-1 col-sm-6" wire:key="delbutton_{{ $key }}">
                                    <button type="button" class="mt-4 btn btn-soft-danger rounded-pill"
                                        wire:click='deleteRow({{ $key }})'><span class="btn-inner">
                                            <x-lucide-trash-2 class="w-4 h-4 text-gray-500" />
                                        </span></button>
                                </div>
                            @endif
                            </div>
                        @endforeach
                        <div class="col-lg-2 col-md-2 col-sm-6" wire:key="button">
                            {{-- @if (count($inputs) != count($levels)) --}}
                            <button type="button" class="mt-4 btn-sm btn-soft-primary rounded-pill"
                                wire:click='addMore'><span class="btn-inner"><x-lucide-plus
                                        class="w-4 h-4 text-gray-500" /></span></button>
                            {{-- @endif --}}
                        </div>
                        <div class="mt-2 row">
                            <div class="mt-3 col">
                                <div class="float-left form-group">
                                    <button type="submit" wire:click='closeCreatePlanDocModel'
                                        class="float-right btn btn-soft-warning rounded-pill">Close</button>
                                </div>
                                <div class="float-right form-group">
                                    {{-- @if ($editProjectTypeId != '') --}}
                                    {{-- <button type="submit" wire:click='update'
                                        class="float-right btn btn-success rounded-pill">Update</button> --}}
                                    {{-- @else --}}
                                    <button type="submit" wire:click='store'
                                        class="float-right btn btn-success rounded-pill">Save</button>
                                    {{-- @endif --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-modal>
</div>
