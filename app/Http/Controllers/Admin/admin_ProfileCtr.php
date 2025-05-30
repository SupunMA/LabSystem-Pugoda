<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Validation\Rule;

class admin_ProfileCtr extends Controller
{


 //Authenticate all Admin routes
    public function __construct()
    {
        $this->middleware('checkAdmin');
       // $this->task = new branches;
    }


    public function AdminViewUpdateProfile(Request $request)
    {
        $client = Auth::user();
        return view('Users.Admin.Profile.myProfile',compact('client'));
    }

    public function updateAdmin(Request $request)
    {
        // Initial validation with custom messages
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nic' => [
                'required',
                'regex:/^(\d{9}[Vv]|\d{12})$/',
                Rule::unique('users', 'nic')->ignore($request->id, 'id'),
                'max:15'
            ],
            'email' => ['string', 'email', 'max:255'],
            'current_password' => 'required|string',
        ], [
            // Custom messages for initial validation
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a valid text.',
            'name.max' => 'Name cannot exceed 255 characters.',

            'nic.required' => 'NIC is required.',
            'nic.regex' => 'NIC format is invalid. Please enter a valid Sri Lankan NIC (9 digits + V/v or 12 digits).',
            'nic.unique' => 'This NIC is already registered with another user.',
            'nic.max' => 'NIC cannot exceed 15 characters.',

            'email.string' => 'Email must be a valid text.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email cannot exceed 255 characters.',

            'current_password.required' => 'Current password is required to update your profile.',
            'current_password.string' => 'Current password must be valid text.',
        ]);

        $auth = Auth::user();
        $user = User::find($auth->id);

        // Check current password first
        if (!Hash::check($request->get('current_password'), $auth->password)) {
            return back()->with('error', "Current password is incorrect. Please enter your correct current password.");
        }

        $newPWD = $request->new_password;

        // Validate new password if provided
        if ($newPWD != '') {
            $request->validate([
                'new_password' => 'confirmed|min:8|string'
            ], [
                // Custom messages for password validation
                'new_password.confirmed' => 'New password confirmation does not match.',
                'new_password.min' => 'New password must be at least 8 characters long.',
                'new_password.string' => 'New password must be valid text.',
            ]);

            // Check if new password is same as current password
            if (strcmp($request->get('current_password'), $request->new_password) == 0) {
                return back()->with('error', "New password cannot be the same as your current password. Please choose a different password.");
            }

            $user->password = Hash::make($request->new_password);
        }

        // Update user information
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nic = $request->nic;

        $user->save();

        return back()->with('message', 'Profile updated successfully!');
    }

    public function deleteAdmin($userID)
    {
        //dd($branchID);
        $delete = User::find($userID);
        $delete->delete();
        return redirect()->back()->with('message','Updated Successfully');
    }
}
