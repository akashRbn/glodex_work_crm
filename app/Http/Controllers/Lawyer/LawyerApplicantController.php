<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\Admin\Applicant;
use App\Models\Admin\ApplicantFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

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

     public function updateLawyerApplicant(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:50',
            'phone'       => 'required',
            'email'       => 'required',
            'dob'         => 'required',
            'passport_no'  => 'required',
            'permanent_address'  => 'required',
            'gender'  => 'required',
        ]);

        DB::beginTransaction();
        try {

        $updateApplicant                     = Applicant::findOrFail($id);
        $updateApplicant->name               = $request->name;
        $updateApplicant->phone              = $request->phone;
        $updateApplicant->email              = $request->email;
        $updateApplicant->permanent_address  = $request->permanent_address;
        $updateApplicant->gender             = $request->gender;
        $updateApplicant->fathers_name       = $request->fathers_name;
        $updateApplicant->mothers_name       = $request->mothers_name;
        $updateApplicant->dob                = $request->dob;
        $updateApplicant->passport_no        = $request->passport_no;
        $updateApplicant->assigned_to_lawyer = $request->assigned_to_lawyer;
        $updateApplicant->moi                = $request->moi;
        $updateApplicant->notes              = $request->notes;

        // Save English Proficiency
        if ($request->has('english_tests')) {
            $englishTests = [];
            foreach ($request->english_tests as $test) {
                $englishTests[] = [
                    'type'      => $test['type'] ?? null,
                    'listening' => $test['listening'] ?? null,
                    'reading'   => $test['reading'] ?? null,
                    'writing'   => $test['writing'] ?? null,
                    'speaking'  => $test['speaking'] ?? null,
                    'overall'   => $test['overall'] ?? null,
                ];
            }

            $updateApplicant->english_proficiency = json_encode($englishTests);
        }

        // Save Academic Qualifications
        if ($request->has('academic_qualifications')) {
            $academicQualifications = [];
            foreach ($request->academic_qualifications as $qualification) {
                $academicQualifications[] = [
                    'group_name'     => $qualification['group_name'] ?? null,
                    'institute_name' => $qualification['institute_name'] ?? null,
                    'gpa'            => $qualification['gpa'] ?? null,
                    'passing_year'   => $qualification['passing_year'] ?? null,
                ];
            }
            $updateApplicant->academic_qualifications = json_encode($academicQualifications);
        }

        $updateApplicant->save();

        
        if ($request->hasFile('applicantfiles')) {
          $applicantFiles = $request->file('applicantfiles');
          $filenames = $request->input('filename');

          foreach ($applicantFiles as $key => $single) {
            $filename = $filenames[$key];
            $originalFileName = $single->getClientOriginalName();
            $originalFileName2 = Carbon::now()->timestamp . $updateApplicant->name . $originalFileName;
            $filePath = $single->storeAs($filename, $originalFileName2, 'public');

            $applicantFile = ApplicantFile::where('applicant_id', $updateApplicant->id)
              ->where('filename', $filename)
              ->first();
            if ($applicantFile) {
              $applicantFile->filepath = $filePath;
              $applicantFile->save();
            } else {
              $applicantFile                 = new ApplicantFile();
              $applicantFile->applicant_id   = $updateApplicant->id;
              $applicantFile->filepath       = $filePath;
              $applicantFile->filename       = $filename;
              $applicantFile->save();
            }
          }
        }
        DB::commit();
        Alert::success('Success','Applicant updated successfully');
        return redirect()->back();
        }catch (\Exception $e) {
            DB::rollBack();
            //   dd($e);
            Alert::error('Error', 'Applicant Already Exists');
            return redirect()->back();
        }
    }
}
