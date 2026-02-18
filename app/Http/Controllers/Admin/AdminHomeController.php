<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Country;
use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    public function adminHomePage()
    {
        $countries = Country::where('status', 1)->orderBy('country_name', 'asc')->get();
        return view('admin.admin-home-page', compact('countries'));
    }
}
