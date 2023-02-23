<div>
    <x-form-section submit='store'>
        <x-slot name='form'>
            <div class="row">
                <div class="col-md-4 col-lg-4 col-sm-3 mb-2">
                        <x-select label="{{ trans('cruds.aafs_project.fields.proj_id') }}" placeholder="Select one {{ trans('cruds.aafs_project.fields.proj_id') }}" wire:model.defer="projectId">

                        @foreach ($projects_number as $projects)
                            <x-select.option label="{{ $projects['estimate_id'] }}" value="{{ $projects['estimate_id'] }}" />
                        @endforeach
                    </x-select>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-3 mb-2">
                    <x-input label="{{ trans('cruds.aafs_project.fields.Govt_id') }}" wire:model='goId'
                        placeholder="Enter {{ trans('cruds.aafs_project.fields.Govt_id') }}" />
                </div>
                <div class="col-md-4 col-lg-4 col-sm-3 mb-2">
                    <x-datetime-picker without-time
                        label="{{ trans('cruds.aafs_project.fields.go_date') }}"
                        placeholder="{{ trans('cruds.aafs_project.fields.go_date') }}"
                        wire:model.defer="goDate"
                    />
                </div>
                <div class="col-md-4 col-lg-4 col-sm-3 mb-2">
                    <div>
                        <div class="flex justify-between mb-1">
                            <label class="block text-sm font-medium text-secondary-700 dark:text-gray-400">
                                File Upload
                            </label>
                        </div>
                        <div class="relative rounded-md shadow-sm">
                            <input type="file" autocomplete="off" wire:model='photo'
                                class="placeholder-secondary-400 dark:bg-secondary-800 dark:text-secondary-400 dark:placeholder-secondary-500 border border-secondary-300 focus:ring-primary-500 focus:border-primary-500 dark:border-secondary-600 form-input block w-full sm:text-sm rounded-md transition ease-in-out duration-100 focus:outline-none shadow-sm">

                        </div>
                        <div wire:loading wire:target="photo">Uploading...</div>
                        @error('photo') <span class="error" style="color: red;">{{ $message }}</span> @enderror
                    </div>
                </div>
                {{-- @if ($photo)
                    Photo Preview:
                    <img src="{{ $photo->temporaryUrl() }}">
                @endif --}}

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
