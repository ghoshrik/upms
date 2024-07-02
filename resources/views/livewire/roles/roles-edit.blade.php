<div>
    <div>
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div wire:loading.delay.longest>
                        <div class="spinner-border text-primary loader-position" role="status"></div>
                    </div>
                    <div wire:loading.delay.longest.class="loading" class="card-body">
                        <form wire:submit.prevent="submit">
                            <div class="form-group">
                                <x-input wire:model="roleName" label="Role Name" placeholder="Enter Role Name"
                                    corner-hint="Ex: admin" />
                            </div>
                            {{--
                            <x-button type="submit" spinner primary label="Create" /> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        {{-- <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card card-block card-stretch card-height px-2 py-3">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center">Module Name</th>
                            </tr>
                            <tr>
                                <th colspan="6" class="text-center">Permissions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grouped_permissions as $key => $permissions)
                                <tr>
                                    <td>{{ $key }}</td>
                                    @foreach ($permissions as $permission)
                                        <td>
                                            <div class="form-check">
                                                <x-checkbox id="right-label"
                                                    wire:key="permissionId-{{ $permission['id'] }}"
                                                    label="{{ $permission['name'] }}"
                                                    value="{{ $permission['name'] . '' . $key }}"
                                                    wire:model="selectedPermissions" />
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12">
                <x-button wire:click="updateRole" rounded warning label="update" />
            </div>
        </div> --}}

        @foreach ($grouped_permissions as $key => $permissions)
            <div class="col-lg-3 col-md-6">
                <div class="card card-block card-stretch card-height">
                    <div class="card-body">
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <a class="badge rounded-pill bg-soft-primary" href="javascript:void(0);">
                                {{ $key }}
                            </a>
                        </div>
                        <div class="card mt-3"
                            style="max-width: 100%; width: 20rem; margin: auto; border-radius: 10px; border: 2px solid blue; position: relative;">
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($permissions as $permission)
                                        <div class="col-6">
                                            <div class="form-check">
                                                <x-checkbox id="right-label"
                                                    wire:key="permissionId-{{ $permission['id'] }}"
                                                    label="{{ $permission['name'] }}"
                                                    value="{{ $permission['name'] . '' . $key }}"
                                                    wire:model="selectedPermissions" />
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-12">
            <x-button wire:click="updateRole" rounded primary label="Save" />
        </div>
    </div>
</div>
