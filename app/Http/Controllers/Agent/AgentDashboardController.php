<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Admin\Applicant;
use App\Models\Admin\Application;
use App\Models\Admin\Company;
use App\Models\Admin\CompanyJob;
use App\Models\Admin\Country;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Course;
use App\Models\Admin\StudentInfo;
use App\Models\Admin\University;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class AgentDashboardController extends Controller
{
    public function agentDashboard()
    {
        $agentTotalCountries        = Country::count();
        $agentTotalCompanies        = Company::count();
        $agentTotalJobs             = CompanyJob::count();
        $agentTotalApplicants       = Applicant::where('created_by', Auth::id())->count();
        $agentTotalApplications     = Application::where('created_by', Auth::id())->count();
        $AgentInProgressApplication = Application::where('status', 1)->where('created_by', Auth::id())->count(); 
        $agentTotalVisaGranted      = Application::where('status', 6)->where('created_by', Auth::id())->count();
        $agentTotalVisaRejected     = Application::where('status', 7)->count();
        return view('dashboard.agent-dashboard',compact('agentTotalCountries','agentTotalCompanies','agentTotalJobs',
       'agentTotalApplicants','agentTotalApplications','AgentInProgressApplication','agentTotalVisaGranted','agentTotalVisaRejected'));
    }
}
