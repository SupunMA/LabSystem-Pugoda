<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Patient;
use App\Models\Test;

use Carbon\Carbon;
use Illuminate\Validation\Rule;



class admin_PatientCtr extends Controller
{
    
   
 //Authenticate all Admin routes
    public function __construct()
    {
        $this->middleware('checkAdmin');
       // $this->task = new branches;
    }


    //Patient

    public function addPatient()
    {
       
        
        return view('Users.Admin.Patients.addPatient');
    }

    public function allPatient()
    {
        //$clients=User::where('role',0)->get();

        $usersWithPatients = Patient::with('user')->get();
        

        //->join('table1','table1.id','=','table3.id');
        //dd($usersWithPatients);
        return view('Users.Admin.Patients.allPatients',compact('usersWithPatients'));
    }
    
    public function deletePatient($userID)
    {
        //Delete patient data from user,patient,test tables
        $patient = Patient::where('userID', $userID)->first();
        $testPatient = Test::where('pid', $patient->pid)->delete();
        $userPatient = User::find($userID);

        
        $userPatient->delete();
        $patient->delete();
       
        
        return redirect()->back()->with('message','Deleted Successfully');
    }

    public function updatePatient(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'in:M,F,O'],
            'dob' => ['required', 'string', 'date','before:-1 years'],
            'mobile' =>['string',Rule::unique('patients', 'mobile')->ignore($request->pid, 'pid')],
            'address' =>['string']
        ]);
        //change the date format
        $formattedDate = Carbon::createFromFormat('m/d/Y', $request->dob)->format('Y-m-d');

        Patient::where('pid', $request->pid)
        ->update([
                    'mobile' => $request->mobile,
                    'address' => $request->address,
                    'gender'=> $request->gender,
                    'dob'=> $formattedDate
                    
                ]);

        User::where('id', $request->id)
        ->update([
                    'name' => $request->name,
                    
                ]);

        return redirect()->back()->with('message','Updated Successfully!');

    }


    
}