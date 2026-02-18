@extends('layouts.app')
@section('title','| Country Details')
@push('page-css')
    <link rel="stylesheet" href="{{ asset('css/country/country-details.css') }}">
@endpush
@section('content')
    <!-- Begin page -->
    <div class="wrapper">
        <div class="page-container">
            <div class="row mt-2">
                <div class="col-xl-12">
                    <div class="card">
                        <div
                            class="card-header border-bottom border-dashed d-flex align-items-center justify-content-between">
                            <h4 class="header-title mb-0">Country Details</h4>
                            <div class="d-flex">
                                <a href="{{ route('agent_country_list') }}" class="btn btn-sm btn-secondary me-2">
                                    <i class="ti ti-arrow-back-up"
                                        style="margin-right:3px; font-size: 1.3rem; margin-bottom: 1px"></i>
                                    Go Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="country-details-container">
                                <section class="py-5">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12">
                                                <div
                                                    class="country-details-cover-photo border-0 shadow-sm position-relative">
                                                    <img class="img-fluid"
                                                        src="{{ $country->cover_photo && file_exists(public_path($country->cover_photo)) ? asset($country->cover_photo) : asset('back-end/assets/images/sellers/s-1.svg') }}"
                                                        alt="cover photo">
                                                    <div class="country-details-top-info">
                                                        <div class="text-white country-details-top-info-inner">
                                                            <p class="text-uppercase mb-2"
                                                                style="letter-spacing: 2px; font-size: 0.875rem;">
                                                                {{ $country->countryContinent->continent_name ?? 'Not Added' }}
                                                            </p>
                                                            <h1 class="display-5 fw-bold mb-2">
                                                                {{ $country->country_name ?? 'Not Added' }}</h1>
                                                            <p class="lead">
                                                                Discover world-class education opportunities in one of the
                                                                most prestigious academic destinations.
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="country-details-cover-bottom-flag">
                                                        <img src="{{ $country->flag && file_exists(public_path($country->flag)) ? asset($country->flag) : asset('back-end/assets/images/dr-profile/image-upload.jpg') }}"
                                                            alt="United Kingdom flag" class="img-fluid rounded-circle">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- Stats Section -->
                                <section class="py-3">
                                    <div class="container">
                                        <div class="row justify-center text-center country-details-stats-section">
                                            <div class="col-md-6 col-lg-4 col-xl-3 col-sm-6 col-xxl">
                                                <div class="card border-0 shadow-sm">
                                                    <div class="card-body px-2 py-3">
                                                        <div
                                                            class="d-inline-flex align-items-center justify-content-center mb-2 country-details-stats-icon">
                                                            <i class="ti ti-school text-white fs-3"></i>
                                                        </div>
                                                        <h3 class="h3 fw-bold text-white mb-2">
                                                            {{ $totalUniversities ?? 0 }}+</h3>
                                                        <p class="text-white opacity-75 mb-0">Total Universities</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-lg-4 col-xl-3 col-sm-6 col-xxl">
                                                <div class="card border-0 shadow-sm">
                                                    <div class="card-body px-2 py-3">
                                                        <div
                                                            class="d-inline-flex align-items-center justify-content-center mb-2 country-details-stats-icon">
                                                            <i class="ti ti-book-2 text-white fs-3"></i>
                                                        </div>
                                                        <h3 class="h3 fw-bold text-white mb-2">{{ $totalCourses ?? 0 }}+
                                                        </h3>
                                                        <p class="text-white opacity-75 mb-0">Total Courses</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-lg-4 col-xl-3 col-sm-6 col-xxl">
                                                <div class="card border-0 shadow-sm">
                                                    <div class="card-body px-2 py-3">
                                                        <div
                                                            class="d-inline-flex align-items-center justify-content-center mb-2 country-details-stats-icon">
                                                            <i class="ti ti-users text-white fs-3"></i>
                                                        </div>
                                                        <h3 class="h3 fw-bold text-white mb-2">
                                                            {{ $country->country_population ?? 0 }}</h3>
                                                        <p class="text-white opacity-75 mb-0">Population</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-lg-4 col-xl-3 col-sm-6 col-xxl">
                                                <div class="card border-0 shadow-sm">
                                                    <div class="card-body px-2 py-3">
                                                        <div
                                                            class="d-inline-flex align-items-center justify-content-center mb-2 country-details-stats-icon">
                                                            <i class="ti ti-map-pin text-white fs-3"></i>
                                                        </div>
                                                        <h3 class="h3 fw-bold text-white mb-2">
                                                            {{ $country->country_capital ?? 0 }}</h3>
                                                        <p class="text-white opacity-75 mb-0">Capital</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-lg-4 col-xl-3 col-sm-6 col-xxl">
                                                <div class="card border-0 shadow-sm">
                                                    <div class="card-body px-2 py-3">
                                                        <div
                                                            class="d-inline-flex align-items-center justify-content-center mb-2 country-details-stats-icon">
                                                            <i class="ti ti-trending-up text-white fs-3"></i>
                                                        </div>
                                                        <h3 class="h3 fw-bold text-white mb-2">
                                                            {{ $country->country_gdp ?? 0 }}</h3>
                                                        <p class="text-white opacity-75 mb-0">GDP</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <!-- Description -->
                                <section class="py-4">
                                    <div class="container">
                                        <div class="row justify-content-center country-details-description">
                                            <div class="col-lg-10 col-sm-12 col-12">
                                                <div class="card border-0 shadow-sm p-4 mb-0">
                                                    <h3 class="h4">About {{ $country->country_name }}</h3>
                                                    <p class="text-white">
                                                        {!! $country->description !!}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <section class="py-4 country-details-universities-list">
                                    <div class="container">
                                        <div class="text-center pb-3">
                                            <h2 class="h2 fw-bold text-white mb-3">Top Universities</h2>
                                            <p class="text-white opacity-75">
                                                Explore the leading institutions offering world-class education
                                            </p>
                                        </div>

                                        {{-- Owl Carousel Wrapper --}}
                                        <div class="owl-carousel owl-theme glodex-details-carousel"
                                            id="country-details-universities-carousel">
                                            @forelse ($randomUniversities as $university)
                                                <div class="glodex-details-carousel-item">
                                                    <div
                                                        class="glodex-details-carousel-image position-relative rounded-4 overflow-hidden">
                                                        <img src="{{ $university->logo && file_exists(public_path($university->logo)) ? asset($university->logo) : asset('back-end/assets/images/dr-profile/image-upload.jpg') }}"
                                                            alt="{{ $university->university_name }}"
                                                            class="w-100 object-fit-cover img-fluid">

                                                        <!-- Overlay -->
                                                        <div
                                                            class="glodex-details-carousel-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-center">
                                                            <h4 class="text-white fw-bold mb-2">
                                                                {{ $university->university_name }}</h4>
                                                            <a href="{{ route('country_details', $country->id) }}" class="btn btn-sm btn-gradient">View
                                                                Details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <h1 class="text-white h-3 text-center">
                                                    No universities available for this country.
                                                </h1>
                                            @endforelse
                                        </div>
                                    </div>
                                </section>


                                <!-- Back Button -->
                                <section class="pb-4 text-center">
                                    <div class="container">
                                        <a href="{{ route('agent_country_list') }}"
                                            class="btn btn-gradient btn-lg text-white border-0 d-inline-flex align-items-center gap-2">
                                            <i class="ti ti-arrow-left"></i>
                                            Back to All Countries
                                        </a>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('page-js')
    <script>
        $("#country-details-universities-carousel").owlCarousel({
            loop: true,
            margin: 15,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            dots: false,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                767: {
                    items: 2
                },
                991: {
                    items: 3
                },
                1199: {
                    items: 3
                },
                1499: {
                    items: 4
                }
            }
        });
    </script>
@endpush
