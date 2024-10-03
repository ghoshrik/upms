<div>
    <div class="card">
        <div class="card-body">
            {{-- <form id="standredUploadForm" method="post" enctype="multipart/form-data">
                @csrf --}}
            <form wire:submit.prevent="store">
                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-sm-12">
                        <label for="dept category" style="color:#000;">Title <span style="color:red;">
                                *</span></label>
                        <x-input wire:model="field.title" placeholder="Document Title" />
                    </div>
                    <div class="col-lg-6 col-sm-6 col-sm-12">
                        <label for="dept category" style="color:#000;">Upload files<span style="color:red;">
                                *</span></label>
                        <input type="file" placeholder="file upload" wire:model.defer="field.file_upload"
                            wire:loading.attr="disabled" required id="file_upload" />

                        <div wire:loading wire:target="field.file_upload">
                            <progress max="100" value="{{ $progress }}"></progress>
                        </div>
                    </div>
                    <div class="mt-3 mb-3">
                        <button type="submit" id="uploadButton" class="btn btn-sm btn-success rounded">
                            Save</button>
                        {{-- <button type="submit" class="btn btn-sm btn-success rounded">
                            Save</button> --}}

                    </div>
                </div>
            </form>
        </div>
    </div>
    <script></script>
</div>
