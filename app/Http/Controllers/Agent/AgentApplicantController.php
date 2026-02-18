<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Admin\Applicant;
use App\Models\Admin\ApplicantFile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AgentApplicantController extends Controller
{

    //  Function to show agent student list
    public function agentApplicantList()
    {
        $applicants = Applicant::with('createdBy')
            ->where('created_by', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('agent.applicant.agent-applicant-list', compact('applicants'));
    }

    // function to show add new applicant page
    public function agentAddNewApplicant()
    {
        return view('agent.applicant.agent-add-new-applicant');
    }

    // function to agent save new applicant
    public function agentSaveNewApplicant(Request $request)
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


        $existingApplicant = Applicant::where('phone', $request->phone)
        ->orWhere('email', $request->email)
        ->orWhere('passport_no', $request->passport_no)
        ->exists();

        if ($existingApplicant) {
        Alert::error('Error', 'Applicant Already Exists');
        return redirect()->back()->withInput();
        }

        DB::beginTransaction();
        try {

        $user = User::create([
            'name'      => $request->name,
            'phone'     => $request->phone,
            'email'     => $request->email,
            'password'  => Hash::make('applicant1234'),
            'created_by'=> Auth::id(),
            'user_type' => 3, //Applicant
        ]);

        $applicantInfo                              = new Applicant();
        $applicantInfo->user_id                     = $user->id;
        $applicantInfo->sent_by                     = Auth::user()->organization_name ?? 'N/A';
        $applicantInfo->name                        = $request->name;
        $applicantInfo->applicant_code              =  'GLD' . rand(1000000, 9999999);
        $applicantInfo->phone                       = $request->phone;
        $applicantInfo->email                       = $request->email;
        $applicantInfo->permanent_address           = $request->permanent_address;
        $applicantInfo->gender                      = $request->gender;
        $applicantInfo->fathers_name                = $request->fathers_name;
        $applicantInfo->mothers_name                = $request->mothers_name;
        $applicantInfo->dob                         = $request->dob;
        $applicantInfo->passport_no                 = $request->passport_no;
        $applicantInfo->moi                         = $request->moi;
        $applicantInfo->notes                       = $request->notes;
        $applicantInfo->created_by                  = Auth::id();

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

            $applicantInfo->english_proficiency = json_encode($englishTests);
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
            $applicantInfo->academic_qualifications = json_encode($academicQualifications);
        }

        $applicantInfo->save();

        $applicantFiles  = $request->file('applicantfiles');
        $filenames     = $request->input('filename');           
        $applicantId    = $applicantInfo->id;
        foreach ($applicantFiles as $key => $single) {
        $originalFileName = $single->getClientOriginalName();
        $originalFileName2 = Carbon::now()->timestamp . $applicantInfo->name . $originalFileName;
        $filePath = $single->storeAs($filenames[$key], $originalFileName2, 'public');

        $applicantFile                 = new ApplicantFile();
        $applicantFile->applicant_id   = $applicantId;
        $applicantFile->filename       = $filenames[$key];
        $applicantFile->filepath       = $filePath;
        $applicantFile->save();
        }
        DB::commit();
        Alert::success('Success', 'Applicant added successfully');
        return redirect()->back();
        }catch (\Exception $e) {
            DB::rollBack();
            //   dd($e);
            Alert::error('Error', 'Failed to save applicant, Try Again');
            return redirect()->back();
        }
    }

    // function to edit agent applicant
    public function agentEditApplicant($id)
    {
        $applicant = Applicant::findOrFail($id);
        $englishTests = json_decode($applicant->english_proficiency, true) ?? [];
        $academicQualifications = json_decode($applicant->academic_qualifications, true) ?? []; // ← Add this line
        return view('agent.applicant.edit-agent-applicant', compact('applicant', 'englishTests', 'academicQualifications'));
    }

     // Function to update applicant
    public function agentUpdateApplicant(Request $request, $id)
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
