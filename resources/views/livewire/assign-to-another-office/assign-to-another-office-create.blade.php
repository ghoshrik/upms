<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                @isset($dropDownData['designations'])
                                    <x-select label="Designation"
                                        placeholder="{{ trans('cruds.access-manager.fields.designation') }}"
                                        wire:model.defer="newAccessData.designation_id">
                                        @foreach ($dropDownData['designations'] as $designation)
                                            <x-select.option label="{{ $designation['designation_name'] }}"
                                                value="{{ $designation['id'] }}" />
                                        @endforeach
                                    </x-select>
                                @endisset
                            </div>
                        </div>
                        <div class="col col-md-2 col-lg-2 col-sm-12 col-xs-12 mb-2">
                            <div class="form-group pt-4">
                                <button type="button" wire:click='getUsers' class="btn btn-soft-primary ">
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @isset($dropDownData['users'])
        <div class="card" wire:loading.delay.longest.class="loading">
            <div class="card-body p-2">
                <div class="table-responsive mt-4">
                    <table id="basic-table" class="table table-striped mb-0" role="grid">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">EMP NAME</th>
                                <th scope="col">EMP ID</th>
                                <th scope="col">DESIGNATION</th>
                                <th scope="col">OFFICE</th>
                                <th scope="col">MOBILE</th>
                                <th scope="col">MAIL</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($dropDownData['users'])
                                {{-- @dd($dropDownData['users']) --}}
                                @foreach ($dropDownData['users'] as $key => $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-wrap" style="width: 30rem">{{ $user['emp_name'] }}</td>
                                        <td class="text-wrap" style="width: 30rem">{{ $user['ehrms_id'] }}</td>
                                        <td class="text-wrap" style="width: 30rem">
                                            {{ $user['designation_id'] }}
                                        </td>
                                        <td class="text-wrap" style="width: 30rem">
                                            {{ $user['office_id'] }}
                                        </td>
                                        <td class="text-wrap" style="width: 30rem">
                                            {{ $user['mobile'] }}
                                        </td>
                                        <td class="text-wrap" style="width: 30rem">
                                            {{ $user['email'] }}
                                        </td>
                                        <td>
                                            <button type="button" wire:click="assignOffice({{ $user['id'] }})"
                                                class="btn btn-soft-primary btn-sm">
                                                Assign Office
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
    @endisset
    <div>
        <livewire:assign-to-another-office.assign-to-another-office-modal>
    </div>
</div>
