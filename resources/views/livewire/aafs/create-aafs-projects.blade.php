<div>
    <x-form-section submit='store'>
        <x-slot name='form'>
            <div class="row">
                {{-- <div class="col-md-3 col-lg-3 col-sm-3 mb-2">
                    <x-select label="{{ trans('cruds.aafs_project.fields.department_id') }}"
                        placeholder="Select one {{ trans('cruds.aafs_project.fields.department_id') }}"
                        wire:model.defer="InputStore.departmentId">
                        @foreach ($departmentList as $department)
                            <x-select.option label="{{ $department['department_name'] }} "
                                value="{{ $department['id'] }}" />
                        @endforeach
                    </x-select>
                </div> --}}
                <div class="col-md-3 col-lg-3 col-sm-3 mb-2">
                    <x-select label="{{ trans('cruds.aafs_project.fields.proj_id') }}"
                        placeholder="Select one {{ trans('cruds.aafs_project.fields.proj_id') }}"
                        wire:model.defer="InputStore.projectId" x-on:select="$wire.getProjectDetails()">
                        @foreach ($projects_number as $projects)
                            <x-select.option label="{{ $projects['estimate_id'] }} "
                                value="{{ $projects['estimate_id'] }}" />
                        @endforeach
                    </x-select>
                    {{-- @dd($projects_number) --}}
                </div>
                {{-- @isset($projectDtls) --}}
                <div class="col-md-2 col-lg-2 col-sm-3 mb-2">
                    <x-input label="Status of Progress" wire:model.defer="currentStatus" placeholder="Status of Progress"
                        readonly />
                </div>
                <div class="col-md-2 col-lg-2 col-sm-3 mb-2">
                    <x-input right-icon="currency-rupee" label="Project Cost"
                        wire:model.defer="InputStore.projectAmount" placeholder="Project Cost" readonly />
                </div>

                <div class="col-md-2 col-lg-2 col-sm-3 mb-2">
                    <x-input right-icon="currency-rupee" label="Tender Cost" wire:model.defer="InputStore.tenderAmount"
                        placeholder="Project Cost" />
                </div>
                {{-- @endisset --}}

                <div class="col-md-3 col-lg-3 col-sm-3 mb-2">
                    <x-input label="AAFS Project ID(Mother project ID)" wire:model.defer='InputStore.aafsMotherId'
                        placeholder="Enter AAFS Project ID(Mother project ID)" />
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3 mb-2">
                    <x-input label="AAFS Project ID(sub project ID)" wire:model.defer='InputStore.aafsSubId'
                        placeholder="Enter AAFS Project ID(sub project ID)" />
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3 mb-2">
                    <x-input label="Project Type" wire:model.defer='InputStore.projectType' placeholder="Project Type" />
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3 mb-2">
                    <x-input label="Status as per AAFS" wire:model.defer='InputStore.status'
                        placeholder="Status as per AAFS " />
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3 mb-2">
                    <x-input label="Completion Period" wire:model.defer='InputStore.completePeriod'
                        placeholder="Completion Period " />
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3 mb-2">
                    <x-input label="UO no and Date" wire:model.defer='InputStore.unNo' placeholder="Enter UO no and Date" />
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3 mb-2">
                    <x-input label="GO no and Date" wire:model.defer='InputStore.goNo' placeholder="GO no and Date" />
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3 mb-2">
                    <x-input label="Pre AAFS Expenditure" wire:model.defer='InputStore.preaafsExp'
                        placeholder="Pre AAFS Expenditure" />
                </div>



                <div class="col-md-4 col-lg-4 col-sm-3 mb-2">
                    <x-input label="Post Expenditure Incurred" wire:model.defer='InputStore.postaafsExp'
                        placeholder="Post Expenditure Incurred" />
                </div>
                <div class="col-md-4 col-lg-4 col-sm-3 mb-2">
                    <x-input label="Fund released in CFY but Expenditure not yet incurred"
                        wire:model.defer='InputStore.Fundcty'
                        placeholder="Fund released in CFY but Expenditure not yet incurred" />
                </div>
                <div class="col-md-4 col-lg-4 col-sm-3 mb-2">
                    <x-input label="Executing Authority" wire:model.defer='InputStore.exeAuthority'
                        placeholder="Executing Authority" />
                </div>





                {{-- <div class="col-md-4 col-lg-4 col-sm-3 mb-2">
                    <x-input label="{{ trans('cruds.aafs_project.fields.Govt_id') }}" wire:model.defer='InputStore.goId'
                        placeholder="Enter {{ trans('cruds.aafs_project.fields.Govt_id') }}" />
                </div>
                <div class="col-md-4 col-lg-4 col-sm-3 mb-2">
                    <x-datetime-picker without-time label="{{ trans('cruds.aafs_project.fields.go_date') }}"
                        placeholder="{{ trans('cruds.aafs_project.fields.go_date') }}"
                        wire:model.defer="InputStore.goDate" />
                </div> --}}
                {{-- <div class="col-md-4 col-lg-4 col-sm-3 mb-2">
                    <div> --}}
                {{-- <div class="flex justify-between mb-1">
                            <label class="block text-sm font-medium text-secondary-700 dark:text-gray-400">
                                File Upload
                            </label>
                        </div> --}}
                {{-- <div class="relative rounded-md shadow-sm"> --}}
                {{-- <input type="file" autocomplete="off" wire:model='InputStore.photo'
                                class="placeholder-secondary-400 dark:bg-secondary-800 dark:text-secondary-400 dark:placeholder-secondary-500 border border-secondary-300 focus:ring-primary-500 focus:border-primary-500 dark:border-secondary-600 form-input block w-full sm:text-sm rounded-md transition ease-in-out duration-100 focus:outline-none shadow-sm"> --}}

                {{-- <x-input type="file" wire:model="InputStore.photo" label="Choose file" autocomplete="off"
                                class="placeholder-secondary-400 dark:bg-secondary-800 dark:text-secondary-400 dark:placeholder-secondary-500 border border-secondary-300 focus:ring-primary-500 focus:border-primary-500 dark:border-secondary-600 form-input block w-full sm:text-sm rounded-md transition ease-in-out duration-100 focus:outline-none shadow-sm" /> --}}
                {{-- @error('InputStore.photo')
                                <span class="error" style="color: red;">{{ $message }}</span>
                            @enderror --}}
                {{-- </div>
                        <div wire:loading wire:target="InputStore.photo">Uploading...</div>
                    </div> --}}
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit"
                        class="{{ trans('global.data_store_btn_color') }} float-right mt-3">{{ trans('global.data_save_btn') }}</button>
                </div>
            </div>
        </x-slot>
    </x-form-section>
</div>
