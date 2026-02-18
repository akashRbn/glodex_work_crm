@extends('layouts.app')
@section('title', '| Edit Job')
@section('content')
    <!-- Begin page -->
    <div class="wrapper">
        <div class="page-container">
            <div class="row mt-2">
                <div class="col-xl-12">
                    <div class="card">
                        <div
                            class="card-header border-bottom border-dashed d-flex align-items-center justify-content-between">
                            <h4 class="header-title mb-0">Edit Job</h4>
                            <div class="d-flex">
                                <a href="{{ route('job_list') }}" class="btn btn-sm btn-secondary me-2">
                                    <i class="ti ti-arrow-back-up"
                                        style="margin-right:3px; font-size: 1.3rem; margin-bottom: 1px"></i>
                                    Go Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="courseForm" action="{{ route('update_job', $job->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="job_name" class="form-label">Job Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="job_name" name="job_name" value="{{ old('job_name', $job->job_name ?? '') }}" placeholder="Enter job name" required>
                                        @error('job_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="company_id" class="form-label">Company Name <span class="text-danger">*</span></label>
                                        <select class="form-control" id="company_id" name="company_id" data-choices required>
                                            <option value="">--Select Company--</option>

                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}"
                                                    {{ old('company_id', $job->company_id ?? '') == $company->id ? 'selected' : '' }}>
                                                    
                                                    {{ $company->company_name }}
                                                    @if($company->country)
                                                        ({{ $company->country->country_name }})
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('company_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="country_id" class="form-label">Country <span class="text-danger">*</span></label>
                                        <select class="form-control" id="country_id" name="country_id" data-choices required>
                                            <option value="">--Select Country--</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ old('country_id', $job->country_id ?? '') == $country->id ? 'selected' : '' }}>
                                                    {{ $country->country_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="avilable_positions" class="form-label">Avilable Positions<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="avilable_positions" name="avilable_positions" value="{{ old('avilable_positions', $job->avilable_positions ?? '') }}" placeholder="Enter available positions" required>
                                        @error('avilable_positions')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="job_type" class="form-label">Job Type<span class="text-danger">*</span></label>
                                        <select class="form-control"  id="job_type" name="job_type" required>
                                            <option value="">--Select Job Type--</option>
                                            <option value="1" {{ old('job_type', $job->job_type ?? '') == 1 ? 'selected' : '' }}>Full Time</option>
                                            <option value="2" {{ old('job_type', $job->job_type ?? '') == 2 ? 'selected' : '' }}>Part Time</option>
                                        </select>
                                        @error('job_type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="experience_level" class="form-label">Experience Level<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="experience_level" name="experience_level" value="{{ old('experience_level', $job->experience_level ?? '') }}" placeholder="Enter experience level" required>
                                        @error('experience_level')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="intial_fees" class="form-label">Initial Fees<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="intial_fees" name="intial_fees" value="{{ old('intial_fees', $job->intial_fees ?? '') }}" placeholder="Enter initial fees" required>
                                        @error('intial_fees')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="job_location" class="form-label">Job Location<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="job_location" name="job_location" value="{{ old('job_location', $job->job_location ?? '') }}" placeholder="Enter job location" required>
                                        @error('job_location')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="job_details" class="form-label">Job Details<span class="text-danger">*</span></label>
                                        <div id="snow-editor" style="height: 400px;">
                                            {!! old('job_details', $job->job_details ?? '') !!}
                                        </div>
                                        <input type="hidden" name="job_details" id="job_details">
                                        @error('job_details')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                </div>
                            </form>
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
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.js-choices').forEach(function (el) {
                if (el.dataset.choicesInitialized) return;

                new Choices(el, {
                removeItemButton: true,
                shouldSort: false,        
                shouldSortItems: false, 
                searchEnabled: true,
                });

                el.dataset.choicesInitialized = '1';
            });
        });
    </script>

    <script>
        document.querySelector("#courseForm").addEventListener("submit", function() {
            document.querySelector("#job_details").value = quill.root.innerHTML;
        });

        @if(old('job_details'))
            quill.root.innerHTML = {!! json_encode(old('job_details')) !!};
        @endif 
    </script>
@endpush
