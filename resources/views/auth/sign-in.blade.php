@extends('layouts.auth-master')
@section('title', 'Glodex-Login')
<link rel="stylesheet" href="{{ asset('css/sign-in.css') }}">
@section('auth-content')
<div class="auth-bg sign-in-bg-img d-flex min-vh-100 justify-content-center align-items-center">
    <div class="row ">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 w-100">
            <div class="card overflow-hidden text-center h-100  p-3 mb-0">
                <a href="#" class="auth-brand mb-3">
                    <img src="{{ asset('back-end/assets/images/logo-main.png') }}" alt="dark logo" height="50" class="logo-dark">
                    <img src="{{ asset('back-end/assets/images/logo-main.png') }}" alt="logo light" height="50" class="logo-light">
                </a>

                <h3 class="fw-semibold mb-2 text-white">Login your account</h3>
                <p class="text-white mb-2">Enter your email address and password to access your panel.</p>
                @if (session('error'))
                    <p id="error-alert" class="alert text-danger" style="text-align: center">
                        {{ session('error') }}
                    </p>
                @endif
                <form  action="{{ route('auth_login') }}" method="POST" class="text-start mb-3">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-white" for="example-email">Email</label>
                        <input type="email" id="example-email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <span class="fw-medium">{{ $message }}</span>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white" for="example-password">Password</label>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password"  required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <span class="fw-medium">{{ $message }}</span>
                            </span>
                        @enderror
                    </div>

                    {{-- <div class="d-flex justify-content-between mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="checkbox-signin">
                            <label class="form-check-label" for="checkbox-signin">Remember me</label>
                        </div>

                        <a href="auth-recoverpw.html" class="text-muted border-bottom border-dashed">Forget Password</a>
                    </div> --}}

                    <div class="d-grid">
                        <button class="btn glodex-login-btn text-white" type="submit">Login</button>
                    </div>
                </form>

                <p class="text-white fs-14 mb-4">Don't have an account? <a href="{{ route('sign_up') }}" class="fw-semibold text-white ms-1">Sign Up !</a></p>

                <p class="mt-auto text-white mb-0">
                    <script>document.write(new Date().getFullYear())</script> © Glodex - By <span class="fw-bold text-decoration-underline text-uppercase text-reset fs-12">Mindcraft Coder</span>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
