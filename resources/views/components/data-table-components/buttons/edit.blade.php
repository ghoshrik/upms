{{-- <button wire:click="$emit('editEstimateRow')" type="button" class="btn btn-soft-warning">Edit</button> --}}
<button wire:click="edit({{ $row->estimate_id }})" type="button" class="btn btn-soft-warning">Edit</button>
