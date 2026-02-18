<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Admin\Application;
use App\Models\Admin\Company;
use App\Models\Admin\CompanyJob;
use App\Models\Admin\Country;
use Illuminate\Http\Request;

class ApplicantDashboardController extends Controller
{
    public function applicantDashboard()
    {
        $applicantTotalCountries  = Country::count();
        $applicantTotalCompanies  = Company::count();
        $applicantTotalJobs       = CompanyJob::count();
        $user = auth()->user();
        $aplicantTotalApplications = Application::whereHas('applicant', function ($q) use ($user) {
                $q->where('user_id', $user->id)
                ->orWhere('email', $user->email);
            })->count();

        $applicantInProgressApplication = Application::where('status', 1)
                        ->whereHas('applicant', function ($q) use ($user) {
                            $q->where('user_id', $user->id)
                            ->orWhere('email', $user->email);
                        })->count();

         $applicantAppliedApplication = Application::where('status', 3)
                        ->whereHas('applicant', function ($q) use ($user) {
                            $q->where('user_id', $user->id)
                            ->orWhere('email', $user->email);
                        })->count();

        $applicantTotalVisaGranted = Application::where('status', 10)
                        ->whereHas('applicant', function ($q) use ($user) {
                            $q->where('user_id', $user->id)
                            ->orWhere('email', $user->email);
                        })->count();
                        
         $applicantTotalVisaRejected  =  Application::where('status', 12)
                        ->whereHas('applicant', function ($q) use ($user) {
                            $q->where('user_id', $user->id)
                            ->orWhere('email', $user->email);
                        })->count();

        return view('dashboard.applicant-dashboard', compact('applicantTotalCountries', 'applicantTotalCompanies', 'applicantTotalJobs', 'aplicantTotalApplications',
        'applicantInProgressApplication', 'applicantAppliedApplication','applicantTotalVisaGranted', 'applicantTotalVisaRejected'));
    }
}
