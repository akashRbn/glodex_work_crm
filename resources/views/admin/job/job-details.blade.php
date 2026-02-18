@extends('layouts.app')
@section('title', '| Job Details')
@push('page-css')
    <link rel="stylesheet" href="{{ asset('css/country/country-details.css') }}">
    <link rel="stylesheet" href="{{ asset('css/university/university-details.css') }}">
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
                            <h4 class="header-title mb-0">Job Details</h4>
                            <div class="d-flex">
                                <a href="{{ route('job_list') }}" class="btn btn-sm btn-secondary me-2">
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
                                                        src="{{ $jobDetails->country && $jobDetails->country->flag && file_exists(public_path($jobDetails->company->flag)) 
                                                        ? asset($jobDetails->country->flag) 
                                                        : asset('back-end/assets/images/dr-profile/image-upload.jpg') }}"
                                                        alt="Company Cover Photo">
                                                    <div class="country-details-top-info">
                                                        <div class="text-white country-details-top-info-inner">
                                                            <h2 class="mb-2">
                                                                {{ $jobDetails->job_name ?? 'Not Added' }}
                                                            </h2>
                                                            <p class="lead">
                                                                Step into a world of top-tier job opportunities in a prestigious international destination.
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="country-details-cover-bottom-flag">
                                                    <img src="{{ $jobDetails->company && $jobDetails->company->logo && file_exists(public_path($jobDetails->company->logo)) 
                                                        ? asset($jobDetails->company->logo) 
                                                        : asset('back-end/assets/images/dr-profile/image-upload.jpg') }}"
                                                        alt="{{ $jobDetails->company->name ?? 'Company Logo' }}"
                                                        class="img-fluid rounded-circle">
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
                                                            <i class="ti ti-building text-white fs-3"></i>
                                                        </div>
                                                        <h3 class="h3 fw-bold text-white mb-2">
                                                            {{ $jobDetails->company->company_name ?? 'Not Added' }}
                                                        </h3>
                                                        <p class="text-white opacity-75 mb-0">Company</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-lg-4 col-xl-3 col-sm-6 col-xxl">
                                                <div class="card border-0 shadow-sm">
                                                    <div class="card-body px-2 py-3">
                                                        <div
                                                            class="d-inline-flex align-items-center justify-content-center mb-2 country-details-stats-icon">
                                                            <i class="ti ti-world-star text-white fs-3"></i>
                                                        </div>
                                                        <h3 class="h3 fw-bold text-white mb-2">{{ $jobDetails->country->country_name ?? 'Not Added' }}</h3>
                                                        <p class="text-white opacity-75 mb-0">Country</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-lg-4 col-xl-3 col-sm-6 col-xxl">
                                                <div class="card border-0 shadow-sm">
                                                    <div class="card-body px-2 py-3">
                                                        <div
                                                            class="d-inline-flex align-items-center justify-content-center mb-2 country-details-stats-icon">
                                                            <i class="ti ti-vocabulary text-white fs-3"></i>
                                                        </div>
                                                        <h3 class="h3 fw-bold text-white">
                                                            {{ $jobDetails->avilable_positions ?? 'Not Added' }}
                                                        </h3>
                                                        <p class="text-white opacity-75 mb-0">Avilable Job</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-lg-4 col-xl-3 col-sm-6 col-xxl">
                                                <div class="card border-0 shadow-sm">
                                                    <div class="card-body px-2 py-3">
                                                        <div
                                                            class="d-inline-flex align-items-center justify-content-center mb-2 country-details-stats-icon">
                                                            <i class="ti ti-briefcase text-white fs-3"></i>
                                                        </div>
                                                        <h3 class="h3 fw-bold text-white mb-2">
                                                            {{ $jobDetails->experience_level ?? 'Not Added' }}
                                                        </h3>
                                                        <p class="text-white opacity-75 mb-0">Experience</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <section class="py-4">
                                    <div class="container">
                                        <div class="info-section row">
                                            <div class="col-md-12">
                                                <h2 class="section-title">
                                                    <i class="bi bi-building"></i>Job Information
                                                </h2>
                                            </div>
                                        </div>

                                        <div class="row pb-4">
                                            <div class="col-md-6">
                                                <div class="info-card">
                                                    <div class="info-label">Intial Fees</div>
                                                    <div class="info-value">{{ $jobDetails->intial_fees ?? 'Not Added' }}</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-card">
                                                    <div class="info-label">Job Location</div>
                                                    <div class="info-value">
                                                        {{ $jobDetails->job_location ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-card">
                                                    <div class="info-label">Job Type</div>
                                                    <div class="info-value">
                                                        {{ $jobDetails->job_type == 1 ? 'Full Time' : ($jobDetails->job_type == 2 ? 'Part Time' : 'Not Added') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-card">
                                                    <div class="info-label">Career Growth</div>
                                                    <div class="info-value">
                                                        Opportunities for promotion & skill development
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- Description -->
                                <section class="py-3">
                                    <div class="container">
                                        <div class="row country-details-description">
                                            <div class="col-lg-12 col-sm-12 col-12">
                                                <div class="card border-0 shadow-sm p-4 mb-0">
                                                    <h3 class="h3 fw-bold text-white mb-2 "><i
                                                            class="ti ti-layout-bottombar-expand"></i> About
                                                        This Job
                                                    </h3>
                                                    <p class="text-white">
                                                         {!! $jobDetails->job_details !!}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <!-- Back Button -->
                                <section class="py-4 text-center">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h2 class="h3 fw-bold text-white mb-3">
                                                    Ready to Start Your Career?
                                                </h2>
                                                <a href="{{ route('job_list') }}"
                                                    class="btn btn-gradient btn-lg text-white border-0 d-inline-flex align-items-center gap-2">
                                                    <i class="ti ti-arrow-right"></i>
                                                    Apply Now
                                                </a>
                                            </div>
                                        </div>
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
