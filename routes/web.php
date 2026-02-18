<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\ApplicantController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CompanyJobController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\UniversityController;
use App\Http\Controllers\Admin\UserActiveController;
use App\Http\Controllers\Agent\AgentApplicantController;
use App\Http\Controllers\Agent\AgentApplicationController;
use App\Http\Controllers\Agent\AgentCompanyController;
use App\Http\Controllers\Agent\AgentCompanyJobController;
use App\Http\Controllers\Agent\AgentCountryController;
use App\Http\Controllers\Agent\AgentCourseController;
use App\Http\Controllers\Agent\AgentDashboardController;
use App\Http\Controllers\Agent\AgentHomeController;
use App\Http\Controllers\Agent\AgentStudentController;
use App\Http\Controllers\Agent\AgentUniversityController;
use App\Http\Controllers\Applicant\ApplicantCompanyController;
use App\Http\Controllers\Applicant\ApplicantCountryController;
use App\Http\Controllers\Applicant\ApplicantDashboardController;
use App\Http\Controllers\Applicant\ApplicantJobController;
use App\Http\Controllers\Applicant\ApplicantRecordController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Lawyer\LawyerDashboardController;
use App\Http\Controllers\Student\StudentApplicationController;
use App\Http\Controllers\Student\StudentCountryController;
use App\Http\Controllers\Student\StudentCourseController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\StudentRecordController;
use App\Http\Controllers\Student\StudentUniversityController;
use App\Http\Controllers\StudentInfoController;
use App\Http\Controllers\User\UserController;
use App\Models\Admin\Company;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'signIn'])->name('sign_in');
Route::post('login', [AuthController::class, 'login'])->middleware('authenticate')->name('auth_login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/sign-up', [AuthController::class, 'signUp'])->name('sign_up');
Route::post('/save-sign-up', [AuthController::class, 'saveSignup'])->name('save_sign_up');
Route::delete('/delete-user/{id}', [AuthController::class, 'deleteUser'])->name('delete_user');

