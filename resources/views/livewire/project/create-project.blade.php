<div>
    <form wire:submit.prevent="saveProject">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="name">Project Name</label>
                    <textarea id="name" class="form-control" wire:model.defer="name" 
                        placeholder="Enter Project Name"></textarea>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="department_id">Department</label>
                    <select id="department_id" class="form-control" wire:model.defer="department_id">
                        <option value="">Select Department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">Save Project</button>
            </div>
        </div>
    </form>

    @if (session()->has('message'))
        <div class="alert alert-success mt-3">
            {{ session('message') }}
        </div>
    @endif
</div>
