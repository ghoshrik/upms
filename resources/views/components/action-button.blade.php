@props(['id' => null, 'icon' => null])

<button type="{{ $type }}" {!! $attributes->merge(['class' => 'btn ' . $class . ' btn-sm m-1 rounded', 'id' => $id]) !!}
    @if ($onClick) wire:click="{{ $onClick }}" @endif>
    @if ($icon)
        {{-- <span class="icon">{{ $icon }}</span> --}}
        <x-lucide-{{ $icon }} class="w-4 h-4 text-gray-500" />
    @endif
    {{ $slot }}
</button>
