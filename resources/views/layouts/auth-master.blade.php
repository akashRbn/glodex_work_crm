<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Auth - Glodex')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('back-end/assets/images/glodex-favicon.png')}}">
    <link href="{{ asset('back-end/assets/css/vendor.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('back-end/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('back-end/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="auth-wrapper">
        @yield('auth-content')
        @include('sweetalert::alert')
    </div>

    <script src="{{ asset('back-end/assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('back-end/assets/js/app.js') }}"></script>
    @stack('page-js')
</body>
</html>
