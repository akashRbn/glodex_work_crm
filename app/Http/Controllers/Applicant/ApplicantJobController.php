<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Admin\Applicant;
use App\Models\Admin\CompanyJob;
use App\Models\Admin\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicantJobController extends Controller
{
    public function applicantJobList()
    {
        $jobs = CompanyJob::with('company','country')
        ->where('avilable_positions', '>', 0)
        ->orderBy('id', 'desc')
        ->paginate(8);

        $countries  = Country::where('status', 1)->get();

        $applicants = Applicant::where('created_by', Auth::id())
                    ->orderBy('id', 'desc')
                    ->get();

        return view('applicant.job.applicant-job-list', compact('jobs', 'countries','applicants'));
    }


    public function applicantSearchJob(Request $request)
    {
        $query = CompanyJob::with(['country']);
        $searchJob = $request->input('search_job');
        $searchCountry = $request->input('search_country');
        $perPage = $request->input('per_page', 8);

        if (!empty($searchJob)) {
            $query->where('job_name', 'like', '%' . $searchJob . '%');
        }

        if (!empty($searchCountry)) {
            $query->whereHas('country', function ($q) use ($searchCountry) {
                $q->where('country_name', 'like', '%' . $searchCountry . '%');
            });
        }

        $jobs = $query->paginate($perPage)->appends($request->all());
        $countries = Country::where('status', 1)->get();
        $applicants = Applicant::where('created_by', Auth::id())
                        ->orderBy('id', 'desc')
                        ->get();
        return view('applicant.job.applicant-job-list', compact('jobs', 'countries','applicants'));
    }


    public function applicantFilterJob(Request $request)
    {
        $query = CompanyJob::with(['company', 'country']);

        // Job name filter
        if ($request->filled('job_name')) {
            $query->where('job_name', 'like', '%' . $request->job_name . '%');
        }

        // Company name filter (relationship)
        if ($request->filled('company_name')) {
            $query->whereHas('company', function ($q) use ($request) {
                $q->where('company_name', 'like', '%' . $request->company_name . '%');
            });
        }

        if ($request->filled('country_id')) {
            $query->where('country_id', $request->country_id);
        }

        // Job type filter
        if ($request->filled('job_type')) {
            $query->where('job_type', $request->job_type);
        }

        $jobs       = $query->orderBy('id', 'desc')->paginate(8)->withQueryString();
        $countries  = Country::where('status', 1)->get();
        $applicants = Applicant::where('created_by', Auth::id())
                        ->orderBy('id', 'desc')
                        ->get();
        return view('applicant.job.applicant-job-list', compact('jobs', 'countries','applicants'));
    }

    public function agentFilterJob(Request $request)
    {
        $query = CompanyJob::with(['company', 'country']);

        // Job name filter
        if ($request->filled('job_name')) {
            $query->where('job_name', 'like', '%' . $request->job_name . '%');
        }

        // Company name filter (relationship)
        if ($request->filled('company_name')) {
            $query->whereHas('company', function ($q) use ($request) {
                $q->where('company_name', 'like', '%' . $request->company_name . '%');
            });
        }

        if ($request->filled('country_id')) {
            $query->where('country_id', $request->country_id);
        }

        // Job type filter
        if ($request->filled('job_type')) {
            $query->where('job_type', $request->job_type);
        }

        $jobs       = $query->orderBy('id', 'desc')->paginate(8)->withQueryString();
        $countries  = Country::where('status', 1)->get();
        $applicants = Applicant::where('created_by', Auth::id())
                        ->orderBy('id', 'desc')
                        ->get();
        return view('agent.job.agent-job-list', compact('jobs', 'countries','applicants'));
    }

    // Function to show job details page
    public function applicantJobDetails($id)
    {
        $jobDetails = CompanyJob::with('company','country')->findOrFail($id);
        return view('applicant.job.applicant-job-details', compact('jobDetails'));
    }
}
