@extends('layouts.app')
@section('title','| Country List')
@push('page-css')
    <link rel="stylesheet" href="{{ asset('css/country/country-list.css') }}">
@endpush

@section('content')
    <!-- Begin page -->
    <div class="wrapper">
        <div class="page-container">
            <div class="row mt-2">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header border-bottom border-dashed d-flex align-items-center justify-content-between">
                            <h4 class="header-title mb-0">Country List</h4>
                            <div class="d-flex items-center gap-2">
                                <a href="{{ route('agent_country_list') }}" class="btn btn-sm glodex-blue-btn" id="addNewCountryBtn">
                                    <i class="ti ti-rotate me-2"></i>
                                    Refresh
                                </a>
                            </div>
                        </div>
                        <section class="glodex-country-list-section p-3">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="glodex-show-entries d-flex align-items-center justify-content-between flex-wrap gap-3">
                                        <!-- Show entries dropdown -->
                                        <div class="d-flex align-items-center gap-2">
                                            <form method="GET" action="{{ route('search_agent_countries') }}">
                                                <div class="d-flex align-items-center gap-2">
                                                    <label for="glodex-show-entries" class="form-label mb-0">Show</label>
                                                    <select name="per_page" id="glodex-show-entries" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                                                        <option value="8" {{ request('per_page') == 8 ? 'selected' : '' }}>8</option>
                                                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                                    </select>
                                                    <span>entries</span>
                                                </div>

                                                @if (request()->has('search_country'))
                                                    <input type="hidden" name="search_country" value="{{ request('search_country') }}">
                                                @endif
                                            <form>
                                        </div>
                                        <!-- Search form -->
                                        <form action="{{ route('search_agent_countries') }}"  method="GET" class="d-flex align-items-center align-items-end">
                                            <div class="glodex-search-field d-flex align-items-center">
                                                <input type="search" name="search_country" id="glodex-country-search" class="form-control form-control-sm mb-0" value="{{ request('search_country') }}" placeholder="Search country...">
                                                <button type="submit" class="btn btn-sm glodex-blue-btn"><i class="ti ti-search" style="font-size: 1.3rem;"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row row-gap-3 no-gutters">
                                @foreach($countries as  $country)
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                                        <div class="glodex-country-list-item position-relative h-100 border rounded-4 shadow-sm p-2">
                                            <div class="btn-group glodex-custom-3dot-dropdown">
                                                <button type="button" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('search_agent_company', ['country_id' => $country->id]) }}" target="_blank"><i class="ti ti-school me-2"></i>Companies</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('agent_filter_job', ['country_id' => $country->id]) }}" target="_blank">
                                                            <i class="ti ti-book-2 me-2"></i> Jobs
                                                        </a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="{{ route('agent_country_details', $country->id) }}"><i class="ti ti-map-pin me-2"></i> Country Details</a></li>
                                                </ul>
                                            </div>
                                            <div class="glodex-country-list-img position-relative overflow-hidden">
                                                <img src="{{ $country->cover_photo && file_exists(public_path($country->cover_photo)) ? asset($country->cover_photo) : asset('back-end/assets/images/dr-profile/image-upload.jpg') }}" class="img-fluid rounded-4" alt="image">

                                                <div class="glodex-country-list-img-sm">
                                                    <img src="{{ $country->flag && file_exists(public_path($country->flag)) ? asset($country->flag) : asset('back-end/assets/images/dr-profile/image-upload.jpg') }}" class="img-fluid rounded-circle" alt="">
                                                </div>
                                            </div>
                                            <div class="glodex-country-list-content text-center px-2 py-3">
                                                <div class="d-flex align-items-center gap-2 justify-content-center">
                                                    <i class="fa-solid fa-flag"></i>
                                                    <h3 class="mb-1 fw-bold ">{{ $country->country_name ?? 'Not Added' }}</h3>
                                                </div>

                                                <span class="  d-block mb-2">{{ $country->countryContinent->continent_name ?? '--' }}</span>
                                                <div class="glodex-country-info d-flex align-items-center justify-content-between text-center">
                                                    <div>
                                                        <p class="mb-0">Total Company</p>
                                                        <p class="mb-0 fw-semibold">{{ $country->companies_count ?? 0 }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0">Total Job</p>
                                                        <p class="mb-0 fw-semibold">{{ $country->jobs_count ?? 0 }}</p>
                                                    </div>
                                                </div>
                                                <button class="btn btn-sm btn-gradient mt-3 px-3 py-1">Active</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row mt-4">
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="pagination-container">
                                        {{ $countries->appends(request()->query())->links() }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <p>
                                        Showing {{ $countries->count() }} records on page {{ $countries->currentPage() }} of {{ $countries->lastPage() }}
                                        (Total: {{ $countries->total() }} records)
                                    </p>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END wrapper -->
@endsection
@push('page-js')
@endpush
