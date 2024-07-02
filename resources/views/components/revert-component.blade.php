
    <button {{ $attributes->merge(['wire:click' => $action . '(' . $id . ')']) }} type="button"
        class="btn btn-soft-primary btn-sm px-3 py-2.5 m-1 rounded" data-toggle="tooltip" data-placement="top" title="Revert Role">
        <x-lucide-undo class="w-4 h-4 text-gray-500" />
    </button>
