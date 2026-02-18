@extends('layouts.app')
@section('title', '| Student List')
@section('content')
    <!-- Begin page -->
    <div class="wrapper">
        <div class="page-container">
            <div class="row mt-2">
                <div class="col-xl-12">
                    <div class="card">
                       <div class="card-header border-bottom border-dashed d-flex align-items-center justify-content-between">
                            <h4 class="header-title mb-0">Student List</h4>
                            <div class="d-flex items-center gap-2">
                                <a href="{{ route('agent_add_new_student') }}" class="btn btn-sm glodex-blue-btn">
                                    <i class="ti ti-plus me-2"></i>
                                    Add New
                                </a>
                                <a href="#" class="btn btn-sm glodex-blue-btn" id="addNewCountryBtn">
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
                                            <th>Student ID</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Gender</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as  $student)
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
                                                            <a href="{{ route('agent_edit_student', $student->id) }}" class="dropdown-item d-flex align-items-center gap-1" title="Login As">
                                                                <i class="ti ti-edit ti-md"></i> <span>Edit</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                   <span class="badge bg-primary">{{ $student->student_code ?? 'Not Added' }}</span>
                                                </td>
                                                <td>{{ $student->name ?? 'Not Added' }}</td>
                                                <td>{{ $student->phone ?? 'Not Added' }}</td>
                                                <td>{{ $student->email ?? 'Not Added' }}</td>
                                                <td>
                                                    @if($student->gender == 1)
                                                        <span class="badge bg-primary">Male</span>
                                                    @else
                                                        <span class="badge bg-secondary">Female</span>
                                                    @endif
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
                    form.action = "{{ route('delete_course', '') }}/" + id;
                    form.submit();
                }
            });
        }
    </script>
@endpush
