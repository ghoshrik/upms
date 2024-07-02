<button wire:click="deleteAction({{ $id }})" type="button"
    class="btn btn-soft-danger btn-sm px-3 py-2.5 m-1 rounded" data-toggle="tooltip" data-placement="{{ $position }}"
    title="{{ $message }}">
    <x-lucide-trash class="w-4 h-4 text-gray-500" />
</button>