Route::prefix('admin')->middleware(['admin', 'auth'])->group(function () {
    Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin_dashboard');
    Route::get('/admin-home-page', [AdminHomeController::class, 'adminHomePage'])->name('admin_home_page');
    Route::delete('/delete-admin-user/{id}', [AdminUserController::class, 'deleteAdminUser'])->name('delete_admin_user');

    // Route for active agent user
    Route::controller(UserActiveController::class)->group(function () {
        Route::get('/pending-agent-user',  'pendingAgentUser')->name('pending_agent_user');
        Route::post('/save-agent', 'saveAgent')->name('save_agent');
        Route::get('/active-agent-user',  'activeAgentUser')->name('active_agent_user');
        Route::get('/pending-applicant-user',  'pendingApplicantUser')->name('pending_applicant_user');
        Route::get('/update-user-status/{id}', 'updateUserStatus')->name('update_user_status');
        Route::get('/pending-lawyer-user',  'pendingLawyerUser')->name('pending_lawyer_user');
        Route::get('/active-lawyer-user',  'activeLawyerUser')->name('active_lawyer_user');
    });

    // route for admin user list and create admin user
    Route::controller(AdminUserController::class)->group(function () {
        Route::get('/admin-user-list', 'adminUserList')->name('admin_user_list');
        Route::post('/save-admin-user', 'saveAdminUser')->name('save_admin_user');
    });

    // route for role permission management
    Route::controller(RolePermissionController::class)->group(function () {
        Route::get('/role-list', 'roleList')->name('role_list');
        Route::get('/permission-list', 'permissionList')->name('permission_list');
        Route::post('/save-permission', 'savePermission')->name('save_permission');
        Route::post('/save-role', 'saveRole')->name('save_role');
        Route::post('/assign-role', 'assignRole')->name('assign_role');
        Route::post('/update-role', 'updateRole')->name('update_role');
    });

    // route for user 
    Route::controller(UserController::class)->group(function () {
        Route::get('/user-profile/{id}', 'userProfile')->name('user_profile');
        Route::get('/admin-change-password', 'adminChangePassword')->name('admin_change_password');
        Route::post('/update-admin-password', 'updateAdminPassword')->name('update_admin_password');
        Route::get('/admin-user-profile', 'adminUserProfile')->name('admin_user_profile');
        Route::post('/update-admin-profile', 'updateAdminProfile')->name('update_admin_profile');
        Route::get('/agent-change-password', 'agentChangePassword')->name('agent_change_password');
        Route::post('/update-agent-password', 'updateAgentPassword')->name('update_agent_password');
    });

     // Route for country
     Route::controller(CountryController::class)->group(function () {
        Route::get('/country-list', 'countryList')->name('country_list');
        Route::get('/add-new-country', 'addCountry')->name('add_new_country');
        Route::post('/save-new-country', 'saveCountry')->name('save_new_country');
        Route::get('/edit-country/{id}', 'editCountry')->name('edit_country');
        Route::post('/update-country/{id}', 'updateCountry')->name('update_country');
        Route::get('/country-details/{id}', 'countryDetails')->name('country_details');
        Route::delete('/delete-country/{id}',  'deleteCountry')->name('delete_country');
        Route::get('/search-countries', 'searchCountries')->name('search_countries_name');
    });

    // Route for company
    Route::controller(CompanyController::class)->group(function () {
        Route::get('/company-list', 'companyList')->name('company_list');
        Route::get('/search-company-name', 'searchCompanyName')->name('search_company_name');
        Route::get('/add-new-company', 'addCompany')->name('add_new_company');
        Route::post('/save-new-company', 'saveCompany')->name('save_new_company');
        Route::get('/edit-company/{id}', 'editCompany')->name('edit_company');
        Route::post('/update-company/{id}', 'updateCompany')->name('update_company');
        Route::get('/company-details/{id}', 'companyDetails')->name('company_details');
        Route::delete('/delete-company/{id}',  'deleteCompany')->name('delete_company');
    });

    Route::controller(CompanyJobController::class)->group(function () {
        Route::get('/job-list', 'jobList')->name('job_list');
        Route::get('/search-job', 'searchJob')->name('search_job');
        Route::get('/filter-job', 'filterJob')->name('filter_job');
        Route::get('/add-new-job', 'addNewJob')->name('add_new_job');
        Route::post('/save-new-job', 'saveNewJob')->name('save_new_job');
        Route::get('/edit-job/{id}', 'editJob')->name('edit_job');
        Route::post('/update-job/{id}', 'updateJob')->name('update_job');
        Route::get('/job-details/{id}', 'jobDetails')->name('job_details');
        Route::delete('/delete-job/{id}', 'deleteJob')->name('delete_job');
    });

    // Route for applicant
    Route::controller(ApplicantController::class)->group(function () {
        Route::get('/my-applicant-list', 'myApplicantList')->name('my_applicant_list');    
        Route::get('/applicant-list-agent', 'applicantListAgent')->name('applicant_list_agent');    
        Route::get('/add-new-applicant', 'addNewApplicant')->name('add_new_applicant');
        Route::post('/save-new-applicant', 'saveNewApplicant')->name('save_new_applicant');
        Route::get('/edit-applicant/{id}', 'editApplicant')->name('edit_applicant');
        Route::post('/update-applicant/{id}', 'updateApplicant')->name('update_applicant');
        Route::delete('/delete-applicant/{id}',  'deleteApplicant')->name('delete_applicant');
    });

    // Route for applications
    Route::controller(ApplicationController::class)->group(function () {
        Route::get('/my-application-list', 'myApplicationList')->name('my_application_list');
        Route::get('/application-list-agent', 'applicationListAgent')->name('application_list_agent');
        Route::get('/all-application', 'allApplication')->name('all_application');
        Route::get('/add-application-new-applicant/{job_id}', 'addApplicationNewApplicant')->name('add_application_new_applicant');
        Route::post('/save-application-new-applicant', 'saveApplicationNewApplicant')->name('save_application_new_applicant');
        Route::get('/add-application-existing-applicant/{job_id}/{applicant_id}', 'addApplicationEixApplicant')->name('add_application_eix_applicant');
        Route::post('/save-application-exit-applicant', 'saveApplicationEixApplicant')->name('save_application_eix_applicant');
        Route::get('/edit-application/{id}/{job_id}/{applicant_id}', 'editApplication')->name('edit_application');
        Route::post('/update-application/{id}', 'updateApplication')->name('update_application');
    });
});

