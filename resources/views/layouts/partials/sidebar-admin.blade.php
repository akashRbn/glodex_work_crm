{{-- left sidebat to admin --}}
<!-- Brand Logo -->
<a href="{{ route('admin_dashboard') }}" class="logo">
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
            <a href="{{ route('admin_home_page') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-home"></i></span>
                <span class="menu-text">Home</span>
            </a>
        </li>
        <li class="side-nav-item">
            <a href="{{ route('admin_dashboard') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                <span class="menu-text">Dashboard</span>
            </a>
        </li>
        @can('View Pending Agent')
        <li class="side-nav-item">
            <a href="{{ route('pending_agent_user') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-user-pause"></i></span>
                <span class="menu-text">Pending Agent</span>
                {{-- <span class="badge bg-success rounded-pill">{{ $pendingAgentUser ?? 0}}</span> --}}
            </a>
        </li>
        @endcan
        @can('View Active Agent')
        <li class="side-nav-item">
            <a href="{{ route('active_agent_user') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-user-check"></i></span>
                <span class="menu-text">Active Agent</span>
                {{-- <span class="badge bg-success rounded-pill">{{ $activeAgentUser ?? 0}}</span> --}}
            </a>
        </li>
        @endcan
        @can('View Pending Lawyer')
        <li class="side-nav-item">
            <a href="{{ route('pending_lawyer_user') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-user-pause"></i></span>
                <span class="menu-text">Pending Lawyer</span>
                {{-- <span class="badge bg-success rounded-pill">{{ $pendingAgentUser ?? 0}}</span> --}}
            </a>
        </li>
        @endcan
        @can('View Active Lawyer')
        <li class="side-nav-item">
            <a href="{{ route('active_lawyer_user') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-user-check"></i></span>
                <span class="menu-text">Active Lawyer</span>
                {{-- <span class="badge bg-success rounded-pill">{{ $activeAgentUser ?? 0}}</span> --}}
            </a>
        </li>
        @endcan
        @can('View Pending Applicant')
        <li class="side-nav-item">
            <a href="{{ route('pending_applicant_user') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-user-pause"></i></span>
                <span class="menu-text">Pending Applicant</span>
                {{-- <span class="badge bg-success rounded-pill">{{ $pendingStudenttUser ?? 0}}</span> --}}
            </a>
        </li>
        @endcan
        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarHospital" aria-expanded="false" aria-controls="sidebarHospital" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-flag-heart"></i></span>
                <span class="menu-text"> Country</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarHospital">
                <ul class="sub-menu">
                    @can('Create Country')
                    <li class="side-nav-item">
                        <a href="{{ route('add_new_country') }}" class="side-nav-link">
                            <span class="menu-text">Add Country</span>
                        </a>
                    </li>
                    @endcan
                    @can('View Country')
                    <li class="side-nav-item">
                        <a href="{{ route('country_list') }}" class="side-nav-link">
                            <span class="menu-text">Country List</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
        </li>
        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarCompany" aria-expanded="false" aria-controls="sidebarCompany" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-brand-bumble"></i></span>
                <span class="menu-text">Company</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarCompany">
                <ul class="sub-menu">
                    @can('Create Company')
                    <li class="side-nav-item">
                        <a href="{{ route('add_new_company') }}" class="side-nav-link">
                            <span class="menu-text">Add Company</span>
                        </a>
                    </li>
                    @endcan
                    @can('View Company')
                    <li class="side-nav-item">
                        <a href="{{ route('company_list') }}" class="side-nav-link">
                            <span class="menu-text">Company List</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
        </li>
        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarJob" aria-expanded="false" aria-controls="sidebarJob" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-briefcase"></i></span>
                <span class="menu-text">Jobs</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarJob">
                <ul class="sub-menu">
                    @can('Create Job')
                    <li class="side-nav-item">
                        <a href="{{ route('add_new_job') }}" class="side-nav-link">
                            <span class="menu-text">Add Job</span>
                        </a>
                    </li>
                    @endcan
                    @can('View Job')
                    <li class="side-nav-item">
                        <a href="{{ route('job_list') }}" class="side-nav-link">
                            <span class="menu-text">Job List</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
        </li>
        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarApplicant" aria-expanded="false" aria-controls="sidebarApplicant" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-api-app"></i></span>
                <span class="menu-text">Applicant</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarApplicant">
                <ul class="sub-menu">
                    @can('Create Applicant')
                    <li class="side-nav-item">
                        <a href="{{ route('add_new_applicant') }}" class="side-nav-link">
                            <span class="menu-text">Add Applicant</span>
                        </a>
                    </li>
                    @endcan
                    @can('View Applicant')
                    <li class="side-nav-item">
                        <a href="{{ route('my_applicant_list') }}" class="side-nav-link">
                            <span class="menu-text">My Applicant</span>
                        </a>
                    </li>
                    @endcan
                    @can('View Partner Applicant')
                    <li class="side-nav-item">
                        <a href="{{ route('applicant_list_agent') }}" class="side-nav-link">
                            <span class="menu-text">Agent Applicant</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
        </li>
        @can('View Application')
        <li class="side-nav-item">
            <a href="{{ route('my_application_list') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-brand-sentry"></i></span>
                <span class="menu-text">My Appplication</span>
            </a>
        </li>
        @endcan
        @can('View Partner Application')
        <li class="side-nav-item">
            <a href="{{ route('application_list_agent') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-brand-appstore"></i></span>
                <span class="menu-text">Agent Appplication</span>
            </a>
        </li>
        @endcan
        @can('View All Application')
        <li class="side-nav-item">
            <a href="{{ route('all_application') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-brand-drupal"></i></span>
                <span class="menu-text">All Appplication</span>
            </a>
        </li>
        @endcan
        @can('View User')
        <li class="side-nav-item">
            <a href="{{ route('admin_user_list') }}" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-users-group"></i></span>
                <span class="menu-text">User</span>
            </a>
        </li>
        @endcan
        @can('View Role')
        <li class="side-nav-item">
           <a data-bs-toggle="collapse" href="#sidebarRolePermission" aria-expanded="false" aria-controls="sidebarRolePermission" class="side-nav-link">
                <span class="menu-icon"><i class="ti ti-lock-off"></i></span>
                <span class="menu-text">Role & Permissions</span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarRolePermission">
                <ul class="sub-menu">
                    @can('View Role')
                    <li class="side-nav-item">
                        <a href="{{ route('role_list') }}" class="side-nav-link">
                            <span class="menu-text">Roles</span>
                        </a>
                    </li>
                    @endcan
                    @can('View Permission')
                    <li class="side-nav-item">
                        <a href="{{ route('permission_list') }}" class="side-nav-link">
                            <span class="menu-text">Permission</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
        </li>
        @endcan
    </ul>
    <div class="clearfix"></div>
</div>



