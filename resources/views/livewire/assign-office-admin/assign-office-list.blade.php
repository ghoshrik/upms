<div>
    {{-- Do your work, then step back. --}}

    @if (count($allUsers) > 0)
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
    @endif
</div>
