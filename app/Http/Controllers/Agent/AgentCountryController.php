<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Admin\Country;
use App\Models\Admin\University;
use Illuminate\Http\Request;

class AgentCountryController extends Controller
{
    public function agentCountryList()
    {
        $countries = Country::with('countryContinent')
        ->where('status', 1)
        ->withCount(['companies', 'jobs'])
        ->orderBy('country_name', 'asc')
        ->paginate(8);
        return view('agent.country.agent-country-list', compact('countries'));
    }

    public function searchAgentCountries(Request $request)
    {
        $query = Country::with('countryContinent')
            ->withCount(['universities', 'courses'])
            ->where('status', 1);

        // Search logic
        if ($request->filled('search_country')) {
            $query->where('country_name', 'LIKE', '%' . $request->search_country . '%');
        }

        // Pagination: default to 10 entries
        $perPage = $request->get('per_page', 10);
        $countries = $query->orderBy('id', 'desc')->paginate($perPage)->appends($request->all());

        return view('agent.country.agent-country-list', compact('countries'));
    }

    // function to country details
    public function agentCountryDetails($id)
    {
        $country = Country::findOrFail($id);
        $totalUniversities = $country->universities()->count();
        $totalCourses = $country->courses()->count();
        $randomUniversities = University::where('country_id', $country->id)
                                        ->inRandomOrder()
                                        ->take(10)
                                        ->get();

        return view('agent.country.agent-country-details', compact(
            'country',
            'totalUniversities',
            'totalCourses',
            'randomUniversities'
        ));
    }
}
