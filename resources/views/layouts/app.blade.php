<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Glodex @yield('title', '')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('back-end/assets/images/glodex-favicon.png')}}">

    <!-- Theme Config Js -->
    <script src="{{asset('back-end/assets/js/config.js') }}"></script>

    <!-- Vendor css -->
    <link href="{{asset('back-end/assets/css/vendor.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{asset('back-end/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{asset('back-end/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Owl Carousel css -->
    <link href="{{ asset('css/owl.carousel.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/owl.theme.default.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Quill css -->
    <link href="{{ asset('back-end/assets/vendor/quill/quill.core.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('back-end/assets/vendor/quill/quill.snow.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('back-end/assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.css')}}" rel="stylesheet" type="text/css" />

    @stack('page-css')
</head>

<body>
    <div class="wrapper">
        <!-- Topbar Start -->
        <header class="app-topbar">
            {{-- @include('layouts.partials.navbar') --}}
             @if(Auth::check())
                @if(Auth::user()->user_type == 1)
                    @include('layouts.partials.navbar-admin')
                @elseif(Auth::user()->user_type == 2)
                    @include('layouts.partials.navbar-agent')
                @elseif(Auth::user()->user_type == 3)
                    @include('layouts.partials.navbar-applicant')
                @elseif(Auth::user()->user_type == 4)
                    @include('layouts.partials.navbar-lawyer')
                @endif
            @endif
        </header>
        <!-- Topbar End -->

        <!-- Sidenav Menu Start -->
        <div class="sidenav-menu">
            @if(Auth::check())
                @if(Auth::user()->user_type == 1)
                    @include('layouts.partials.sidebar-admin')
                @elseif(Auth::user()->user_type == 2)
                    @include('layouts.partials.sidebar-agent')
                @elseif(Auth::user()->user_type == 3)
                    @include('layouts.partials.sidebar-applicant')
                @elseif(Auth::user()->user_type == 4)
                    @include('layouts.partials.sidebar-lawyer')
                @endif
            @endif
        </div>
        <!-- Sidenav Menu End -->
        <div class="page-content">
            @yield('content')
            @include('sweetalert::alert')
        </div>
        @include('layouts.partials.footer')
    </div>
    <!-- Vendor js -->
    <script src="{{asset('back-end/assets/js/vendor.min.js')}}"></script>

    <!-- App js -->
    <script src="{{asset('back-end/assets/js/app.js')}}"></script>

    <!-- Apex Chart js -->
    <script src="{{asset('back-end/assets/vendor/apexcharts/apexcharts.min.js')}}"></script>

    <!-- Projects Analytics Dashboard App js -->
    <script src="{{asset('back-end/assets/js/pages/dashboard-sales.js')}}"></script>

    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Quill Editor js -->
    <script src="{{ asset('back-end/assets/vendor/quill/quill.js')}}"></script>

    <!-- Quill Demo js -->
    <script src="{{ asset('back-end/assets/js/pages/form-quilljs.js')}}"></script>

    <!-- Bootstrap Wizard Form js -->
    <script src="{{ asset('back-end/assets/vendor/vanilla-wizard/js/wizard.min.js') }}"></script>

    <!-- Wizard Form Demo js -->
    <script src="{{ asset('back-end/assets/js/pages/form-wizard.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js')}}"></script>

    @stack('page-js')

</body>
</html>
