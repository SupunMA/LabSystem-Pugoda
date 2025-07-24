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
use App\Models\ReportPath;
use App\Models\TestResult;
use App\Models\TestCategory_New;
use App\Models\Remark;
use Illuminate\Support\Facades\Log; // For logging errors

use DB;
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
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('report_paths')
                      ->whereColumn('report_paths.requested_test_id', 'requested_tests.id'); // Exclude tests with reports
            })
            ->get();

        // Return data for DataTables
        return DataTables::of($tests)
            ->addColumn('actions', function ($test) {
                // Render the Upload Report and Delete buttons dynamically
                return '
                    <button type="button" class="btn btn-success btn-sm uploadReportBtn"
                            data-id="' . $test->id . '"
                            data-patient-name="' . htmlspecialchars($test->patient_name, ENT_QUOTES, 'UTF-8') . '">
                        <i class="fas fa-upload"></i> Upload Report
                    </button>
                    <button type="button" class="btn btn-danger btn-sm deleteTestBtn"
                            data-id="' . $test->id . '"
                            data-patient-name="' . htmlspecialchars($test->patient_name, ENT_QUOTES, 'UTF-8') . '">
                        <i class="fas fa-trash"></i> Delete
                    </button>
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
                'requested_tests.test_id', // Added test_id for fetching categories
                'patients.dob',
                'users.nic',
                'users.name as patient_name',
                'availableTests.name as test_name',
                'availableTests.is_internal',
            ])
            ->join('patients', 'requested_tests.patient_id', '=', 'patients.pid') // Join patients table
            ->join('users', 'patients.userID', '=', 'users.id') // Join users table to get NIC and name
            ->join('availableTests', 'requested_tests.test_id', '=', 'availableTests.id') // Join availableTests table
            ->leftJoin('test_results', 'requested_tests.id', '=', 'test_results.requested_test_id') // Left join with test_results
            ->where('availableTests.is_internal', true) // Fetch only internal (onsite) tests
            ->whereNull('test_results.requested_test_id') // Exclude rows where results already exist
            ->get();

        // Return data for DataTables
        return DataTables::of($tests)
            ->addColumn('actions', function ($test) {
                // Replace Edit button with Add Result button
                return '
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm addResultBtn" data-id="' . $test->id . '" data-test-id="' . $test->test_id . '">
                            <i class="fas fa-flask"></i> Add Result
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
                'reportFile' => [
                    'required',
                    'file',
                    'max:2048',
                    function ($attribute, $value, $fail) {
                        $allowedExtensions = ['pdf'];
                        $extension = strtolower($value->getClientOriginalExtension());

                        if (!in_array($extension, $allowedExtensions)) {
                            $fail('The file must be a PDF.');
                        }

                        // Optional: Check file signature (first few bytes)
                        $handle = fopen($value->getPathname(), 'r');
                        $header = fread($handle, 4);
                        fclose($handle);

                        if ($header !== '%PDF') {
                            $fail('The file does not appear to be a valid PDF.');
                        }
                    }
                ],
                'testId' => 'required|exists:requested_tests,id',
            ]);

            $file = $request->file('reportFile');
            $fileName = 'report_' . $request->testId . '.pdf'; // Force .pdf extension
            $filePath = $file->storeAs('reports', $fileName, 'public');

            ReportPath::create([
                'requested_test_id' => $request->testId,
                'file_path' => $filePath,
            ]);

            return response()->json(['success' => 'Report uploaded successfully!']);
        } catch (\Exception $e) {
            \Log::error('Error uploading report: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to upload report: ' . $e->getMessage()], 500);
        }
    }

    //send out request delete
    public function deleteSendOutRequestedTest(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:requested_tests,id',
            ]);

            RequestedTests::findOrFail($request->id)->delete();

            return response()->json(['success' => 'Requested test deleted successfully!']);
        } catch (\Exception $e) {
            \Log::error('Error deleting requested test: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete requested test.'], 500);
        }
    }

// Add this new method to get test categories for a specific test
public function getTestCategories($testId)
{
    try {
        $categories = TestCategory_New::where('availableTests_id', $testId)
            ->orderBy('display_order')
            ->get();

        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    } catch (\Exception $e) {
        \Log::error('Error fetching test categories: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Failed to fetch test categories'
        ], 500);
    }
}

// Add this method to store test results
 public function storeTestResults(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'requested_test_id' => 'required|exists:requested_tests,id',
                'results' => 'required|array',
                'results.*.category_id' => 'required|exists:test_categories,id',
                'results.*.value' => 'required',
                'results.*.additional_value' => 'nullable|string',
                'remark_id_or_customRemark' => 'nullable|string', // New: Validate the remark field
            ]);

            DB::beginTransaction(); // Start a database transaction

            $requested_test = RequestedTests::find($validatedData['requested_test_id']);

            // Handle remark: Update the 'remark_id_or_customRemark' column in the 'requested_tests' table
            $remarkValue = $request->input('remark_id_or_customRemark');
            if (!empty($remarkValue)) {
                // Check if the provided remarkValue is an ID of an existing remark
                // We assume remark_id in 'remarks' table is an auto-incrementing integer.
                // If it's a number and exists in remarks table, store the ID.
                // Otherwise, it's a custom string, store the string directly.
                if (is_numeric($remarkValue) && Remark::where('remark_id', $remarkValue)->exists()) {
                    $requested_test->remark_id_or_customRemark = $remarkValue; // Store the ID
                } else {
                    // It's a custom remark, store the string directly
                    $requested_test->remark_id_or_customRemark = $remarkValue;
                }
            } else {
                $requested_test->remark_id_or_customRemark = null; // No remark provided
            }
            $requested_test->save(); // Save the updated remark to the requested_tests table

            // Check if results already exist for this test and delete them (to update)
            // This ensures that when results are re-saved, old entries are removed first.
            // Assuming TestResult is the model for the table storing individual test category results.
            TestResult::where('requested_test_id', $validatedData['requested_test_id'])->delete();

            // Store each new result
            foreach ($validatedData['results'] as $result) {
                // Initialize combinedResultValue with the primary 'value'
                $combinedResultValue = $result['value'];

                // If 'additional_value' exists and is not empty, append it with a space
                if (isset($result['additional_value']) && $result['additional_value'] !== null && $result['additional_value'] !== '') {
                    $combinedResultValue .= ' ' . $result['additional_value'];
                }

                TestResult::create([
                    'requested_test_id' => $validatedData['requested_test_id'],
                    'category_id' => $result['category_id'],
                    'result_value' => $combinedResultValue, // Use the combined value here
                    'added_by' => auth()->id() // Assuming you have authentication and a 'TestResult' model
                ]);
            }

            DB::commit(); // Commit the transaction if all operations are successful

            return response()->json([
                'success' => true,
                'message' => 'Test results and remark saved successfully'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack(); // Rollback transaction on validation error
            Log::error('Validation Error saving test results: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction on any other error
            Log::error('Error saving test results: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save test results. An unexpected error occurred.'
            ], 500);
        }
    }

    //Delete Requested Test
        public function destroyRequestedTest($id)
    {
        try {
            $requestedTest = RequestedTests::findOrFail($id);
            $requestedTest->delete();

            return response()->json([
                'success' => true,
                'message' => 'Requested test deleted successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting requested test: ' . $e->getMessage(), ['id' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete requested test. ' . $e->getMessage()
            ], 500); // 500 Internal Server Error
        }
    }

}
