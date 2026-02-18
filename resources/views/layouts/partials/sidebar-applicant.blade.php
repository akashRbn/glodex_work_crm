{{-- Left sidebar to student --}}
<!-- Brand Logo -->
<a href="#" class="logo">
    <span class="logo-light">
        <span class="logo-lg">
            <img src="{{ Auth::user()->profile_photo && file_exists(public_path(Auth::user()->profile_photo)) 
                            ? asset(Auth::user()->profile_photo) 
                            : asset('back-end/assets/images/logo-main.png') }}" style="height: 2rem"
                alt="logo">
        </span>
        <span class="logo-sm"><img src="{{asset('back-end/assets/images/icon-sm.png')}}" style="height: 2rem" alt="small logo"></span>
    </span>

    <span class="logo-dark">
        <span class="logo-lg"><img src="{{ asset('back-end/assets/images/logo-main.png') }}" alt="dark logo"></span>
        <span class="logo-sm"><img src="{{ asset('back-end/assets/images/icon-sm.png') }}" alt="small logo"></span>
    </span>
</a>

<!-- Sidebar Hover Menu Toggle Button -->
<button class="button-sm-hover">
    <i class="ti ti-circle align-middle"></i>
</button>

<!-- Full Sidebar Menu Close Button -->
<button class="button-close-fullsidebar">
    <i class="ti ti-x align-middle"></i>
</button>

<div data-simplebar>
    <!--- Sidenav Menu -->
    <ul class="side-nav">
        
        <li class="side-nav-item">
            <a href="{{ route('applicant_dashboard') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                <span class="menu-text">Dashboard</span>
            </a>
        </li>
        <li class="side-nav-item">
            <a href="{{ route('applicant_country_list') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-flag-heart"></i></span>
                <span class="menu-text">Countries</span>
            </a>
        </li>
        <li class="side-nav-item">
            <a href="{{ route('applicant_company_list') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-brand-bumble"></i></span>
                <span class="menu-text">Companies</span>
            </a>
        </li>
        <li class="side-nav-item">
            <a href="{{ route('applicant_job_list') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-briefcase"></i></span>
                <span class="menu-text">Jobs</span>
            </a>
        </li>
        <li class="side-nav-item">
           <a data-bs-toggle="collapse" href="#sidebarMyRecord" aria-expanded="false" aria-controls="sidebarMyRecord" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-school"></i></span>
                <span class="menu-text">My Record</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarMyRecord">
                <ul class="sub-menu">
                    <li class="side-nav-item">
                        <a href="{{ route('edit_my_record', auth()->id()) }}" class="side-nav-link">
                            <span class="menu-text">Add Profile</span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="{{ route('my_record_list') }}" class="side-nav-link">
                            <span class="menu-text">Record List</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="side-nav-item">
            <a href="{{ route('applicant_application_list') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-brand-appstore"></i></span>
                <span class="menu-text">Appplication</span>
            </a>
        </li>
    </ul>
    <div class="clearfix"></div>
</div>
