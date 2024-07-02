@props(['dir'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $dir ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="This is uniuqe project of West Bengal(WB.Govt) Unified Project Management System is a project of every department Schedule or Rate(SOR). This project is link on WB PWD - http://wbpwd.gov.in/ and https:wbupmswb.gov.in">
    <meta name="robots" content="index, follow">
    <meta name="keywords" content="upms,SOR,PWD,Dynamic SOR">
    <title>@yield('webtitle', env('APP_NAME'))</title>
    @livewireStyles
    <wireui:scripts />
    <script src="{{ asset('js/alpineJs/alpinejs.cdn.min.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/quill.snow.css') }}">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    @include('partials.dashboard._head')
    <script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/quill.min.js') }}"></script>
</head>

<body class="">
    <x-dialog />
    @livewireScripts
    @include('partials.dashboard._body')
    <style>
        .modal-confirm .modal-content {
            padding: 20px;
            border-radius: 5px;
            border: none;
            text-align: center;
            font-size: 14px;
        }

        .modal-confirm .modal-header {
            border-bottom: none;
            position: relative;
        }

        .modal-confirm h4 {
            text-align: center;
            font-size: 26px;
            margin: 30px 0 -10px;
        }

        .modal-confirm .close {
            position: absolute;
            top: -5px;
            right: -2px;
        }

        .modal-confirm .modal-body {
            color: #999;
        }

        .modal-confirm .modal-footer {
            border: none;
            text-align: center;
            border-radius: 5px;
            font-size: 13px;
            padding: 10px 15px 25px;
        }

        .modal-confirm .modal-footer a {
            color: #999;
        }

        .modal-confirm .icon-box {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            border-radius: 50%;
            z-index: 9;
            text-align: center;
            border: 3px solid #f15e5e;
        }

        .modal-confirm .icon-box i {
            color: #f15e5e;
            font-size: 46px;
            display: inline-block;
            margin-top: 13px;
        }

        .modal-confirm .btn,
        .modal-confirm .btn:active {
            color: #fff;
            border-radius: 4px;
            /* background: #60c7c1; */
            text-decoration: none;
            transition: all 0.4s;
            line-height: normal;
            min-width: 120px;
            border: none;
            min-height: 40px;
            border-radius: 3px;
            margin: 0 5px;
            font-size: 18px;
        }

        .modal-confirm .btn-secondary {
            background: #c1c1c1;
        }

        .modal-confirm .btn-secondary:hover,
        .modal-confirm .btn-secondary:focus {
            background: #a8a8a8;
        }

        .modal-confirm .btn-danger {
            background: #f15e5e;
        }

        .modal-confirm .btn-danger:hover,
        .modal-confirm .btn-danger:focus {
            background: #ee3535;
        }

        .trigger-btn {
            display: inline-block;
            margin: 100px auto;
        }
    </style>
    <div id="deleteModal" class="modal fade" data-easein="whirlIn" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">>
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header flex-column">
                    {{-- <div class="icon-box">
                        <!-- <x-lucide-check-circle class="w-8 h-8 text-gray-500" />&nbsp; -->


                    </div> --}}
                    <svg xmlns="http://www.w3.org/2000/svg" id="sucSvg" width="48" height="48"
                        viewBox="0 0 24 24" fill="none" stroke="#22c50d" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-check-circle">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <path d="m9 11 3 3L22 4" />
                    </svg>
                    <h4 class="modal-title w-100">Are you sure?</h4>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> --}}
                </div>
                <div class="modal-body">
                    <!-- <p>Do you really want to delete these records? This process cannot be undone.</p> -->
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger" id="model-cancel" data-dismiss="modal">Cancel</button>
                    <button type="button" id="btnModalAction" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
    {{-- @yield('scripts') --}}
    <script>
        window.jsPDF = window.jspdf.jsPDF;
        $(document).ready(function() {
            // alert("hi");
            setTimeout(function() {
                $('.alert').hide();
            }, 3000);
            $('[data-toggle="tooltip"]').tooltip();
        });
        document.addEventListener('livewire:load', function() {
            Livewire.on('refreshCSRFToken', function() {
                // axios.get('/refresh-csrf').then(function(response) {
                //     document.querySelector('meta[name="csrf-token"]').setAttribute('content',
                //         response.data.csrfToken);
                // });
                window.location.href = '/';
            });
        });
    </script>
</body>

</html>
