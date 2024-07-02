<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 col-lg-4 col-sm-12">
                    <label for="dept category">Category <span style="color:red;"> *</span></label>
                    <select class="form-control" aria-label="Select Category" id="dept_category_id"
                        wire:model.defer="sorDocu.fieldData.dept_category_id" required>
                        <option selected>Select Category</option>
                        @isset($field['dept_category'])
                            @foreach ($field['dept_category'] as $deptCategory)
                                <option value="{{ $deptCategory['id'] }}">{{ $deptCategory['dept_category_name'] }}</option>
                            @endforeach
                        @endisset
                        {{-- @dd($field['dept_category']) --}}

                    </select>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-12">
                    <label for="volumn_no" class="">Select Volume <span style="color:red;"> *</span></label>
                    <select class="form-control" aria-label="Select Volume" id="volume_no"
                        wire:model.defer="sorDocu.fieldData.volume_no" required>
                        <option>Select Volume</option>
                        <option value="1">Volume I</option>
                        <option value="2">Volume II</option>
                        <option value="3">Volume III</option>
                    </select>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-12">
                    <label for="upload_at" class="">Upload At <span style="color:red;"> *</span></label>
                    <select class="form-control" aria-label="Select Volume" id="upload_at"
                        wire:model.defer="sorDocu.fieldData.upload_at" required>
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
                <div class="col-md-12 col-lg-12 col-sm-3 mt-2">
                    <label for="dept category">Description </label>
                    <textarea rows="5" cols="5" class="form-control" wire:model.defer="sorDocu.fieldData.desc"></textarea>
                </div>
            </div>
            <div class="mt-3 mb-3">
                <button type="submit" wire:click="updateData" wire:loading.attr="disabled" wire:target="updateData"
                    class="btn btn-sm btn-soft-warning rounded"> Update</button>
            </div>
        </div>
    </div>
</div>
