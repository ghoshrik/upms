@props(['loading'=>false])

<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary mt-5']) }}>
    @if($loading && $target = $attributes->wire('click')->value())
        <span wire:loading.remove wire:target='{{$target}}'>{{ $slot }}</span>
        <span wire:loading wire:target='{{$target}}'>{{ $loading }}</span>
    @else
    {{ $slot }}
    @endif

</button>
