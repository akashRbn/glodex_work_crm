<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Admin\Application;
use App\Models\Admin\Course;
use App\Models\Admin\StudentFile;
use App\Models\Admin\StudentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class StudentApplicationController extends Controller
{
    
    public function studentApplicationList()
    {
         $user = Auth::user();

         $applications = Application::with([
            'student',
            'course.country',
            'course.university',
            'applicationStatus'
        ])
        ->whereHas('student', function ($q) use ($user) {
            // Match application to logged-in student only
            $q->where('user_id', $user->id)
              ->orWhere('email', $user->email);
        })
        ->orderBy('id', 'desc')
        ->get();
        return view('student.application.student-application-list', compact('applications'));
    }
    
    public function studentApplicationEixRecord($course_id, $student_id)
    {
        $applicationExists = Application::where('course_id', $course_id)
        ->where('student_id', $student_id)
        ->exists();

        if ($applicationExists) {
            Alert::error('Error', 'In this course the application in progress');
            return redirect()->back();
        }

        $course   = Course::find($course_id);
        $student  = StudentInfo::find($student_id);
        $englishTests = json_decode($student->english_proficiency, true) ?? [];
        $academicQualifications = json_decode($student->academic_qualifications, true) ?? [];
        return view('student.application.student-application-existing-record',compact('course','student','englishTests','academicQualifications'));
    }

    public function saveStudentApplicationEixRecord(Request $request)
    {
        $request->validate([
            'student_id'        => 'required|exists:student_infos,id',
            'course_id'         => 'required|exists:courses,id',
            'name'              => 'required|string|max:50',
            'phone'             => 'required',
            'email'             => 'required|email',
            'dob'               => 'required|date',
            'passport_no'       => 'required|string',
            'permanent_address' => 'required|string',
            'gender'            => 'required',
            'intake_year'       => 'required',
        ]);

        DB::beginTransaction();

        try {
            // Find existing student
            $studentInfo = StudentInfo::find($request->student_id);

            if (!$studentInfo) {
                Alert::error('Error', 'Student not found.');
                return redirect()->back();
            }

            //Update Student Info
            $studentInfo->update([
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
                $studentInfo->english_proficiency = json_encode($englishTests);
                $studentInfo->save();
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
                $studentInfo->academic_qualifications = json_encode($academicQualifications);
                $studentInfo->save();
            }

            //Upload Student Files (if any new files)
            if ($request->hasFile('studentfiles')) {
                $studentFiles = $request->file('studentfiles');
                $filenames = $request->input('filename');

                foreach ($studentFiles as $key => $single) {
                    $originalFileName = $single->getClientOriginalName();
                    $newFileName = Carbon::now()->timestamp . '_' . $studentInfo->name . '_' . $originalFileName;
                    $filePath = $single->storeAs($filenames[$key], $newFileName, 'public');

                    StudentFile::create([
                        'student_id' => $studentInfo->id,
                        'filename'   => $filenames[$key],
                        'filepath'   => $filePath,
                    ]);
                }
            }

            //Create Application for this student
            Application::create([
                'user_id'     => Auth::id(),
                'course_id'   => $request->course_id,
                'student_id'  => $studentInfo->id,
                'sent_by'     => Auth::user()->organization_name ?? 'N/A',
                'application_code' => rand(100000, 999999),
                'created_by'  => Auth::id(),
                'intake_year' => $request->intake_year,
            ]);

            DB::commit();

            Alert::success('Success', 'Application added successfully for existing student.');
            return redirect()->route('student_application_list');

        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            Alert::error('Error', 'Failed to add application, Try Again.');
            return redirect()->back()->withInput();
        }
    }
}
