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

                <div class="mb-3">
                    <label for="mandatory_docs">Mandatory Documents</label>
                    <div class="p-3 border rounded">
                        <div class="row">
                            @foreach($mandetory_docs_list as $index => $doc)
                            <div class="mb-2 col-12 col-sm-4 col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" wire:model="selectedDocs"
                                        value="{{ $doc->id }}" id="doc_{{ $doc->id }}">
                                    <label class="form-check-label" for="doc_{{ $doc->id }}">
                                        {{ $doc->name }}
                                    </label>
                                </div>
                            </div>
                            @if (($index + 1) % 3 == 0)
                        </div>
                        <div class="row">
                            @endif
                            @endforeach
                        </div>
                        @error('selectedDocs')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
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
