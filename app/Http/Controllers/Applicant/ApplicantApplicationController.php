<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Admin\Applicant;
use App\Models\Admin\ApplicantFile;
use App\Models\Admin\Application;
use App\Models\Admin\CompanyJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ApplicantApplicationController extends Controller
{
    public function applicantApplicationList()
    {
        $user = Auth::user();
        $applications = Application::with([
            'applicant',
            'job.country',
            'job.company',
            'applicationStatus'
        ])
        ->whereHas('applicant', function ($q) use ($user) {
            // Match application to logged-in student only
            $q->where('user_id', $user->id)
              ->orWhere('email', $user->email);
        })
        ->orderBy('id', 'desc')
        ->get();
        return view('applicant.application.applicant-application-list', compact('applications'));
    }



    public function applicantApplicationEixRecord($job_id, $applicant_id)
    {
        $applicationExists = Application::where('job_id', $job_id)
        ->where('applicant_id', $applicant_id)
        ->exists();

        if ($applicationExists) {
            Alert::error('Error', 'In this job the application in progress');
            return redirect()->back();
        }

        $job   = CompanyJob::find($job_id);
        $applicant  = Applicant::find($applicant_id);
        $englishTests = json_decode($applicant->english_proficiency, true) ?? [];
        $academicQualifications = json_decode($applicant->academic_qualifications, true) ?? [];
        return view('applicant.application.applicant-application-existing-record',compact('job','applicant','englishTests','academicQualifications'));
    }


    public function saveApplicantApplicationEixRecord(Request $request)
    {
        $request->validate([
            'applicant_id'      => 'required|exists:applicants,id',
            'name'              => 'required|string|max:50',
            'phone'             => 'required',
            'email'             => 'required|email',
            'dob'               => 'required|date',
            'passport_no'       => 'required|string',
            'permanent_address' => 'required|string',
            'gender'            => 'required',
            'going_year'        => 'required',
            'job_id'            => 'required|exists:company_jobs,id',
        ]);

        DB::beginTransaction();

        try {
            // Find existing applicant
            $applicantInfo = Applicant::find($request->applicant_id);

            if (!$applicantInfo) {
                Alert::error('Error', 'Applicant not found.');
                return redirect()->back();
            }

            $job = CompanyJob::lockForUpdate()->find($request->job_id);

            if (!$job || $job->avilable_positions <= 0) {
                throw new \Exception('No available positions left for this job.');
            }

            // Decrease available position
            $job->decrement('avilable_positions');

            //Update Applicant Info
            $applicantInfo->update([
                'name'              => $request->name,
                'phone'             => $request->phone,
                'email'             => $request->email,
                'dob'               => $request->dob,
                'passport_no'       => $request->passport_no,
                'permanent_address' => $request->permanent_address,
                'gender'            => $request->gender,
                'fathers_name'      => $request->fathers_name,
                'mothers_name'      => $request->mothers_name,
                'moi'               => $request->moi,
                'notes'             => $request->notes,
            ]);

            // 🔹 Update English Proficiency
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
                $applicantInfo->save();
            }

            //Update Academic Qualifications
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
                $applicantInfo->save();
            }

            //Upload Applicant Files (if any new files)
            if ($request->hasFile('applicantfiles')) {
                $applicantFiles = $request->file('applicantfiles');
                $filenames = $request->input('filename');

                foreach ($applicantFiles as $key => $single) {
                    $originalFileName = $single->getClientOriginalName();
                    $newFileName = Carbon::now()->timestamp . '_' . $applicantInfo->name . '_' . $originalFileName;
                    $filePath = $single->storeAs($filenames[$key], $newFileName, 'public');

                    ApplicantFile::create([
                        'applicant_id' => $applicantInfo->id,
                        'filename'   => $filenames[$key],
                        'filepath'   => $filePath,
                    ]);
                }
            }

            //Create Application for this applicant
            Application::create([
                'user_id' => Auth::id(),
                'job_id' => $job->id,
                'applicant_id' => $applicantInfo->id,
                'sent_by' => Auth::user()->organization_name ?? 'Not Added',
                'application_code' => rand(100000, 999999),
                'created_by' => Auth::id(),
                'going_year' => $request->going_year,
            ]);

            DB::commit();

            Alert::success('Success', 'Application added successfully for existing applicant.');
            return redirect()->route('agent_application_list');

        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            Alert::error('Error', 'Failed to add application, Try Again.');
            return redirect()->back()->withInput();
        }
    }
}
