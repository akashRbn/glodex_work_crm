<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Handler\ImageHandlerController;
use App\Models\Admin\Company;
use App\Models\Admin\Country;
use App\Models\Admin\CountryContinent;
use App\Models\Admin\University;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CountryController extends Controller
{
    protected $imageHandler;

    // Functio to call image handler
    public function __construct(ImageHandlerController $imageHandler)
    {
        $this->imageHandler = $imageHandler;
    }
    
    // function to show country list
    public function countryList()
    {
        $countries = Country::with('countryContinent')
        ->where('status', 1)
        ->withCount(['companies', 'jobs'])
        ->orderBy('country_name', 'asc')
        ->paginate(8);
        return view('admin.country.country-list', compact('countries'));
    }

    public function searchCountries(Request $request)
    {
        $query = Country::with('countryContinent')
            ->withCount(['companies', 'jobs'])
            ->where('status', 1);

        // Search logic
        if ($request->filled('search_country')) {
            $query->where('country_name', 'LIKE', '%' . $request->search_country . '%');
        }

        // Pagination: default to 10 entries
        $perPage = $request->get('per_page', 10);
        $countries = $query->orderBy('id', 'desc')->paginate($perPage)->appends($request->all());

        return view('admin.country.country-list', compact('countries'));
    }

    // function to add country
    public function addCountry()
    {
        $countryContinents = CountryContinent::all();
        return view('admin.country.add-new-country', compact('countryContinents'));
    }

    // function to save country
    public function saveCountry(Request $request)
    {
       
        $request->validate([
            'country_name'       => 'required|string|max:50',
            'country_capital'    => 'required|string|max:50',
            'country_population' => 'required|string|max:50',
            'country_gdp'        => 'required|string|max:50',
            'description'        => 'required',
            'flag'               => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cover_photo'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description'        => 'nullable',
            ], [
               'country_continent_id.required' => 'The country continent field is required.',
        ]);

        DB::beginTransaction();
        try {
        $country = new Country();
        $country->country_name       = $request->country_name;
        $country->country_capital    = $request->country_capital;
        $country->country_population = $request->country_population;
        $country->country_gdp        = $request->country_gdp;
        $country->continent_id       = $request->continent_id;
        $country->description        = $request->description;

        if ($request->hasFile('flag')) {
        $file = $request->file('flag');
        $filePath = $this->imageHandler->countryFlag($file);
        $country->flag = $filePath;
      }

      if ($request->hasFile('cover_photo')) {
          $file = $request->file('cover_photo');
          $filePath = $this->imageHandler->countryCoverPhoto($file);
          $country->cover_photo = $filePath;
        }

      $country->save();
      DB::commit();
      Alert::success('Success', 'Country added successfuly');
      return redirect()->route('country_list');
    }catch (\Exception $e) {
            DB::rollback();
            Alert::error('Error', 'Failed to save country. Please try again.');
            return redirect()->back();
        }
    }

    // function to edit country
    public function editCountry($id)
    {
        $countryContinents = CountryContinent::all();
        $country = Country::findOrFail($id);
        return view('admin.country.edit-country', compact('countryContinents','country'));
    }


     // function to save country
    public function updateCountry(Request $request, $id)
    {
       
        $request->validate([
            'country_name' => 'required|string|max:50',
            'continent_id' => 'required|integer',
            'flag' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            ], [
               'country_continent_id.required' => 'The country continent field is required.',
        ]);

        DB::beginTransaction();
        try {
        $updateCountry                     = Country::findOrFail($id);
        $updateCountry->country_name       = $request->country_name;
        $updateCountry->country_capital    = $request->country_capital;
        $updateCountry->country_population = $request->country_population;
        $updateCountry->country_gdp        = $request->country_gdp;
        $updateCountry->continent_id       = $request->continent_id;
        $updateCountry->description        = $request->description;

        if ($request->hasFile('flag')) {
        $file = $request->file('flag');
        $filePath = $this->imageHandler->countryFlag($file);
        $updateCountry->flag = $filePath;
      }

      if ($request->hasFile('cover_photo')) {
          $file = $request->file('cover_photo');
          $filePath = $this->imageHandler->countryCoverPhoto($file);
          $updateCountry->cover_photo = $filePath;
        }

      $updateCountry->save();
      DB::commit();
      Alert::success('Succes', 'Country update successfuly');
      return redirect()->route('country_list');
    }catch (\Exception $e) {
            DB::rollback();
            Alert::error('Error', 'Failed to update country. Please try again.');
            return redirect()->back();
        }
    }

    // function to country details
    public function countryDetails($id)
    {
        $country = Country::findOrFail($id);
        $totalCompanies = $country->companies()->count();
        $totalJobs = $country->jobs()->count();
        $randomCompanies = Company::where('country_id', $country->id)
                                        ->inRandomOrder()
                                        ->take(10)
                                        ->get();

        return view('admin.country.country-details', compact(
            'country',
            'totalCompanies',
            'totalJobs',
            'randomCompanies'
        ));
    }


    // function to delete country
    public function deleteCountry($id)
    {
        try {
            $country = Country::findOrFail($id);
            $country->delete();
            Alert::success('Success', 'Country deleted successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to delete country');
            return redirect()->back();
        }
    }
}
