<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    <div class="row">
                        <div class="col col-md-6 col-lg-6 col-sm-12 col-xs-12 mb-2">
                            <div class="form-group">
                                <x-select label="Select Office Level" placeholder="Select Office Level"
                                    wire:model.defer="officeLevel" x-on:select='$wire.getOffice()'>
                                    <x-select.option label="L1 Level" value="1" />
                                    <x-select.option label="L2 Level" value="2" />
                                    <x-select.option label="L3 Level" value="3" />
                                    <x-select.option label="L4 Level" value="4" />
                                    <x-select.option label="L5 Level" value="5" />
                                    <x-select.option label="L6 Level" value="6" />
                                </x-select>
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-6 col-sm-12 col-xs-12 mb-2">
                            <div class="form-group">
                                <x-select label="Select Office" placeholder="Select Office" wire:model.defer="office_id"
                                    x-on:select='$wire.getOfficeById()'>
                                    @isset($selectedLevelAllOffices)
                                        @foreach ($selectedLevelAllOffices as $office)
                                            <x-select.option label="{{ $office['office_name'] }}"
                                                value="{{ $office['id'] }}" />
                                        @endforeach
                                    @endisset
                                </x-select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($filtredOffices!=null)
        <div class="card" wire:loading.delay.longest.class="loading">
            <div class="card-body p-2">
                <div class="table-responsive mt-4">
                    <table id="basic-table" class="table table-striped mb-0" role="grid">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Office Name</th>
                                <th>Office Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($filtredOffices)
                                @foreach ($filtredOffices as $key => $office)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $office['office_name'] }}</td>
                                        <td>address</td>
                                        <td width="40%">
                                            <div class="row">
                                                <div class="col-8">
                                                    {{-- <x-select label="Select User" placeholder="Select User"
                                                wire:model.defer="model" x-on:select=''>
                                                @isset($office['users'])
                                                    @foreach ($office['users'] as $user)
                                                        <x-select.option label="{{ $user['user_name'] }}"
                                                            value="{{ $user['id'] }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select> --}}
                                                    <select class="form-select" aria-label="Default select example">
                                                        <option selected>Select User</option>
                                                        @foreach ($office['users'] as $user)
                                                            <option value="{{ $user['id'] }}">{{ $user['user_name'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <button type="button" class="btn btn-soft-primary btn-sm">
                                                        Assign Admin
                                                    </button>
                                                </div>
                                            </div>
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
