<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LawyerDashboardController extends Controller
{
    public function lawyerDashboard()
    {
        return view('dashboard.lawyer-dashboard');
    }
}
