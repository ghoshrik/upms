<div>
    <div class="card">
        <div class="card-body">
            <form id="fileUploadForm" method="post" enctype="multipart/form-data">
                @csrf
                {{-- <form wire:submit.prevent="upload"> --}}
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-sm-3">
                        <label for="dept category" style="color:#000;">Category <span style="color:red;">
                                *</span></label>
                        <select class="form-control" aria-label="Select Category" id="dept_category_id"
                            name="dept_category" wire:model.defer="field.dept_category">
                            <option value="default" selected disabled>Select Category</option>
                            @isset($deptCategories)
                                @foreach ($deptCategories as $deptCategory)
                                    <option value="{{ $deptCategory['id'] }}">{{ $deptCategory['dept_category_name'] }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        @error('field.dept_category')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-3 col-lg-2 col-sm-3">
                        <label for="dept category" style="color:#000;">Select Volume <span style="color:red;">
                                *</span></label>
                        <select class="form-control" aria-label="Select Category" id="volume_no" name="volume_no"
                            required wire.model.defer="field.volume_no">
                            <option value="default" selected disabled>Select Volume</option>
                            <option value="1">Volume I</option>
                            <option value="2">Volume II</option>
                            <option value="3">Volume III</option>
                        </select>
                        @error('field.volume_no')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-3">
                        <label for="dept category" style="color:#000;">Upload Type <span style="color:red;">
                                *</span></label>
                        <select class="form-control" aria-label="Select Category" id="upload_at"
                            wire:model.defer="field.upload_at" name="upload_at" required>
                            <option value="default" selected disabled>Select </option>
                            <option value="0">Useful Tables</option>
                            <option value="1">Support Structure(Diagram)</option>
                            <option value="2">Formula</option>
                            <option value="3">Preface</option>
                            <option value="4">General Abstruct of Cost</option>
                            <option value="5">Contents</option>
                            <option value="6">General Conditions</option>
                            <option value="7">General Specification</option>
                            <option value="8">Others</option>
                            <option value="9">Preamble</option>
                        </select>
                        @error('field.upload_at')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-3">
                        <label for="dept category" style="color:#000;">Upload files<span style="color:red;">
                                *</span></label>
                        <input type="file" placeholder="file upload" wire:model.defer="field.file_upload"
                            wire:loading.attr="disabled" required id="file_upload" />

                        <div wire:loading wire:target="field.file_upload">
                            <progress max="100" value="{{ $progress }}"></progress>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12 col-sm-3">
                        <label for="description" style="color:#000;">Description</label>
                        <textarea rows="5" cols="5" class="form-control" name="description" wire:model.defer="field.description"
                            id="description"></textarea>
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
    {{-- Loading Screen --}}
    <div id="loadingModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="loadingmodal-content">
                <div class="modal-body">
                    <div class="loader-container clock">
                        <div class="loader">
                            <div class="arc"></div>
                        </div>
                    </div>
                    <p
                        style="padding: 72px 0px 0px 64px;text-align: center;font-size: 26px;font-weight: 400;color: aliceblue;">
                        Please Wait ... </p>
                </div>
            </div>
        </div>
    </div>
    {{-- Loading Screen --}}
    <div id="loaderoverlay"></div>
    <script>
        //console.log("lists");

        const form = document.getElementById('fileUploadForm');
        const uploadButton = document.getElementById('uploadButton');

        /* loading Screen */
        const LoadingModel = document.getElementById("loadingModal");
        const LoadverOverlay = document.getElementById("loaderoverlay");
        /* loading Screen */

        const fileInput = document.getElementById('file_upload');
        const deptCategory = document.getElementById('dept_category_id');
        const volumeNo = document.getElementById('volume_no');
        const uploadAt = document.getElementById('upload_at');
        const description = document.getElementById('description');

        function validateForm() {

            if (deptCategory === 'default' || volumeNo === 'default' || fileInput === '') {
                window.$wireui.notify({
                    description: "Please fill in all the required fields.",
                    icon: 'error'
                });
                // uploadButton.disabled = false;
                // LoadverOverlay.style.display = "none";
                // LoadingModel.style.display = "none";
                //return false;
            }
            return true;
        }



        form.addEventListener('submit', async function(e) {
            // console.log("dasdas");
            e.preventDefault();
            uploadButton.disabled = true;
            const valid = validateForm();
            if (valid) {
                LoadverOverlay.style.display = "block";
                LoadingModel.style.display = "block";

                const encoder = new TextEncoder();
                const uploadFile = fileInput.files[0];
                const render = new FileReader();
                render.onload = async function(event) {
                    const base64File = event.target.result.split(',')[1];
                    const encodedFileName = encodeURIComponent(uploadFile.name);
                    console.log(encodedFileName);
                    const formData = new FormData();
                    formData.append('file_upload', base64File);
                    formData.append('dept_category_id', deptCategory.value);
                    formData.append('volume_no', volumeNo.value);
                    formData.append('upload_at', uploadAt.value);
                    formData.append('description', btoa(String.fromCharCode(...(encoder.encode(
                        description
                        .value)))));

                    await axios.post('sor-fileUpload', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                            }
                        })
                        .then(response => {
                            console.log(response.data);
                            console.log(response.data.status);
                            console.log(response.data.message);
                            if (response.data.status === true) {
                                LoadverOverlay.style.display = "none";
                                LoadingModel.style.display = "none";
                                uploadButton.disabled = false;

                                window.$wireui.notify({
                                    description: response.data.message,
                                    icon: 'success'
                                });
                                window.location.href = "{{ route('sor-document') }}";
                            }
                        })
                        .catch(error => {
                            console.log('File upload failed.');
                            window.$wireui.notify({
                                description: "File upload failed",
                                icon: 'error'
                            });
                            LoadverOverlay.style.display = "none";
                            LoadingModel.style.display = "none";
                            uploadButton.disabled = false;
                        });
                };
                render.readAsDataURL(uploadFile);
            } else {
                uploadButton.disabled = false;
                window.$wireui.notify({
                    description: "Form validation failed.",
                    icon: 'error'
                });
                LoadverOverlay.style.display = "none";
                LoadingModel.style.display = "none";
            }
        });
    </script>
</div>
