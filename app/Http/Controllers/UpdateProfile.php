<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\UserRequest;



class UpdateProfile extends Controller
{


    //Patient
    public function CustomerViewUpdateProfile(Request $request)
    {

        $client = Auth::user();

        return view('Users.User.Profile.myProfile',compact('client'));
    }

public function CustomerUpdateProfile(Request $request)
{
    // Initial validation with custom messages
    $this->validate($request, [
        'name' => ['required', 'string', 'max:255'],
        'current_password' => 'required|string'
    ], [
        // Custom messages for initial validation
        'name.required' => 'Name is required.',
        'name.string' => 'Name must be valid text.',
        'name.max' => 'Name cannot exceed 255 characters.',
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
        $this->validate($request, [
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
    $user->save();

    return back()->with('message', 'Profile updated successfully!');
}


    //Doctor
    public function DoctorViewUpdateProfile(Request $request)
    {
        $client = Auth::user();

        return view('Users.Doctor.Profile.myProfile',compact('client'));
    }

    public function DoctorUpdateProfile(Request $request)
    {

        $this->validate($request, [

            'name' => ['required', 'string', 'max:255'],
            'email' => ['string', 'email', 'max:255'],
            'current_password' => 'required|string'

        ]);
        $auth = Auth::user();
        $user =  User::find($auth->id);

        $newPWD = $request->new_password;
        if ($newPWD !=''){
            $this->validate($request, [
                'new_password' => 'confirmed|min:8|string'

            ]);

        $user->password = Hash::make($request->new_password);
        }


        // The passwords matches
        if (!Hash::check($request->get('current_password'), $auth->password))
        {
            return back()->with('error', "Current Password is Invalid");
        }

        // Current password and new password same
        if (strcmp($request->get('current_password'), $request->new_password) == 0)
        {
            return redirect()->back()->with("error", "New Password cannot be same as your current password.");
        }

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();
        return back()->with('message','successful');
    }
}
