<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-input wire:model="newMenuData.title" label="Label" placeholder="Enter Menu Label" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <x-select label="Type" placeholder="Select Menu Type" :options="['Route']"
                                    wire:model.defer="newMenuData.link_type" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-input wire:model="newMenuData.link" label="Link" placeholder="Enter menu Url" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-select label="Parent" placeholder="Select Menu Parent"
                                    wire:model.defer="newMenuData.parent_id">
                                    @isset($dropDownData['menus'])
                                    @foreach ($dropDownData['menus'] as $menu)
                                    <x-select.option label="{{ $menu['title'] }}" value="{{ $menu['id'] }}" />
                                    @endforeach
                                    @endisset
                                </x-select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-input wire:model="newMenuData.icon" label="Icon" placeholder="Enter Icon Name" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <x-select label="Type" placeholder="Select Menu Type"
                                x-on:select="$wire.getDropdownData($event.target)"
                                    :options="[
                                        ['name'=>'Role','value'=>'role'],
                                        ['name'=>'Permission','value'=>'permission']
                                    ]"
                                    option-label="name"
                                    option-value="value"
                                    wire:model.defer="newMenuData.permission_or_role" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <x-select label="{{($newMenuData['permission_or_role']=='role')?'Roles':'Permissions'}}" placeholder="Select"
                                    wire:model.defer="newMenuData.permissions_roles">
                                    @isset($dropDownData['permissionsRoles'])
                                    @foreach ($dropDownData['permissionsRoles'] as $key => $permissionRole)
                                    <x-select.option label="{{ ($newMenuData['permission_or_role']=='role')?$permissionRole['name']:$key }}" value="{{ ($newMenuData['permission_or_role']=='role')?$permissionRole['id']:$key}}" />
                                    @endforeach
                                    @endisset
                                </x-select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group float-right">
                                <button type="button" wire:click='store' class="btn btn-primary rounded-pill">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>