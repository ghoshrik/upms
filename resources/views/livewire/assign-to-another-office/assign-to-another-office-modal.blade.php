<x-modal  wire:model.defer="openAssignModal">
    <x-card fullscreen title="Select Office">
        <div class="card">
            <div wire:loading.delay.longest>
                <div class="spinner-border text-primary loader-position" role="status"></div>
            </div>
            <div wire:loading.delay.longest.class="loading" class="card-body">
                <div class="row">
                    <div class="col col-md-5 col-lg-5 col-sm-12 col-xs-12 mb-2">
                        <div class="form-group">
                            <x-select wire:key='dist' label="Select District" placeholder="Select District"
                                wire:model.defer="selectedDist">
                                @isset($dropdownData['dist'])
                                    @foreach ($dropdownData['dist'] as $dist)
                                        <x-select.option label="{{ $dist['district_name'] }}"
                                            value="{{ $dist['district_code'] }}" :key="'district-' . $dist['district_code']" />
                                    @endforeach
                                @endisset
                            </x-select>
                        </div>
                    </div>
                    <div class="col col-md-5 col-lg-5 col-sm-12 col-xs-12 mb-2">
                        <div class="form-group">
                            <x-select wire:key='level' label="Select Office Level" placeholder="Select Office Level"
                                wire:model.defer="selectedLevel">
                                <x-select.option :key="1" label="L1 Level" value="1" />
                                <x-select.option :key="2" label="L2 Level" value="2" />
                                <x-select.option :key="3" label="L3 Level" value="3" />
                                <x-select.option :key="4" label="L4 Level" value="4" />
                                <x-select.option :key="5" label="L5 Level" value="5" />
                                <x-select.option :key="6" label="L6 Level" value="6" />
                            </x-select>
                        </div>
                    </div>

                    <div class="col col-md-2 col-lg-2 col-sm-12 col-xs-12 mb-2">
                        <div class="form-group pt-4">
                            <button type="button" wire:click='filter' class="btn btn-soft-primary ">
                                Search
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @if ($filtredOffices != null)
                <div class="card" wire:loading.delay.longest.class="loading">
                    <div class="card-body p-2">
                        <div class="table-responsive mt-4">
                            <table id="basic-table" class="table table-striped mb-0" role="grid">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Office Name</th>
                                        <th scope="col">Office Code</th>
                                        <th scope="col">Office Address</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($filtredOffices)
                                        {{-- @dd($filtredOffices) --}}
                                        @foreach ($filtredOffices as $key => $office)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-wrap" style="width: 30rem">{{ $office['office_name'] }}</td>
                                                <td>
                                                    {{ $office['office_code'] }}
                                                </td>
                                                <td class="text-wrap" style="width: 30rem">{{ $office['office_address'] }}
                                                </td>
                                                <td>
                                                    <button type="button" wire:click="assign({{ $office['id'] }})"
                                                        class="btn btn-soft-primary btn-sm"
                                                        {{ $office['user_id'] ? 'disabled ' : '' }}>
                                                        Assign Admin
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-button flat label="Cancel" x-on:click="close" />
                <x-button wire:click="store" primary label="Save" />
            </div>
        </x-slot>
    </x-card>
</x-modal>
