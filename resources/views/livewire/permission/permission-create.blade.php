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
                            <x-input wire:model="permissionName" label="Permission Name"
                                placeholder="Enter Perission Name" corner-hint="Ex: create user" />
                        </div>
                        <x-button type="submit" spinner primary label="Create" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
