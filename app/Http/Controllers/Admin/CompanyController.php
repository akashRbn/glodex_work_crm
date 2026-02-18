<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Handler\ImageHandlerController;
use App\Models\Admin\Company;
use App\Models\Admin\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class CompanyController extends Controller
{
    
    protected $imageHandler;

    // Functio to call image handler
    public function __construct(ImageHandlerController $imageHandler)
    {
        $this->imageHandler = $imageHandler;
    }

    // Function to show company list page
    public function companyList()
    {
        $companies    = Company::with('country')->orderBy('id','desc')->paginate(8);
        $countries    = Country::where('status', 1)->get();
        return view('admin.company.company-list', compact('companies','countries'));
    }

    // Function to search company by name and country
    public function searchCompanyName(Request $request)
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

        return view('admin.company.company-list', compact('companies', 'countries'));
    }

    
    // Function to show add company page
    public function addCompany()
    {
        $countries = Country::where('status', 1)->get();
        $users = User::where('user_type', 4)->where('user_status', 2)->get();   
        return view('admin.company.add-new-company', compact('countries', 'users'));
    }

    // function to save company
    public function saveCompany(Request $request)
    {
        $request->validate([
            'company_name'  => 'required',
            'company_city'  => 'required',
            'company_email' => 'required|email',
            'company_phone' => 'required',
            'website_link'  => 'required|url',
            'address'       => 'required',
            'description'   => 'required',
            'country_id'    => 'required|exists:countries,id',
            'lawyer_id'     => 'required|exists:users,id',
            'logo'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'country_id.required' => 'The country field is required.',
            'lawyer_id.required'  => 'The lawyer field is required.',
        ]);


        DB::beginTransaction();
        try {
            $company = new Company();
            $company->company_name  = $request->company_name;
            $company->country_id    = $request->country_id;
            $company->lawyer_id     = $request->lawyer_id;
            $company->company_city  = $request->company_city;
            $company->company_email = $request->company_email;
            $company->company_phone = $request->company_phone;
            $company->website_link  = $request->website_link;
            $company->address       = $request->address;
            $company->description   = $request->description;

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $filePath = $this->imageHandler->companyPhoto($file);
                $company->logo = $filePath;
            }

        $company->save();
        DB::commit();
        Alert::success('Success', 'Company added successfuly');
        return redirect()->back();
        }catch (\Exception $e) {
            DB::rollback();
            dd($e);
            Alert::error('Error', 'Failed to save company. Please try again.');
            return redirect()->back();
        }
    }

    // function to edit company
    public function editCompany($id)
    {  
        $company   = Company::findOrFail($id);
        $countries =  Country::where('status', 1)->get();
        $users = User::where('user_type', 4)->where('user_status', 2)->get(); 
        return view('admin.company.edit-company', compact('countries','company','users'));
    }

    // function to update company
     public function updateCompany(Request $request, $id)
    {
        $request->validate([
            'company_name'  => 'required',
            'company_city'  => 'required',
            'company_email' => 'required|email',
            'company_phone' => 'required',
            'website_link'  => 'required|url',
            'address'       => 'required',
            'description'   => 'required',
            'country_id'    => 'required|exists:countries,id',
            'lawyer_id'     => 'required|exists:users,id',
            'logo'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'country_id.required' => 'The country field is required.',
            'lawyer_id.required'  => 'The lawyer field is required.',
        ]);


        DB::beginTransaction();
        try {
            $updateCompany = Company::findOrFail($id);
            $updateCompany->company_name  = $request->company_name;
            $updateCompany->country_id    = $request->country_id;
            $updateCompany->lawyer_id     = $request->lawyer_id;
            $updateCompany->company_city  = $request->company_city;
            $updateCompany->company_email = $request->company_email;
            $updateCompany->company_phone = $request->company_phone;
            $updateCompany->website_link  = $request->website_link;
            $updateCompany->address       = $request->address;
            $updateCompany->description   = $request->description;

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $filePath = $this->imageHandler->companyPhoto($file);
                $updateCompany->logo = $filePath;
            }

        $updateCompany->save();
        DB::commit();
        Alert::success('Success', 'Company updated successfuly');
        return redirect()->back();
        }catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            Alert::error('Error', 'Failed to update company. Please try again.');
            return redirect()->back();
        }
    }

    // function to show company details
    public function companyDetails($id)
    {
        $companyDetails = Company::with('country')->findOrFail($id);
        return view('admin.company.company-details', compact('companyDetails'));
    }

    // function to delete university
    public function deleteCompany($id)
    {
        try {
            $company = Company::findOrFail($id);
            $company->delete();
            Alert::success('Success', 'Company deleted successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to delete company');
            return redirect()->back();
        }
    }}
