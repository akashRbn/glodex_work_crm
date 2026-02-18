<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Applicant as MiddlewareApplicant;
use App\Models\Admin\Applicant;
use App\Models\Admin\Company;
use App\Models\Admin\CompanyJob;
use App\Models\Admin\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class CompanyJobController extends Controller
{
    // Function to show job list page
    public function jobList()
    {
        $jobs = CompanyJob::with('company','country')
        ->where('avilable_positions', '>', 0)
        ->orderBy('id', 'desc')
        ->paginate(8);

        $countries = Country::where('status', 1)->get();

        $applicants = Applicant::with('createdBy')
            ->whereHas('createdBy', function ($query) {
                $query->where('user_type', 1);
            })->orderBy('id', 'desc')->get();

        return view('admin.job.job-list', compact('jobs', 'countries','applicants'));
    }

    // Function to search job by name and country
    public function searchJob(Request $request)
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
        $applicants = Applicant::with('createdBy')
            ->whereHas('createdBy', function ($query) {
                $query->where('user_type', 1);
            })->orderBy('id', 'desc')->get();
        return view('admin.job.job-list', compact('jobs', 'countries','applicants'));
    }


    public function filterJob(Request $request)
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

        $jobs = $query->orderBy('id', 'desc')->paginate(8)->withQueryString();
        $countries = Country::where('status', 1)->get();
        $applicants = Applicant::with('createdBy')
            ->whereHas('createdBy', function ($query) {
                $query->where('user_type', 1);
            })->orderBy('id', 'desc')->get();
        return view('admin.job.job-list', compact('jobs', 'countries','applicants'));
    }


    // Function to show add new job page
    public function addNewJob()
    {
        $countries = Country::where('status', 1)->get();
        $companies = Company::where('status', 1)->get();    
        return view('admin.job.add-new-job', compact('countries', 'companies'));
    }

    // Function to save new job
    public function saveNewJob(Request $request)
    {
        $request->validate([
            'company_id'         => 'required|exists:companies,id',
            'country_id'         => 'required|exists:countries,id',
            'job_name'           => 'required',
            'avilable_positions' => 'required',
            'job_type'           => 'required',
            'experience_level'   => 'required',
            'intial_fees'        => 'required',
            'job_location'       => 'required',
            'job_details'        => 'required',
        ]);

        DB::beginTransaction();
        try {
            $job = new CompanyJob(); 
            $job->company_id         = $request->company_id;
            $job->country_id         = $request->country_id;
            $job->job_name           = $request->job_name;
            $job->avilable_positions = $request->avilable_positions;
            $job->job_type           = $request->job_type;
            $job->experience_level   = $request->experience_level;
            $job->intial_fees        = $request->intial_fees;
            $job->job_location       = $request->job_location;
            $job->job_details        = $request->job_details;
            $job->save();

            DB::commit();
            Alert::success('Success', 'Job added successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            Alert::error('Error', 'Failed to save job. Please try again.');
            return redirect()->back();
        }
    }

    // Function to show edit job page
    public function editJob($id)
    {
        $job = CompanyJob::findOrFail($id);
        $countries = Country::where('status', 1)->get();
        $companies = Company::where('status', 1)->get();    
        return view('admin.job.edit-job', compact('job', 'countries', 'companies'));
    }
    
    // Function to update job
     public function updateJob(Request $request, $id)
    {
        $request->validate([
            'company_id'         => 'required|exists:companies,id',
            'country_id'         => 'required|exists:countries,id',
            'job_name'           => 'required',
            'avilable_positions' => 'required',
            'job_type'           => 'required',
            'experience_level'   => 'required',
            'intial_fees'        => 'required',
            'job_location'       => 'required',
            'job_details'        => 'required',
        ]);

        DB::beginTransaction();
        try {
            $updateJob                     = CompanyJob::findOrFail($id);
            $updateJob->company_id         = $request->company_id;
            $updateJob->country_id         = $request->country_id;
            $updateJob->job_name           = $request->job_name;
            $updateJob->avilable_positions = $request->avilable_positions;
            $updateJob->job_type           = $request->job_type;
            $updateJob->experience_level   = $request->experience_level;
            $updateJob->intial_fees        = $request->intial_fees;
            $updateJob->job_location       = $request->job_location;
            $updateJob->job_details        = $request->job_details;
            $updateJob->save();

            DB::commit();
            Alert::success('Success', 'Job updated successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            Alert::error('Error', 'Failed to update job. Please try again.');
            return redirect()->back();
        }
    }

    // Function to show job details page
    public function jobDetails($id)
    {
        $jobDetails = CompanyJob::with('company','country')->findOrFail($id);
        return view('admin.job.job-details', compact('jobDetails'));
    }

    // Function to delete job
    public function deleteJob($id)
    {
        try {
            $job = CompanyJob::findOrFail($id);
            $job->delete();
            Alert::success('Success', 'Job deleted successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to delete job. Please try again.');
            return redirect()->back();
        }
    }

           
}
