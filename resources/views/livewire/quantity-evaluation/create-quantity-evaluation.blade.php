<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                {{-- <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div> --}}
                {{-- <div wire:loading.delay.longest.class="loading" class="card-body"> --}}
                    <div class="card-body">
                    <div class="row">
                        <div class="row">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <x-select wire:key="dept" label="{{ trans('cruds.estimate.fields.dept') }}"
                                            placeholder="Select {{ trans('cruds.estimate.fields.dept') }}"
                                            wire:model.defer="estimateData.dept_id"
                                            x-on:select="$wire.getDeptEstimates()">
                                            @isset($fatchDropdownData['departments'])
                                            @foreach ($fatchDropdownData['departments'] as $department)
                                            <x-select.option label="{{ $department['department_name'] }}"
                                                value="{{ $department['id'] }}" />
                                            @endforeach
                                            @endisset
                                        </x-select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-select wire:key="estimate_no" label="{{ __('Select Estimate') }}"
                                            placeholder="Select {{ __('Estimate') }}"
                                            wire:model.defer="estimateData.estimate_no">
                                            @isset($fatchDropdownData['estimatesList'])
                                            @foreach ($fatchDropdownData['estimatesList'] as $estimate)
                                            <x-select.option
                                                label="{{ $estimate['estimate_id'].' - '.$estimate['sorMasterDesc'] }}"
                                                value="{{ $estimate['estimate_id'] }}" />
                                            @endforeach
                                            @endisset
                                        </x-select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <x-input wire:key="label" wire:model.defer="estimateData.lable"
                                        label="Lable" placeholder="Label" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    {{-- @dd($fetchDropDownData['unitMaster']); --}}
                                    <x-select wire:key="unitmaster"
                                        label="{{ trans('cruds.sor.fields.unit') }}"
                                        placeholder="Select {{ trans('cruds.sor.fields.unit') }}"
                                        wire:model.defer="estimateData.unite">
                                        @isset($unite)
                                        @foreach ($unite as $units)
                                        <x-select.option label="{{ $units['unit_name'] }}" value="{{ $units['id'] }}" />
                                        @endforeach
                                        @endisset
                                    </x-select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <x-input wire:key="other_rate" wire:model.defer="estimateData.value"
                                        label="value"
                                        placeholder="value" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group float-right">
                                    <button type="button" wire:click='addEstimate'
                                        class="{{ trans('global.add_btn_color') }}">
                                        <x-lucide-list-plus class="w-4 h-4 text-gray-500" />
                                        {{ trans('global.add_btn') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- @if ($showTableOne && $addedEstimate != null)
        <livewire:estimate.added-estimate-list :addedEstimateData="$addedEstimate" :key="1" />
        @endif
        @if (!$showTableOne && $addedEstimate != null)
        <livewire:estimate.added-estimate-list :addedEstimateData="$addedEstimate" :key="2" />
        @endif --}}
        @if ($addedEstimate != null || Session::has('addedProjectEstimateData'))
        <div x-transition.duration.500ms>
            {{--
            <livewire:estimate-project.added-estimate-project-list :addedEstimateData="$addedEstimate"
                :sorMasterDesc="$sorMasterDesc" :wire:key="$addedEstimateUpdateTrack" /> --}}
            <livewire:quantity-evaluation.add-quantity-evaluation :addedEstimateData="$addedEstimate"
            :sorMasterDesc="$sorMasterDesc" :wire:key="$addedEstimateUpdateTrack"/>
        </div>
        @endif
    </div>

</div>