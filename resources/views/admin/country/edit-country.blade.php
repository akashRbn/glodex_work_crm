@extends('layouts.app')
@section('title','|Edit Country')
@section('content')
    <!-- Begin page -->
    <div class="wrapper">
        <div class="page-container">
            <div class="row mt-2">
                <div class="col-xl-12">
                    <div class="card">
                        <div
                            class="card-header border-bottom border-dashed d-flex align-items-center justify-content-between">
                            <h4 class="header-title mb-0">Edit Country</h4>
                            <div class="d-flex">
                                <a href="{{ route('country_list') }}" class="btn btn-sm btn-secondary me-2">
                                    <i class="ti ti-arrow-back-up"
                                        style="margin-right:3px; font-size: 1.3rem; margin-bottom: 1px"></i>
                                    Go Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="countryForm" action="{{ route('update_country', $country->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="country_name" class="form-label">Country Name <spanclass="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="country_name" name="country_name" value="{{ old('country_name', $country->country_name ?? '') }}" placeholder="Enter country name" required>
                                        @error('country_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="continent_id" class="form-label">Country Continent <span class="text-danger">*</span></label>
                                        <select class="form-control" id="continent_id" name="continent_id" required>
                                            <option value="">--Select Continent--</option>
                                            @foreach ($countryContinents as $continent)
                                                <option value="{{ $continent->id }}"
                                                    {{ old('continent_id', $country->continent_id ?? '') == $continent->id ? 'selected' : '' }}>
                                                    {{ $continent->continent_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('continent_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="country_capital" class="form-label">Country Capital <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="country_capital" name="country_capital" value="{{ old('country_capital', $country->country_capital) }}" placeholder="Enter country capital" required>
                                        @error('country_capital')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="country_capital" class="form-label">Country Population<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="country_population" name="country_population" value="{{ old('country_population', $country->country_population) }}" placeholder="Enter country population" required>
                                        @error('country_population')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="country_gdp" class="form-label">Country GDP <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="country_gdp" name="country_gdp" value="{{ old('country_gdp', $country->country_gdp) }}" placeholder="Enter country gdp" required>
                                        @error('country_gdp')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <label for="countryFlag" class="form-label">Flag<span class="text-danger">*</span>:</label>
                                        <!-- Preview Box -->
                                        <div class="col-md-3">
                                            <div class="photo-preview overflow-hidden shadow" style="width: 160px; height: 160px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <img id="preview"
                                                    src="{{ $country->flag && file_exists(public_path($country->flag)) ? asset($country->flag) : asset('back-end/assets/images/dr-profile/image-upload.jpg') }}"
                                                    class="w-100 img-fluid"
                                                    style="object-fit: cover; width: 100%; height: 100%; border-radius: 10px; {{ $country->flag ? '' : 'display: none;' }}" 
                                                    alt="Image Preview">
                                            </div>
                                        </div>
                                        <!-- File Input for Country Image -->
                                        <img id="image_preview" src="#" alt="Image Preview" style="display: none; margin-top: 10px; max-width: 100%; height: auto;" />
                                        <div class="fallback mt-3">
                                            <input type="file" name="flag" class="form-control" accept="image/png, image/gif, image/jpeg, image/jpg" id="country_image_input" onchange="previewImage(event)"/>
                                        </div>

                                        @error('flag')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <label for="cover_photo" class="form-label">Cover Photo<span
                                                class="text-danger">*</span>:</label>

                                        <!-- Preview Box -->
                                        <div class="col-md-3">
                                            <div class="photo-preview overflow-hidden shadow"
                                                style="width: 160px; height: 160px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <img id="popular_preview"
                                                    src="{{ $country->flag && file_exists(public_path($country->cover_photo)) ? asset($country->cover_photo) : asset('back-end/assets/images/dr-profile/image-upload.jpg') }}"
                                                    class="w-100 img-fluid"
                                                    style="object-fit: cover; width: 100%; height: 100%; border-radius: 10px; {{ $country->cover_photo ? '' : 'display: none;' }}"
                                                    alt="Image Preview">
                                            </div>
                                        </div>

                                        <!-- File Input for Country Image -->
                                        <img id="popular_image_preview" src="#" alt="Image Preview"
                                            style="display: none; margin-top: 10px; max-width: 100%; height: auto;" />
                                        <div class="fallback mt-3">
                                            <input type="file" name="cover_photo" class="form-control"
                                                accept="image/png, image/gif, image/jpeg, image/jpg"
                                                id="popular_image_input" onchange="popularPreviewImage(event)" />
                                        </div>
                                        @error('cover_photo')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="country_name" class="form-label">Description<span class="text-danger">*</span></label>
                                        <div id="snow-editor" style="height: 400px;">
                                            {!! old('description', $country->description) !!}
                                        </div>
                                        <input type="hidden" name="description" id="description">
                                        @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
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
            preview.src = '{{ $country->flag ? asset($country->flag) : '' }}';
            preview.style.display = '{{ $country->country_image ? 'block' : 'none' }}';
        }
    }
</script>
<script>
    function popularPreviewImage(event) {
        const preview = document.getElementById('popular_preview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = '{{ $country->cover_photo ? asset($country->cover_photo) : '' }}';
            preview.style.display = '{{ $country->cover_photo ? 'block' : 'none' }}';
        }
    }
</script>
<script>
    document.querySelector("#countryForm").addEventListener("submit", function() {
        document.querySelector("#description").value = quill.root.innerHTML;
    });

    @if(old('description'))
        quill.root.innerHTML = {!! json_encode(old('description')) !!};
    @endif 
</script>
@endpush
