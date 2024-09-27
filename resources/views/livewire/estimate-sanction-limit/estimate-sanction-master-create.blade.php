<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    @foreach ($Inputs as $key => $input)
                        <div class="mb-2 row" wire:key='{{ $key }}'>
                            {{-- <div class="col" wire:key="level_No_{{ $key }}">
                                <x-select label="Level No" placeholder="Select Level No"
                                    wire:model.defer="Inputs.{{ $key }}.level" x-on:select="$wire.getCheckLevel({{$key}})">
                                    @foreach ($levels as $level)
                                        <x-select.option label="{{ $level['level_name'] }}"
                                            value="{{ $level['id'] }}" />
                                    @endforeach
                                </x-select>
                            </div> --}}
                            {{-- <div class="col" wire:key="Role_No_{{ $key }}">
                                <x-select label="Roles" placeholder="Select Roles"
                                    wire:model.defer="Inputs.{{ $key }}.role_id" x-on:select="$wire.getCheckLevel({{$key}})">
                                    @foreach ($roles as $role)
                                        <x-select.option label="{{ $role['name'] }}"
                                            value="{{ $role['id'] }}" />
                                    @endforeach
                                </x-select>
                            </div> --}}
                            <div class="col" wire:key="project_type_id_{{ $key }}">
                                <x-select label="Project Type" placeholder="Select Project Type"
                                    wire:model.defer="Inputs.{{ $key }}.project_type_id">
                                    @foreach ($projectTypes as $projectType)
                                        <x-select.option label="{{ $projectType['title'] }}"
                                            value="{{ $projectType['id'] }}" />
                                    @endforeach
                                </x-select>
                            </div>
                            <div class="col" wire:key="min_amount_{{ $key }}">
                                <x-input label="Minimum Amount" placeholder="Min Amount"
                                    wire:model.defer="Inputs.{{ $key }}.min_amount"
                                    wire:key='min_amount_{{ $key }}' />
                            </div>
                            <div class="col" wire:key="max_amount_{{ $key }}">
                                <x-input label="Max Amount" placeholder="Max Amount"
                                    wire:model.defer="Inputs.{{ $key }}.max_amount"
                                    wire:key='max_amount_{{ $key }}' />
                            </div>
                            {{-- @if (count($Inputs) > 1)
                                <div class="col-lg-1 col-md-1 col-sm-6" wire:key="delbutton_{{ $key }}">
                                    <button type="button" class="mt-4 btn btn-soft-danger rounded-pill"
                                        wire:click='deleteMore({{ $key }})'><span class="btn-inner">
                                            <x-lucide-trash-2 class="w-4 h-4 text-gray-500" />
                                        </span></button>
                                </div>
                            @endif --}}
                        </div>
                    @endforeach
                    {{-- <div class="col-lg-2 col-md-2 col-sm-6" wire:key="button">
                        @if (count($Inputs) != count($levels))
                            <button type="button" class="mt-4 btn btn-soft-primary rounded-pill"
                                wire:click='addMore'><span class="btn-inner"><x-lucide-plus class="w-4 h-4 text-gray-500" /></span></button>
                        @endif
                    </div> --}}
                    <div class="row">
                        <div class="mt-3 col">
                            <div class="float-right form-group">
                                @if ($editSLMId != '')
                                    <button type="submit" wire:click='update'
                                        class="float-right btn btn-success rounded-pill">Update</button>
                                @else
                                    <button type="submit" wire:click='store'
                                        class="float-right btn btn-success rounded-pill">Save</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
