{{-- Left sidebar to agent --}}
<!-- Brand Logo -->
<a href="{{ route('agent_dashboard') }}" class="logo">
    <span class="logo-light">
        <span class="logo-lg">
            <img src="{{ Auth::user()->company_logo && file_exists(public_path(Auth::user()->company_logo)) 
                            ? asset(Auth::user()->company_logo) 
                            : asset('back-end/assets/images/logo-main.png') }}" style="height: 2rem"
                alt="logo">
        </span>

        <span class="logo-sm">
            <img src="{{ Auth::user()->favicon && file_exists(public_path(Auth::user()->favicon)) 
                            ? asset(Auth::user()->favicon) 
                            : asset('back-end/assets/images/icon-sm.png') }}" style="height: 2rem"
                alt="small logo">
        </span>
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
            <a href="{{ route('agent_home_page') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-home"></i></span>
                <span class="menu-text">Home</span>
            </a>
        </li>
        <li class="side-nav-item">
            <a href="{{ route('agent_dashboard') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                <span class="menu-text">Dashboard</span>
            </a>
        </li>
        <li class="side-nav-item">
            <a href="{{ route('agent_country_list') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-flag-heart"></i></span>
                <span class="menu-text">Countries</span>
            </a>
        </li>
        <li class="side-nav-item">
            <a href="{{ route('agent_company_list') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-brand-bumble"></i></span>
                <span class="menu-text">Companies</span>
            </a>
        </li>
        <li class="side-nav-item">
            <a href="{{ route('agent_job_list') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-briefcase"></i></span>
                <span class="menu-text">Jobs</span>
            </a>
        </li>
        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarHospital" aria-expanded="false" aria-controls="sidebarHospital" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-api-app"></i></span>
                <span class="menu-text">Applicant</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarHospital">
                <ul class="sub-menu">
                    <li class="side-nav-item">
                        <a href="{{ route('agent_add_new_applicant') }}" class="side-nav-link">
                            <span class="menu-text">Add Applicant</span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="{{ route('agent_applicant_list') }}" class="side-nav-link">
                            <span class="menu-text">Applicant List</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="side-nav-item">
            <a href="{{ route('agent_application_list') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-brand-appstore"></i></span>
                <span class="menu-text">Appplication</span>
            </a>
        </li>
    </ul>

    <div class="clearfix"></div>
</div>