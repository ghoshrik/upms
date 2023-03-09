<div>
    <div class="col-md-12 col-lg-12 col-sm-3">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive mt-4">
                    <table id="basic-table" class="table table-striped mb-0" role="grid">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Project Id</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($mileStone) > 0)
                                @foreach ($mileStone as $miles)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $miles->project_id }}</td>
                                        <td>{{ $miles->project_list->sorMasterDesc}}</td>
                                        <td>
                                            <x-button type="button" class="btn btn-soft-info btn-sm"
                                                wire:click="mileStoneRowView({{$miles->project_id}})">
                                                <span class="btn-inner" >
                                                    <x-lucide-eye class="w-4 h-4 text-gray-500" /> View
                                                </span>
                                            </x-button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="text-center">{{ trans('global.table_data_msg') }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
