<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Applicant;
use App\Models\Admin\Application;
use App\Models\Admin\Company;
use App\Models\Admin\CompanyJob;
use App\Models\Admin\Country;
use App\Models\Admin\Course;
use App\Models\Admin\StudentInfo;
use App\Models\Admin\University;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $isSuperAdmin      = Auth::user()->hasRole('SuperAdmin');
        $totalCountries    = Country::count();
        $totalCompanies    = Company::count();
        $totalJobs         = CompanyJob::count();
        $totalAplicants    = Applicant::count();
        $totalActiveAgent  = User::where('user_type', 2)->where('user_status', 2)->count();
        $totalApplications = Application::count();
        $totalVisaGranted  = Application::where('status', 6)->count();
        $totalVisaRejected = Application::where('status', 7)->count();
        
        // condition for BDM role

         // Condition for BDM Admin Role   
        $isBDM                 = Auth::user()->hasRole('BDM');
        $totalPartnerApplicants = Applicant::whereHas('createdBy', function ($query) {
                                    $query->where('created_by', Auth::id());
                                    })->count();

        $totalPartnerCreated = User::where('created_by',Auth::id())->where('user_type',2)->count();

        $authUser = Auth::user();
        $totalPartnerApplications = Application::whereHas('createdBy', function ($query) use ($authUser) {
            $query->where('user_type', 2)          
                ->where('created_by', $authUser->id);
        })->count();

        $totalPartnerVisaGranted = Application::where('status', 6)
        ->when($authUser->hasRole('BDM'), function ($query) use ($authUser) {
            $query->whereHas('createdBy', function ($q) use ($authUser) {
                $q->where('user_type', 2)
                ->where('created_by', $authUser->id);
            });
        })->count();

        $totalPartnerVisaRejected = Application::where('status', 7)
        ->when($authUser->hasRole('BDM'), function ($query) use ($authUser) {
            $query->whereHas('createdBy', function ($q) use ($authUser) {
                $q->where('user_type', 2)
                ->where('created_by', $authUser->id);
            });
        })->count();
    
       return view('dashboard.admin-dashboard', compact('isSuperAdmin', 'totalCountries','totalCompanies','totalJobs','totalAplicants','totalActiveAgent',
            'totalApplications','totalVisaGranted','totalVisaRejected',
            // conditions for BDM
            'isBDM','totalPartnerApplicants','totalPartnerCreated','totalPartnerApplications','totalPartnerVisaGranted','totalPartnerVisaGranted','totalPartnerVisaRejected'
       ));
    }
}
