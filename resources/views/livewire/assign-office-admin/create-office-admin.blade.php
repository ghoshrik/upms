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
    <style>
        .hiddenRow {
            padding: 0 !important;
        }
    </style>
    @if ($filtredOffices != null)
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-3">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="table-responsive mt-4">
                            <table id="basic-table" class="table table-striped mb-0" role="grid">
                                <thead>
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-wrap" style="width: 30rem">{{ $office['office_name'] }}</td>
                                        <td>
                                            {{ $office['office_code'] }}
                                        </td>
                                        <td class="text-wrap" style="width: 30rem">{{ $office['office_address'] }}</td>
                                        <td>
                                            {{-- @if ($office['user_id']) --}}
                                            @foreach ($hooUsers as $user)
                                                @if ($user['id'] == $office['user_id'])
                                                    {{-- <input class="form-group" type="text"
                                                            value="{{ $user['emp_name'] }}" wire:ignore disabled> --}}
                                                    <label wire:ignore disabled readonly>{{ $user['emp_name'] }}</label>
                                                @endif
                                            @endforeach
                                            @else
                                            {{-- @else --}}
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
                                            @endif


                                        </td>
                                        <td>
                                            <button type="button"
                                                wire:click="$emit({{ $office['user_id'] ? '"Modify",' . $office['user_id'] . ',' . $office->id . ',' . $office->dist_code . ',' . $office->level_no . '' : '"assignuser",' . $office->id . ',' . $office->dist_code . ',' . $office->level_no . '' }})"
                                                class="btn btn-soft-{{ $office['user_id'] ? 'warning' : 'primary' }} btn-sm text-dark" wire:ignore>
                                                {{$office['user_id'] ? 'Modify':'Assign Admin'}}
                                            </button>

                                            {{-- @isset($office['user_id'])
                                                <button type="button" class="btn btn-soft-warning btn-sm test-dark" wire:ignore
                                                    disabled>Modify</button>
                                                @endif
                                            @else
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
                                </thead>
                                <tbody>
                                    @isset($filtredOffices)
                                        @foreach ($filtredOffices as $key => $office)
                                            @php

                                                $users = \App\Models\User::select('users.emp_name as employeeName', 'designations.designation_name as desg_name', 'users.mobile as mob', 'users.email as email_id')
                                                    ->join('designations', 'users.designation_id', '=', 'designations.id')
                                                    ->where('office_id', $office->id)
                                                    ->where('user_type', 4)
                                                    ->where('is_active', 1)
                                                    // ->where('department_id', \Auth::user()->id)
                                                    ->get();
                                                // dd($users);
                                            @endphp

                                            {{-- heading --}}
                                            <tr data-bs-toggle="collapse" data-bs-target="#collapse-{{ $loop->iteration }}"
                                                aria-expanded="true" aria-controls="collapse-{{ $loop->iteration }}"
                                                class="accordion accordion-flush">
                                                <td>
                                                    <x-icon name="eye" class="w-5 h-5" />
                                                </td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-wrap" style="width: 30rem">{{ $office['office_name'] }}</td>
                                                <td>{{ $office['office_code'] }}</td>
                                                <td class="text-wrap" style="width: 30rem">{{ $office['office_address'] }}
                                                </td>
                                                <td class="text-wrap">
                                                    {{-- @foreach ($hooUsers as $user)
                                                        @if ($user['id'] == $office['user_id']) --}}
                                                    {{ $office['user_id'] }}
                                                    {{-- @endif
                                                    @endforeach --}}
                                                </td>
                                                {{-- <td>

                                                    @if ($office['user_id'])
                                                        <button type="button"
                                                            class="btn btn-soft-primary btn-sm test-dark">Assign
                                                            Admin</button>
                                                    @endif
                                                </td> --}}
                                            </tr>
                                            <tr>
                                                <td colspan="7">
                                                    <div id="collapse-{{ $loop->iteration }}"
                                                        class="accordion-collapse collapse" aria-labelledby="headingOne"
                                                        data-bs-parent="#accordionExample">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr class="info">
                                                                    <th>NAME OF THE HOO</th>
                                                                    <th>DESIGNATION NAME</th>
                                                                    <th>MOBILE NO</th>
                                                                    <th>EMAIL ID</th>
                                                                    <th>ACTION</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($users as $user)
                                                                    <tr>
                                                                        <td>{{ $user['employeeName'] }}</td>
                                                                        <td>{{ $user['desg_name'] }}</td>
                                                                        <td>{{ $user['mob'] }} </td>
                                                                        <td>{{ $user['email_id'] ? $user['email_id'] : 'N/A' }}
                                                                        </td>
                                                                        <td>
                                                                            <button type="button"
                                                                                class="btn btn-warning btn-sm text-dark"
                                                                                wire:click="assignModify({{ $office['user_id'] . ',' . $office->id . ',' . $office->dist_code . ',' . $office->level_no }})">Modify</button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                            {{-- heading --}}
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endif
</div>
<div>
    {{-- <x-modal.card title="Users Lists" x-on:close="false" max-width="sm|md|lg|xl|2xl|6xl" blur hide-close
        wire:model.defer="openModel" data-backdrop="static" data-keyboard="false"> --}}

    {{-- <livewire:assign-office-admin.user-assign-model :openAssignAdminId="$openAssignAdminId" /> --}}

    {{-- </x-modal> --}}
    <x-modal wire:model.defer="openModel" blur>
        <x-card title="Assign Office User">
            {{-- @if (empty($modifyUsers['userList'])) --}}
            <div class="col-md-12 col-lg-12 col-sm-6">
                <div class="form-group">
                    <x-select wire:key="userModify" label="select User" placeholder="Select User"
                        wire:model.defer="listUser">
                        {{-- @dd($modifyUsers['userList']) --}}
                        @isset($modifyUsers)
                            {{-- @if (is_array($modifyUsers['userList']) || is_object($modifyUsers['userList'])) --}}
                            @foreach ($modifyUsers as $user)
                                <x-select.option label="{{ $user['emp_name'] }}" value="{{ $user['id'] }}" />
                            @endforeach
                            {{-- @else
                                {{ __('not allow') }}
                            @endif --}}
                        @endisset
                    </x-select>
                </div>
                <x-slot name="footer">
                    <div class="flex justify-end gap-x-4">
                        <x-button flat label="Cancel" x-on:click="close" />
                        <x-button wire:click="store" primary label="Save" />
                    </div>
                </x-slot>
            </div>
            {{-- @else --}}
            {{-- <label class="text-center">{{ __('No Any user Assign find') }}</label>
                @endif --}}
        </x-card>
    </x-modal>


</div>






{{-- <div class="accordion" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                aria-expanded="true" aria-controls="collapseOne">
                Accordion Item #1
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
            data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse
                plugin adds the appropriate classes that we use to style each element. These classes control the overall
                appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with
                custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go
                within the <code>.accordion-body</code>, though the transition does limit overflow.
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Accordion Item #2
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
            data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse
                plugin adds the appropriate classes that we use to style each element. These classes control the overall
                appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with
                custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go
                within the <code>.accordion-body</code>, though the transition does limit overflow.
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Accordion Item #3
            </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
            data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse
                plugin adds the appropriate classes that we use to style each element. These classes control the overall
                appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with
                custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go
                within the <code>.accordion-body</code>, though the transition does limit overflow.
            </div>
        </div>
    </div>
</div> --}}
