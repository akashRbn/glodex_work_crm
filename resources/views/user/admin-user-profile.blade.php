@extends('layouts.app')
@section('title', '| Update Profile')
@section('content')
    <!-- Begin page -->
    <div class="wrapper">
        <div class="page-container">
            <div class="row mt-2">
                <div class="col-xl-12">
                    <div class="card">
                        <div
                            class="card-header border-bottom border-dashed d-flex align-items-center justify-content-between">
                            <h4 class="header-title mb-0">Update User Profile</h4>
                            <div class="d-flex">
                                <a href="{{ route('admin_dashboard') }}" class="btn btn-sm btn-secondary me-2">
                                    <i class="ti ti-arrow-back-up"
                                        style="margin-right:3px; font-size: 1.3rem; margin-bottom: 1px"></i>
                                    Go Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('update_admin_profile') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="userName" class="form-label">Name<span class="text-danger">*</span>:</label>
                                        <input type="text" name="name" class="form-control" id="userName" placeholder="Enter your name" value="{{ old('name', $user->name) }}" />
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="userPhone" class="form-label">Phone<span class="text-danger">*</span>:</label>
                                        <input type="text" name="phone" class="form-control" id="userPhone" placeholder="Enter your phone" value="{{ old('phone', $user->phone) }}" />
                                        @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="userEmail" class="form-label">Email<span class="text-danger">*</span>:</label>
                                        <input type="text" name="email" class="form-control" id="userEmail" placeholder="Enter your email" value="{{ old('email', $user->email) }}" />
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="userDob" class="form-label">Date of Birth<span class="text-danger">*</span>:</label>
                                        <input type="date" name="dob" class="form-control" id="userDob" value="{{ old('dob', $user->dob) }}" />
                                        @error('dob')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="maritalStatus" class="form-label">Marital Status<span class="text-danger">*</span>:</label>
                                        <select id="maritalStatus" name="marital_status" class="form-select">
                                            <option value="">Select Status</option>
                                            <option value="1" {{ old('marital_status', $user->marital_status) == 1 ? 'selected' : '' }}>Single</option>
                                            <option value="2" {{ old('marital_status', $user->marital_status) == 2 ? 'selected' : '' }}>Married</option>
                                        </select>
                                        @error('marital_status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="defaultSelect" class="form-label">Gender<span class="text-danger">*</span>:</label>
                                        <select id="defaultSelect"  name="gender" class="form-select">
                                            <option value="">Select gender</option>
                                            <option value="1" {{ old('gender', $user->gender) == 1 ? 'selected' : '' }}>Male</option>
                                            <option value="2" {{ old('gender', $user->gender) == 2 ? 'selected' : '' }}>Female</option>
                                        </select>
                                        @error('gender')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="userName" class="form-label">Organization Name<span class="text-danger">*</span>:</label>
                                        <input type="text" name="organization_name" class="form-control" id="userName" placeholder="Enter your organizatio name" value="{{ old('organization_name', $user->organization_name) }}" />
                                        @error('organization_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="userName" class="form-label">Address<span class="text-danger">*</span>:</label>
                                        <input type="text" name="address" class="form-control" id="userAddress" placeholder="Enter your address" value="{{ old('address', $user->address) }}" />
                                        @error('address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label for="profile_photo" class="form-label">Profile Picture</label>
                                        <!-- Preview Box -->
                                        <div class="col-md-3">
                                            <div class="photo-preview overflow-hidden shadow"
                                                style="width: 160px; height: 160px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <img id="profile_preview"
                                                    src="{{ isset($user) && $user->profile_photo && file_exists(public_path($user->profile_photo)) 
                                                        ? asset($user->profile_photo) 
                                                        : asset('back-end/assets/images/dr-profile/image-upload.jpg') }}"
                                                    class="w-100 img-fluid"
                                                    style="object-fit: cover; width: 100%; height: 100%; border-radius: 10px;"
                                                    alt="Image Preview">
                                            </div>
                                        </div>

                                        <!-- File Input for Profile Image -->
                                        <img id="profile_image_preview" src="#" alt="Image Preview"
                                            style="display: none; margin-top: 10px; max-width: 100%; height: auto;" />

                                        <div class="fallback mt-3">
                                            <input type="file" name="profile_photo" class="form-control"
                                                accept="image/png, image/gif, image/jpeg, image/jpg"
                                                id="profile_image_input" onchange="previewProfile(event)" />
                                        </div>

                                        @error('profile_photo')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label for="cover_photo" class="form-label">Company Logo</label>

                                        <!-- Preview Box -->
                                        <div class="col-md-3">
                                            <div class="photo-preview overflow-hidden shadow"
                                                style="width: 160px; height: 160px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <img id="company_logo_preview"
                                                    src="{{ isset($user) && $user->company_logo && file_exists(public_path($user->company_logo)) 
                                                        ? asset($user->company_logo) 
                                                        : asset('back-end/assets/images/dr-profile/image-upload.jpg') }}"
                                                    class="w-100 img-fluid"
                                                    style="object-fit: cover; width: 100%; height: 100%; border-radius: 10px;"
                                                    alt="Image Preview">
                                            </div>
                                        </div>

                                        <!-- File Input for company logo -->
                                        <img id="company_image_preview" src="#" alt="Image Preview"
                                            style="display: none; margin-top: 10px; max-width: 100%; height: auto;" />
                                        <div class="fallback mt-3">
                                            <input type="file" name="company_logo" class="form-control"
                                                accept="image/png, image/gif, image/jpeg, image/jpg"
                                                id="popular_image_input" onchange="companyPreviewLogo(event)" required />
                                        </div>
                                        @error('company_logo')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label for="cover_photo" class="form-label">Favicon</label>

                                        <!-- Preview Box -->
                                        <div class="col-md-3">
                                            <div class="photo-preview overflow-hidden shadow"
                                                style="width: 160px; height: 160px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <img id="company_favicon_preview"
                                                    src="{{ isset($user) && $user->favicon && file_exists(public_path($user->favicon)) 
                                                        ? asset($user->favicon) 
                                                        : asset('back-end/assets/images/dr-profile/image-upload.jpg') }}"
                                                    class="w-100 img-fluid"
                                                    style="object-fit: cover; width: 100%; height: 100%; border-radius: 10px;"
                                                    alt="Image Preview">
                                            </div>
                                        </div>

                                        <!-- File Input for company logo -->
                                        <img id="company_image_favicon" src="#" alt="Image Preview"
                                            style="display: none; margin-top: 10px; max-width: 100%; height: auto;" />
                                        <div class="fallback mt-3">
                                            <input type="file" name="favicon" class="form-control"
                                                accept="image/png, image/gif, image/jpeg, image/jpg"
                                                id="popular_image_input" onchange="companyPreviewFavicon(event)" required />
                                        </div>
                                        @error('favicon')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="company_description" class="form-label">Description <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="company_description" name="company_description" rows="6" 
                                            placeholder="Add your content here...">{{ old('company_description', $user->company_description ?? '') }}</textarea>
                                        @error('company_description')
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
        function previewProfile(event) {
            const preview = document.getElementById('profile_preview');
            const imagePreview = document.getElementById('profile_image_preview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'none';
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = '{{ isset($user) && $user->profile_photo ? asset($user->profile_photo) : "" }}';
                preview.style.display = '{{ isset($user) && $user->profile_photo ? "block" : "none" }}';
            }
        }
    </script>

    <script>
        function companyPreviewLogo(event) {
            const preview = document.getElementById('company_logo_preview');
            const imagePreview = document.getElementById('company_image_preview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'none';
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = '{{ isset($user) && $user->company_logo ? asset($user->company_logo) : "" }}';
                preview.style.display = '{{ isset($user) && $user->company_logo ? "block" : "none" }}';
            }
        }
    </script>
    <script>
        function companyPreviewFavicon(event) {
            const preview = document.getElementById('company_favicon_preview');
            const imagePreview = document.getElementById('company_image_favicon');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'none';
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = '{{ isset($user) && $user->favicon ? asset($user->favicon) : "" }}';
                preview.style.display = '{{ isset($user) && $user->favicon ? "block" : "none" }}';
            }
        }
    </script>
@endpush
