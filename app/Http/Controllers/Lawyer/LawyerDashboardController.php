<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\Admin\Applicant;
use App\Models\Admin\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LawyerDashboardController extends Controller
{
   public function lawyerDashboard()
    {
        $lawyerId               = Auth::id();
        $lawyerTotalApplicant   = Applicant::where('assigned_to_lawyer', $lawyerId)->count();
        $applicantIds           = Applicant::where('assigned_to_lawyer', $lawyerId)->pluck('id');
        $lawyerTotalApplication = Application::whereIn('applicant_id', $applicantIds)->count();
        $lawyerVisaGranted      = Application::where('status', 6)
                                    ->whereHas('applicant', function ($query) use ($lawyerId) {
                                        $query->where('assigned_to_lawyer', $lawyerId);
                                    })->count();
                                    
        $lawyerVisaRejected      = Application::where('status', 7)
                                    ->whereHas('applicant', function ($query) use ($lawyerId) {
                                        $query->where('assigned_to_lawyer', $lawyerId);
                                    })->count();
        return view('dashboard.lawyer-dashboard', compact('lawyerTotalApplicant', 'lawyerTotalApplication', 'lawyerVisaGranted', 'lawyerVisaRejected'));
    }
}
