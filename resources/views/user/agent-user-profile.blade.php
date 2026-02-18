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
                                <a href="{{ route('agent_dashboard') }}" class="btn btn-sm btn-secondary me-2">
                                    <i class="ti ti-arrow-back-up"
                                        style="margin-right:3px; font-size: 1.3rem; margin-bottom: 1px"></i>
                                    Go Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('update_agent_profile') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <h6 class="badge bg-primary">General Information</h6>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="userName" class="form-label">Name<span class="text-danger">*</span>:</label>
                                        <input type="text" name="name" class="form-control" id="userName" placeholder="Enter your name" value="{{ old('name', $agentUser->name) }}" />
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="userPhone" class="form-label">Phone<span class="text-danger">*</span>:</label>
                                        <input type="text" name="phone" class="form-control" id="userPhone" placeholder="Enter your phone" value="{{ old('phone', $agentUser->phone) }}" />
                                        @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="userEmail" class="form-label">Email<span class="text-danger">*</span>:</label>
                                        <input type="text" name="email" class="form-control" id="userEmail" placeholder="Enter your email" value="{{ old('email', $agentUser->email) }}" />
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="userDob" class="form-label">Date of Birth<span class="text-danger">*</span>:</label>
                                        <input type="date" name="dob" class="form-control" id="userDob" value="{{ old('dob', $agentUser->dob) }}" />
                                        @error('dob')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="maritalStatus" class="form-label">Marital Status<span class="text-danger">*</span>:</label>
                                        <select id="maritalStatus" name="marital_status" class="form-select">
                                            <option value="">Select Status</option>
                                            <option value="1" {{ old('marital_status', $agentUser->marital_status) == 1 ? 'selected' : '' }}>Single</option>
                                            <option value="2" {{ old('marital_status', $agentUser->marital_status) == 2 ? 'selected' : '' }}>Married</option>
                                        </select>
                                        @error('marital_status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="defaultSelect" class="form-label">Gender<span class="text-danger">*</span>:</label>
                                        <select id="defaultSelect"  name="gender" class="form-select">
                                            <option value="">Select gender</option>
                                            <option value="1" {{ old('gender', $agentUser->gender) == 1 ? 'selected' : '' }}>Male</option>
                                            <option value="2" {{ old('gender', $agentUser->gender) == 2 ? 'selected' : '' }}>Female</option>
                                        </select>
                                        @error('gender')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="userName" class="form-label">Organization Name<span class="text-danger">*</span>:</label>
                                        <input type="text" name="organization_name" class="form-control" id="userName" placeholder="Enter your organizatio name" value="{{ old('organization_name', $agentUser->organization_name) }}" />
                                        @error('organization_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="userName" class="form-label">Address<span class="text-danger">*</span>:</label>
                                        <input type="text" name="address" class="form-control" id="userAddress" placeholder="Enter your address" value="{{ old('address', $agentUser->address) }}" />
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
                                                    src="{{ isset($agentUser) && $agentUser->profile_photo && file_exists(public_path($agentUser->profile_photo)) 
                                                        ? asset($agentUser->profile_photo) 
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
                                                    src="{{ isset($agentUser) && $agentUser->company_logo && file_exists(public_path($agentUser->company_logo)) 
                                                        ? asset($agentUser->company_logo) 
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
                                                    src="{{ isset($agentUser) && $agentUser->favicon && file_exists(public_path($agentUser->favicon)) 
                                                        ? asset($agentUser->favicon) 
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
                                </div>
                                <h6 class="badge bg-primary mt-4">Others Information</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="userName" class="form-label">Person To Contact<span class="text-danger">*</span>:</label>
                                        <input type="text" name="poc" class="form-control" id="userPoc" placeholder="Enter your name" value="{{ old('poc', $agentUserProfile->poc ?? '') }}" />
                                        @error('poc')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="userName" class="form-label">Website URL<span class="text-danger">*</span>:</label>
                                        <input type="text" name="website_url" class="form-control" id="userPoc" placeholder="Enter website url" value="{{ old('website_url', $agentUserProfile->website_url ?? '') }}" />
                                        @error('website_url')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="userName" class="form-label">Social Media URL<span class="text-danger">*</span>:</label>
                                        <input type="text" name="social_url" class="form-control" id="userPoc" placeholder="Enter social media url" value="{{ old('website_url', $agentUserProfile->social_url ?? '') }}" />
                                        @error('social_url')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mt-3">
                                        <label for="userName" class="form-label">What's App Number<span class="text-danger">*</span>:</label>
                                        <input type="text" name="whatsapp_no" class="form-control" id="userPoc" placeholder="Enter what's app number" value="{{ old('whatsapp_no', $agentUserProfile->whatsapp_no ?? '') }}" />
                                        @error('whatsapp_no')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mt-3">
                                        <label for="userName" class="form-label">Trade Lincese Number<span class="text-danger">*</span>:</label>
                                        <input type="text" name="trade_license_number" class="form-control" id="userPoc" placeholder="Enter trade license" value="{{ old('trade_license_number', $agentUserProfile->trade_license_number ?? '') }}" />
                                        @error('trade_license_number')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mt-3">
                                        <label class="form-label">Trade License Copy (PDF) <span class="text-danger">*</span>:</label>
                                        <input type="file" name="trade_license_copy" class="form-control" />
                                        @error('trade_license_copy')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                        @if(!empty($agentUserProfile->trade_license_copy))
                                            <a href="{{ asset('storage/'.$agentUserProfile->trade_license_copy ?? '') }}" target="_blank" 
                                                class="mt-1 d-block text-center p-1 rounded"  
                                                style="background-color: #232E51; color: #ffffff; text-decoration: none;">
                                                Download PDF
                                            </a>
                                        @endif
                                    </div>

                                    <div class="col-md-3 mt-3">
                                        <label class="form-label">NID / Passport Copy(PDF)<span class="text-danger">*</span>:</label>
                                        <input type="file" name="passport_nid_copy" class="form-control" />
                                        @error('passport_nid_copy')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                        @if(!empty($agentUserProfile->passport_nid_copy))
                                            <a href="{{ asset('storage/'.$agentUserProfile->passport_nid_copy) }}" 
                                                target="_blank" 
                                                class="mt-1 d-block text-center p-1 rounded"  
                                                style="background-color: #232E51; color: #ffffff; text-decoration: none;">
                                                Download PDF
                                            </a>
                                        @endif
                                    </div>

                                </div>
                                <h6 class="badge bg-primary mt-4">Bank Details</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="userName" class="form-label">Account Name<span class="text-danger">*</span>:</label>
                                        <input type="text" name="bank_account_name" class="form-control" id="userPoc" placeholder="Enter account name" value="{{ old('bank_account_name', $agentUserProfile->bank_account_name ?? '') }}" />
                                        @error('bank_account_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="userName" class="form-label">Bank Name<span class="text-danger">*</span>:</label>
                                        <input type="text" name="bank_name" class="form-control" id="userPoc" placeholder="Enter bank name" value="{{ old('bank_name', $agentUserProfile->bank_name ?? '') }}" />
                                        @error('bank_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="userName" class="form-label">Account Number<span class="text-danger">*</span>:</label>
                                        <input type="text" name="bank_account_number" class="form-control" id="userPoc" placeholder="Enter account number" value="{{ old('bank_account_number', $agentUserProfile->bank_account_number ?? '') }}" />
                                        @error('bank_account_number')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="userName" class="form-label">Account Address<span class="text-danger">*</span>:</label>
                                        <input type="text" name="bank_address" class="form-control" id="userPoc" placeholder="Enter account address" value="{{ old('bank_address', $agentUserProfile->bank_address ?? '') }}" />
                                        @error('bank_address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="userName" class="form-label">Swift Code<span class="text-danger">*</span>:</label>
                                        <input type="text" name="swift_code" class="form-control" id="userPoc" placeholder="Enter swift code" value="{{ old('swift_code', $agentUserProfile->swift_code ?? '') }}" />
                                        @error('swift_code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="userName" class="form-label">IFSC Code:</label>
                                        <input type="text" name="ifsc_code" class="form-control" id="userPoc" placeholder="Enter ifsc code" value="{{ old('ifsc_code', $agentUserProfile->ifsc_code ?? '') }}" />
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="userName" class="form-label">Branch Name:</label>
                                        <input type="text" name="branch_name" class="form-control" id="userPoc" placeholder="Enter branch name" value="{{ old('branch_name', $agentUserProfile->branch_name ?? '') }}" />
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="userName" class="form-label">Benificiary Number:</label>
                                        <input type="text" name="benificiary_number" class="form-control" id="userPoc" placeholder="Enter benificiary number" value="{{ old('benificiary_number', $agentUserProfile->benificiary_number ?? '') }}" />
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="userName" class="form-label">Benificiary Address:</label>
                                        <input type="text" name="benificiary_address" class="form-control" id="userPoc" placeholder="Enter benificiary address" value="{{ old('benificiary_address', $agentUserProfile->benificiary_address ?? '') }}" />
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
                preview.src = '{{ isset($agentUser) && $agentUser->profile_photo ? asset($agentUser->profile_photo) : "" }}';
                preview.style.display = '{{ isset($agentUser) && $agentUser->profile_photo ? "block" : "none" }}';
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
               preview.src = '{{ isset($agentUserProfile) && $agentUserProfile->company_logo ? asset($agentUserProfile->company_logo) : asset("back-end/assets/images/dr-profile/image-upload.jpg") }}';
               preview.style.display = 'block';

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
                preview.src = '{{ isset($agentUser) && $agentUser->favicon ? asset($agentUser->favicon) : "" }}';
                preview.style.display = '{{ isset($agentUser) && $agentUser->favicon ? "block" : "none" }}';
            }
        }
    </script>
@endpush
