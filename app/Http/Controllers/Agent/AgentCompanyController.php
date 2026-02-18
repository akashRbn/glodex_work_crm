<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Admin\Company;
use App\Models\Admin\Country;
use Illuminate\Http\Request;

class AgentCompanyController extends Controller
{
    // function to company list
    public function agentCompanyList()
    {
        $companies    = Company::with('country')->orderBy('id','desc')->paginate(8);
        $countries    = Country::where('status', 1)->get();
        return view('agent.company.agent-company-list', compact('companies','countries'));
    }

    // Function to search company by name and country
     public function searchAgentCompany(Request $request)
    {
        $query = Company::with('country')->orderBy('id', 'desc');

        // Search by company name
        if ($request->filled('search')) {
            $query->where('company_name', 'LIKE', '%' . $request->search . '%');
        }

        // Filter by country
        if ($request->filled('country_id')) {
            $query->where('country_id', $request->country_id);
        }

        $perPage = $request->input('per_page', 8);
        $companies = $query->paginate($perPage)->appends($request->all());

        $countries = Country::where('status', 1)->get();

        return view('agent.company.agent-company-list', compact('companies', 'countries'));
    }

    public function agentCompanyDetails($id)
    {
        $companyDetails = Company::with('country')->findOrFail($id);
        return view('agent.company.agent-company-details', compact('companyDetails'));
    }
}
