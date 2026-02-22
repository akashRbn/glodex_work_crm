<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\Admin\Applicant;
use Illuminate\Http\Request;

class LawyerApplicantController extends Controller
{
    public function lawyerApplicantList()
    {
        $lawyerId = auth()->id();
        $applicants = Applicant::where('assigned_to_lawyer', $lawyerId)
            ->orderBy('id', 'desc')
            ->get();
        return view('lawyer.applicant.lawyer-applicant-list', compact('applicants'));    
    }

    public function editLawyerApplicant($id)
    {
        $applicant = Applicant::findOrFail($id);
        $englishTests = json_decode($applicant->english_proficiency, true) ?? [];
        $academicQualifications = json_decode($applicant->academic_qualifications, true) ?? [];
        return view('lawyer.applicant.edit-lawyer-applicant', compact('applicant', 'englishTests', 'academicQualifications'));
    }
}