Route::prefix('agent')->middleware(['agent'])->group(function () {
    Route::get('/agent-dashboard', [AgentDashboardController::class, 'agentDashboard'])->name('agent_dashboard');
    Route::get('/agent-home-page', [AgentHomeController::class, 'agentHomePage'])->name('agent_home_page');          
        
    
    // route for agent user 
    Route::controller(UserController::class)->group(function () {
        Route::get('/agent-change-password', 'agentChangePassword')->name('agent_change_password');
        Route::post('/update-agent-password', 'updateAgentPassword')->name('update_agent_password');
        Route::get('/agent-user-profile', 'agentUserProfile')->name('agent_user_profile');
        Route::post('/update-agent-profile', 'updateAgentProfile')->name('update_agent_profile');
    });

    // Route for agent country
    Route::controller(AgentCountryController::class)->group(function () {
        Route::get('/agent-country-list', 'agentCountryList')->name('agent_country_list');
        Route::get('/agent-country-details/{id}', 'agentCountryDetails')->name('agent_country_details');
        Route::get('/search-agent-countries', 'searchAgentCountries')->name('search_agent_countries');
    });
    
    // Route for agent company 
    Route::controller(AgentCompanyController::class)->group(function () {
        Route::get('/agent-company-list', 'agentCompanyList')->name('agent_company_list');
        Route::get('/search-agent-company', 'searchAgentCompany')->name('search_agent_company');
        Route::get('/agent-company-details/{id}', 'agentCompanyDetails')->name('agent_company_details');
    });

    // Route for agent company job
    Route::controller(AgentCompanyJobController::class)->group(function () {
        Route::get('/agent-job-list', 'agentJobList')->name('agent_job_list');
        Route::get('/agent-job-details/{id}', 'agentJobDetails')->name('agent_job_details');
        Route::get('/agent-search-job', 'agentSearchJob')->name('agent_search_job');
        Route::get('/agent-filter-job', 'agentFilterJob')->name('agent_filter_job');
    });   

    // Route for agent students
    Route::controller(AgentApplicantController::class)->group(function () {
        Route::get('/agent-applicant-list', 'agentApplicantList')->name('agent_applicant_list');
        Route::get('/agent-add-new-applicant', 'agentAddNewApplicant')->name('agent_add_new_applicant');
        Route::post('/agent-save-new-applicant', 'agentSaveNewApplicant')->name('agent_save_new_applicant');
        Route::get('/agent-edit-applicant/{id}', 'agentEditApplicant')->name('agent_edit_applicant');
        Route::post('/agent-update-applicant/{id}', 'agentUpdateApplicant')->name('agent_update_applicant');
    });

    // Route for agent applications
    Route::controller(AgentApplicationController::class)->group(function () {
        Route::get('/agent-application-list', 'agentApplicationList')->name('agent_application_list');
        Route::get('/agent-application-new-applicant/{job_id}', 'agentApplicationNewApplicant')->name('agent_application_new_applicant');
        Route::post('/save-agent-application-new-applicant', 'saveAgentApplicationNewApplicant')->name('save_agent_application_new_applicant');
        Route::get('/agent-application-existing-applicant/{job_id}/{applicant_id}', 'agentApplicationEixApplicant')->name('agent_application_existing_applicant');
        Route::post('/save-agent-application-exit-applicant', 'saveAgentApplicationEixApplicant')->name('save_agent_application_eix_applicant');
        Route::get('/agent-edit-application/{id}/{job_id}/{applicant_id}', 'agentEditApplication')->name('agent_edit_application');
        Route::post('/agent-update-application/{id}', 'agentUpdateApplication')->name('agent_update_application');
    });
});

