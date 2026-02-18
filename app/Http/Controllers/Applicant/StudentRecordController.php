<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Admin\StudentFile;
use App\Models\Admin\StudentInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class StudentRecordController extends Controller
{
    // function to show my record list
    public function myRecordList()
    {
        $user = Auth::user();

        if ($user->user_type == 3) {
            // Student: show only records linked to them
            $students = StudentInfo::where('user_id', $user->id) // self-created
                ->orWhere(function($query) use ($user) {
                    // OR created by Admin/Agent for this student (match by email)
                    $query->where('email', $user->email)
                        ->whereHas('createdBy', function($q) {
                            $q->whereIn('user_type', [1, 2]);
                        });
                })
                ->get();
        } else {
            // Admin/Agent: show all students created by Admin/Agent
            $students = StudentInfo::whereHas('createdBy', function($q) {
                $q->whereIn('user_type', [1, 2]);
            })->get();
        }

        return view('student.record.my-record-list', compact('students'));
    }





    public function editMyRecord()
    {
        // Get student profile if exists
        $student = StudentInfo::where('user_id', auth()->id())->first();

        // Default empty arrays (for new profile)
        $englishTests = [];
        $academicQualifications = [];

        // If profile exists, decode data
        if ($student) {
            $englishTests = json_decode($student->english_proficiency, true) ?? [];
            $academicQualifications = json_decode($student->academic_qualifications, true) ?? [];
        }

        return view('student.record.edit-my-record', compact(
            'student',
            'englishTests',
            'academicQualifications'
        ));
    }


    public function updateMyRecord(Request $request, $id = null)
    {
        $request->validate([
            'name'              => 'required|string|max:50',
            'phone'             => 'required',
            'email'             => 'required',
            'dob'               => 'required',
            'passport_no'       => 'required',
            'permanent_address' => 'required',
            'gender'            => 'required',
        ]);

        DB::beginTransaction();
        try {

            // Find existing record or create a new instance
            $studentInfo = $id ? StudentInfo::find($id) : null;
            if (!$studentInfo) {
                $studentInfo = new StudentInfo();
            }

            // Fill data
            $studentInfo->name              = $request->name;
            $studentInfo->phone             = $request->phone;
            $studentInfo->email             = $request->email;
            $studentInfo->student_code      =  'GLD' . rand(1000000, 9999999);
            $studentInfo->permanent_address = $request->permanent_address;
            $studentInfo->gender            = $request->gender;
            $studentInfo->fathers_name      = $request->fathers_name;
            $studentInfo->mothers_name      = $request->mothers_name;
            $studentInfo->dob               = $request->dob;
            $studentInfo->passport_no       = $request->passport_no;
            $studentInfo->moi               = $request->moi;
            $studentInfo->notes             = $request->notes;
            $studentInfo->created_by        = Auth::id();
            $studentInfo->user_id           = Auth::id();

            // English Proficiency
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
            }

            // Academic Qualifications
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
            }

            $studentInfo->save();

            // Student Files
            if ($request->hasFile('studentfiles')) {
                $studentFiles = $request->file('studentfiles');
                $filenames = $request->input('filename');

                foreach ($studentFiles as $key => $single) {
                    $filename = $filenames[$key];
                    $originalFileName = $single->getClientOriginalName();
                    $originalFileName2 = Carbon::now()->timestamp . $studentInfo->name . $originalFileName;
                    $filePath = $single->storeAs($filename, $originalFileName2, 'public');

                    // Update existing file or create new
                    StudentFile::updateOrCreate(
                        [
                            'student_id' => $studentInfo->id,
                            'filename'   => $filename
                        ],
                        [
                            'filepath'   => $filePath
                        ]
                    );
                }
            }

            DB::commit();
            Alert::success('Success', $id ? 'Record updated successfully' : 'Record created successfully');
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e);
            Alert::error('Error', 'Something went wrong: ');
            return redirect()->back();
        }
    }


}
