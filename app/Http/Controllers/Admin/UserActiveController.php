<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserActiveController extends Controller
{
    // Function to show pending agent users
    public function pendingAgentUser()
    {
        $authUser = auth()->user();
        $pendingAgentUsers = User::with('creator')
            ->where('user_type', 2)
            ->where('user_status', 1)
            ->when($authUser->hasRole('BDM'), function ($query) use ($authUser) {
                //BDM → only his created agents
                $query->where('created_by', $authUser->id);
            })
            // 🔹 SuperAdmin → no condition (sees all)
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($user) {
                $user->user_type_label = 'Agent';

                $user->created_by_name = $user->creator
                    ? $user->creator->name
                    : 'Self Registered';

                return $user;
            });

        return view('admin.user-active.pending-agent-user',compact('pendingAgentUsers'));
    }


    // Function to show pending student users
    public function pendingApplicantUser()
    {
        $authUser = auth()->user();

        $pendingStudentUsers = User::with(['creator', 'applicantInfo.createdBy'])
            ->where('user_type', 3) // Student
            ->where('user_status', 1)
            ->when($authUser->hasRole('BDM'), function ($query) use ($authUser) {
                // 🔹 BDM → students created by agents under this BDM
                $query->whereHas('applicantInfo.createdBy', function ($q) use ($authUser) {
                    $q->where('created_by', $authUser->id); // agent.created_by = BDM id
                });
            })
            // 🔹 SuperAdmin → sees all
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($user) {

                $user->user_type_label = 'Applicant';

                if (
                    $user->applicantInfo &&
                    $user->applicantInfo->createdBy
                ) {
                    // Agent name (or company if exists)
                    $user->created_by_name =
                        $user->applicantInfo->company_name
                        ?? $user->applicantInfo->createdBy->name;
                } else {
                    $user->created_by_name = 'Self Registered';
                }

                return $user;
            });

        return view('admin.user-active.pending-applicant-user',compact('pendingStudentUsers'));
    }


    
    // Function to show active agent users
    public function activeAgentUser()
    {
        $authUser = auth()->user();

        $activeAgentUsers = User::with('creator')
            ->where('user_type', 2)
            ->where('user_status', 2)
            ->when($authUser->hasRole('BDM'), function ($query) use ($authUser) {
                //BDM → only agents created by him
                $query->where('created_by', $authUser->id);
            })
            //SuperAdmin → sees all
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($user) {
                $user->user_type_label = 'Agent';

                $user->created_by_name = $user->creator
                    ? $user->creator->name
                    : 'Self Registered';

                return $user;
            });

        return view(
            'admin.user-active.active-agent-user',
            compact('activeAgentUsers')
        );
    }

    // Function to show pending lawyer users
    public function pendingLawyerUser()
    {
        $pendingLawyerUsers = User::with('creator')
            ->where('user_type', 4)
            ->where('user_status', 1)
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($user) {
                $user->user_type_label = 'Lawyer';
                $user->created_by_name = $user->creator
                    ? $user->creator->name
                    : 'Self Registered';

                return $user;
            });

        return view('admin.user-active.pending-lawyer-user',compact('pendingLawyerUsers'));
    }


    public function activeLawyerUser()
    {
        $activeLawyerUsers = User::with(['creator', 'companies.country'])
            ->where('user_type', 4)
            ->where('user_status', 2)
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($user) {
                $user->user_type_label = 'Lawyer';
                $user->created_by_name = $user->creator ? $user->creator->name : 'Self Registered';
                return $user;
            });

        return view('admin.user-active.active-lawyer-user', compact('activeLawyerUsers'));
    }


    
    // Function to update user status
    public function updateUserStatus($id)
    {
        $user = User::findOrFail($id);
        $user->user_status = $user->user_status == 1 ? 2 : 1;
        $user->save();

        Alert::success('Success', 'User status update Successfully');
        return redirect()->back();
    }

    // Function to create new  Agent User
    public function saveAgent(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'phone'        => 'required|string|unique:users,phone',
            'organization_name' => 'required|string|max:255',
            'password'     => 'required|string|min:8',
        ]);

        DB::beginTransaction();

        try {
            $existingUser = User::where('email', $request->email)
                ->orWhere('phone', $request->phone)
                ->first();

            if ($existingUser) {
                DB::rollBack();
                Alert::error('Error', 'Email or phone number already exists');
                return redirect()->back()->withInput();
            }

            User::create([
                'name'         => $request->name,
                'email'        => $request->email,
                'phone'        => $request->phone,
                'organization_name' => $request->organization_name,
                'password'     => Hash::make($request->password),
                'user_type'    => 2,
                'created_by'   => Auth::id(),
            ]);

            DB::commit();
            Alert::success('Success', 'Agent created successfully');
            return redirect()->route('pending_agent_user');
        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();
            Alert::error('Error', 'Failed to add agent. Please try again.');
            return redirect()->back()->withInput();
        }
    }
}
