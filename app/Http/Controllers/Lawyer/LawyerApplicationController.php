<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\Admin\Applicant;
use App\Models\Admin\ApplicantFile;
use App\Models\Admin\Application;
use App\Models\Admin\ApplicationStatus;
use App\Models\Admin\CompanyJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class LawyerApplicationController extends Controller
{
    public function lawyerApplicationList()
    {
        $lawyerId = auth()->id();

        $applications = Application::with(['applicant','job.country','job.company','applicationStatus'])
            ->whereHas('job.company', function ($query) use ($lawyerId) {
                $query->where('lawyer_id', $lawyerId);
            })
            ->orderBy('id', 'desc')
            ->get();
        return view('lawyer.application.lawyer-application-list', compact('applications'));
    }

    public function lawyerEditApplication($id, $job_id, $applicant_id)
    {
        $application = Application::find($id);

        if (!$application) {
            Alert::error('Error', 'Application not found.');
            return redirect()->back();
        }

        $job = CompanyJob::find($job_id);
        if (!$job) {
            Alert::error('Error', 'Job not found.');
            return redirect()->back();
        }

        if (!$applicant_id || !Applicant::find($applicant_id)) {
            Alert::error('Error', 'Applicant record has been deleted or is invalid.');
            return redirect()->back();
        }

        $applicant = Applicant::find($applicant_id);

        // Make sure expires_at is a Carbon instance
        if ($application->expires_at) {
            $expiresAt = Carbon::parse($application->expires_at); // parse string to Carbon
            $now = Carbon::now();
            $diff = $expiresAt->diff($now);

            // Add attributes to $application for Blade
            $application->days = $diff->invert ? $diff->d : 0; // invert = future
            $application->hours = $diff->invert ? $diff->h : 0;
            $application->minutes = $diff->invert ? $diff->i : 0;
        } else {
            $application->days = 0;
            $application->hours = 0;
            $application->minutes = 0;
        }

        $applicationStatus = ApplicationStatus::all();
        $englishTests = json_decode($applicant->english_proficiency, true) ?? [];
        $academicQualifications = json_decode($applicant->academic_qualifications, true) ?? [];

        return view('lawyer.application.lawyer-edit-application', compact(
            'application',
            'job',
            'applicant',
            'applicationStatus',
            'englishTests',
            'academicQualifications'
        ));
    }

    public function lawyerUpdateApplication(Request $request, $id)
    {
        $request->validate([
            'applicant_id'      => 'required|exists:applicants,id',
            'job_id'            => 'required|exists:company_jobs,id',
            'name'              => 'required|string|max:50',
            'phone'             => 'required',
            'email'             => 'required|email',
            'dob'               => 'required|date',
            'passport_no'       => 'required|string',
            'permanent_address' => 'required|string',
            'gender'            => 'required',
            'going_year'        => 'required',
            'days'              => 'required|integer|min:0',
            'hours'             => 'required|integer|min:0|max:23',
            'minutes'           => 'required|integer|min:0|max:59',
        ]);

        DB::beginTransaction();

        try {
            // Find existing applicant
            $applicantInfo = Applicant::find($request->applicant_id);

            if (!$applicantInfo) {
                Alert::error('Error', 'Applicant not found.');
                return redirect()->back();
            }

            //Update Student Info
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

            //Update English Proficiency
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
                        'filename'     => $filenames[$key],
                        'filepath'     => $filePath,
                    ]);
                }
            }

            $expiresAt = now()
                ->addDays((int)$request->days)
                ->addHours((int)$request->hours)
                ->addMinutes((int)$request->minutes);

            $updateApplication               = Application::findOrFail($id);
            $updateApplication->applicant_id = $applicantInfo->id;
            $updateApplication->job_id       = $request->input('job_id');
            $updateApplication->status       = $request->input('status') ?? 'In Progress';
            $updateApplication->going_year   = $request->input('going_year');
            $updateApplication->expires_at   = $expiresAt;

            $updateApplication->save();
            DB::commit();
            Alert::success('Success', 'Application update successfully applicant.');
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e);
            Alert::error('Error', 'Failed to update application, Try Again.');
            return redirect()->back()->withInput();
        }
    }
}
