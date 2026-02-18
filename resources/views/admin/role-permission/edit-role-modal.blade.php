{{-- ================= EDIT ROLE MODAL ================= --}}
<form action="{{ route('update_role') }}" method="POST">
    @csrf
    <input type="hidden" name="role_id" id="editRoleId">
    <div class="modal fade" id="editRoleModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Permission For This Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body px-0">
                    <div class="mb-3 px-3">
                        <label class="form-label">Role Name</label>
                        <input type="text" name="role_name" class="form-control" id="editRoleName" readonly>
                    </div>

                   <div class="pb-2 pt-2 border-bottom px-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-semibold mb-0">User Management</h5>
                        <div class="d-flex justify-content-start flex-wrap ">

                            <div class="form-check me-4">
                                <input id="viewCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="View User">
                                <label for="viewCountry" class="form-check-label">View</label>
                            </div>
                            <div class="form-check me-4">
                                <input id="createCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Create User">
                                <label for="createCountry" class="form-check-label">Create</label>
                            </div>

                            <div class="form-check me-4">
                                <input id="deleteCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Delete User">
                                <label for="deleteCountry" class="form-check-label">Delete</label>
                            </div>
                        </div>
                    </div>
                    <div class="pb-2 pt-2 border-bottom px-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-semibold mb-0">Roles Management</h5>
                        <div class="d-flex justify-content-start flex-wrap ">

                            <div class="form-check me-4">
                                <input id="viewCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="View Role">
                                <label for="viewCountry" class="form-check-label">View</label>
                            </div>
                            <div class="form-check me-4">
                                <input id="createCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Create Role">
                                <label for="createCountry" class="form-check-label">Create</label>
                            </div>
                            <div class="form-check me-4">
                                <input id="editCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Edit Role">
                                <label for="editCountry" class="form-check-label">Edit</label>
                            </div>
                        </div>
                    </div>
                    <div class="pb-2 pt-2 border-bottom px-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-semibold mb-0">Permission Management</h5>
                        <div class="d-flex justify-content-start flex-wrap ">
                            <div class="form-check me-4">
                                <input id="viewCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="View Permission">
                                <label for="viewCountry" class="form-check-label">View</label>
                            </div>
                            <div class="form-check me-4">
                                <input id="createCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Create Permission">
                                <label for="createCountry" class="form-check-label">Create</label>
                            </div>
                        </div>
                    </div>
                    <div class="pb-2 pt-2 border-bottom px-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-semibold mb-0">Pending Partner</h5>
                        <div class="d-flex justify-content-start flex-wrap ">

                            <div class="form-check me-4">
                                <input id="viewCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="View Pending Agent">
                                <label for="viewCountry" class="form-check-label">View</label>
                            </div>
                        </div>
                    </div>
                    <div class="pb-2 pt-2 border-bottom px-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-semibold mb-0">Active Partner</h5>
                        <div class="d-flex justify-content-start flex-wrap ">

                            <div class="form-check me-4">
                                <input id="viewCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="View Active Agent">
                                <label for="viewCountry" class="form-check-label">View</label>
                            </div>
                            <div class="form-check me-4">
                                <input id="viewCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Create Agent">
                                <label for="viewCountry" class="form-check-label">Create</label>
                            </div>
                            <div class="form-check me-4">
                                <input id="deleteCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Delete Agent">
                                <label for="viewCountry" class="form-check-label">Delete</label>
                            </div>
                            <div class="form-check me-4">
                                <input id="deleteCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Approval Agent">
                                <label for="viewCountry" class="form-check-label">Pending</label>
                            </div>
                        </div>
                    </div>
                    <div class="pb-2 pt-2 border-bottom px-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-semibold mb-0">Pending Lawyer</h5>
                        <div class="d-flex justify-content-start flex-wrap ">
                            <div class="form-check me-4">
                                <input id="viewCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="View Pending Lawyer">
                                <label for="viewCountry" class="form-check-label">View</label>
                            </div>
                        </div>
                    </div>
                    <div class="pb-2 pt-2 border-bottom px-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-semibold mb-0">Active Lawyer</h5>
                        <div class="d-flex justify-content-start flex-wrap ">
                            <div class="form-check me-4">
                                <input id="viewCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="View Active Lawyer">
                                <label for="viewCountry" class="form-check-label">View</label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start flex-wrap ">
                            <div class="form-check me-4">
                                <input id="viewCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Delete Lawyer">
                                <label for="viewCountry" class="form-check-label">Delete</label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start flex-wrap ">
                            <div class="form-check me-4">
                                <input id="viewCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Approval Lawyer">
                                <label for="viewCountry" class="form-check-label">Pending</label>
                            </div>
                        </div>
                    </div>
                     <div class="pb-2 pt-2 border-bottom px-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-semibold mb-0">Pending Applicant</h5>
                        <div class="d-flex justify-content-start flex-wrap ">

                            <div class="form-check me-4">
                                <input id="viewCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="View Pending Applicant">
                                <label for="viewCountry" class="form-check-label">View</label>
                            </div>
                        </div>
                    </div>
                    <div class="pb-2 pt-2 border-bottom px-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-semibold mb-0">Country Management</h5>
                        <div class="d-flex justify-content-start flex-wrap ">

                            <div class="form-check me-4">
                                <input id="viewCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="View Country">
                                <label for="viewCountry" class="form-check-label">View</label>
                            </div>

                            <div class="form-check me-4">
                                <input id="editCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Edit Country">
                                <label for="editCountry" class="form-check-label">Edit</label>
                            </div>

                            <div class="form-check me-4">
                                <input id="createCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Create Country">
                                <label for="createCountry" class="form-check-label">Create</label>
                            </div>

                            <div class="form-check me-4">
                                <input id="deleteCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Delete Country">
                                <label for="deleteCountry" class="form-check-label">Delete</label>
                            </div>
                        </div>
                    </div>
                    <div class="pb-2 pt-2 border-bottom px-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-semibold mb-0">Company Management</h5>
                        <div class="d-flex justify-content-start flex-wrap ">

                            <div class="form-check me-4">
                                <input id="viewCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="View Company">
                                <label for="viewCountry" class="form-check-label">View</label>
                            </div>

                            <div class="form-check me-4">
                                <input id="editCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Edit Company">
                                <label for="editCountry" class="form-check-label">Edit</label>
                            </div>

                            <div class="form-check me-4">
                                <input id="createCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Create Company">
                                <label for="createCountry" class="form-check-label">Create</label>
                            </div>

                            <div class="form-check me-4">
                                <input id="deleteCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Delete Company">
                                <label for="deleteCountry" class="form-check-label">Delete</label>
                            </div>
                        </div>
                    </div>
                    <div class="pb-2 pt-2 border-bottom px-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-semibold mb-0">Job Management</h5>
                        <div class="d-flex justify-content-start flex-wrap ">

                            <div class="form-check me-4">
                                <input id="viewCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="View Job">
                                <label for="viewCountry" class="form-check-label">View</label>
                            </div>

                            <div class="form-check me-4">
                                <input id="editCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Edit Job">
                                <label for="editCountry" class="form-check-label">Edit</label>
                            </div>

                            <div class="form-check me-4">
                                <input id="createCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Create Job">
                                <label for="createCountry" class="form-check-label">Create</label>
                            </div>

                            <div class="form-check me-4">
                                <input id="deleteCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Delete Job">
                                <label for="deleteCountry" class="form-check-label">Delete</label>
                            </div>
                        </div>
                    </div>
                    <div class="pb-2 pt-2 border-bottom px-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-semibold mb-0">Applicant Management</h5>
                        <div class="d-flex justify-content-start flex-wrap ">

                            <div class="form-check me-4">
                                <input id="viewCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="View Applicant">
                                <label for="viewCountry" class="form-check-label">View</label>
                            </div>

                            <div class="form-check me-4">
                                <input id="editCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Edit Applicant">
                                <label for="editCountry" class="form-check-label">Edit</label>
                            </div>

                            <div class="form-check me-4">
                                <input id="createCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Create Applicant">
                                <label for="createCountry" class="form-check-label">Create</label>
                            </div>

                            <div class="form-check me-4">
                                <input id="deleteCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Delete Applicant">
                                <label for="deleteCountry" class="form-check-label">Delete</label>
                            </div>
                        </div>
                    </div>
                    <div class="pb-2 pt-2 border-bottom px-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-semibold mb-0">Partner Applicant Management</h5>
                        <div class="d-flex justify-content-start flex-wrap ">

                            <div class="form-check me-4">
                                <input id="viewCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="View Partner Applicant">
                                <label for="viewCountry" class="form-check-label">View</label>
                            </div>

                            <div class="form-check me-4">
                                <input id="editCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Edit Partner Student">
                                <label for="editCountry" class="form-check-label">Edit</label>
                            </div>
                            <div class="form-check me-4">
                                <input id="deleteCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Delete Partner Applicant">
                                <label for="deleteCountry" class="form-check-label">Delete</label>
                            </div>
                        </div>
                    </div>
                    <div class="pb-2 pt-2 border-bottom px-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-semibold mb-0">Application</h5>
                        <div class="d-flex justify-content-start flex-wrap ">

                            <div class="form-check me-4">
                                <input id="viewCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="View Application">
                                <label for="viewCountry" class="form-check-label">View</label>
                            </div>

                            <div class="form-check me-4">
                                <input id="editCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Edit Application">
                                <label for="editCountry" class="form-check-label">Edit</label>
                            </div>
                            <div class="form-check me-4">
                                <input id="createCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Create Application">
                                <label for="createCountry" class="form-check-label">Create</label>
                            </div>
                        </div>
                    </div>
                    <div class="pb-2 pt-2 border-bottom px-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-semibold mb-0">Partner Application</h5>
                        <div class="d-flex justify-content-start flex-wrap">

                            <div class="form-check me-4">
                                <input id="viewCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="View Partner Application">
                                <label for="viewCountry" class="form-check-label">View</label>
                            </div>

                            <div class="form-check me-4">
                                <input id="editCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Edit Partner Application">
                                <label for="editCountry" class="form-check-label">Edit</label>
                            </div>
                        </div>
                    </div>
                    <div class="pb-2 pt-2 border-bottom px-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-semibold mb-0">All Application</h5>
                        <div class="d-flex justify-content-start flex-wrap ">

                            <div class="form-check me-4">
                                <input id="viewCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="View All Application">
                                <label for="viewCountry" class="form-check-label">View</label>
                            </div>

                            <div class="form-check me-4">
                                <input id="editCountry" class="form-check-input permission-checkbox" type="checkbox" name="permissions[]"
                                    value="Edit All Application">
                                <label for="editCountry" class="form-check-label">Edit</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer pt-0 border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Role</button>
                </div>

            </div>
        </div>
    </div>
</form>
