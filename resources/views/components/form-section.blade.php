@props(['submit'])

<div {{ $attributes->merge(['class' => 'intro-y col-span-12 overflow-auto lg:overflow-visible']) }}>
    {{-- <x-jet-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-jet-section-title> --}}

    <div class="intro-y box">
        <div id="vertical-form" class="p-5">
            <form wire:submit.prevent="{{ $submit }}">
                {{ $form }}
                {{-- @if (isset($actions))
                    <div
                        class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                        {{ $actions }}
                    </div>
                @endif --}}
            </form>
        </div>
    </div>
</div>
