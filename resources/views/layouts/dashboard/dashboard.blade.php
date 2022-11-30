@props(['dir'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{$dir ? 'rtl' : 'ltr'}}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('webtitle',env('APP_NAME'))</title>
    @livewireStyles
    <wireui:scripts />
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @include('partials.dashboard._head')
</head>

<body class="">
    <x-notifications />
    @include('partials.dashboard._body')
    @livewireScripts
</body>

</html>
