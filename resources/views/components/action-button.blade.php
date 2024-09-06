@props(['id' => null, 'icon' => null])

<button type="{{ $type }}" {!! $attributes->merge(['class' => 'btn ' . $class . ' btn-sm m-1 rounded', 'id' => $id]) !!}
    @if ($onClick) wire:click="{{ $onClick }}" @endif>
    @if ($icon)
        <span class="icon">{{ $icon }}</span>
    @endif
    {{ $slot }}
</button>
