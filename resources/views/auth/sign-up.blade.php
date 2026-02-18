@extends('layouts.auth-master')
@section('title', 'Glodex-Sign-Up')
<link rel="stylesheet" href="{{ asset('css/sign-up.css') }}">
@section('auth-content')
<div class="auth-bg sign-up-bg-img d-flex min-vh-100 justify-content-center align-items-center">
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 w-100">
            <div class="card overflow-hidden text-center h-100 p-xxl-4 p-3 mb-0">
                <a href="index.html" class="auth-brand mb-3">
                    <img src="{{ asset('back-end/assets/images/logo-main.png')}}" alt="dark logo" height="50" class="logo-dark">
                    <img src="{{ asset('back-end/assets/images/logo-main.png')}}" alt="logo light" height="50" class="logo-light">
                </a>
                <h3 class="fw-semibold text-white mb-3">Welcome to Glodex</h3>

                <form  action="{{ route('save_sign_up') }}" class="text-start mb-3" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-2 col-md-6">
                            <label class="form-label text-white" for="first-name">First Name<span class="text-danger">*</span></label>
                            <input type="text" id="first-name" name="first_name" class="form-control @error('first_name') is-invalid @enderror" placeholder="Enter your first name" value="{{ old('first_name') }}" required>
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <span class="fw-medium">{{ $message }}</span>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-2 col-md-6">
                            <label class="form-label text-white" for="last-name">Last Name<span class="text-danger">*</span></label>
                            <input type="text" id="last-name" name="last_name" class="form-control @error('last_name') is-invalid @enderror" placeholder="Enter your last name" value="{{ old('last_name') }}" required>
                           @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <span class="fw-medium">{{ $message }}</span>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label text-white" for="phone">Phone<span class="text-danger">*</label>
                        <input type="phone" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter your phone with country code" value="{{ old('phone') }}" required>
                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <span class="fw-medium">{{ $message }}</span>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label text-white" for="user-type">User Type<span class="text-danger">*</span></label>
                        <select id="user-type" name="user_type" class="form-control @error('user_type') is-invalid @enderror" required>
                            <option value="">-- Select User Type --</option>
                            <option value="2">Agent</option>
                            <option value="3">Applicant</option>
                            <option value="4">Lawyer</option>
                        </select>
                        @error('user_type')
                            <span class="invalid-feedback" role="alert">
                                <span class="fw-medium">{{ $message }}</span>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-2" id="organization-div" style="display: none;">
                        <label class="form-label text-white" for="organization-name">Organization Name</label>
                        <input type="text" id="organization" name="organization_name" class="form-control" placeholder="Enter your organization name">
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-white" for="example-email">Email<span class="text-danger">*</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email" value="{{ old('phone') }}" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <span class="fw-medium">{{ $message }}</span>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-white" for="password">Password<span class="text-danger">*</label>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <span class="fw-medium">{{ $message }}</span>
                            </span>
                        @enderror
                    </div>

                    {{-- <div class="d-flex justify-content-between mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="checkbox-signin">
                            <label class="form-check-label" for="checkbox-signin">I agree to all <a href="#!" class="link-dark text-decoration-underline">Terms & Condition</a> </label>
                        </div>
                    </div> --}}

                    <div class="d-grid pt-2">
                        <button class="btn glodex-login-btn text-white" type="submit">Sign Up</button>
                    </div>
                </form>

                <p class="text-white fs-14 mb-4">Already have an account? <a href="{{ route('sign_in') }}" class="text-white fw-semibold text-dark ms-1">Login !</a></p>

                <p class="mt-auto text-white mb-0">
                    <script>document.write(new Date().getFullYear())</script> © Glodex - By <span class="fw-bold text-decoration-underline text-uppercase text-white fs-12">Mindcraft Coders</span>
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
@push('page-js')
<script>
    document.getElementById('user-type').addEventListener('change', function() {
        var orgDiv = document.getElementById('organization-div');
        if (this.value == '2') {
            orgDiv.style.display = 'block';
        } else {
            orgDiv.style.display = 'none';
        }
    });
</script>
@endpush
