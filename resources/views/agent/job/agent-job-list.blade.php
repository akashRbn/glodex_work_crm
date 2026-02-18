@extends('layouts.app')
@section('title', '| Job List')
@push('page-css')
    <link rel="stylesheet" href="{{ asset('css/course/course-list.css') }}">
@endpush
@section('content')
<div class="wrapper">
    <div class="page-container">
        <div class="row mt-2">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-bottom border-dashed d-flex align-items-center justify-content-between">
                        <h4 class="header-title mb-0">Jobs</h4>
                        <div class="d-flex items-center gap-1">
                            <a href="{{ route('agent_job_list') }}" class="btn btn-sm glodex-blue-btn" id="addNewCountryBtn">
                                <i class="ti ti-rotate me-2"></i>
                                Refresh
                            </a>
                            <button class="btn btn-sm glodex-blue-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#course_filterBtn" aria-controls="offcanvasRight">
                                <i class="ti ti-filter me-2"></i>
                                Filter
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="glodex-show-entries d-flex align-items-center justify-content-between flex-wrap gap-3">
                                    <!-- Show entries dropdown -->
                                    <form method="GET" action="{{ route('agent_search_job') }}" class="d-flex align-items-center gap-2">
                                        <label for="glodex-show-entries" class="form-label mb-0">Show</label>
                                        <select name="per_page" id="glodex-show-entries" class="form-select form-select-sm w-auto"
                                            onchange="this.form.submit()">
                                            <option value="8" {{ request('per_page') == 8 ? 'selected' : '' }}>8</option>
                                            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                        </select>
                                        <span>entries</span>
                                        <input type="hidden" name="agent_search_job" value="{{ request('agent_search_job') }}">
                                        <input type="hidden" name="search_country" value="{{ request('search_country') }}">
                                    </form>

                                    <!-- Search form -->
                                    <form action="{{ route('agent_search_job') }}" method="GET" class="d-flex align-items-center align-items-end">
                                        <div class="glodex-search-field glodex-search-field-doble">
                                            <!-- What to Study -->
                                            <input type="search" name="search_job" id="glodex-job-search"
                                                class="form-control form-control-sm mb-0"
                                                value="{{ request('agent_search_job') }}" placeholder="What Job are you looking for?">
                                        </div>

                                        <div class="glodex-search-field glodex-search-field-right d-flex align-items-center">
                                            <!-- Where to Study -->
                                            <input type="search" name="search_country" id="glodex-country-search"
                                                class="form-control form-control-sm mb-0"
                                                value="{{ request('search_country') }}" placeholder="Where to Work?">
                                            <button type="submit" class="btn btn-sm glodex-blue-btn">
                                                <i class="ti ti-search" style="font-size: 1.3rem;"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="row pb-4">
                            @foreach ($jobs as $job)
                                <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 col-xxl-3 mb-3">
                                    <div class="course-list-card border position-relative">

                                        <!-- 3 Dots Dropdown -->
                                        <div class="btn-group glodex-custom-3dot-dropdown">
                                            <button type="button" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('agent_job_details', $job->id) }}"><i class="ti ti-map-pin me-2"></i>Job Details</a></li>
                                            </ul>
                                        </div>

                                        <!-- Card Header Section -->
                                        <div class="card-header-section">
                                            <h1 class="course-title">{{ $job->job_name ?? 'Not Added' }}</h1>
                                            <div class="university-info">
                                                <div class="university-details">
                                                    <h3>{{ $job->company->company_name ?? 'Not Added' }}</h3>
                                                    <p><i class="ti ti-flag"></i>{{ $job->country->country_name ?? 'Not Added' }}</p>
                                                </div>
                                                <div class="university-logo">
                                                   <img src="{{ $job->company && $job->company->logo && file_exists(public_path($job->company->logo))
                                                            ? asset($job->company->logo)
                                                            : asset('back-end/assets/images/dr-profile/image-upload.jpg') }}"
                                                    alt="{{ $job->company->company_name ?? 'Company Logo' }}"
                                                    class="img-fluid rounded-4">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Card Body Section -->
                                        <div class="card-body-section">
                                            <div class="info-grid">
                                                <div class="info-item">
                                                    <h4 class="d-flex align-items-center gap-1">
                                                        <i class="ti ti-status-change" style="font-size: 18px;"></i>Available Jobs
                                                    </h4>
                                                    <div class="info-value">{{ $job->avilable_positions ?? 'Not Added' }}</div>
                                                </div>

                                                <div class="info-item">
                                                    <h4 class="d-flex align-items-center gap-1">
                                                        <i class="ti ti-calendar-check" style="font-size: 18px;"></i>Job Type
                                                    </h4>
                                                     {{ $job->job_type == 1 ? 'Full Time' : ($job->job_type == 2 ? 'Part Time' : 'Not Added') }}
                                                </div>
                                            </div>

                                            <div class="info-grid">
                                                <div class="info-item">
                                                    <h4 class="d-flex align-items-center gap-1">
                                                        <i class="ti ti-brand-framer" style="font-size: 18px;"></i>Experience
                                                    </h4>
                                                    <div class="info-value price">{{ $job->experience_level ?? 'Not Added' }}</div>
                                                </div>

                                                <div class="info-item">
                                                    <h4 class="d-flex align-items-center gap-1">
                                                        <i class="ti ti-currency-dollar" style="font-size: 18px;"></i>Initial Fees
                                                    </h4>
                                                    <div class="info-value price">{{ $job->intial_fees ?? 'Not Added' }}</div>
                                                </div>
                                            </div>
                                            <div class="pt-2 d-flex justify-content-center">
                                                <a href="#" class="btn btn-sm btn-gradient" target="_blank" data-bs-toggle="modal"
                                                data-bs-target="#modalCenter{{ $job->id }}">Apply Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modalCenter{{ $job->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalCenterTitle">Start Application For
                                                    {{ $job->job_title }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6 text-center">
                                                        <a href="javascript:void(0);" 
                                                            class="btn btn-dark w-100 d-flex align-items-center justify-content-center" 
                                                            style="height: 60px;  font-size: 18px;"
                                                            onclick="toggleSelect('existingStudentSelect{{ $job->id }}')">
                                                                <i class="ti ti-search me-1"></i> Existing Applicant
                                                        </a>
                                                    </div>
                                                    <div class="col-md-6 text-center">
                                                        <a href="{{ route('agent_application_new_applicant', ['job_id' => $job->id]) }}" class="btn btn-success w-100 d-flex align-items-center justify-content-center"
                                                            style="height: 60px; font-size: 18px;">
                                                            <i class="ti ti-pencil me-1"></i> New Applicant
                                                        </a>
                                                    </div>
                                                    <div id="existingStudentSelect{{ $job->id }}" style="display: none; margin-top: 10px;">
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <select id="studentSelect{{ $job->id }}" data-choices id="choices-single-default"
                                                                        class="form-control"
                                                                        onchange="updateStartButton({{ $job->id }})">
                                                                    <option value="">-- Select Applicant --</option>
                                                                    @foreach($applicants as $applicant)
                                                                        <option value="{{ $applicant->id }}">{{ $applicant->name }} ({{ $applicant->email }})</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3 d-flex align-items-end">
                                                                <a href="#" id="startApplicationBtn{{ $job->id }}" 
                                                                class="btn btn-success w-100"
                                                                onclick="startApplication({{ $job->id }})">
                                                                    Start
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center">
                                <div class="pagination-container">
                                    {{ $jobs->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <p>
                                    Showing {{ $jobs->count() }} records on page {{ $jobs->currentPage() }} of {{ $jobs->lastPage() }}
                                    (Total: {{ $jobs->total() }} records)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="offcanvas offcanvas-end" tabindex="-1" id="course_filterBtn" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h4 class="offcanvas-title" id="offcanvasRightLabel">Job Filter</h4>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <form action="{{ route('agent_filter_job') }}" method="GET">
        <div class="mb-3">
            <label for="job_name" class="form-label">Job Name:</label>
            <input type="text" class="form-control" name="job_name" id="job_name"
                value="{{ request('job_name') }}" placeholder="Job Name">
        </div>

        <div class="mb-3">
            <label for="company_name" class="form-label">Company Name:</label>
            <input type="text" class="form-control" name="company_name" id="company_name"
                value="{{ request('company_name') }}" placeholder="Company Name">
        </div>

        <div class="mb-3">
            <label for="country_id" class="form-label">Country Name:</label>
            <select class="form-control" name="country_id" id="country_id" data-choices>
                <option value="">--Select Country--</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>
                        {{ $country->country_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="job_type" class="form-label">Job Type:</label>
            <select class="form-control" id="job_type" name="job_type">
                <option value="">--Select Job Type--</option>
                <option value="1" {{ request('job_type') == 1 ? 'selected' : '' }}>Full Time</option>
                <option value="2" {{ request('job_type') == 2 ? 'selected' : '' }}>Part Time</option>
            </select>
        </div>
        <button type="submit" class="btn btn-sm glodex-blue-btn">Apply Filter</button>
    </form>
  </div>
</div>
<!-- END wrapper -->
@endsection
@push('page-js')
  <script>
      document.addEventListener('DOMContentLoaded', function() {
        const canvas = new bootstrap.Offcanvas('#course-rbnss-canvaas');
        document.querySelector('#course-customFilterBtn').addEventListener('click', function() {
            canvas.show();
        });
      });
    </script>
    <script>
        function toggleSelect(selectId) {
            const selectDiv = document.getElementById(selectId);
            selectDiv.style.display = (selectDiv.style.display === "none" || selectDiv.style.display === "") 
                ? "block" 
                : "none";
        }

        function updateStartButton(courseId) {
            const select = document.getElementById('studentSelect' + courseId);
            const startButton = document.getElementById('startApplicationBtn' + courseId);
            const selectedStudentId = select.value;

            // Store selected student in a data attribute
            startButton.setAttribute('data-student-id', selectedStudentId);
        }

        function startApplication(courseId) {
            const startButton = document.getElementById('startApplicationBtn' + courseId);
            const selectedStudentId = startButton.getAttribute('data-student-id');

            if (!selectedStudentId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Please select a student first!',
                    showConfirmButton: false,
                    timer: 1500
                });
                return;
            }
 
            const url = "{{ route('agent_application_existing_applicant', ['job_id' => '__job_id__', 'applicant_id' => '__applicant_id__']) }}"
            .replace('__job_id__', courseId) 
            .replace('__applicant_id__', selectedStudentId);


            // Redirect to that page
            window.location.href = url;
        }
    </script>
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
                    const form = document.getElementById(`delete-course-form-${id}`);
                    form.action = "{{ route('delete_job', '') }}/" + id;
                    form.submit();
                }
            });
        }
    </script>
@endpush
