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

            $columns = ['pid', 'users.name', 'users.nic','dob', 'gender', 'mobile', 'users.email', 'address', 'users.created_at']; // Add columns for sorting

            // Start the query and join the user table
            $query = Patient::with('user')->join('users', 'patients.userID', '=', 'users.id')->select('patients.*', 'users.created_at as user_created_at');

            // Apply search filter
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('dob', 'like', "%{$searchValue}%")
                      ->orWhere('mobile', 'like', "%{$searchValue}%")
                      ->orWhere('pid', 'like', "%{$searchValue}%")
                      ->orWhere('address', 'like', "%{$searchValue}%")
                      ->orWhere('users.name', 'like', "%{$searchValue}%")
                      ->orWhere('users.nic', 'like', "%{$searchValue}%")
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
                // Format the created date
                $createdDate = $patient->user_created_at 
                    ? \Carbon\Carbon::parse($patient->user_created_at)->format('Y-m-d H:i')
                    : 'N/A';
                
                // Calculate age from DOB
                $ageString = 'N/A';
                if ($patient->dob) {
                    try {
                        $birthDate = \Carbon\Carbon::parse($patient->dob);
                        $today = \Carbon\Carbon::now();
                        $diff = $today->diff($birthDate);
                        
                        $ageParts = [];
                        if ($diff->y > 0) {
                            $ageParts[] = $diff->y . ' year' . ($diff->y != 1 ? 's' : '');
                        }
                        if ($diff->m > 0) {
                            $ageParts[] = $diff->m . ' month' . ($diff->m != 1 ? 's' : '');
                        }
                        if ($diff->d > 0) {
                            $ageParts[] = $diff->d . ' day' . ($diff->d != 1 ? 's' : '');
                        }
                        
                        $ageString = implode(', ', $ageParts);
                    } catch (\Exception $e) {
                        $ageString = 'Invalid Date';
                    }
                }
                
                return [
                    'id' => $patient->pid,
                    'name' => optional($patient->user)->name ?? 'N/A',
                    'nic' => optional($patient->user)->nic ?? 'N/A',
                    'dob' => $patient->dob,
                    'age' => $ageString,
                    'gender' => $patient->gender === 'M' ? 'Male' : ($patient->gender === 'F' ? 'Female' : 'Other'),
                    'mobile' => $patient->mobile,
                    'email' => optional($patient->user)->email ?? 'N/A',
                    'address' => $patient->address ?? 'N/A',
                    'created_at' => $createdDate,
                    'actions' => '
                        <button
                            class="btn btn-warning editBtn"
                            data-id="' . $patient->userID . '"
                            data-pid="' . $patient->pid . '"
                            data-name="' . e(optional($patient->user)->name) . '"
                            data-nic="' . e(optional($patient->user)->nic) . '"
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
                        </button>
                        <button
                            class="btn btn-primary requestTestBtn"
                            data-id="' . $patient->pid . '"
                            data-name="' . e(optional($patient->user)->name) . '">
                            <i class="fa fa-flask"></i> Request Test
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
            'nic' => ['required_without:mobile', 'nullable', 'regex:/^(\d{9}[Vv]|\d{12})$/',Rule::unique('users', 'nic')->ignore($request->userID, 'id')],
            'gender' => ['required', 'string', 'in:M,F,O'],
            'dob' => ['required', 'string', 'date'],
            'mobile' => ['required_without:nic', 'nullable','string', Rule::unique('patients', 'mobile')->ignore($request->pid, 'pid'),'regex:/^\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{4}$/'],
            'address' => ['string','nullable'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        // Clean the phone number if mobile exists
        if ($request->filled('mobile')) {
            $cleanedMobile = preg_replace('/[^0-9]/', '', $request->mobile);
            $request->merge(['mobile' => $cleanedMobile]);
        }

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
                    'name' => $request->name,
                    'nic' => $request->nic,
                    'email' => $request->email,
                ]);

            return response()->json(['success' => true, 'message' => 'Patient updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Update failed!'], 500);
        }
    }



}
