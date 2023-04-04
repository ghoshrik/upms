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
        <div wire:loading.delay.longest>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>
        @foreach ($grouped_permissions as $key => $permissions)
        <div wire:key="permissionOf{{ $key}}" class="col-lg-3 col-md-6">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <a class="badge rounded-pill bg-soft-primary" href="javascript:void(0);">
                            {{$key}}
                        </a>
                    </div>
                    <div class="card mt-3"
                        style="max-width: 100%; width: 20rem; margin: auto; border-radius: 10px; border: 2px solid blue; position: relative;">
                        <div class="card-body">
                            <div class="row">
                                @foreach ($permissions as $permission)
                                <div class="col-6" wire:key="permissionId-{{ $permission['id'] }}">
                                    <div class="form-check" >
                                        <x-checkbox id="permissionId-{{ $permission['id'] }}" wire:key="permissionId-{{ $permission['id'] }}"
                                            label="{{$permission['name']}}" value="{{$permission['name'].''.$key}}"
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
            <x-button wire:click="createRole" rounded primary label="Save" />
        </div>
    </div>
</div>