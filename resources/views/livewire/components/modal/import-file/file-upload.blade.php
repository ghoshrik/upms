<div>
    <x-modal max-width="5xl" blur wire:model.defer="viewModal">
        {{-- <x-card>

        </x-card> --}}
        <x-form-section submit='blukUploadFile' form-enctype="multipart-formdata">
            <x-slot name='form'>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <x-input type="file" label="File Upload" wire:model="file_upload" placeholder="file_upload" />
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12 col-lg-12 col-sm-12 float-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </div>
            </x-slot>
        </x-form-section>
    </x-modal>
</div>
