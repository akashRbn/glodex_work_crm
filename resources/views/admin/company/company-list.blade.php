@extends('layouts.app')
@section('title', '| Company List')
@push('page-css')
    <link rel="stylesheet" href="{{ asset('css/university/university-list.css') }}">
@endpush
@section('content')
    <!-- Begin page -->
    <div class="wrapper">
        <div class="page-container">
            <div class="row mt-2">
                <div class="col-xl-12">
                    <div class="card">
                       <div class="card-header border-bottom border-dashed d-flex align-items-center justify-content-between">
                            <h4 class="header-title mb-0">Company List</h4>
                            <div class="d-flex items-center gap-2">
                                @can('Create Company')
                                <a href="{{ route('add_new_company') }}" class="btn btn-sm glodex-blue-btn">
                                    <i class="ti ti-plus" style="margin-right:3px; font-size: 1.3rem; margin-bottom: 1px"></i>
                                    Add New
                                </a>
                                @endcan
                                <a href="{{ route('company_list') }}" class="btn btn-sm glodex-blue-btn" id="addNewCountryBtn">
                                    <i class="ti ti-rotate me-2"></i>
                                    Refresh
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="glodex-show-entries">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                                            <!-- Show entries form -->
                                            <form method="GET" action="{{ route('search_company_name') }}" class="d-flex align-items-center gap-2">
                                                <label class="form-label mb-0">Show</label>
                                                <select name="per_page" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                                                    <option value="8"   {{ request('per_page') == 8 ? 'selected' : '' }}>8</option>
                                                    <option value="24"  {{ request('per_page') == 24 ? 'selected' : '' }}>24</option>
                                                    <option value="60"  {{ request('per_page') == 60 ? 'selected' : '' }}>60</option>
                                                    <option value="120" {{ request('per_page') == 120 ? 'selected' : '' }}>120</option>
                                                </select>
                                                <span>entries</span>

                                                {{-- Keep filters --}}
                                                @if (request()->has('search'))
                                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                                @endif
                                                @if (request()->has('country_id'))
                                                    <input type="hidden" name="country_id" value="{{ request('country_id') }}">
                                                @endif
                                            </form>

                                            <!-- Search + Filter -->
                                            <form action="{{ route('search_company_name') }}" method="GET" class="d-flex align-items-center company-filter-form">
                                                <div class="glodex-show-entries-select">
                                                    <select class="form-control form-select-sm" name="country_id" data-choices>
                                                        <option value="">Select Country</option>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}"
                                                                {{ request('country_id') == $country->id ? 'selected' : '' }}>
                                                                {{ $country->country_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="glodex-search-field d-flex align-items-center">
                                                    <input type="search"
                                                        name="search"
                                                        class="form-control form-control-sm mb-0"
                                                        placeholder="Search company..."
                                                        value="{{ request('search') }}">

                                                    <button type="submit" class="btn btn-sm glodex-blue-btn ms-2">
                                                        <i class="ti ti-search" style="font-size: 1.3rem;"></i>
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2">
                                @foreach($companies as  $company)
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 col-xxl-3">
                                        <div class="university-card border rounded-4 shadow-md py-3 px-2 position-relative h-100">
                                            <!-- 3-dot Dropdown -->
                                            <div class="btn-group glodex-custom-3dot-dropdown position-absolute top-0 end-0 m-2">
                                                <button type="button" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @can('View Job')
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('filter_job', [
                                                            'job_name' => '',
                                                            'company_name' => $company->company_name,
                                                            'country_id' => '',
                                                            'search_terms' => '',
                                                            'job_type' => ''
                                                            ]) }}">Jobs
                                                        </a>
                                                    </li>
                                                    @endcan
                                                    @can('View Company')
                                                    <li><a class="dropdown-item" href="{{ route('company_details', $company->id) }}">Company Details</a></li>
                                                    @endcan
                                                    @can('Edit Company')
                                                    <li><a class="dropdown-item" href="{{ route('edit_company', $company->id) }}">Edit</a></li>
                                                    @endcan 
                                                    @can('Delete Company')
                                                    <li>
                                                        <a class="dropdown-item"  href="#" onclick="confirmDelete({{ $company->id }})">Delete</a>
                                                        <form id="delete-company-form-{{ $company->id }}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </li>
                                                    @endcan
                                                </ul>
                                            </div>
                                            <div class="university-card-header d-flex align-items-center gap-2 pb-3">
                                                <div class="university-logo flex-shrink-0">
                                                    <img src="{{ $company->logo && file_exists(public_path($company->logo)) ? asset($company->logo) : asset('back-end/assets/images/dr-profile/image-upload.jpg') }}" alt="Logo" class="img-fluid">
                                                </div>
                                                <div class="flex-grow-1 text-left">
                                                    <h5 class="university-title mb-0 text-left">{{ $company->company_name }}</h5>
                                                    <p class="university-subtitle mb-0 text-left text-muted">{{ $company->country->country_name ?? 'Not added' }} • {{ $company->company_city ?? 'Not added' }}</p>
                                                </div>
                                            </div>
                                            <div class="card-body-custom">
                                                <div class="contact-item py-1 d-flex align-items-center">
                                                    <div class="contact-icon me-2">
                                                        <i class="ti ti-mail-filled"></i>
                                                    </div>
                                                    <p class="contact-text mb-0">{{ $company->company_email ?? 'Not added' }}</p>
                                                </div>
                                                <div class="contact-item py-1 d-flex align-items-center">
                                                    <div class="contact-icon me-2">
                                                        <i class="ti ti-phone-filled"></i>
                                                    </div>
                                                    <p class="contact-text mb-0">{{ $company->company_phone ?? 'Not added' }}</p>
                                                </div>
                                                <div class="contact-item py-1 d-flex align-items-center">
                                                    <div class="contact-icon me-2">
                                                        <i class="ti ti-world-www"></i>
                                                    </div>
                                                    <p class="contact-text mb-0">{{ $company->website_link ?? 'Not added'}}</p>
                                                </div>
                                                <div class="contact-item py-1 d-flex align-items-center">
                                                    <div class="contact-icon me-2">
                                                        <i class="ti ti-map-pin-filled"></i>
                                                    </div>
                                                    <p class="contact-text mb-0">{{ $company->address ?? 'Not added'}}</p>
                                                </div>
                                                <div class="d-flex justify-content-center">
                                                    @can('View Job')
                                                    <a href="{{ route('filter_job', [
                                                            'job_name' => '',
                                                            'company_name' => $company->company_name,
                                                            'country_id' => '',
                                                            'search_terms' => '',
                                                            'job_type' => ''
                                                            ]) }}" class="btn btn-sm py-2 btn-gradient mt-3 d-inline-flex align-items-center">
                                                        <i class="ti ti-graduation-cap-filled me-2"></i>
                                                        View Jobs
                                                    </a>
                                                    @endcan
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row mt-4">
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="pagination-container">
                                        {{ $companies->appends(request()->query())->links() }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <p>
                                        Showing {{ $companies->count() }} records on page {{ $companies->currentPage() }} of {{ $companies->lastPage() }}
                                        (Total: {{ $companies->total() }} records)
                                    </p>
                                </div>
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
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById(`delete-company-form-${id}`);
                    form.action = "{{ route('delete_company', '') }}/" + id;
                    form.submit();
                }
            });
        }
    </script>
@endpush
