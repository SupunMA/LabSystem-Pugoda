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
            $orderColumn = $request->input('order.0.column');  // Column index
            $orderDirection = $request->input('order.0.dir');  // Direction (asc/desc)

            $columns = ['userID', 'users.name', 'dob', 'gender', 'mobile', 'users.email', 'address']; // Add columns for sorting

            // Start the query and join the user table
            $query = Patient::with('user')->join('users', 'patients.userID', '=', 'users.id');

            // Apply search filter
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('dob', 'like', "%{$searchValue}%")
                      ->orWhere('mobile', 'like', "%{$searchValue}%")
                      ->orWhere('address', 'like', "%{$searchValue}%")
                      ->orWhere('users.name', 'like', "%{$searchValue}%")
                      ->orWhere('users.email', 'like', "%{$searchValue}%");
                });
            }

            // Apply sorting
            if (isset($orderColumn) && isset($columns[$orderColumn])) {
                $query->orderBy($columns[$orderColumn], $orderDirection);
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
                                <button
                                    class="btn btn-warning editBtn"
                                    data-id="' . $patient->userID . '"
                                    data-pid="' . $patient->pid . '"
                                    data-name="' . e(optional($patient->user)->name) . '"
                                    data-dob="' . e($patient->dob) . '"
                                    data-gender="' . e($patient->gender) . '"
                                    data-mobile="' . e($patient->mobile) . '"
                                    data-email="' . e(optional($patient->user)->email) . '"
                                    data-address="' . e($patient->address) . '">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button
                                    class="btn btn-danger deleteBtn"
                                    data-id="' . $patient->userID . '">
                                    <i class="fa fa-trash"></i>
                                </button>'
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




    public function deletePatient(Request $request)
    {
        try {
            $patient = Patient::where('userID', $request->pid)->first();

            if (!$patient) {
                return response()->json(['error' => 'Patient not found'], 404);
            }

            // Delete tests related to patient
            Test::where('pid', $patient->pid)->delete();

            // Delete user
            $user = User::find($request->pid);
            if ($user) {
                $user->delete();
            }

            // Delete patient
            $patient->delete();

            return response()->json(['success' => true, 'message' => 'Deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    public function updatePatient(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'in:M,F,O'],
            'dob' => ['required', 'string', 'date','before:-1 years'],
            'mobile' => ['string', Rule::unique('patients', 'mobile')->ignore($request->pid, 'pid')],
            'address' => ['string']
        ]);

        try {
            Patient::where('pid', $request->pid)
                ->update([
                    'mobile' => $request->mobile,
                    'address' => $request->address,
                    'gender' => $request->gender,
                    'dob' => $request->dob
                ]);

            User::where('id', $request->userID)
                ->update([
                    'name' => $request->name
                ]);

            return response()->json(['success' => true, 'message' => 'Patient updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Update failed!'], 500);
        }
    }



}
