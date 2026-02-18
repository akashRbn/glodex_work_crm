<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function signIn()
    {
        return view('auth.sign-in');
    }

    // Funtion to use case for login different user
    protected function redirectToDashboard($userType)
    {
        switch ($userType) {
            case 1: // Admin
                Alert::success('Success', 'Admin login successful');
                return redirect()->route('admin_home_page');

            case 2: // Agent
                Alert::success('Success', 'Agent login successful');
                return redirect()->route('agent_home_page');

            case 3: // Applicant
                Alert::success('Success', 'Applicant login successful');
                return redirect()->route('student_dashboard');

            case 4: // Lawyer
                Alert::success('Success', 'Lawyer login successful');
                return redirect()->route('student_dashboard');

            default:
                return redirect()->route('sign_in')
                    ->with('error', 'User type not recognized');
        }
    }

    // Function to handle login request
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'email'    => 'required|email',
                'password' => 'required',
            ]);

            $credentials = $request->only('email', 'password');

            try {
                if (!Auth::attempt($credentials)) {
                    return redirect()->back()->with('error', 'Invalid email or password.');
                }

                $user = Auth::user();

                // Check user status for agent/student
                if (in_array($user->user_type, [2, 3, 4]) && $user->user_status == 1) {
                    Auth::logout();
                    Alert::error('Error', 'Your registration is currently pending approval from the admin.');
                    return redirect()->back();
                }

                // Valid user, regenerate session and redirect
                $request->session()->regenerate();
                return $this->redirectToDashboard($user->user_type);

            } catch (Exception $e) {
                Log::error('Login error: ' . $e->getMessage());
                return redirect()->back()->with('error', 'An error occurred. Please try again.');
            }
        }

        return view('auth.sign-in');
    }

    // function to show sign-up form 
    public function signUp()
    {
        return view('auth.sign-up');
    }

    // Funttion to save sign-up user
    public function saveSignup(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',  
            'email'     => 'required|email',
            'phone'     => 'required|string|max:20',
            'user_type' => 'required|in:2,3,4', // Only allow 'Agent' (2), 'Student' (3), and 'Lawyer' (4)
            'password'  => 'required|string|min:8',
        ]);

        $existingUser = User::where('phone', $request->phone)
            ->orWhere('email', $request->email)
            ->first();

        if ($existingUser) {
            // Alert::error('Error', 'A user with this phone number or email already exists.');
            return redirect()->back()->withInput();
        }

        // $request->user_type == 2 ? 'Agent' : 'Applicant';

        DB::beginTransaction();

        try {
            $fullName = $request->first_name . ' ' . $request->last_name;
            $user = User::create([
                'name'              => $fullName,
                'email'             => $request->email,
                'phone'             => $request->phone,
                'user_type'         => $request->user_type,
                'organization_name' => $request->organization_name,
                'password'          => Hash::make($request->password),
                'created_by'        => null,
            ]);
            $user->created_by = $user->id;
            $user->save();
              
            DB::commit();
            Alert::success('Success', 'Thanks for registration. Please wait for admin approval.');
            return redirect()->route('sign_in');

        } catch (\Exception $e) {

            DB::rollBack();
            // dd($e);
            Alert::error('Error', 'Registration failed. Please try again.');
            return redirect()->back();
        }
    }

    // Function to logout user
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('sign_in');
    }

    // Function to delete user
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            Alert::success('Success', 'User deleted successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to delete user');
            return redirect()->back();
        }
    }
}
