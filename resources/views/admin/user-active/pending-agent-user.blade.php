@extends('layouts.app')
@section('content')
    <!-- Begin page -->
    <div class="wrapper">
        <div class="page-container">
            <div class="row mt-2">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header border-bottom border-dashed d-flex align-items-center justify-content-between">
                            <h4 class="header-title mb-0">Pending Agent User</h4>
                            <a href="{{ route('admin_dashboard') }}" class="btn btn-sm btn-secondary">
                                <i class="ti ti-arrow-back-up" style="margin-right:3px; font-size: 1.3rem; margin-bottom: 1px"></i>Go Back 
                            </a>
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
                                            <th>Organization</th>
                                            <th>Created By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingAgentUsers as  $user)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('update_user_status', $user->id) }}"
                                                        class="btn btn-sm fw-bold {{ $user->user_status == 1 ? 'btn-secondary' : 'btn-dark' }}">
                                                        {{ $user->user_status == 1 ? 'Approve' : 'Pending' }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if($user->user_status == 1)
                                                        <span class="badge bg-primary badge bg-primary px-2 py-1 fs-11 me-2">Pending</span>
                                                    @else
                                                        <span class="badge bg-success badge bg-primary px-2 py-1 fs-11 me-2">Approved</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <img src="{{asset('back-end/assets/images/users/dummy-user.jpg')}}" alt="table-user" class="avatar-sm me-2 rounded-circle" />
                                                    {{$user->name ?? 'Not Added'}}
                                                </td>
                                                <td>{{ $user->phone ?? 'Not Added' }}</td>
                                                <td>{{ $user->email ?? 'Not Added' }}</td>
                                                <td>{{ $user->organization_name ?? 'Not Added' }}</td>
                                                <td>
                                                   {{ $user->creator->name ?? 'Not Added' }}
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
@endpush