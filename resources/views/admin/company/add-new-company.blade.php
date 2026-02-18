@extends('layouts.app')
@section('title', '|Add New Company')
@section('content')
    <!-- Begin page -->
    <div class="wrapper">
        <div class="page-container">
            <div class="row mt-2">
                <div class="col-xl-12">
                    <div class="card">
                        <div
                            class="card-header border-bottom border-dashed d-flex align-items-center justify-content-between">
                            <h4 class="header-title mb-0">Add Company</h4>
                            <div class="d-flex">
                                <a href="{{ route('company_list') }}" class="btn btn-sm btn-secondary me-2">
                                    <i class="ti ti-arrow-back-up"
                                        style="margin-right:3px; font-size: 1.3rem; margin-bottom: 1px"></i>
                                    Go Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="CompanyForm" action="{{ route('save_new_company') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="company_name" class="form-label">Company Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name') }}" placeholder="Enter company name" required>
                                        @error('company_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="conuntry_id" class="form-label">Country<span class="text-danger">*</span></label>
                                        <select class="form-control"  id="country_id" name="country_id" data-choices id="choices-single-default" required>
                                                    <option value="">--Select Country--</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                                       {{ $country->country_name }}
                                                    </option>
                                                @endforeach
                                        </select>
                                        @error('country_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="lawyer_id" class="form-label">Assign Lawyer<span class="text-danger">*</span></label>
                                        <select class="form-control"  id="lawyer_id" name="lawyer_id" data-choices id="choices-single-default" required>
                                                <option value="">--Select Lawyer--</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}" {{ old('lawyer_id') == $user->id ? 'selected' : '' }}>
                                                       {{ $user->name }}
                                                    </option>
                                                @endforeach
                                        </select>
                                        @error('lawyer_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="company_city" class="form-label">City<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="company_city" name="company_city" value="{{ old('company_city') }}" placeholder="Enter company city" required>
                                        @error('company_city')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="company_email" class="form-label">Email<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="company_email" name="company_email" value="{{ old('company_email') }}" placeholder="Enter company email " required>
                                        @error('company_email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="company_phone" class="form-label">Phone<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="company_phone" name="company_phone" value="{{ old('company_phone') }}" placeholder="Enter company phone " required>
                                        @error('company_phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="website_link" class="form-label">Website link<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="website_link" name="website_link" value="{{ old('website_link') }}" placeholder="Enter website link " required>
                                        @error('website_link')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="address" class="form-label">Address<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" placeholder="Enter company address" required>
                                        @error('address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label for="logo" class="form-label">Logo<span class="text-danger">*</span>:</label>
                                        <!-- Preview Box -->
                                        <div class="col-md-3">
                                            <div class="photo-preview overflow-hidden shadow"
                                                style="width: 160px; height: 160px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <img id="preview"
                                                    src="{{ asset('back-end/assets/images/dr-profile/image-upload.jpg') }}"
                                                    class="w-100 img-fluid"
                                                    style="object-fit: cover; width: 100%; height: 100%; border-radius: 10px;"
                                                    alt="Image Preview">
                                            </div>
                                        </div>

                                        <!-- File Input for university logo -->
                                        <img id="image_preview" src="#" alt="Image Preview"
                                            style="display: none; margin-top: 10px; max-width: 100%; height: auto;" />
                                        <div class="fallback mt-3">
                                            <input type="file" name="logo" class="form-control"
                                                accept="image/png, image/gif, image/jpeg, image/jpg"
                                                id="country_image_input" onchange="previewImage(event)" required />
                                        </div>
                                        @error('logo')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="description" class="form-label">Description<span class="text-danger">*</span></label>
                                        <div id="snow-editor" style="height: 400px;">
                                            {!! old('description', '<h3><span class="ql-size-large">Add Your Content Here....</span></h3>') !!}
                                        </div>
                                        <input type="hidden" name="description" id="description">
                                        @error('description')
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
        function previewImage(event) {
            const preview = document.getElementById('preview');
            const imagePreview = document.getElementById('image_preview');
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
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    </script>
    <script>
        document.querySelector("#CompanyForm").addEventListener("submit", function() {
            document.querySelector("#description").value = quill.root.innerHTML;
        });

        @if(old('description'))
            quill.root.innerHTML = {!! json_encode(old('description')) !!};
        @endif 
    </script>
@endpush
