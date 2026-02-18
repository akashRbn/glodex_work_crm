@extends('layouts.app')
@push('page-css')
    <link rel="stylesheet" href="{{ asset('css/user/user-profile.css') }}">
@endpush
@section('content')
    <!-- Begin page -->
    <div class="wrapper">
        <div class="page-container">
            <div class="row mt-2">
                <div class="col-xl-12">
                    <div class="card">
                        <div
                            class="card-header border-bottom border-dashed d-flex align-items-center justify-content-between">
                            <h4 class="header-title mb-0">Agent Profile</h4>
                            <a href="{{ route('admin_dashboard') }}" class="btn btn-sm btn-secondary">
                                <i class="ti ti-arrow-back-up"
                                    style="margin-right:3px; font-size: 1.3rem; margin-bottom: 1px"></i>Go Back
                            </a>
                        </div>
                        <div class="card-body">
                            <section>
                                <div class="profile-header">
                                    <div class="profile-cover"></div>
                                    <div class="profile-info-top">
                                        <div class="profile-avatar-section">
                                            <div class="profile-avatar">
                                                <i class="ti ti-building"></i>
                                            </div>
                                            <div class="profile-meta">
                                                <div class="agency-type">Premium Agency</div>
                                                <h1 class="agency-name">{{ $user->organization_name ?? 'Not Added' }}</h1>
                                                <p class="agency-description">Connecting students to a wide range of trusted study abroad solutions designed to guide 
                                                    them toward the best international opportunities.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="status-badge">
                                            <i class="ti ti-check-circle-fill"></i>
                                            Active & Verified
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section>
                                <div class="content-grid">
                                    <!-- Basic Information -->
                                    <div class="info-card">
                                        <div class="info-card-title">
                                            <i class="ti ti-info-circle"></i>
                                            Basic Information
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Owner Name</span>
                                            <span class="info-value">{{ $user->name ?? 'Not Added' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Phone Number</span>
                                            <span class="info-value">{{ $user->phone ?? 'Not Added' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Email</span>
                                            <span class="info-value">{{ $user->email ?? 'Not Added' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Address</span>
                                            <span class="info-value">{{ $user->address ?? 'Not Added' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">On Board</span>
                                            <span class="info-value">{{ $user->created_at ? $user->created_at->format('F d, Y') : 'Not Added' }}</span>
                                        </div>
                                    </div>

                                    <!-- Contact Information -->
                                    <div class="info-card">
                                        <div class="info-card-title">
                                            <i class="ti ti-phone-outgoing"></i>
                                            Contact Information
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">WhatsApp</span>
                                            <span class="info-value">{{ $user->userInfo->whatsapp_no ?? 'Not Added' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Website</span>
                                            <span class="info-value">{{ $user->userInfo->website_url ?? 'Not Added' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Social Media</span>
                                            <span class="info-value">{{ $user->userInfo->social_url ?? 'Not Added' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Point of Contact</span>
                                            <span class="info-value">{{ $user->userInfo->poc ?? 'Not Added' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Date of Birth</span>
                                            <span class="info-value">{{ $user->dob ?? 'Not Added' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section>
                                <div class="full-card">
                                    <div class="card-section-title">
                                        <i class="ti ti-building-bank"></i>
                                        Bank Information
                                    </div>
                                    <div
                                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                                        <div class="info-item"
                                            style="border: none; display: flex; flex-direction: column; align-items: flex-start;">
                                            <span class="info-label">Account Name</span>
                                            <span class="info-value" style="text-align: left; margin-top: 5px;">
                                              {{ $user->userInfo->bank_account_name ?? 'Not Added' }}
                                            </span>
                                        </div>
                                        <div class="info-item"
                                            style="border: none; display: flex; flex-direction: column; align-items: flex-start;">
                                            <span class="info-label">Bank Name</span>
                                            <span class="info-value" style="text-align: left; margin-top: 5px;">
                                                 {{ $user->userInfo->bank_name ?? 'Not Added' }}
                                            </span>
                                        </div>
                                        <div class="info-item"
                                            style="border: none; display: flex; flex-direction: column; align-items: flex-start;">
                                            <span class="info-label">Account Number</span>
                                            <span class="info-value"
                                                style="text-align: left; margin-top: 5px;">
                                                {{ $user->userInfo->bank_account_number ?? 'Not Added' }}
                                            </span>
                                        </div>
                                        <div class="info-item"
                                            style="border: none; display: flex; flex-direction: column; align-items: flex-start;">
                                            <span class="info-label">Swift Code</span>
                                            <span class="info-value" style="text-align: left; margin-top: 5px;">
                                                {{ $user->userInfo->swift_code ?? 'Not Added' }}
                                            </span>
                                        </div>
                                        <div class="info-item"
                                            style="border: none; display: flex; flex-direction: column; align-items: flex-start;">
                                            <span class="info-label">Branch Name</span>
                                            <span class="info-value" style="text-align: left; margin-top: 5px;">
                                                {{ $user->userInfo->branch_name ?? 'Not Added' }}
                                            </span>
                                        </div>
                                        <div class="info-item"
                                            style="border: none; display: flex; flex-direction: column; align-items: flex-start;">
                                            <span class="info-label">Bank Address</span>
                                            <span class="info-value" style="text-align: left; margin-top: 5px;">
                                                {{ $user->userInfo->bank_address ?? 'Not Added' }}
                                            </span>
                                        </div>
                                        <div class="info-item"
                                            style="border: none; display: flex; flex-direction: column; align-items: flex-start;">
                                            <span class="info-label">IFSC Code</span>
                                            <span class="info-value" style="text-align: left; margin-top: 5px;">
                                                {{ $user->userInfo->ifsc_code ?? 'Not Added' }}
                                            </span>
                                        </div>
                                        <div class="info-item"
                                            style="border: none; display: flex; flex-direction: column; align-items: flex-start;">
                                            <span class="info-label">Benificiary Number</span>
                                            <span class="info-value" style="text-align: left; margin-top: 5px;">
                                                {{ $user->userInfo->benificiary_number ?? 'Not Added' }}
                                            </span>
                                        </div>
                                        <div class="info-item"
                                            style="border: none; display: flex; flex-direction: column; align-items: flex-start;">
                                            <span class="info-label">Benificiary Address</span>
                                            <span class="info-value" style="text-align: left; margin-top: 5px;">
                                                {{ $user->userInfo->benificiary_address ?? 'Not Added' }}
                                            </span>
                                        </div>
                                        <div class="info-item"
                                            style="border: none; display: flex; flex-direction: column; align-items: flex-start;">
                                            <span class="info-label">Trade License Number</span>
                                            <span class="info-value" style="text-align: left; margin-top: 5px;">
                                                {{ $user->userInfo->trade_license_number ?? 'Not Added' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section>
                                <div class="full-card">
                                    <div class="card-section-title">
                                        <i class="ti ti-file"></i>
                                        Documents & License
                                    </div>
                                    <div class="document-grid">
                                        <div class="document-item">
                                            <div class="doc-icon"><i class="ti ti-pdf"></i></div>
                                            <div class="doc-name">Government License / NID, Passport</div>
                                        </div>
                                        <div class="document-item">
                                            <div class="doc-icon"><i class="ti ti-file"></i></div>
                                            <div class="doc-name">Trade License</div>
                                        </div>
                                        <div class="document-item">
                                            <div class="doc-icon"><i class="ti ti-report"></i></div>
                                            <div class="doc-name">Company Details</div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <div class="full-card">
                                    <div class="action-buttons d-flex gap-4">
                                        <!-- NID / Passport Copy -->
                                        <div class="text-center">
                                            <label class="form-label fw-bold d-block mb-1">NID / Passport Copy</label>

                                            @if(!empty($user->userInfo->passport_nid_copy))
                                                <a href="{{ asset('storage/'.$user->userInfo->passport_nid_copy) }}" 
                                                    target="_blank"
                                                    class="btn-custom btn-primary-custom d-inline-block text-white"
                                                    style="background-color: #232E51; text-decoration: none;">
                                                    <i class="ti ti-download"></i> Download PDF
                                                </a>
                                            @else
                                                <span class="text-muted">No File Uploaded</span>
                                            @endif
                                        </div>

                                        <!-- Trade License Copy -->
                                        <div class="text-center">
                                            <label class="form-label fw-bold d-block mb-1">Trade License Copy</label>
                                            @if(!empty($user->userInfo->trade_license_copy))
                                                <a href="{{ asset('storage/'.$user->userInfo->trade_license_copy) }}" 
                                                    target="_blank"
                                                    class="btn-custom btn-primary-custom d-inline-block text-white"
                                                    style="background-color: #232E51; text-decoration: none;">
                                                    <i class="ti ti-download"></i> Download PDF
                                                </a>
                                            @else
                                                <span class="text-muted">No File Uploaded</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END wrapper -->
@endsection
@push('page-js')
@endpush
