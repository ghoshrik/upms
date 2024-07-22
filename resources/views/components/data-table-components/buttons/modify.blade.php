{{-- <button wire:click="modify({{ $value }})" type="button" class="btn btn-soft-secondary btn-sm"> <x-lucide-pencil class="w-4 h-4 text-gray-500" /> Modify</button> --}}
<button wire:click="edit({{ $value }})" type="button" class="btn-soft-warning btn-sm">
    <x-lucide-edit class="w-4 h-4 text-gray-500" /> Modify
</button>
