<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Test;
use App\Models\Patient;
use DB;
use Carbon\Carbon;




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
                'availableTests.is_internal',
                'requested_tests.price',
                'requested_tests.created_at',
                'requested_tests.updated_at'
            )
            ->orderBy('requested_tests.test_date', 'desc')
            ->orderBy('requested_tests.id', 'desc')
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

            // Format report ID: date + test_id + type (based on is_internal)
            $formattedDate = \Carbon\Carbon::parse($test->test_date)->format('Ymd');
            $paddedId = str_pad($test->report_id, 2, '0', STR_PAD_LEFT);

            // If is_internal = 1, add "OS", else add "SO"
            $suffix = $test->is_internal ? 'OS' : 'SO';
            $test->formatted_report_id = $formattedDate . '-' . $paddedId . '-' . $suffix;
        }

        // Count pending results (tests that don't have results or report paths)
        $pendingCount = $requestedTests->where('is_completed', 0)->count();

        // Count completed reports (tests that have results or report paths)
        $reportCount = $requestedTests->where('is_completed', 1)->count();

        // Prepare data for the table
        // In your checkUser() function, replace the current map/sort with:
        $reportsData = $requestedTests->map(function($test) {
            $status = $test->is_completed ? 'Completed' : 'Pending';
            $action = $test->is_completed ? 'Download' : 'In Progress';

            return [
                'report_id' => $test->report_id,
                'formatted_report_id' => $test->formatted_report_id,
                'test_date' => \Carbon\Carbon::parse($test->test_date)->format('Y-m-d'),
                'test_name' => $test->test_name,
                // 'price' => number_format($test->price, 2),
                'status' => $status,
                'action' => $action,
                'file_path' => $test->file_path,
                // Add raw values for DataTables sorting
                'raw_report_id' => $test->report_id,
                'raw_test_date' => $test->test_date
            ];
        })->sortByDesc('raw_report_id')->values();

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

        // Return file download response with explicit headers
        return response()->download($filePath, $fileName, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function viewReport($requestedTestId)
    {
        $userId = Auth::id();

        // Get the patient record for the current user
        $patient = DB::table('patients')->where('userID', $userId)->first();

        if (!$patient) {
            abort(404, 'Patient record not found.');
        }

        // Verify the requested test belongs to this patient and has a report
        $reportPath = DB::table('requested_tests')
            ->join('report_paths', 'requested_tests.id', '=', 'report_paths.requested_test_id')
            ->where('requested_tests.id', $requestedTestId)
            ->where('requested_tests.patient_id', $patient->pid)
            ->select('report_paths.file_path')
            ->first();

        if (!$reportPath) {
            abort(404, 'Report not found or access denied.');
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
            abort(404, 'Report file not found on server.');
        }

        // Return file for inline viewing with explicit headers
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="report.pdf"'
        ]);
    }


    //Download pdf by generating
     public function generateDownloadReport($id)
    {
        // Get the basic report information by joining multiple tables
        $testResult = DB::table('test_results')
            ->join('requested_tests', 'test_results.requested_test_id', '=', 'requested_tests.id')
            ->join('patients', 'requested_tests.patient_id', '=', 'patients.pid')
            ->join('users', 'patients.userID', '=', 'users.id')
            ->join('availableTests', 'requested_tests.test_id', '=', 'availableTests.id')
            ->where('requested_tests.id', $id)
            ->select(
                'test_results.id as report_id',
                'test_results.requested_test_id',
                'requested_tests.id as requestedTest_ID',
                'users.name as patient_name',
                'patients.gender',
                'patients.dob',
                'users.nic',
                'requested_tests.test_date',
                'availableTests.id as test_id',
                'availableTests.name as test_name',
                'availableTests.specimen'
            )
            ->first();

        if (!$testResult) {
            return abort(404, 'Report not found');
        }

        // Calculate patient age in years, months, and days
        $birthDate = Carbon::parse($testResult->dob);
        $today = Carbon::now();

        // Use diff to get accurate years, months and days
        $diff = $today->diff($birthDate);
        $ageYears = $diff->y;
        $ageMonths = $diff->m;
        $ageDays = $diff->d;

        // Format age as "X years, Y months, Z days"
        $age = "";
        if ($ageYears > 0) {
            $age = $ageYears . " year" . ($ageYears != 1 ? "s" : "");
        }
        if ($ageMonths > 0 || ($ageYears > 0 && $ageDays > 0)) {
            $age .= ($age ? ", " : "") . $ageMonths . " month" . ($ageMonths != 1 ? "s" : "");
        }
        if ($ageDays > 0 || ($ageYears == 0 && $ageMonths == 0)) {
            $age .= ($age ? ", " : "") . $ageDays . " day" . ($ageDays != 1 ? "s" : "");
        }

        // Format report ID (YYYYMMDD-requestID-OS)
        $reportId = date('Ymd', strtotime($testResult->test_date)) . '-' . $testResult->requestedTest_ID . '-OS';

        // Prepare data for the PDF (same as preview)
        $formattedResults = $this->getFormattedTestResults($testResult->test_id, $testResult->requested_test_id);

    // Generate QR code URL using online service
    $qrCodeUrl = null;
    if (!empty($testResult->nic)) {
        // Using Google Charts API (simple and reliable)
        // $qrCodeUrl = 'https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=' . urlencode($testResult->nic);

        // Or use QR Server API
        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($testResult->nic);
    }



    // Prepare data for the view
    $sampleData = [
        'patientName' => $testResult->patient_name,
        'nic' => $testResult->nic,
        'nicQrCode' => $qrCodeUrl,
        'age' => $age,
        'gender' => ucfirst(strtolower($testResult->gender)),
        'reportDate' => date('Y-m-d', strtotime($testResult->test_date)),
        'reportId' => $reportId,
        'testName' => $testResult->test_name,
        'specimenType' => $testResult->specimen,
        'testResults' => $formattedResults
    ];

        // Create PDF filename
        $filename = $reportId . '.pdf';

        // Create the PDF using a dedicated download view
        $pdf = \PDF::loadView('Users.labReportDownload', [
            'sampleData' => $sampleData,
            'isPdfDownload' => true
        ]);

        // Configure PDF settings
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'isPhpEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif',
            'dpi' => 150,
            'debugCss' => false
        ]);

        // Return PDF download
        return $pdf->download($filename);
    }

    /**
     * Helper method to get formatted test results for reports
     *
     * @param int $testId The available test ID
     * @param int $requestedTestId The requested test ID
     * @return array Formatted test results
     */
    private function getFormattedTestResults($testId, $requestedTestId)
    {
        // Get test categories and elements
        $testCategories = DB::table('test_categories')
            ->where('test_categories.availableTests_id', $testId)
            ->orderBy('test_categories.display_order')
            ->get();

        $testElements = DB::table('availableTest_elements')
            ->where('availableTest_elements.availableTests_id', $testId)
            ->orderBy('availableTest_elements.display_order')
            ->get();

        // Get results for the requested test
        $results = DB::table('test_results')
            ->where('requested_test_id', $requestedTestId)
            ->get()
            ->keyBy('category_id');

        // Combine categories and elements for display
        $allItems = collect([]);

        foreach ($testCategories as $category) {
            $allItems->push([
                'type' => 'category',
                'display_order' => $category->display_order,
                'data' => $category
            ]);
        }

        foreach ($testElements as $element) {
            $allItems->push([
                'type' => $element->type,
                'display_order' => $element->display_order,
                'data' => $element
            ]);
        }

        // Sort by display_order
        $allItems = $allItems->sortBy('display_order');

        // Format results
        $formattedResults = [];
        foreach ($allItems as $item) {
            if ($item['type'] === 'category') {
                $category = $item['data'];
                $result = $results[$category->id] ?? null;
                $resultValue = $result ? $result->result_value : 'Pending';

                // Format reference range
                $reference = '';
                if ($category->reference_type === 'minmax' && !is_null($category->min_value) && !is_null($category->max_value)) {
                    $reference = $category->min_value . ' - ' . $category->max_value;
                    if ($category->unit_enabled && $category->unit) {
                        $reference .= ' ' . $category->unit;
                    }
                } elseif ($category->reference_type === 'table') {
                    $tableData = $this->getReferenceTableData($category->id);
                    $reference = [
                        'isTable' => true,
                        'data' => $tableData
                    ];
                }

                // Add unit to result if enabled
                if ($result && $category->unit_enabled && $category->unit) {
                    $resultValue .= ' ' . $category->unit;
                }

                $formattedResults[] = [
                    'name' => $category->name,
                    'result' => $resultValue,
                    'reference' => $reference,
                    'isTitle' => false,
                    'isParagraph' => false,
                    'isSpace' => false,
                    'isCategory' => true
                ];
            } else {
                // Handle other elements (title, paragraph, space)
                $element = $item['data'];
                $formattedResults[] = [
                    'name' => $element->content,
                    'result' => $element->content,
                    'reference' => '',
                    'isTitle' => ($item['type'] === 'title'),
                    'isParagraph' => ($item['type'] === 'paragraph'),
                    'isSpace' => ($item['type'] === 'space'),
                    'isCategory' => false
                ];
            }
        }

        return $formattedResults;
    }

    private function getReferenceTableData($categoryId)
    {
        $tableEntries = DB::table('reference_range_tables')
            ->where('test_categories_id', $categoryId)
            ->select('row', 'column', 'value')
            ->get();

        if ($tableEntries->isEmpty()) {
            return [];
        }

        // Group by row first
        $rows = [];
        foreach ($tableEntries as $entry) {
            if (!isset($rows[$entry->row])) {
                $rows[$entry->row] = [];
            }
            $rows[$entry->row][$entry->column] = $entry->value;
        }

        // Convert to indexed arrays
        $tableData = [];
        foreach ($rows as $rowIndex => $columns) {
            $rowArray = [];
            ksort($columns); // Sort by column index
            foreach ($columns as $columnValue) {
                $rowArray[] = $columnValue;
            }
            $tableData[] = $rowArray;
        }

        return $tableData;
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

}
