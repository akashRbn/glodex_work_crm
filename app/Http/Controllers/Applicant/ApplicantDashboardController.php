<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicantDashboardController extends Controller
{
    public function applicantDashboard()
    {
        return view('dashboard.applicant-dashboard');
    }
}
