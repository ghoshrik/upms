{{-- @if ($showCheckbox) --}}
{{-- <input type="checkbox" wire:model="selected" wire:click="{{ $toggleFunction }}" value="{{ $model->id }}"
        {{ $isChecked }}> --}}
{{-- <input data-id="{{ $model->id }}" class="toggle-class" type="checkbox" data-onstyle="success"
        data-offstyle="danger" data-toggle="toggle" wire:model="selected" wire:click="{{ $toggleFunction }}"
        data-on="Active" data-off="InActive" {{ $model->status ? 'checked' : '' }}  --}}

{{-- <div class="mb-3 form-check form-switch">
    <input class="form-check-input" type="checkbox" wire:model="selected" wire:click="{{ $toggleFunction }}"
        id="flexSwitchCheckChecked" {{ $isChecked }}>
    <label class="form-check-label" for="flexSwitchCheckChecked"></label>
</div> --}}

<label wire:click="toggleSelected({{ $status->id }},{{ $value == '1' ? '0' : '1' }})"
    class="badge badge-pill {{ $value == '1' ? 'bg-success' : 'bg-danger' }} cursor-pointer">
    {{ $value == '1' ? 'Active' : 'Inactive' }}
</label>

{{-- @endif --}}
