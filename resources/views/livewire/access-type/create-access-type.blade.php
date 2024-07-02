<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-input wire:model.defer="newAccessTypeData.access_name" label="Name" placeholder="Enter Access Type Name" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                @isset($dropDownData['permissions'])
                                <x-select multiselect label="Permissions" placeholder="Select Permissions"
                                    wire:model.defer="newAccessTypeData.permissions">
                                    @foreach ($dropDownData['permissions'] as $permission)
                                    <x-select.option label="{{ $permission['name'] }}"
                                        value="{{ $permission['name'] }}" />
                                    @endforeach
                                </x-select>
                                @endisset
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group float-right">
                                <button type="button" wire:click='store'
                                    class="btn btn-primary rounded-pill">
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
