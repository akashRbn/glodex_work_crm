<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Admin\Company;
use App\Models\Admin\Country;
use Illuminate\Http\Request;

class ApplicantCountryController extends Controller
{
    public function applicantCountryList()
    {
        $countries = Country::with('countryContinent')
        ->where('status', 1)
        ->withCount(['companies', 'jobs'])
        ->orderBy('country_name', 'asc')
        ->paginate(8);

        return view('applicant.country.applicant-country-list', compact('countries'));
    }


    // Function to search countries for applicant
    public function searchApplicantCountries(Request $request)
    {
        $query = Country::with('countryContinent')
            ->withCount(['companies', 'jobs'])
            ->where('status', 1);

        // Search logic
        if ($request->filled('search_applicant_countries')) {
            $query->where('country_name', 'LIKE', '%' . $request->search_applicant_countries . '%');
        }

        // Pagination: default to 10 entries
        $perPage = $request->get('per_page', 10);
        $countries = $query->orderBy('id', 'desc')->paginate($perPage)->appends($request->all());

        return view('applicant.country.applicant-country-list', compact('countries'));
    }

    // function to applicant country details
    public function applicantCountryDetails($id)
    {
        $country = Country::findOrFail($id);
        $totalCompanies = $country->companies()->count();
        $totalJobs = $country->jobs()->count();
        $randomCompanies = Company::where('country_id', $country->id)
                                        ->inRandomOrder()
                                        ->take(10)
                                        ->get();

        return view('applicant.country.applicant-country-details', compact('country','totalCompanies','totalJobs','randomCompanies'));
    }
}
