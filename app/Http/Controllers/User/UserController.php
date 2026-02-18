<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Handler\ImageHandlerController;
use App\Models\Admin\UserInfo;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    protected $imageHandler;

    // Functio to call image handler
    public function __construct(ImageHandlerController $imageHandler)
    {
        $this->imageHandler = $imageHandler;
    }

    public function userProfile($id)
    {
        $user = User::with('userInfo')->findOrFail($id);
        return view('user.user-profile', compact('user'));
    }

    // Admin change password view
    public function adminChangePassword()
    {
        $user  = auth()->user();
        return view('user.admin-change-password', compact('user'));
    }

    // Update admin password
    public function updateAdminPassword(Request $request)
    {
        $request->validate([
            'current_password'      => 'required|string',
            'new_password'          => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            Alert::error('Error', 'The current password does not match our records.');
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $user = auth()->user();
            $user->password = Hash::make($request->new_password);
            $user->save();

            DB::commit();

            Alert::success('Success', 'Password updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'An error occurred while updating the password. Please try again.');
            return redirect()->back();
        }
    }

    // Admin user profile view
    public function adminUserProfile()
    {
        $user  = auth()->user();
        return view('user.admin-user-profile', compact('user'));    
    }

    // Update admin profile
    public function updateAdminProfile(Request $request)
    {
        $request->validate([
            'name'                => 'required|string|max:255',
            'phone'               => 'required|string|max:20',
            'email'               => 'required|email|max:255',
            'dob'                 => 'required|date',
            'marital_status'      => 'required',
            'gender'              => 'required',
            'organization_name'   => 'required',
            'address'             => 'required',
            'company_description' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $user = auth()->user();
            $user->name                = $request->name;
            $user->phone               = $request->phone;
            $user->email               = $request->email;
            $user->dob                 = $request->dob;
            $user->marital_status      = $request->marital_status;
            $user->gender              = $request->gender;
            $user->organization_name   = $request->organization_name;
            $user->address             = $request->address;
            $user->company_description = $request->company_description;
            if ($request->hasFile('profile_photo')) {
                if ($user->profile_photo) {
                    $this->imageHandler->deleteImage($user->profile_photo);
                }
                $file = $request->file('profile_photo');
                $filePath = $this->imageHandler->profilePhoto($file, 'profile_photo');
                $user->profile_photo = $filePath;
            }

            if ($request->hasFile('company_logo')) {
                if ($user->company_logo) {
                    $this->imageHandler->deleteImage($user->company_logo);
                }
                $file = $request->file('company_logo');
                $filePath = $this->imageHandler->companyLogo($file, 'company_logo');
                $user->company_logo = $filePath;
            }

            if ($request->hasFile('favicon')) {
                if ($user->favicon) {
                    $this->imageHandler->deleteImage($user->favicon);
                }
                $file = $request->file('favicon');
                $filePath = $this->imageHandler->faviconPhoto($file, 'favicon');
                $user->favicon = $filePath;
            }

            // Save all updates
            $user->save();

            DB::commit();
            alert()->success('Success', 'Profile updated successfully!');
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            alert()->error('Error', 'Something went wrong: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // Agent change password view
    public function agentChangePassword()
    {
        $agentUser  = auth()->user();
        return view('user.agent-change-password', compact('agentUser'));
    }
    
    // Update agent password
    public function updateAgentPassword(Request $request)
    {
         $request->validate([
            'current_password'      => 'required|string',
            'new_password'          => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            Alert::error('Error', 'The current password does not match our records.');
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $user = auth()->user();
            $user->password = Hash::make($request->new_password);
            $user->save();

            DB::commit();

            Alert::success('Success', 'Password updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'An error occurred while updating the password. Please try again.');
            return redirect()->back();
        }
    }

    // Agent user profile view
    public function agentUserProfile()
    {
        $agentUser        = auth()->user();
        $agentUserProfile = $agentUser->userInfo;
        return view('user.agent-user-profile', compact('agentUser', 'agentUserProfile')); 
    }   

    // Update agent profile
    public function updateAgentProfile(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name'                => 'required|string|max:255',
            'phone'               => 'required|string|max:20',
            'email'               => 'required|email|max:255',
            'dob'                 => 'required|date',
            'marital_status'      => 'required',
            'gender'              => 'required',
            'organization_name'   => 'required',
            'address'             => 'required',
        ]);

        DB::beginTransaction();

        try {
            $user = auth()->user();
            $user->name                = $request->name;
            $user->phone               = $request->phone;
            $user->email               = $request->email;
            $user->dob                 = $request->dob;
            $user->marital_status      = $request->marital_status;
            $user->gender              = $request->gender;
            $user->organization_name   = $request->organization_name;
            $user->address             = $request->address;
            if ($request->hasFile('profile_photo')) {
                if ($user->profile_photo) {
                    $this->imageHandler->deleteImage($user->profile_photo);
                }
                $file = $request->file('profile_photo');
                $filePath = $this->imageHandler->profilePhoto($file, 'profile_photo');
                $user->profile_photo = $filePath;
            }

            if ($request->hasFile('company_logo')) {
                if ($user->company_logo) {
                    $this->imageHandler->deleteImage($user->company_logo);
                }
                $file = $request->file('company_logo');
                $filePath = $this->imageHandler->companyLogo($file, 'company_logo');
                $user->company_logo = $filePath;
            }

            if ($request->hasFile('favicon')) {
                if ($user->favicon) {
                    $this->imageHandler->deleteImage($user->favicon);
                }
                $file = $request->file('favicon');
                $filePath = $this->imageHandler->faviconPhoto($file, 'favicon');
                $user->favicon = $filePath;
            }
            $user->save();


            /*------------------------------------------
            | UPDATE USER_INFO TABLE
            -------------------------------------------*/
            $userInfo = $user->userInfo ?: new UserInfo();
            $userInfo->user_id = $user->id;
            $userInfo->poc                   = $request->poc;
            $userInfo->website_url           = $request->website_url;
            $userInfo->social_url            = $request->social_url;
            $userInfo->whatsapp_no           = $request->whatsapp_no;
            $userInfo->trade_license_number  = $request->trade_license_number;
            $userInfo->bank_account_name     = $request->bank_account_name;
            $userInfo->bank_name             = $request->bank_name;
            $userInfo->bank_account_number   = $request->bank_account_number;
            $userInfo->bank_address          = $request->bank_address;
            $userInfo->swift_code            = $request->swift_code;
            $userInfo->ifsc_code             = $request->ifsc_code;
            $userInfo->branch_name           = $request->branch_name;
            $userInfo->benificiary_number    = $request->benificiary_number;
            $userInfo->benificiary_address   = $request->benificiary_address;

            // TRADE LICENSE PDF
            if ($request->hasFile('trade_license_copy')) {

                if ($userInfo->trade_license_copy 
                    && Storage::disk('public')->exists($userInfo->trade_license_copy)) {
                    Storage::disk('public')->delete($userInfo->trade_license_copy);
                }

                $userInfo->trade_license_copy =
                    $request->file('trade_license_copy')
                            ->store('agent_files/trade_license', 'public');
            }

            // PASSPORT / NID PDF
            if ($request->hasFile('passport_nid_copy')) {

                if ($userInfo->passport_nid_copy 
                    && Storage::disk('public')->exists($userInfo->passport_nid_copy)) {
                    Storage::disk('public')->delete($userInfo->passport_nid_copy);
                }

                $userInfo->passport_nid_copy =
                    $request->file('passport_nid_copy')
                            ->store('agent_files/passport_nid', 'public');
            }

            $userInfo->save();
            DB::commit();
            alert()->success('Success', 'Profile updated successfully!');
            return redirect()->back();

        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();
            alert()->error('Error', 'Something went wrong: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    
    // student user profile view
    public function studentUserProfile()
    {
        $studentUser  = auth()->user();
        return view('user.student-user-profile', compact('studentUser')); 
    }
    
    public function updateStudentProfile(Request $request)
    {
        $request->validate([
            'name'                => 'required|string|max:255',
            'phone'               => 'required|string|max:20',
            'email'               => 'required|email|max:255',
            'dob'                 => 'required|date',
            'marital_status'      => 'required',
            'gender'              => 'required',
            'address'             => 'required',
        ]);

        DB::beginTransaction();

        try {
            $user = auth()->user();
            $user->name                = $request->name;
            $user->phone               = $request->phone;
            $user->email               = $request->email;
            $user->dob                 = $request->dob;
            $user->marital_status      = $request->marital_status;
            $user->gender              = $request->gender;
            $user->organization_name   = $request->organization_name;
            $user->address             = $request->address;
            $user->company_description = $request->company_description;
            if ($request->hasFile('profile_photo')) {
                if ($user->profile_photo) {
                    $this->imageHandler->deleteImage($user->profile_photo);
                }
                $file = $request->file('profile_photo');
                $filePath = $this->imageHandler->profilePhoto($file, 'profile_photo');
                $user->profile_photo = $filePath;
            }


            // Save all updates
            $user->save();

            DB::commit();
            alert()->success('Success', 'Profile updated successfully!');
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            alert()->error('Error', 'Something went wrong: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    // student change password view
    public function studentChangePassword()
    {
        $user  = auth()->user();
        return view('user.student-change-password', compact('user'));
    }

     // Update student password
    public function updateStudentPassword(Request $request)
    {
        $request->validate([
            'current_password'      => 'required|string',
            'new_password'          => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            Alert::error('Error', 'The current password does not match our records.');
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $user = auth()->user();
            $user->password = Hash::make($request->new_password);
            $user->save();

            DB::commit();

            Alert::success('Success', 'Password updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'An error occurred while updating the password. Please try again.');
            return redirect()->back();
        }
    }
}
