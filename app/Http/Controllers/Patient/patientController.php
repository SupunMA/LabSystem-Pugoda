<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Test;
use App\Models\Patient;
use DB;




class patientController extends Controller
{
    public function checkUser()
    {
        $userId = Auth::id();

        // Get the patient record for the current user
        $patient = DB::table('patients')->where('userID', $userId)->first();

        if (!$patient) {
            // Handle case where patient record doesn't exist
            return redirect()->back()->with('error', 'Patient record not found.');
        }

        // Get all requested tests for this patient with test details and completion status
        $requestedTests = DB::table('requested_tests')
            ->join('availableTests', 'requested_tests.test_id', '=', 'availableTests.id')
            ->where('requested_tests.patient_id', $patient->pid)
            ->select(
                'requested_tests.id as report_id',
                'requested_tests.test_date',
                'availableTests.name as test_name',
                'requested_tests.price',
                'requested_tests.created_at',
                'requested_tests.updated_at'
            )
            ->orderBy('requested_tests.test_date', 'desc')
            ->get();

        // Check completion status for each test
        foreach ($requestedTests as $test) {
            // Check if test has report path
            $hasReportPath = DB::table('report_paths')
                ->where('requested_test_id', $test->report_id)
                ->exists();

            // Check if test has results
            $hasTestResults = DB::table('test_results')
                ->where('requested_test_id', $test->report_id)
                ->exists();

            // Get file path if exists
            $filePath = DB::table('report_paths')
                ->where('requested_test_id', $test->report_id)
                ->value('file_path');

            // Set completion status
            $test->is_completed = ($hasReportPath || $hasTestResults) ? 1 : 0;
            $test->file_path = $filePath;
        }

        // Count pending results (tests that don't have results or report paths)
        $pendingCount = $requestedTests->where('is_completed', 0)->count();

        // Count completed reports (tests that have results or report paths)
        $reportCount = $requestedTests->where('is_completed', 1)->count();

        // Prepare data for the table
        $reportsData = $requestedTests->map(function($test) {
            $status = $test->is_completed ? 'Completed' : 'Pending';
            $action = $test->is_completed ? 'Download' : 'In Progress';

            return [
                'report_id' => $test->report_id,
                'test_date' => \Carbon\Carbon::parse($test->test_date)->format('Y-m-d'),
                'test_name' => $test->test_name,
                'price' => number_format($test->price, 2),
                'status' => $status,
                'action' => $action,
                'file_path' => $test->file_path // Include file path for download functionality
            ];
        });

        return view('Users.User.home', compact('pendingCount', 'reportCount', 'reportsData'));
    }



    public function downloadReport($requestedTestId)
    {
        $userId = Auth::id();

        // Get the patient record for the current user
        $patient = DB::table('patients')->where('userID', $userId)->first();

        if (!$patient) {
            return redirect()->back()->with('error', 'Patient record not found.');
        }

        // Verify the requested test belongs to this patient and has a report
        $reportPath = DB::table('requested_tests')
            ->join('report_paths', 'requested_tests.id', '=', 'report_paths.requested_test_id')
            ->where('requested_tests.id', $requestedTestId)
            ->where('requested_tests.patient_id', $patient->pid)
            ->select('report_paths.file_path')
            ->first();

        if (!$reportPath) {
            return redirect()->back()->with('error', 'Report not found or access denied.');
        }

        // Check if file exists - handle different path formats
        $storedPath = $reportPath->file_path;

        // If the stored path includes 'reports/', use it as is
        if (strpos($storedPath, 'reports/') !== false) {
            $filePath = storage_path('app/public/' . $storedPath);
        } else {
            // If it's just the filename, assume it's in reports folder
            $filePath = storage_path('app/public/reports/' . basename($storedPath));
        }

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Report file not found on server.');
        }

        // Get file name for download
        $fileName = 'Report_' . $requestedTestId . '_' . date('Y-m-d') . '.pdf';

        // Return file download response
        return response()->download($filePath, $fileName);
    }

    public function deleteUser($ID)
    {


        $patient = Patient::where('userID', $ID)->first();
        $testPatient = Test::where('pid', $patient->pid)->delete();
        $delete = User::find($ID);

        $patient->delete();

        $delete->delete();
        return redirect()->back()->with('message','successful');
    }

    public function viewReport($ID)
    {

        //all done test with other tables
        // $viewReportData = User::join('patients', 'patients.userID', '=', 'users.id')
        // ->join('tests', 'tests.pid', '=', 'patients.pid')
        // ->join('available_tests', 'available_tests.tlid', '=', 'tests.tlid')
        // ->join('reports', 'reports.tid', '=', 'tests.tid')
        // ->select('users.*', 'tests.*', 'available_tests.*','reports.*','patients.*')
        // ->where('reports.rid','=', $ID)
        // ->first();


        $viewReportData = User::join('patients', 'patients.userID', '=', 'users.id')
        ->join('tests', 'tests.pid', '=', 'patients.pid')
        ->join('available_tests', 'available_tests.tlid', '=', 'tests.tlid')
        ->join('reports', 'reports.tid', '=', 'tests.tid')
        ->join('subcategories', 'subcategories.AvailableTestID', '=', 'available_tests.tlid')
        ->select('*')
        ->where('reports.rid','=', $ID)
        ->get();

        // dd($viewReportData);
        return view('Users.user.invoice-print',compact('viewReportData'));
    }
}
