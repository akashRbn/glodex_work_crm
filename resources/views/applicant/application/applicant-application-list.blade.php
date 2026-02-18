@extends('layouts.app')
@section('title', '| Application List')
@push('page-css')
    <link rel="stylesheet" href="{{ asset('css/custom-status.css') }}">
@endpush
@section('content')
    <!-- Begin page -->
    <div class="wrapper">
        <div class="page-container">
            <div class="row mt-2">
                <div class="col-xl-12">
                    <div class="card">
                       <div class="card-header border-bottom border-dashed d-flex align-items-center justify-content-between">
                            <h4 class="header-title mb-0">Application List</h4>
                            <div class="d-flex">
                                <a href="{{ route('applicant_dashboard') }}" class="btn btn-sm btn-secondary me-2">
                                    <i class="ti ti-arrow-back-up" style="margin-right:3px; font-size: 1.3rem; margin-bottom: 1px"></i>
                                    Go Back 
                                </a>
                                <a href="{{ route('applicant_job_list') }}" class="btn btn-sm btn-primary me-2">
                                    <i class="ti ti-plus" style="margin-right:3px; font-size: 1.3rem; margin-bottom: 1px"></i>
                                    Add New
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive-sm">
                                <table id="dataTable" class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Application ID</th>
                                            <th>Applicant ID</th>
                                            <th>Name</th>
                                            <th>Job</th>
                                            <th>Going Year</th>
                                            <th>Company</th>
                                            <th>Duration</th>
                                            <th>Application Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         @foreach($applications as $application)
                                            <tr>
                                                <td>
                                                    @php
                                                        $statusColors = [
                                                            'In Progress' => 'badge-in-progress',
                                                            'On Hold' => 'badge-on-hold',
                                                            'Applied' => 'badge-applied',
                                                            'Permit Received' => 'badge-unconditional',                                                            
                                                            'Visa Applied' => 'badge-visa-applied',
                                                            'Visa Granted' => 'badge-visa-granted',
                                                            'Enrolled' => 'badge-enrolled',
                                                            'Visa Rejected' => 'badge-rejected',
                                                            'Canceled' => 'badge-canceled',
                                                        ];

                                                        $statusName = $application->applicationStatus->status_name ?? 'N/A';
                                                        $badgeClass = $statusColors[$statusName] ?? 'badge-canceled';
                                                    @endphp

                                                    <span class="badge {{ $badgeClass }}">{{ $statusName }}</span>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <span class="badge bg-primary">
                                                        {{ $application->application_code ?? 'Not Added' }}
                                                    </span>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <span class="badge bg-dark">
                                                        {{ $application->applicant->applicant_code ?? 'Not Added' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ $application->applicant->name ?? 'Not Added' }}
                                                </td>
                                                <td>
                                                    {{ $application->job->job_name ?? 'Not Added' }}
                                                </td>
                                                <td class="text-center align-middle">
                                                    <span class="badge bg-success">
                                                        @if ($application->going_year && \Carbon\Carbon::hasFormat($application->going_year, 'Y-m'))
                                                            {{ \Carbon\Carbon::createFromFormat('Y-m', $application->going_year)->format('F Y') }}
                                                        @else
                                                            Not Added
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ $application->job->company->company_name ?? '--' }}
                                                </td>
                                                <td>
                                                    <span class="timer" data-time="{{ $application->expires_at }}"></span>
                                                </td>
                                                <td>
                                                    {{ $application->created_at->format('Y-m-d') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->
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
        document.addEventListener('DOMContentLoaded', function () {

            document.querySelectorAll('.timer').forEach(el => {
                let end = new Date(el.dataset.time).getTime();

                function update() {
                    let now = new Date().getTime();
                    let diff = end - now;

                    if (diff <= 0) {
                        el.innerText = "Expired";
                        return;
                    }

                    let days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    let hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
                    let minutes = Math.floor((diff / (1000 * 60)) % 60);
                    let seconds = Math.floor((diff / 1000) % 60);

                    el.innerText = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                }

                update();
                setInterval(update, 1000);
            });

        });
    </script>
@endpush