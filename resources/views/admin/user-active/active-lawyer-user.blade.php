@extends('layouts.app')
@section('title', '| Active Lawyer List')
@section('content')
    <!-- Begin page -->
    <div class="wrapper">
        <div class="page-container">
            <div class="row mt-2">
                <div class="col-xl-12">
                    <div class="card">
                       <div class="card-header border-bottom border-dashed d-flex align-items-center justify-content-between">
                            <h4 class="header-title mb-0">Active Lawyer User</h4>
                            <div class="d-flex">
                                <a href="{{ route('admin_dashboard') }}" class="btn btn-sm btn-secondary me-2">
                                    <i class="ti ti-arrow-back-up" style="margin-right:3px; font-size: 1.3rem; margin-bottom: 1px"></i>
                                    Go Back 
                                </a>
                                <a href="{{ route('admin_dashboard') }}" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#centermodal">
                                    <i class="ti ti-plus" style="margin-right:3px; font-size: 1.3rem; margin-bottom: 1px"></i>
                                    Assign Lawyer
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive-sm">
                                <table id="dataTable" class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Status</th>
                                            <th>Name</th>
                                            <th>Contact</th>
                                            <th>Email</th>
                                            <th>Company</th>
                                            <th>Created By</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activeLawyerUsers as  $user)
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
                                                            {{-- <a href="#" class="dropdown-item d-flex align-items-center gap-1" title="Login As">
                                                                <i class="ti ti-login-2 ti-md"></i> <span>Login</span>
                                                            </a> --}}

                                                            <a href="{{ route('user_profile', $user->id) }}" class="dropdown-item d-flex align-items-center gap-1" title="Profile">
                                                                <i class="ti ti-users ti-md"></i> <span>Profile</span>
                                                            </a>
                                                            @can('Delete Lawyer')
                                                            <a href="javascript:void(0);" 
                                                                onclick="confirmDelete({{ $user->id }})" 
                                                                class="dropdown-item d-flex align-items-center gap-1" 
                                                                title="Delete">
                                                                <i class="ti ti-trash ti-md"></i> <span>Delete</span>
                                                            </a>
                                                            @endcan
                                                            @can('Approval Lawyer')
                                                            <a href="{{ route('update_user_status', $user->id) }}"
                                                                class="dropdown-item d-flex align-items-center gap-1"
                                                                title="{{ $user->user_status == 1 ? 'Approve' : 'Pending' }}">
                                                                @if($user->user_status == 1)
                                                                    <i class="ti ti-check ti-md text-success"></i>
                                                                    <span>Approve</span>
                                                                @else
                                                                    <i class="ti ti-clock ti-md text-warning"></i>
                                                                    <span>Pending</span>
                                                                @endif
                                                            </a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                    <form id="delete-user-form" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                                <td>
                                                    @if($user->user_status == 2)
                                                        <span class="badge bg-primary badge bg-primary px-2 py-1 fs-11 me-2">Active</span>
                                                    @else
                                                        <span class="badge bg-success badge bg-primary px-2 py-1 fs-11 me-2">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <img src="{{asset('back-end/assets/images/users/dummy-user.jpg')}}" alt="table-user" class="avatar-sm me-2 rounded-circle" />
                                                    {{$user->name ?? 'Not Added'}}
                                                </td>
                                                <td>{{ $user->phone ?? 'Not Added' }}</td>
                                                <td>{{ $user->email ?? 'Not Added' }}</td>
                                               <td>
                                                    <ul class="mb-0 ps-3">
                                                        @foreach($user->companies as $company)
                                                            <li>
                                                                {{ $company->company_name }}
                                                                <small class="text-primary">
                                                                    ( {{ $company->country->country_name ?? 'Not Added' }} )
                                                                </small>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>
                                                   {{ $user->creator->name ?? 'Not Added' }}
                                                </td>
                                                <td>
                                                    {{ $user->created_at ? $user->created_at->format('F j, Y') : 'Not Added' }}
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
    {{-- create new agent modal start --}}
    <div class="modal fade" id="centermodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Create New Agent</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form action="{{ route('save_agent') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number<span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number with country code" required>
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address<span class="text-danger">*</span>:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="organization_name" class="form-label">Organization Name<span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control" id="organization_name" name="organization_name" placeholder="Enter organization name" required>
                            @error('organization_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password(At least 8 character)<span class="text-danger">*</span>:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- create new agent modal end --}}
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
                    const form = document.getElementById('delete-user-form');
                    form.action = `/delete-user/${id}`;
                    form.submit();
                }
            });
        }
    </script>
@endpush