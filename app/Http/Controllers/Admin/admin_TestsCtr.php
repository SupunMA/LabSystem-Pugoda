<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Patient;
use App\Models\AvailableTest;
use App\Models\AvailableTest_New;
use App\Models\RequestedTests;
use App\Models\Test;

use Yajra\DataTables\Facades\DataTables;

use Carbon\Carbon;

class admin_TestsCtr extends Controller
{


 //Authenticate all Admin routes
    public function __construct()
    {
        $this->middleware('checkAdmin');
       // $this->task = new branches;
    }


    //Test

    public function addTest()
    {
        return view('Users.Admin.RequestedTests.onSiteReqTest');
    }




    public function allTest()
    {
        return view('Users.Admin.RequestedTests.sendOutReqTest');
    }


    //new

    public function getAvailableTests()
   {
       $tests = AvailableTest_New::all();
       return response()->json($tests);
   }

   public function requestTest(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'patient_id' => 'required|exists:patients,pid', // Ensure patient exists
        'test_id' => 'required|exists:availableTests,id', // Ensure test exists
        'test_date' => 'required|date', // Ensure valid date
    ]);

    // Fetch the test price from the availableTests table
    $test = AvailableTest_New::findOrFail($request->test_id);

    // Create a new test request
    RequestedTests::create([
        'patient_id' => $request->patient_id,
        'test_id' => $request->test_id,
        'price' => $test->price, // Save the price at the time of the request
        'test_date' => $request->test_date,
    ]);

    // Return a success response
    return response()->json(['message' => 'Test requested successfully!'], 201);
}


public function getAllExternalRequestedTests()
{
    try {
        // Fetch requested tests with related patient, user, and test details
        $tests = RequestedTests::select([
                'requested_tests.id',
                'requested_tests.test_date',
                'requested_tests.price',
                'patients.dob',
                'users.nic',
                'users.name as patient_name',
                'availableTests.name as test_name',
                'availableTests.is_internal',
            ])
            ->join('patients', 'requested_tests.patient_id', '=', 'patients.pid') // Join patients table
            ->join('users', 'patients.userID', '=', 'users.id') // Join users table to get NIC and name
            ->join('availableTests', 'requested_tests.test_id', '=', 'availableTests.id') // Join availableTests table
            ->where('availableTests.is_internal', false) // Fetch only external tests
            ->get();

        // Return data for DataTables
        return DataTables::of($tests)
            ->addColumn('actions', function ($test) {
                return '
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm editBtn" data-id="' . $test->id . '">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button type="button" class="btn btn-danger btn-sm deleteBtn" data-id="' . $test->id . '">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                ';
            })
            ->editColumn('test_date', function ($test) {
                return $test->test_date ? \Carbon\Carbon::parse($test->test_date)->format('M d, Y') : 'N/A';
            })
            ->editColumn('dob', function ($test) {
                return $test->dob ? \Carbon\Carbon::parse($test->dob)->format('M d, Y') : 'N/A';
            })
            ->rawColumns(['actions']) // Mark the actions column as raw HTML
            ->make(true);
    } catch (\Exception $e) {
        \Log::error('Error fetching requested tests: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred while fetching data'], 500);
    }
}


public function getAllInternalRequestedTests()
{
    try {
        // Fetch requested tests with related patient, user, and test details
        $tests = RequestedTests::select([
                'requested_tests.id',
                'requested_tests.test_date',
                'requested_tests.price',
                'patients.dob',
                'users.nic',
                'users.name as patient_name',
                'availableTests.name as test_name',
                'availableTests.is_internal',
            ])
            ->join('patients', 'requested_tests.patient_id', '=', 'patients.pid') // Join patients table
            ->join('users', 'patients.userID', '=', 'users.id') // Join users table to get NIC and name
            ->join('availableTests', 'requested_tests.test_id', '=', 'availableTests.id') // Join availableTests table
            ->where('availableTests.is_internal', true) // Fetch only internal (onsite) tests
            ->get();

        // Return data for DataTables
        return DataTables::of($tests)
            ->addColumn('actions', function ($test) {
                return '
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm editBtn" data-id="' . $test->id . '">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button type="button" class="btn btn-danger btn-sm deleteBtn" data-id="' . $test->id . '">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                ';
            })
            ->editColumn('test_date', function ($test) {
                return $test->test_date ? \Carbon\Carbon::parse($test->test_date)->format('M d, Y') : 'N/A';
            })
            ->editColumn('dob', function ($test) {
                return $test->dob ? \Carbon\Carbon::parse($test->dob)->format('M d, Y') : 'N/A';
            })
            ->rawColumns(['actions']) // Mark the actions column as raw HTML
            ->make(true);
    } catch (\Exception $e) {
        \Log::error('Error fetching requested tests: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred while fetching data'], 500);
    }
}



// upload pdf
    public function uploadPdf(Request $request)
    {
        try {
            $request->validate([
                'reportFile' => 'required|mimes:pdf|max:2048', // Validate PDF file
                'testId' => 'required|exists:requested_tests,id', // Ensure test ID exists
            ]);

            $file = $request->file('reportFile');
            $fileName = 'report_' . $request->testId . '.' . $file->getClientOriginalExtension();
            $file->storeAs('reports', $fileName, 'public'); // Save file to storage/app/public/reports

            // Optionally, update the database with the file path
            // RequestedTests::where('id', $request->testId)->update(['report_path' => $fileName]);

            return response()->json(['success' => 'Report uploaded successfully!']);
        } catch (\Exception $e) {
            \Log::error('Error uploading report: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to upload report.'], 500);
        }
    }

}
