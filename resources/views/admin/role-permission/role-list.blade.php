@extends('layouts.app')
@section('title', '| Roles')

@section('content')
    <div class="wrapper">
        <div class="page-container">
            <div class="row mt-2">
                <div class="col-xl-12">
                    <div class="card">

                        {{-- HEADER --}}
                        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Roles</h4>
                            @can('View Role')
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#assignRoleModal">
                                <i class="ti ti-plus me-1"></i> Assign Role
                            </button>
                            @endcan
                        </div>

                        {{-- BODY --}}
                        <div class="card-body">
                            <div class="row g-4">
                                {{-- ROLE CARDS --}}
                                @foreach ($roles as $role)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card h-100 shadow-sm border-start border-primary mb-0">
                                            <div class="card-body p-x-4 py-3">
                                                <h5 class="fw-semibold mb-1">{{ $role->name ?? 'Not Found'}}</h5>

                                                {{-- EDIT ROLE --}}
                                                <div class="d-flex align-items-center justify-content-between ">
                                                   {{-- @can('Edit Roles') --}}
                                                   <a href="javascript:void(0)" class="text-primary edit-role-btn"
                                                        data-bs-toggle="modal" data-bs-target="#editRoleModal"
                                                        data-role="{{ $role->load('permissions')->toJson() }}">
                                                        Edit Role
                                                    </a>
                                                    {{-- @endcan --}}
                                                    <i class="ti ti-copy ti-md text-heading"></i>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                {{-- ADD NEW ROLE CARD --}}
                                <div class="col-lg-4 col-md-6">
                                    <div class="card h-100 d-flex align-items-center justify-content-center shadow-sm border-start border-primary mb-0"
                                        style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#rolePermissionModal">
                                        <div class="card-body w-100 p-x-4 py-3 ">
                                            @can('Create Role')
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div style="font-size:32px">👩‍💼</div>
                                                <button class="btn btn-primary">Add New Role</button>
                                            </div>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= ASSIGN ROLE MODAL ================= --}}
  <form action="{{ route('assign_role') }}" method="POST">
    @csrf

    <div class="modal fade" id="assignRoleModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title">Assign Role</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    {{-- Select Role --}}
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role_name" class="form-select" required>
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Select User --}}
                    <div class="mb-3">
                        <label class="form-label">User</label>
                        <select name="user_id" class="form-select" required>
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Assign Role</button>
                </div>

            </div>
        </div>
    </div>
</form>


    {{-- ================= ADDNEW ROLE MODAL ================= --}}
    @include('admin.role-permission.add-new-role-modal')
    @include('admin.role-permission.edit-role-modal')
@endsection

{{-- ================= PAGE JS ================= --}}
@push('page-js')
    <script>
        document.querySelectorAll('.edit-role-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                let role = JSON.parse(this.dataset.role);

                // Set role ID and name
                document.getElementById('editRoleId').value = role.id;
                document.getElementById('editRoleName').value = role.name;

                // Uncheck all permissions first
                document.querySelectorAll('#editRoleModal .permission-checkbox').forEach(cb => cb.checked = false);

                // Check permissions assigned to this role
                if(role.permissions) {
                    role.permissions.forEach(p => {
                        let checkbox = document.querySelector('#editRoleModal input[value="'+p.name+'"]');
                        if(checkbox) checkbox.checked = true;
                    });
                }
            });
        });
    </script>
@endpush
