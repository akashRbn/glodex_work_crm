@extends('layouts.app')
@section('title', '| My Applicant List')
@section('content')
    <!-- Begin page -->
    <div class="wrapper">
        <div class="page-container">
            <div class="row mt-2">
                <div class="col-xl-12">
                    <div class="card">
                       <div class="card-header border-bottom border-dashed d-flex align-items-center justify-content-between">
                            <h4 class="header-title mb-0">My Applicants</h4>
                            <div class="d-flex items-center gap-2">
                                @can('Create Applicant')
                                <a href="{{ route('add_new_applicant') }}" class="btn btn-sm glodex-blue-btn">
                                    <i class="ti ti-plus me-2"></i>
                                    Add New
                                </a>
                                @endcan
                                <a href="{{ route('my_applicant_list') }}" class="btn btn-sm glodex-blue-btn" id="addNewCountryBtn">
                                    <i class="ti ti-rotate me-2"></i>
                                    Refresh
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive-sm">
                                <table id="dataTable" class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Applicant ID</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Gender</th>
                                            <th>Created By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($applicants as  $applicant)
                                            <tr>
                                                <td>
                                                    <div class="dropdown position-relative">
                                                        <button
                                                            type="button"
                                                            class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill"
                                                            data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="ti ti-dots-vertical ti-md"></i>
                                                        </button>

                                                        <div class="dropdown-menu">
                                                            @can('Edit Applicant')
                                                            <a href="{{ route('edit_applicant', $applicant->id) }}" class="dropdown-item d-flex align-items-center gap-1" title="Login As">
                                                                <i class="ti ti-edit ti-md"></i> <span>Edit</span>
                                                            </a>
                                                            @endcan
                                                            @can('Delete Applicant')
                                                             <a class="dropdown-item" href="#"  onclick="confirmDelete({{ $applicant->id }})"><i class="ti ti-trash me-2"></i> Delete</a>
                                                            <form id="delete-applicant-form-{{ $applicant->id }}" method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                   <span class="badge bg-primary">{{ $applicant->applicant_code ?? 'Not Added' }}</span>
                                                </td>
                                                <td>{{ $applicant->name ?? 'Not Added' }}</td>
                                                <td>{{ $applicant->phone ?? 'Not Added' }}</td>
                                                <td>{{ $applicant->email ?? 'Not Added' }}</td>
                                                <td>
                                                    @if($applicant->gender == 1)
                                                        <span class="badge bg-primary">Male</span>
                                                    @else
                                                        <span class="badge bg-secondary">Female</span>
                                                    @endif
                                                </td>
                                                <td>{{ $applicant->createdBy->name ?? 'Not Added' }}</td>
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
                    const form = document.getElementById(`delete-applicant-form-${id}`);
                    form.action = "{{ route('delete_applicant', '') }}/" + id;
                    form.submit();
                }
            });
        }
    </script>
@endpush
