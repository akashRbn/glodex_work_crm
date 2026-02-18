<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Applicant;
use App\Models\Admin\ApplicantFile;
use App\Models\Admin\Application;
use App\Models\Admin\ApplicationStatus;
use App\Models\Admin\CompanyJob;
use App\Models\Admin\Course;
use App\Models\Admin\StudentFile;
use App\Models\Admin\StudentInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ApplicationController extends Controller
{
    public function myApplicationList()
    {
        $applications = Application::with([
                'applicant',
                'job.country',
                'job.company',
                'applicationStatus'
            ])
            ->whereHas('createdBy', function ($query) {
                $query->whereIn('user_type', [1, 3]);
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.application.my-application-list', compact('applications'));
    }


    // function to show application list for agent
   public function applicationListAgent()
    {
        $authUser = auth()->user();

        $applications = Application::with(['applicant','job.country','job.company','applicationStatus','createdBy'])
            ->whereHas('createdBy', function ($q) use ($authUser) {
                $q->where('user_type', 2); // only Agent applications

                // If BDM → only agents created by this BDM
                if ($authUser->hasRole('BDM')) {
                    $q->where('created_by', $authUser->id);
                }
            })
            // SuperAdmin → no extra filter
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.application.application-list-agent', compact('applications'));
    }

    // function to show all application list
    public function allApplication()
    {
        $authUser = auth()->user();

        $applications = Application::with(['job', 'job.country', 'job.company', 'applicationStatus', 'createdBy'
            ])->when($authUser->hasRole('BDM'), function ($query) use ($authUser) {
                // BDM only applications submitted by agents created by user
                $query->whereHas('createdBy', function ($q) use ($authUser) {
                    $q->where('user_type', 2)  // Only agents
                    ->where('created_by', $authUser->id); // Agent created by this BDM
                });
            })
            // SuperAdmin no filter (sees all)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.application.all-application', compact('applications'));
    }

    // function to add application for new applicant
    public function addApplicationNewApplicant($job_id)
    {
        $job                = CompanyJob::find($job_id);
        $applicationStatus  = ApplicationStatus::all();
        return view('admin.application.add-application-new-applicant', compact('job','applicationStatus'));
    }

    // function to save application for new applicant
    public function saveApplicationNewApplicant(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:50',
            'phone'       => 'required',
            'email'       => 'required|email',
            'dob'         => 'required|date',
            'passport_no' => 'required|string',
            'permanent_address' => 'required|string',
            'gender'      => 'required',
            'going_year'  => 'required',
            'days'    => 'required|integer|min:0',
            'hours'   => 'required|integer|min:0|max:23',
            'seconds' => 'required|integer|min:0|max:59',
            'job_id'  => 'required|exists:company_jobs,id',
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

            $job = CompanyJob::lockForUpdate()->find($request->job_id);

            if (!$job || $job->avilable_positions <= 0) {
                throw new \Exception('No available positions left for this job.');
            }

            // Decrease available position
            $job->decrement('avilable_positions');

            // Create User
            $user = User::create([
                'name'       => $request->name,
                'phone'      => $request->phone,
                'email'      => $request->email,
                'password'   => Hash::make('applicant1234'),
                'created_by' => Auth::id(),
                'user_type'  => 3,
            ]);

            // Create Applicant
            $applicantInfo = new Applicant();
            $applicantInfo->user_id = $user->id;
            $applicantInfo->sent_by = 'Glodex';
            $applicantInfo->name = $request->name;
            $applicantInfo->applicant_code = 'GLD' . rand(1000000, 9999999);
            $applicantInfo->phone = $request->phone;
            $applicantInfo->email = $request->email;
            $applicantInfo->permanent_address = $request->permanent_address;
            $applicantInfo->gender = $request->gender;
            $applicantInfo->fathers_name = $request->fathers_name;
            $applicantInfo->mothers_name = $request->mothers_name;
            $applicantInfo->dob = $request->dob;
            $applicantInfo->passport_no = $request->passport_no;
            $applicantInfo->moi = $request->moi;
            $applicantInfo->notes = $request->notes;
            $applicantInfo->created_by = Auth::id();

            // English Tests
            if ($request->has('english_tests')) {
                $tests = [];
                foreach ($request->english_tests as $test) {
                    $tests[] = [
                        'type' => $test['type'] ?? null,
                        'listening' => $test['listening'] ?? null,
                        'reading' => $test['reading'] ?? null,
                        'writing' => $test['writing'] ?? null,
                        'speaking' => $test['speaking'] ?? null,
                        'overall' => $test['overall'] ?? null,
                    ];
                }
                $applicantInfo->english_proficiency = json_encode($tests);
            }

            // Academic
            if ($request->has('academic_qualifications')) {
                $academic = [];
                foreach ($request->academic_qualifications as $q) {
                    $academic[] = [
                        'group_name' => $q['group_name'] ?? null,
                        'institute_name' => $q['institute_name'] ?? null,
                        'gpa' => $q['gpa'] ?? null,
                        'passing_year' => $q['passing_year'] ?? null,
                    ];
                }
                $applicantInfo->academic_qualifications = json_encode($academic);
            }

            $applicantInfo->save();

            // Files
            if ($request->hasFile('applicantfiles')) {
                foreach ($request->file('applicantfiles') as $key => $file) {
                    $newName = time().'_'.$file->getClientOriginalName();
                    $path = $file->storeAs('applicants', $newName, 'public');

                    ApplicantFile::create([
                        'applicant_id' => $applicantInfo->id,
                        'filename' => 'applicants',
                        'filepath' => $path,
                    ]);
                }
            }

            // Expiry time
            $expiresAt = now()
                ->addDays((int)$request->days)
                ->addHours((int)$request->hours)
                ->addSeconds((int)$request->seconds);

            // Save Application
            Application::create([
                'user_id' => Auth::id(),
                'job_id' => $job->id,
                'applicant_id' => $applicantInfo->id,
                'sent_by' => 'Glodex',
                'application_code' => rand(100000, 999999),
                'status' => $request->status,
                'created_by' => Auth::id(),
                'going_year' => $request->going_year,
                'expires_at' => $expiresAt,
            ]);

            DB::commit();
            Alert::success('Success', 'Application added & job position updated!');
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    
    // Function to show exsiting application list
    public function addApplicationEixApplicant($job_id, $applicant_id)
    {
        // Find job & applicant
        $job = CompanyJob::find($job_id);
        $applicant = Applicant::find($applicant_id);

        // If either is missing, redirect back safely
        if (!$job || !$applicant) {
            Alert::error('Error', 'Job or Applicant not found');
            return redirect()->back();
        }

        // Check if application already exists
        $applicationExists = Application::where('job_id', $job_id)
            ->where('applicant_id', $applicant_id)
            ->exists();

        if ($applicationExists) {
            Alert::error('Error', 'This applicant already has an application for this job');
            return redirect()->back();
        }

        $applicationStatus      = ApplicationStatus::all();
        $englishTests           = json_decode($applicant->english_proficiency, true) ?? [];
        $academicQualifications = json_decode($applicant->academic_qualifications, true) ?? [];

        return view('admin.application.add-application-existing-applicant', compact(
            'job',
            'applicant',
            'applicationStatus',
            'englishTests',
            'academicQualifications'
        ));
    }


    // function to save application for existing student
    public function saveApplicationEixApplicant(Request $request)
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
            'days'    => 'required|integer|min:0',
            'hours'   => 'required|integer|min:0|max:23',
            'seconds' => 'required|integer|min:0|max:59',
            'job_id'  => 'required|exists:company_jobs,id',
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

            $expiresAt = now()
                ->addDays((int)$request->days)
                ->addHours((int)$request->hours)
                ->addSeconds((int)$request->seconds);

            //Create Application for this applicant
            Application::create([
                'user_id' => Auth::id(),
                'job_id' => $job->id,
                'applicant_id' => $applicantInfo->id,
                'sent_by' => 'Glodex',
                'application_code' => rand(100000, 999999),
                'status' => $request->status,
                'created_by' => Auth::id(),
                'going_year' => $request->going_year,
                'expires_at' => $expiresAt,
            ]);

            DB::commit();

            Alert::success('Success', 'Application added successfully for existing applicant.');
            return redirect()->route('my_application_list');

        } catch (\Exception $e) {
            // DB::rollBack();
            dd($e->getMessage());
            Alert::error('Error', 'Failed to add application, Try Again.');
            return redirect()->back()->withInput();
        }
    }

    // Function to edit application
    public function editApplication($id, $job_id, $applicant_id)
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

        return view('admin.application.edit-application', compact(
            'application',
            'job',
            'applicant',
            'applicationStatus',
            'englishTests',
            'academicQualifications'
        ));
    }


    // function to update application
    public function updateApplication(Request $request, $id)
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
            dd($e);
            Alert::error('Error', 'Failed to update application, Try Again.');
            return redirect()->back()->withInput();
        }
    }
}
