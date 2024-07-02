<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <x-form-section submit='store'>
        <x-slot name='form'>
            <div class="row">
                <div class="col-md-6 col-sm-3 col-lg-6">
                    <div class="form-group">
                        <x-input label="Unit Name *" wire:model.defer="InputStoreData.unitName" />
                    </div>
                </div>
                <div class="col-md-6 col-sm-3 col-lg-6">
                    <div class="form-group">
                        <x-input label="Unit Short Name *" wire:model.defer="InputStoreData.unitShortName" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12"><button type="submit"
                        class="btn btn-success rounded-pill float-right">Save</button>
                </div>
            </div>
        </x-slot>
    </x-form-section>
</div>