Route::prefix('applicant')->middleware(['applicant'])->group(function () {
    Route::get('/applicant-dashboard', [ApplicantDashboardController::class, 'applicantDashboard'])->name('applicant_dashboard');

    // route for agent user 
    Route::controller(UserController::class)->group(function () {
        Route::get('/student-user-profile', 'studentUserProfile')->name('student_user_profile');
        Route::post('/update-student-profile', 'updateStudentProfile')->name('update_student_profile');
        Route::get('/student-change-password', 'studentChangePassword')->name('student_change_password');
        Route::post('/update-student-password', 'updateStudentPassword')->name('update_student_password');
    });

    // Route for applicant country
    Route::controller(ApplicantCountryController::class)->group(function () {
        Route::get('/applicant-country-list', 'applicantCountryList')->name('applicant_country_list');
        Route::get('/applicant-country-details/{id}', 'applicantCountryDetails')->name('applicant_country_details');
        Route::get('/search-applicant-countries', 'searchApplicantCountries')->name('search_applicant_countries');
    });

    // Route for applicant company
    Route::controller(ApplicantCompanyController::class)->group(function () {
        Route::get('/applicant-company-list', 'applicantCompanyList')->name('applicant_company_list');
        Route::get('/search-applicant-company', 'searchApplicantCompany')->name('search_applicant_company');
        Route::get('/applicant-company-details/{id}', 'applicantCompanyDetails')->name('applicant_company_details');
    });


    Route::controller(ApplicantJobController::class)->group(function () {
        Route::get('/applicant-job-list', 'applicantJobList')->name('applicant_job_list');
        Route::get('/applicant-job-details/{id}', 'applicantJobDetails')->name('applicant_job_details');
        Route::get('/applicant-search-job', 'applicantSearchJob')->name('applicant_search_job');
        Route::get('/applicant-filter-job', 'applicantFilterJob')->name('applicant_filter_job');           
    });

    // Route for applicant record info
    Route::controller(ApplicantRecordController::class)->group(function () {
        Route::get('/my-record-list', 'myRecordList')->name('my_record_list');
        Route::get('/edit-my-record', 'editMyRecord')->name('edit_my_record');
        Route::post('/update-my-record/{id?}', 'updateMyRecord')->name('update_my_record');

    });

    // Route for student recrord info
    // Route::controller(StudentRecordController::class)->group(function () {
    //     Route::get('/my-record-list', 'myRecordList')->name('my_record_list');
    //     Route::get('/edit-my-record', 'editMyRecord')->name('edit_my_record');
    //     Route::post('/update-my-record/{id?}', 'updateMyRecord')->name('update_my_record');

    // });

    Route::controller(StudentApplicationController::class)->group(function () {
         Route::get('/student-application-list', 'studentApplicationList')->name('student_application_list');
        Route::get('/student-application-existing-record/{course_id}/{student_id}', 'studentApplicationEixRecord')->name('student_application_existing_record');
        Route::post('/save-student-application-exit-record', 'saveStudentApplicationEixRecord')->name('save_student_application_exit_record');
    });

});


// route for lawyer
Route::prefix('lawyer')->middleware(['lawyer'])->group(function () {
    Route::get('/lawyer-dashboard', [LawyerDashboardController::class, 'lawyerDashboard'])->name('lawyer_dashboard');
});


