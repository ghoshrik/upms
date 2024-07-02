<div>
    {{-- Do your work, then step back. --}}

    {{-- @if (count($allUsers) > 0)
        <div wire:loading.delay.long.class="loading">
            <div x-transition.duration.900ms>
                <x-cards title="">
                    <x-slot name="table">
                        <div class="table-responsive mt-4">
                            <table id="basic-table" class="table table-striped mb-0" role="grid">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name of the HOO</th>
                                        <th scope="col">Designation</th>
                                        <th scope="col">Mobile No</th>
                                        <th scope="col">Mail ID</th>
                                        <th scope="col">Active/Inactive flag</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allUsers as $list)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>{{ $list->emp_name }}</td>
                                            <td>{{ $list->designation_id ? $list->designation->designation_name : '' }}
                                            </td>
                                            <td>{{ $list->mobile }}</td>
                                            <td>{{ $list->email }}</td>
                                            <td>
                                                <input type="checkbox" />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <center class="mt-5">
                            {{ $allUsers->links('vendor.pagination.bootstrap-4') }}
                        </center>
                    </x-slot>
                </x-cards>
            </div>
        </div>
    @else
    @endif --}}

    {{-- // if ($user->office_id == null) {
        //     return '<button class="btn btn-primary cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm btn-sm" type="button" wire:click="SelectedActive(' . $user->id . ',' . $user->officeId . ')">Save</button>';
        // } else {
        //     return '<label wire:click="SelectedModify(' . $user->id . ',' . $user->officeId . ')" class="badge badge-pill bg-danger cursor-pointer">Modify</label>';
        //     // return '<label wire:click="$emit(openModal)" class="badge badge-pill bg-danger cursor-pointer">Modify</label>';
        //     // return
        // }
     --}}
     @if($userOffice==null)
        <button class="btn btn-primary cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm btn-sm" type="button" wire:click="SelectedActive({{$userId}},{{$officeId}})">Save</button>
     @else
        {{-- <button wire:click="$emit('openModal', {{ $userId }})">Open Modal</button> --}}
        <label wire:click="$emit('openModal')" class="badge badge-pill bg-warning cursor-pointer">Modify</label>
     @endif

    {{-- <div x-data="{ showModal: false }" x-on:open-modal.window="showModal = true"> --}}
        <!-- Pop-up modal markup here -->
        <x-modal wire:model.defer="modelOpen">
        <x-card title="Consent Terms">
            <p class="text-gray-600">
               {{$userId}} | {{$officeId}}
            </p>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button primary wire:click="accept" label="I Agree" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>
    {{-- </div> --}}



</div>
