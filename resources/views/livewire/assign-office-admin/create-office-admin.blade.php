<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
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
                                <button type="button" wire:click="$emit('filter',[])" class="btn btn-soft-primary ">
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($filtredOffices != null)
        {{-- <livewire:assign-office-admin.office-assign-model :filterOfficeAssign="$filterOfficeAssign" /> --}}
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
                                <th scope="col">User</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @isset($filtredOffices)
                                @forelse ($filtredOffices as $key => $office)
                                    @php
                                        $assignOfficeUser = DB::table('users')
                                            ->select('emp_name')
                                            ->where('user_type', 3)
                                            ->where('id', $office->user_id)
                                            ->where('department_id', Auth::user()->department_id)
                                            ->where('is_active', 1)
                                            ->get();
                                        // echo $assignOfficeUser;
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-wrap" style="width: 30rem">{{ $office['office_name'] }}</td>
                                        <td>
                                            {{ $office['office_code'] }}
                                        </td>
                                        <td class="text-wrap" style="width: 30rem">{{ $office['office_address'] }}</td>
                                        <td>
                                            {{-- {{ $officeUser }} --}}
                                            @foreach ($assignOfficeUser as $user)
                                                <label wire:key="" wire:ignore>{{ $user->emp_name }}</label>
                                            @endforeach

                                            {{-- @if ($office['user_id']) --}}
                                            {{-- @foreach ($hooUsers as $user)
                                                @if ($user['id'] == $office['user_id']) --}}
                                            {{-- <input class="form-group" type="text"
                                                        value="{{ $user['emp_name'] }} wire:key="{{ $user['id'] }}""
                                                        wire:ignore> --}}
                                            {{-- <label wire:key="{{ $user['id'] }}"
                                                        wire:ignore>{{ $user['emp_name'] }}</label> --}}
                                            {{-- @else
                                                    {{ __('Not Exists') }} --}}
                                            {{-- @endif
                                            @endforeach --}}
                                            {{-- @else --}}
                                            {{-- {{ __('dfdsfsdf') }} --}}
                                            {{-- <select class="form-select" aria-label="Select user"
                                                    wire:key='select-{{ $key }}'
                                                    wire:model='selectedUser.{{ $office['id'] }}' wire:ignore>
                                                    <option wire:key='select_option-{{ $key }}'>Select User
                                                    </option>
                                                    @foreach ($hooUsers as $user)
                                                        <option wire:key='user-{{ $user['id'] }}'
                                                            value="{{ $user['id'] }}" wire:ignore>
                                                            {{ $user['emp_name'] }}
                                                        </option>
                                                    @endforeach
                                                </select> --}}
                                            {{-- @endif --}}


                                        </td>
                                        <td>
                                            <button type="button"
                                                wire:click="$emit({{ $office['user_id'] ? '"Modify",' . $office['user_id'] . ',' . $office->id . ',' . $office->dist_code . ',' . $office->level_no . '' : '"assignuser",' . $office->id . ',' . $office->dist_code . ',' . $office->level_no . '' }})"
                                                class="btn btn-soft-{{ $office['user_id'] ? 'warning' : 'primary' }} btn-sm text-dark"
                                                wire:loading.attr="disabled" wire:target="user-name-{{ $office->id }}"
                                                wire:model="emp_name">
                                                {{ $office['user_id'] ? 'Already Assign' : 'Assign Admin' }}
                                            </button>
                                            {{-- @isset($office['user_id']) --}}

                                            {{-- <button type="button" class="btn btn-soft-warning btn-sm text-dark"
                                                wire:click="$emit({{ $office['user_id'] ? '"Modify",' . $office['user_id'] . ',' . $office->id . ',' . $office->dist_code . ',' . $office->level_no . '' : '"assignuser",' . $office->id . ',' . $office->dist_code . ',' . $office->level_no . '' }})"
                                                {{ $office['user_id'] ? 'disabled' : '' }} wire:ignore>Re-Assign</button>


                                            <button type="button" class="btn btn-soft-primary btn-sm text-dark"
                                                wire:click="$emit('assignuser',{{ $office->id . ',' . $office->dist_code . ',' . $office->level_no }})"
                                                {{ $office['user_id'] == 0 ? '' : 'disabled' }} wire:ignore>Assign
                                                Admin</button> --}}

                                            {{-- @if ($office['user_id'])
                                                <button type="button" class="btn btn-soft-warning btn-sm test-dark"
                                                    wire:click="$emit('assignuser',{{ $office->id . ',' . $office->dist_code . ',' . $office->level_no }})"
                                                    {{ $office['user_id'] == 0 ? '' : 'disabled' }} wire:ignore
                                                    disabled>Modify</button>
                                            @endif --}}
                                            {{-- @else
                                                <button type="button"
                                                    wire:click="$emit('assignuser',{{ $office->id . ',' . $office->dist_code . ',' . $office->level_no }})"
                                                    class="btn btn-soft-primary btn-sm">
                                                    Assign Admin
                                                </button>
                                            @endisset --}}
                                            {{-- <button type="button" class="btn btn-soft-warning btn-sm"
                                                wire:click="assignuser({{ $office['id'] }})">
                                                <x-lucide-user-check class="w-4 h-4 text-gray-500" />
                                            </button> --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">{{ trans('global.table_data_msg') }}</td>
                                    </tr>
                                @endforelse
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
<div>
    <x-modal.card title="Users Lists" x-on:close="false" max-width="sm|md|lg|xl|2xl|6xl" blur
        wire:click.away="hideElement" hide-close wire:model.defer="openModel" data-backdrop="static"
        data-keyboard="false" wire:click="hideModal">

        <livewire:assign-office-admin.user-assign-model :openAssignAdminId="$openAssignAdminId" />

        </x-modal>

</div>
