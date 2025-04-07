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


    public function allPatient(Request $request)
    {
        if ($request->ajax()) {
            $start = $request->input('start');
            $length = $request->input('length');
            $searchValue = $request->input('search.value');

            $query = Patient::with('user')->orderBy('userID', 'desc'); // Sort by id in descending order;

            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('dob', 'like', "%{$searchValue}%") // ✅ Search by DOB
                      ->orWhere('mobile', 'like', "%{$searchValue}%")
                      ->orWhere('address', 'like', "%{$searchValue}%")
                      ->orWhereHas('user', function ($subQuery) use ($searchValue) {
                          $subQuery->where('name', 'like', "%{$searchValue}%")
                                   ->orWhere('email', 'like', "%{$searchValue}%");
                      });
                });
            }

            $totalRecords = Patient::count();
            $filteredRecords = $query->count();
            $patients = $query->offset($start)->limit($length)->get();

            $data = $patients->map(function ($patient) {
                return [
                    'id' => optional($patient->user)->id ?? 'N/A',
                    'name' => optional($patient->user)->name ?? 'N/A',
                    'dob' => $patient->dob,
                    'gender' => $patient->gender === 'M' ? 'Male' : ($patient->gender === 'F' ? 'Female' : 'Other'),
                    'mobile' => $patient->mobile,
                    'email' => optional($patient->user)->email ?? 'N/A',
                    'address' => $patient->address,
                    'actions' => '
                                                <a class="btn btn-warning" type="button" data-toggle="modal" data-target="#branchEditModal-{{$TestData->tid}}" >
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                            <a class="btn btn-danger" type="button" data-toggle="modal" data-target="#branchDeleteModal-{{$TestData->tid}}"  >
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>'
                ];
            });

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data
            ]);
        }

        return view('Users.Admin.Patients.allPatients');
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
