<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Doctor;

use Carbon\Carbon;
use Illuminate\Validation\Rule;


class admin_DoctorCtr extends Controller
{
    
   
 //Authenticate all Admin routes
    public function __construct()
    {
        $this->middleware('checkAdmin');
       // $this->task = new branches;
    }


    //Client

    public function addDoctor()
    {
       
        
        return view('Users.Admin.Doctors.addDoctor');
    }

    public function allDoctor()
    {
        //$clients=User::where('role',0)->get();

        $usersWithDoctors = Doctor::with('user')->get();

        //->join('table1','table1.id','=','table3.id');
        //dd($usersWithDoctors);
        return view('Users.Admin.Doctors.allDoctors',compact('usersWithDoctors'));
    }
    
    public function deleteDoctor($userID)
    {
        //
        
        $patient = Doctor::where('userID', $userID)->first();
        //dd($patient);
        $delete = User::find($userID);
        $delete->delete();
        $patient->delete();
       
        
        return redirect()->back()->with('message','Deleted Successfully');
    }

    public function updateDoctor(Request $request)
    {
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'in:M,F,O'],
            'mobile' => ['string', Rule::unique('doctors', 'mobile')->ignore($request->did, 'did')],
            'clinicName' => ['required', 'string', 'max:255'],
            'clinicAddress' =>['string']
        ]);

        Doctor::where('did', $request->did)
        ->update([
                    'mobile' => $request->mobile,
                    'gender'=> $request->gender,
                    'clinicAddress' => $request->clinicAddress,
                    'clinicName'=> $request->clinicName
                    
                ]);

        User::where('id', $request->id)
        ->update([
                    'name' => $request->name,
                    
                ]);

        return redirect()->back()->with('message','Updated Successfully');

    }


    
}