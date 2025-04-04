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