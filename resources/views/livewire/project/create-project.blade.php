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
                    <label for="site">Project Site</label>
                    <textarea id="site" class="form-control" wire:model.defer="site"
                        placeholder="Enter Project Site"></textarea>
                    @error('site')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">Save Project</button>
            </div>
        </div>
    </form>

    @if (session()->has('message'))
        <div class="mt-3 alert alert-success">
            {{ session('message') }}
        </div>
    @endif
</div>
