<div class="card">
    <div class="card-body">
        <form action="#" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12 col-lg-3 col-sm-3">
                    <label for="dept category" style="color:#000;">Category <span style="color:red;">
                            *</span></label>
                    <select class="form-control" aria-label="Select Category" id="dept_category_id" name="dept_category"
                        required>
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
                    <select class="form-control" aria-label="Select Category" id="dept_category_id" name="volume_no"
                        required>
                        <option>Select Volume</option>
                        <option value="1">Volume I</option>
                        <option value="2">Volume II</option>
                        <option value="3">Volume III</option>
                    </select>
                </div>
                <div class="col-md-12 col-lg-3 col-sm-3">
                    <label for="dept category" style="color:#000;">Upload At <span style="color:red;">
                            *</span></label>
                    <select class="form-control" aria-label="Select Category" id="dept_category_id" name="upload_at"
                        required>
                        <option>Select </option>
                        <option value="1">Useful Tables</option>
                        <option value="2">Support Structure(Diagram)</option>
                        <option value="3">Formula</option>
                    </select>
                </div>
                <div class="col-md-12 col-lg-3 col-sm-3">
                    <label for="dept category" style="color:#000;">Upload files<span style="color:red;">
                            *</span></label>
                    <input type="file" class="form-control" placeholder="file upload" required name="file_upload" />
                </div>
                {{-- <div class="form-group">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
                            role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                            style="width: 0%"></div>
                    </div>
                </div> --}}
                <div class="mt-3 mb-3">
                    <button type="submit" class="btn btn-sm btn-success rounded">
                        Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    console.log("lists");
</script>