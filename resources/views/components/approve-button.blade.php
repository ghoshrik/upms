<button {{ $attributes->merge(['wire:click' => $action . '(' . $id . ')']) }} type="button"
    class="btn btn-soft-success btn-sm px-3 py-2.5 m-1 rounded">
    <x-lucide-check class="w-4 h-4 text-gray-500" /> {{ trans('global.approve_btn') }}
</button>
