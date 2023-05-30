<button wire:click="generatePdf({{ $id }})" type="button"
    class="btn btn-soft-primary btn-sm px-3 py-2.5 m-1 rounded" data-toggle="tooltip" data-placement="top" title="Download">
    <x-icon name="{{ $iconName }}" class="w-5 h-5" />{{ $iconName }}
</button>
