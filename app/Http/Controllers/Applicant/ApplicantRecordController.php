<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Admin\Applicant;
use App\Models\Admin\ApplicantFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ApplicantRecordController extends Controller
{
    public function myRecordList()
    {
        $user = Auth::user();

        if ($user->user_type == 3) {
            // applicant: show only records linked to them
            $applicants = Applicant::where('user_id', $user->id) // self-created
                ->orWhere(function($query) use ($user) {
                    // OR created by Admin/Agent for this student (match by email)
                    $query->where('email', $user->email)
                        ->whereHas('createdBy', function($q) {
                            $q->whereIn('user_type', [1, 2]);
                        });
                })
                ->get();
        } else {
            // Admin/Agent: show all applicants created by Admin/Agent
            $applicants = Applicant::whereHas('createdBy', function($q) {
                $q->whereIn('user_type', [1, 2]);
            })->get();
        }

        return view('applicant.record.my-record-list', compact('applicants'));
    } 

    
    public function editMyRecord()
    {
        // Get applicant profile if exists
        $applicant = Applicant::where('user_id', auth()->id())->first();

        // Default empty arrays (for new profile)
        $englishTests = [];
        $academicQualifications = [];

        // If profile exists, decode data
        if ($applicant) {
            $englishTests = json_decode($applicant->english_proficiency, true) ?? [];
            $academicQualifications = json_decode($applicant->academic_qualifications, true) ?? [];
        }

        return view('applicant.record.edit-my-record', compact(
            'applicant',
            'englishTests',
            'academicQualifications'
        ));
    }

    // Other methods like updateMyRecord can be added here
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
            $applicantInfo = $id ? Applicant::find($id) : null;
            if (!$applicantInfo) {
                $applicantInfo = new Applicant();
            }

            // Fill data
            $applicantInfo->name              = $request->name;
            $applicantInfo->phone             = $request->phone;
            $applicantInfo->email             = $request->email;
            $applicantInfo->applicant_code    =  'GLD' . rand(1000000, 9999999);
            $applicantInfo->permanent_address = $request->permanent_address;
            $applicantInfo->gender            = $request->gender;
            $applicantInfo->fathers_name      = $request->fathers_name;
            $applicantInfo->mothers_name      = $request->mothers_name;
            $applicantInfo->dob               = $request->dob;
            $applicantInfo->passport_no       = $request->passport_no;
            $applicantInfo->moi               = $request->moi;
            $applicantInfo->notes             = $request->notes;
            $applicantInfo->created_by        = Auth::id();
            $applicantInfo->user_id           = Auth::id();

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
                $applicantInfo->english_proficiency = json_encode($englishTests);
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
                $applicantInfo->academic_qualifications = json_encode($academicQualifications);
            }

            $applicantInfo->save();

            // Applicant Files
            if ($request->hasFile('studentfiles')) {
                $applicantFiles = $request->file('studentfiles');
                $filenames = $request->input('filename');

                foreach ($applicantFiles as $key => $single) {
                    $filename = $filenames[$key];
                    $originalFileName = $single->getClientOriginalName();
                    $originalFileName2 = Carbon::now()->timestamp . $applicantInfo->name . $originalFileName;
                    $filePath = $single->storeAs($filename, $originalFileName2, 'public');

                    // Update existing file or create new
                    ApplicantFile::updateOrCreate(
                        [
                            'applicant_id' => $applicantInfo->id,
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
            dd($e);
            Alert::error('Error', 'Something went wrong: ');
            return redirect()->back();
        }
    }
}
