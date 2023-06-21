<div>
    <x-modal max-width="5xl" blur wire:model.defer="viewModal">
        {{-- <x-card>

        </x-card> --}}
        <x-form-section submit='import' form-enctype="multipart-formdata">
            <x-slot name='form'>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <x-input type="file" label="File Upload" wire:model="importFile" placeholder="file_upload" />
                        @if ($importing && !$importFinished)
                            <div wire:poll="updateImportProgress">Importing...please wait.</div>
                        @endif

                        @if ($importFinished)
                            Finished importing.
                        @endif
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-12 col-lg-12 col-sm-12 float-right">
                        <button class="btn btn-primary px-3 py-2.5 rounded">Submit</button>
                    </div>
                </div>
            </x-slot>
        </x-form-section>
        {{-- <form wire:submit.prevent="import" enctype="multipart/form-data">
            @csrf
            <input type="file" wire:model="importFile" class="@error('import_file') is-invalid @enderror">
            <button class="btn btn-outline-secondary">Import</button>
            @error('import_file')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </form> --}}


    </x-modal>
</div>
