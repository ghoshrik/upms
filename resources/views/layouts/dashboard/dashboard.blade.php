@props(['dir'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $dir ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('webtitle', env('APP_NAME'))</title>
    @livewireStyles
    <wireui:scripts />
    <script src="{{ asset('js/alpineJs/alpinejs.cdn.min.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @include('partials.dashboard._head')
</head>

<body class="">
    <x-dialog />
    @include('partials.dashboard._body')
    @livewireScripts
    {{-- @yield('scripts') --}}
    <script>
        $(document).ready(function() {
            // alert("hi");
            setTimeout(function() {
                $('.alert').hide();
            }, 3000);
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</body>

</html>
