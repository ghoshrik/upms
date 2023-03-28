<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    @foreach ($inputsData as $key => $inputData)
                        <div class="row mutipal-add-row">
                            <div class="col-md-11 col-sm-6 col-lg-11">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <x-select wire:key="deptCategory.{{ $key }}"
                                                label="{{ trans('cruds.sor.fields.dept_category') }}"
                                                placeholder="Select {{ trans('cruds.sor.fields.dept_category') }}"
                                                wire:model.defer="inputsData.{{ $key }}.dept_category_id">
                                                @isset($fetchDropDownData['departmentCategory'])
                                                    @foreach ($fetchDropDownData['departmentCategory'] as $category)
                                                        <x-select.option label="{{ $category['dept_category_name'] }}"
                                                            value="{{ $category['id'] }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <x-input wire:key='item_details.{{ $key }}'
                                                label="{{ trans('cruds.sor.fields.item_number') }}"
                                                placeholder="{{ trans('cruds.sor.fields.item_number') }}"
                                                wire:model.defer="inputsData.{{ $key }}.item_details"
                                                placeholder="12.34" />
                                            <!--only maskable 12 number -->
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <x-input wire:key='unit.{{ $key }}'
                                                label="{{ trans('cruds.sor.fields.unit') }}"
                                                placeholder="{{ trans('cruds.sor.fields.unit') }}"
                                                wire:model.defer="inputsData.{{ $key }}.unit" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <x-input wire:key='cost.{{ $key }}'
                                                label="{{ trans('cruds.sor.fields.cost') }}"
                                                placeholder="{{ trans('cruds.sor.fields.cost') }}"
                                                wire:model.defer="inputsData.{{ $key }}.cost" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <x-select wire:key="version.{{ $key }}"
                                                label="{{ trans('cruds.sor.fields.version') }}"
                                                placeholder="Select {{ trans('cruds.sor.fields.version') }}"
                                                wire:model.defer="inputsData.{{ $key }}.version"
                                                :options="[
                                                    ['name' => '2015-16', 'id' => '2015-16'],
                                                    ['name' => '2016-17', 'id' => '2016-17'],
                                                    ['name' => '2017-18', 'id' => '2017-18'],
                                                    ['name' => '2018-19', 'id' => '2018-19'],
                                                ]" option-label="name" option-value="id" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <x-datetime-picker without-time wire:key="effect_from.{{ $key }}"
                                                label="{{ trans('cruds.sor.fields.effect_from') }}"
                                                placeholder="{{ trans('cruds.sor.fields.effect_from') }}"
                                                wire:model.defer="inputsData.{{ $key }}.effect_from"
                                                min="{{ now() }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <x-textarea rows="2" wire:key="description.{{ $key }}"
                                                wire:model="inputsData.{{ $key }}.description"
                                                label="{{ trans('cruds.sor.fields.description') }}"
                                                placeholder="{{ trans('cruds.sor.fields.description') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {{-- <x-media-library-attachment name="myUpload" /> --}}
                                            {{-- <label>File Upload</label>
                                            <input type="file" wire:key="file_upload.{{ $key }}"
                                                wire:model="inputsData.{{ $key }}.file_upload"
                                                class="form-control" multiple accept=".pdf" />
                                            @error('inputsData.{{ $key }}.file_upload')
                                                {{ $message }}
                                            @enderror --}}
                                            <div>
                                                <div class="relative rounded-md shadow-sm">
                                                    <x-input type="file"
                                                        wire:model="inputsData.{{ $key }}.file_upload"
                                                        label="Choose file" autocomplete="off" multiple accept=".pdf"
                                                        class="placeholder-secondary-400 dark:bg-secondary-800 dark:text-secondary-400 dark:placeholder-secondary-500 border border-secondary-300 focus:ring-primary-500 focus:border-primary-500 dark:border-secondary-600 form-input block w-full sm:text-sm rounded-md transition ease-in-out duration-100 focus:outline-none shadow-sm" />
                                                    {{-- @error('InputStore.photo')
                                                        <span class="error" style="color: red;">{{ $message }}</span>
                                                    @enderror --}}
                                                </div>
                                                <div wire:loading
                                                    wire:target="inputsData.{{ $key }}.file_upload">
                                                    Uploading...</div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 col-sm-6 col-lg-1 d-flex align-items-center">
                                <div class="col-md-12">
                                    <button wire:click="removeRow({{ $key }})"
                                        class="btn btn-danger rounded-pill btn-ms"
                                        {{ count($inputsData) < 2 ? 'disabled' : '' }}>
                                        <span class="btn-inner">
                                            <x-lucide-trash-2 class="w-4 h-4 text-denger-500" />
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <button wire:click="addNewRow" class="btn btn-primary rounded-pill btn-ms mutipal-row-add-button">
                        <span class="btn-inner">
                            <x-lucide-plus class="w-4 h-4 text-denger-500" />
                        </span>
                    </button>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12"><button type="submit" wire:click='store'
                                    class="btn btn-success rounded-pill float-right">Save</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
