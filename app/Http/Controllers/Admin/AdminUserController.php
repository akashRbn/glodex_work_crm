<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminUserController extends Controller
{
    public function adminUserList()
    {
        $users = User::with('creator')
        ->where('user_type', 1)          
        ->orderBy('id', 'desc')
        ->get();
        return view('admin.admin-user.admin-user-list', compact('users'));
    }


    // Function to create new  admin User
    public function saveAdminUser(Request $request)
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
                'user_type'    => 1,
                'user_status'  => 2,
                'created_by'   => Auth::id(),
            ]);

            DB::commit();
            Alert::success('Success', 'User created successfully');
            return redirect()->route('admin_user_list');
        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();
            Alert::error('Error', 'Failed to add user. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    // Function to delete user
    public function deleteAdminUser($id)
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
