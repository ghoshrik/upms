<div>
    <div class="card">
        <div class="card-body">
            <form id="fileUploadForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 col-lg-3 col-sm-3">
                        <label for="dept category" style="color:#000;">Category <span style="color:red;">
                                *</span></label>
                        <select class="form-control" aria-label="Select Category" id="dept_category_id"
                            name="dept_category" required>
                            <option selected>Select Category</option>
                            @isset($deptCategories)
                                @foreach ($deptCategories as $deptCategory)
                                    <option value="{{ $deptCategory['id'] }}">{{ $deptCategory['dept_category_name'] }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="col-md-12 col-lg-3 col-sm-3">
                        <label for="dept category" style="color:#000;">Select Volume <span style="color:red;">
                                *</span></label>
                        <select class="form-control" aria-label="Select Category" id="volume_no" name="volume_no"
                            required>
                            <option>Select Volume</option>
                            <option value="1">Volume I</option>
                            <option value="2">Volume II</option>
                            <option value="3">Volume III</option>
                        </select>
                    </div>
                    <div class="col-md-12 col-lg-3 col-sm-3">
                        <label for="dept category" style="color:#000;">Upload Type <span style="color:red;">
                                *</span></label>
                        <select class="form-control" aria-label="Select Category" id="upload_at" name="upload_at"
                            required>
                            <option>Select </option>
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
                    </div>
                    <div class="col-md-12 col-lg-3 col-sm-3">
                        <label for="dept category" style="color:#000;">Upload files<span style="color:red;">
                                *</span></label>
                        <input type="file" placeholder="file upload" required id="file_upload" />

                    </div>
                    <div class="col-md-12 col-lg-12 col-sm-3">
                        <label for="description" style="color:#000;">Description</label>
                        <textarea rows="5" cols="5" class="form-control" name="description" id="description"></textarea>
                    </div>
                    <div class="mt-3 mb-3">
                        <button type="submit" id="uploadButton" class="btn btn-sm btn-success rounded">
                            Save</button>
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

        function validateForm() {
            const fileInput = document.getElementById('file_upload');
            const deptCategory = document.getElementById('dept_category_id');
            const volumeNo = document.getElementById('volume_no');
            const uploadAt = document.getElementById('upload_at');
            const description = document.getElementById('description');

            if (deptCategory === 'Select Category' || volumeNo === 'Select Volume' || uploadAt === 'select' || fileInput ===
                '') {
                window.$wireui.notify({
                    description: "Please fill in all the required fields.",
                    icon: 'error'
                });
                // uploadButton.disabled = false;
                // LoadverOverlay.style.display = "none";
                // LoadingModel.style.display = "none";
                return false;
            }
            return true;
        }











        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const fileInput = document.getElementById('file_upload');
            const deptCategory = document.getElementById('dept_category_id');
            const volumeNo = document.getElementById('volume_no');
            const uploadAt = document.getElementById('upload_at');
            const description = document.getElementById('description');
            uploadButton.disabled = true;



            const valid = validateForm();
            if (valid) {

                LoadverOverlay.style.display = "block";
                LoadingModel.style.display = "block";


                // const jsonStr = JSON.stringify(rowData);
                const encoder = new TextEncoder();
                // const jsonDataAsBytes = encoder.encode(jsonStr);
                // const base64EncodedData = btoa(String.fromCharCode(...jsonDataAsBytes));


                const noteencode = encoder.encode(description.value);
                const base64textencodeData = btoa(String.fromCharCode.apply(null, noteencode));



                const uploadFile = fileInput.files[0];
                const render = new FileReader();
                render.onload = function(event) {
                    const base64File = event.target.result.split(',')[1];
                    const formData = new FormData();
                    formData.append('file_upload', base64File);
                    formData.append('dept_category_id', deptCategory.value);
                    formData.append('volume_no', volumeNo.value);
                    formData.append('upload_at', uploadAt.value);
                    formData.append('description', base64textencodeData);

                    axios.post('sor-file-upload', formData, {
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
