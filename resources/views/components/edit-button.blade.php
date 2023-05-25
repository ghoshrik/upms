<button {{ $attributes->merge(['wire:click'=>$action.'('.$id.')']) }} type="button" class="btn btn-soft-warning btn-sm px-3 py-2.5 m-1 rounded">
    <x-lucide-edit class="w-4 h-4 text-gray-500" /> {{ trans('global.edit_btn') }}
</button>
