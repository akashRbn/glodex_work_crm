@extends('layouts.app')
@section('title', '| Company Details')
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
                            <h4 class="header-title mb-0">Company Details</h4>
                            <div class="d-flex">
                                <a href="{{ route('agent_company_list') }}" class="btn btn-sm btn-gradient">
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
                                                        src="{{ $companyDetails->country->flag && file_exists(public_path($companyDetails->country->flag)) ? asset($companyDetails->country->flag) : asset('back-end/assets/images/dr-profile/image-upload.jpg') }}"
                                                        alt="cover photo">
                                                    <div class="country-details-top-info">
                                                        <div class="text-white country-details-top-info-inner">
                                                            <h1 class="display-5 fw-bold mb-2">
                                                                {{ $companyDetails->country->country_name ?? 'Not Added' }}
                                                            </h1>
                                                            <p class="lead">
                                                                Explore world-class career opportunities with top organizations in one of the most dynamic professional destinations.
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="country-details-cover-bottom-flag">
                                                        <img src="{{ $companyDetails->logo && file_exists(public_path($companyDetails->logo)) ? asset($companyDetails->logo) : asset('back-end/assets/images/dr-profile/image-upload.jpg') }}"
                                                            alt="United Kingdom flag" class="img-fluid rounded-circle">
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
                                                    <i class="bi bi-building"></i>Company Information
                                                </h2>
                                            </div>
                                        </div>

                                        <div class="row pb-4">
                                            <div class="col-md-6">
                                                <div class="info-card">
                                                    <div class="info-label">Company Name</div>
                                                    <div class="info-value">{{ $companyDetails->company_name }}</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-card">
                                                    <div class="info-label">Country</div>
                                                    <div class="info-value">
                                                        {{ $companyDetails->country->country_name ?? 'Not Added' }}</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-card">
                                                    <div class="info-label">City</div>
                                                    <div class="info-value">
                                                        {{ $companyDetails->company_city ?? 'Not Added' }}</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-card">
                                                    <div class="info-label">Email</div>
                                                    <div class="info-value">
                                                        <a href="#" class="text-decoration-none text-white">
                                                            <i
                                                                class="bi bi-envelope"></i>{{ $companyDetails->company_email ?? 'Not Added' }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-card">
                                                    <div class="info-label">Phone</div>
                                                    <div class="info-value">
                                                        <i
                                                            class="bi bi-telephone"></i>{{ $companyDetails->company_phone ?? 'Not Added' }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-card">
                                                    <div class="info-label">Location</div>
                                                    <div class="info-value">
                                                        <i
                                                            class="bi bi-pin-map"></i>{{ $companyDetails->address ?? 'Not Added' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="description-box">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h3 class="section-title">
                                                        <i class="ti ti-file-text"></i> About the Company
                                                    </h3>
                                                    <div class="text-white">
                                                        {!! $companyDetails->description !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                {{-- <section class="py-4 country-details-universities-list">
                                    <div class="container">
                                        <div class="text-center pb-3">
                                            <h2 class="h2 fw-bold text-white mb-3">Top Jobs</h2>
                                            <p class="text-white opacity-75">
                                               Find your dream job with globally recognized organizations
                                            </p>
                                        </div>

                                        
                                        <div class="owl-carousel owl-theme glodex-details-carousel" id="university-details-universities-carousel">
                                            @forelse ($randomJobs as $job)
                                                <div class="glodex-details-carousel-item">
                                                    <div class="glodex-details-carousel-image position-relative rounded-4 overflow-hidden">
                                                      <img 
                                                            src="{{ $job->country && $job->country->flag && file_exists(public_path($job->country->flag)) 
                                                                ? asset($job->country->flag) 
                                                                : asset('back-end/assets/images/dr-profile/image-upload.jpg') }}"
                                                            alt="{{ $job->country->country_name ?? 'Country' }}"
                                                            class="w-100 object-fit-cover img-fluid">
                                                        <!-- Overlay -->
                                                        <div class="glodex-details-carousel-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-center">
                                                            <h4 class="text-white fw-bold mb-2">
                                                                {{ $job->job_title }}
                                                            </h4>
                                                            <a href="{{ route('job_details', $job->id) }}" class="btn btn-sm btn-gradient">View Details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <h1 class="text-white h-3 text-center">
                                                    No courses available for this university.
                                                </h1>
                                            @endforelse
                                        </div>
                                    </div>
                                </section> --}}
                                <section class="pb-4 text-center">
                                    <div class="container">
                                        <a href="{{ route('agent_company_list') }}" class="btn btn-gradient btn-lg text-white border-0 d-inline-flex align-items-center gap-2"
                                            >
                                            <i class="ti ti-arrow-left"></i>
                                            Back to all companies
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
    <!-- END wrapper -->
@endsection

@push('page-js')
    <script>
        $("#university-details-universities-carousel").owlCarousel({
            loop: true,
            margin: 15,
            dots: false,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
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
