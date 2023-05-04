<div>
    <div class="card-body p-2">
        <div class="table-responsive mt-4">
            <table id="basic-table" class="table table-striped mb-0" role="grid">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Department Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departments as $key => $department)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $department['department_name'] }}</td>
                            <td width="40%">
                                <div class="row">
                                    <div class="col-8">
                                        <select wire:key='select-{{$key}}' {{ ($department['user_id'])?'disabled wire:ignore'  :'' }}  class="form-select" aria-label="Default select example" wire:model='selectedUser.{{$department['id']}}'>
                                            <option wire:key='select_option-{{$key}}'selected>Select HOD</option>
                                            @foreach ($hodUsers as $user)
                                                <option wire:key='user-{{$user['id']}}' {{ ($user['department_id']==$department['id'])? 'selected':'' }} value="{{ $user['id']}}" >{{ $user['emp_name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <button {{ ($department['user_id'])?'disabled wire:ignore':'' }} wire:click="assign({{$department['id']}})" type="button" class="btn btn-soft-primary btn-sm">
                                            Assign Admin
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
