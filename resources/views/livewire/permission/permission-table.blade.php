<div>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive mt-4">
                <table id="basic-table" class="table table-striped mb-0" role="grid">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Permission Name</th>
                            <th>created On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permisssions as $key => $permisssion)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{$key+1}}
                                </div>
                            </td>
                            <td>
                                <div class="text-primary">{{$permisssion->name}}</div>
                            </td>
                            <td>
                                <div class="text-primary">{{$permisssion->created_at}}</div>
                            </td>
                            <td>
	                              {{--  <x-button icon="pencil" primary label="Edit" /> --}}
				<x-edit-button wire:click="edit({{ $permisssion->id }})" id action/>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div> 
    </div>{{ $permisssions->links() }}
</div>