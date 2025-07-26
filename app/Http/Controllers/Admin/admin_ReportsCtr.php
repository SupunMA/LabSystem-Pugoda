<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Patient;
use App\Models\AvailableTest;
use App\Models\Test;
use App\Models\Report;
use App\Models\ReportPath;
use App\Models\Remark;
use Yajra\DataTables\Facades\DataTables;
use DB;
use PDF;

use Illuminate\Support\Facades\Storage;

use App\Models\RequestedTest;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

use Carbon\Carbon;

class admin_ReportsCtr extends Controller
{


 //Authenticate all Admin routes
    public function __construct()
    {
        $this->middleware('checkAdmin');
       // $this->task = new branches;
    }


    //Test

    public function addReport()
    {
        // dd($allTestData);
        return view('Users.Admin.Reports.AddNewReport');
    }

    public function addingReport(Request $data)
    {
        // dd($data);
         $data->validate([
            'tid' => ['required'],
            'result' => ['required', 'array'],
            'result.*' => ['required', 'string'],
            // 'status' => ['required','string']
         ]);

         // Assuming 'result' is an array in the request
        $results = $data->input('result');

        // Convert the array to a comma-separated string
        $resultString = implode(', ', $results);
// dd($resultString);
        //  $results = $data->input('result');
        //  dd($results);
        $report = new Report();

        $report->tid = $data->tid;
        $report->result = $resultString;
        // $AvailableTest->AvailableTestCost = $request->AvailableTestCost;
        //  $report = Report::create($data->all());
        $report->save();
         Test::where('tid', $data->tid)
        ->update([
                    'done' => 1
                ]);
         return redirect()->back()->with('message','Created Successful');

    }



    public function allReport()
    {
        return view('Users.Admin.Reports.AllReport');
    }

    public function deleteReport($ID)
    {
        //dd($branchID);
        $delete = Report::find($ID);
        $delete->delete();
        return redirect()->back()->with('message','Delete successfully');
    }

    public function updateReport(Request $request)
    {

        $request->validate([
            'result' =>['required','string'],
            'status' => ['required','string']
        ]);

        Report::where('rid', $request->rid)
        ->update([
                    'result' => $request->result,
                    'status'=> $request->status

                ]);

        return redirect()->back()->with('message','Updated Successfully');

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

        //  dd($viewReportData);
        return view('Users.Admin.Reports.components.invoice-print',compact('viewReportData'));
    }


    //new


public function getReports()
{
    $reports = DB::table('report_paths')
        ->join('requested_tests', 'report_paths.requested_test_id', '=', 'requested_tests.id')
        ->join('patients', 'requested_tests.patient_id', '=', 'patients.pid')
        ->join('users', 'patients.userID', '=', 'users.id')
        ->join('availableTests', 'requested_tests.test_id', '=', 'availableTests.id')
        ->select(
            'report_paths.id as report_id',
            'report_paths.file_path',
            'requested_tests.id as requestedTest_ID',
            'users.name as patient_name',
            'users.nic',
            'patients.dob',
            'requested_tests.test_date',
            'availableTests.name as test_name',
            'requested_tests.price as test_price'
        );

    return DataTables::of($reports)
        ->addColumn('custom_report_id', function ($row) {
            // Format: YYYYMMDD-ID (e.g., 20250518-123)
            $dateFormatted = date('Ymd', strtotime($row->test_date));
            return $dateFormatted . '-' . $row->requestedTest_ID . '-SO';
        })
        ->addColumn('dob_formatted', function ($row) {
            return $row->dob ? date('Y-m-d', strtotime($row->dob)) : 'N/A';
        })
        ->addColumn('test_date_formatted', function ($row) {
            return date('Y-m-d', strtotime($row->test_date));
        })
        ->addColumn('actions', function ($row) {
            $downloadBtn = '<a href="' . route('reports.download', $row->report_id) . '" class="btn btn-sm btn-primary download-btn" title="Download Report">
                    <i class="fas fa-download"></i> Download
                    <span class="spinner-border spinner-border-sm text-light d-none" role="status" aria-hidden="true"></span>
                </a>';
            $previewBtn = '<a href="' . route('reports.preview', $row->report_id) . '" target="_blank" class="btn btn-sm btn-info ml-1" title="Preview Report"><i class="fas fa-eye"></i> View</a>';

            return $downloadBtn . ' ' . $previewBtn;
        })
        ->filterColumn('custom_report_id', function($query, $keyword) {
            // Allow searching for either the date part or the ID part or both
            $query->whereRaw("CONCAT(DATE_FORMAT(requested_tests.test_date, '%Y%m%d'), '-', requested_tests.id,'-SO') like ?", ["%{$keyword}%"]);
        })
        ->filterColumn('patient_name', function($query, $keyword) {
            $query->whereRaw("users.name like ?", ["%{$keyword}%"]);
        })
        ->filterColumn('nic', function($query, $keyword) {
            $query->whereRaw("users.nic like ?", ["%{$keyword}%"]);
        })
        ->filterColumn('dob_formatted', function($query, $keyword) {
            $query->whereRaw("DATE_FORMAT(patients.dob, '%Y-%m-%d') like ?", ["%{$keyword}%"]);
        })
        ->filterColumn('test_date_formatted', function($query, $keyword) {
            $query->whereRaw("DATE_FORMAT(requested_tests.test_date, '%Y-%m-%d') like ?", ["%{$keyword}%"]);
        })
        ->filterColumn('test_name', function($query, $keyword) {
            $query->whereRaw("availableTests.name like ?", ["%{$keyword}%"]);
        })
        ->filterColumn('test_price', function($query, $keyword) {
            $query->whereRaw("requested_tests.price like ?", ["%{$keyword}%"]);
        })
        // Adding proper order handlers for each column
        ->orderColumn('custom_report_id', 'requested_tests.test_date $1, requested_tests.id $1')
        ->orderColumn('patient_name', 'users.name $1')
        ->orderColumn('nic', 'users.nic $1')
        ->orderColumn('dob_formatted', 'patients.dob $1')
        ->orderColumn('test_date_formatted', 'requested_tests.test_date $1')
        ->orderColumn('test_name', 'availableTests.name $1')
        ->orderColumn('test_price', 'requested_tests.price $1')
        ->rawColumns(['actions'])
        ->make(true);
}
    public function download($id)
    {
        $report = ReportPath::findOrFail($id);
        $filePath = storage_path('app/public/reports/' . basename($report->file_path));

        if (!file_exists($filePath)) {
            return back()->with('error', 'File not found.');
        }

        return new StreamedResponse(function () use ($filePath) {
            readfile($filePath);
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . basename($filePath) . '"',
        ]);
    }
    public function preview($id)
    {
        $report = ReportPath::findOrFail($id);
        $filePath = storage_path('app/public/' . $report->file_path);

        if (file_exists($filePath)) {
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf'
            ]);
        }

        $alternativePath = public_path('storage/' . $report->file_path);
        if (file_exists($alternativePath)) {
            return response()->file($alternativePath, [
                'Content-Type' => 'application/pdf'
            ]);
        }

        return back()->with('error', 'File not found! Please check storage configuration and file path.');
    }


    //New Onsite Report
    public function getOnSiteReports()
    {
        $reports = DB::table('test_results')
            ->join('requested_tests', 'test_results.requested_test_id', '=', 'requested_tests.id')
            ->join('patients', 'requested_tests.patient_id', '=', 'patients.pid')
            ->join('users', 'patients.userID', '=', 'users.id')
            ->join('availableTests', 'requested_tests.test_id', '=', 'availableTests.id')
            ->whereIn('test_results.id', function($query) {
                $query->select(DB::raw('MIN(id)'))
                    ->from('test_results')
                    ->groupBy('requested_test_id');
            })
            ->select(
                'test_results.id as report_id',
                'requested_tests.id as requestedTest_ID',
                'users.name as patient_name',
                'users.nic',
                'patients.dob',
                'requested_tests.test_date',
                'availableTests.name as test_name',
                'requested_tests.price as test_price'
            );

        return DataTables::of($reports)
            ->addColumn('custom_report_id', function ($row) {
                // Format: YYYYMMDD-ID (e.g., 20250518-123)
                $dateFormatted = date('Ymd', strtotime($row->test_date));
                return $dateFormatted . '-' . $row->requestedTest_ID . '-OS';
            })
            ->addColumn('dob_formatted', function ($row) {
                return $row->dob ? date('Y-m-d', strtotime($row->dob)) : 'N/A';
            })
            ->addColumn('test_date_formatted', function ($row) {
                return date('Y-m-d', strtotime($row->test_date));
            })
            ->addColumn('actions', function ($row) {
                $downloadBtn = '<a href="' . route('reportsOnSite.download', $row->report_id) . '" class="btn btn-sm btn-warning download-btn" title="Download Report">
                        <i class="fas fa-download"></i> Download
                        <span class="spinner-border spinner-border-sm text-light d-none" role="status" aria-hidden="true"></span>
                    </a>';
                $previewBtn = '<a href="' . route('reportsOnSite.preview', $row->report_id) . '" target="_blank" class="btn btn-sm btn-danger ml-1" title="Preview Report"><i class="fas fa-eye"></i> View</a>';

                return $downloadBtn . ' ' . $previewBtn;
            })
            ->filterColumn('custom_report_id', function($query, $keyword) {
                // Allow searching for either the date part or the ID part or both
                $query->whereRaw("CONCAT(DATE_FORMAT(requested_tests.test_date, '%Y%m%d'), '-', requested_tests.id,'-OS') like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('patient_name', function($query, $keyword) {
                $query->whereRaw("users.name like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('nic', function($query, $keyword) {
                $query->whereRaw("users.nic like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('dob_formatted', function($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(patients.dob, '%Y-%m-%d') like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('test_date_formatted', function($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(requested_tests.test_date, '%Y-%m-%d') like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('test_name', function($query, $keyword) {
                $query->whereRaw("availableTests.name like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('test_price', function($query, $keyword) {
                $query->whereRaw("requested_tests.price like ?", ["%{$keyword}%"]);
            })
            // Adding proper order handlers for each column
            ->orderColumn('custom_report_id', 'requested_tests.test_date $1, requested_tests.id $1')
            ->orderColumn('patient_name', 'users.name $1')
            ->orderColumn('nic', 'users.nic $1')
            ->orderColumn('dob_formatted', 'patients.dob $1')
            ->orderColumn('test_date_formatted', 'requested_tests.test_date $1')
            ->orderColumn('test_name', 'availableTests.name $1')
            ->orderColumn('test_price', 'requested_tests.price $1')
            ->rawColumns(['actions'])
            ->make(true);
    }


 public function previewReport($id)
    {
        // Get the basic report information by joining multiple tables
        $testResult = DB::table('test_results')
            ->join('requested_tests', 'test_results.requested_test_id', '=', 'requested_tests.id')
            ->join('patients', 'requested_tests.patient_id', '=', 'patients.pid')
            ->join('users', 'patients.userID', '=', 'users.id')
            ->join('availableTests', 'requested_tests.test_id', '=', 'availableTests.id')
            ->where('test_results.id', $id)
            ->select(
                'test_results.id as report_id',
                'test_results.requested_test_id',
                'requested_tests.id as requestedTest_ID',
                'users.name as patient_name',
                'users.nic as nic',
                'patients.gender',
                'patients.dob',
                'requested_tests.test_date',
                'availableTests.id as test_id',
                'availableTests.name as test_name',
                'availableTests.specimen',
                'requested_tests.remark_id_or_customRemark' // Fetch the remark
            )
            ->first();

        if (!$testResult) {
            return abort(404, 'Report not found');
        }

        // Calculate patient age in years, months, and days
        $birthDate = Carbon::parse($testResult->dob);
        $today = Carbon::now();

        // Create a diff instance that contains the full difference information
        $diff = $today->diff($birthDate);

        // Extract years, months and days directly from the diff object
        $ageYears = $diff->y;
        $ageMonths = $diff->m;
        $ageDays = $diff->d;

        // Format age as "X years, Y months, Z days" with proper handling
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

        // Get all test categories for this test
        $testCategories = DB::table('test_categories')
            ->where('test_categories.availableTests_id', $testResult->test_id)
            ->orderBy('test_categories.display_order')
            ->get();

        // Get all test elements (titles, paragraphs, etc.)
        $testElements = DB::table('availableTest_elements')
            ->where('availableTest_elements.availableTests_id', $testResult->test_id)
            ->orderBy('availableTest_elements.display_order')
            ->get();

        // Get results for the requested test
        $results = DB::table('test_results')
            ->where('requested_test_id', $testResult->requested_test_id)
            ->get()
            ->keyBy('category_id');

        // Format test results (combine categories and elements in proper display order)
        $formattedResults = [];

        // Create a combined collection of categories and elements for sorting
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
                'type' => $element->type, // 'space', 'title', or 'paragraph'
                'display_order' => $element->display_order,
                'data' => $element
            ]);
        }

        // Sort by display_order
        $allItems = $allItems->sortBy('display_order');

        // Process all items to build the final results array
        foreach ($allItems as $item) {
            if ($item['type'] === 'category') {
                $category = $item['data'];
                // Find result for this category
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
                    // Get reference table data
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

        // Determine the remark text to display
        $remarkText = null;
        if (!empty($testResult->remark_id_or_customRemark)) {
            // Check if it's an ID of an existing remark
            if (is_numeric($testResult->remark_id_or_customRemark)) {
                $remark = Remark::find($testResult->remark_id_or_customRemark);
                if ($remark) {
                    $remarkText = $remark->remark_description;
                }
            } else {
                // It's a custom remark string
                $remarkText = $testResult->remark_id_or_customRemark;
            }
        }


        // Prepare data for the view
        $sampleData = [
            'patientName' => $testResult->patient_name,
            'nic' => $testResult->nic,
            'age' => $age,
            'gender' => ucfirst(strtolower($testResult->gender)),
            'reportDate' => date('Y-m-d', strtotime($testResult->test_date)),
            'reportId' => $reportId,
            'testName' => $testResult->test_name,
            'specimenType' => $testResult->specimen,
            'testResults' => $formattedResults,
            'remark' => $remarkText // Pass the remark to the view
        ];

        // Return the view with the prepared data and the correct back button route
        return view('Users.labReport', [
            'sampleData' => $sampleData,
            'backRoute' => 'admin.allReport'  // Set the correct back button route for Admin area
        ]);
    }


/**
 * Get reference table data for a test category
 *
 * @param int $categoryId The test category ID
 * @return array The reference table data as a 2D array
 */




  public function downloadReport($id)
    {
        // Get the basic report information by joining multiple tables
        $testResult = DB::table('test_results')
            ->join('requested_tests', 'test_results.requested_test_id', '=', 'requested_tests.id')
            ->join('patients', 'requested_tests.patient_id', '=', 'patients.pid')
            ->join('users', 'patients.userID', '=', 'users.id')
            ->join('availableTests', 'requested_tests.test_id', '=', 'availableTests.id')
            ->where('test_results.id', $id)
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
                'availableTests.specimen',
                'requested_tests.remark_id_or_customRemark' // Fetch the remark here
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

        // Determine the remark text to display
        $remarkText = null;
        if (!empty($testResult->remark_id_or_customRemark)) {
            // Check if it's an ID of an existing remark
            if (is_numeric($testResult->remark_id_or_customRemark)) {
                $remark = Remark::find($testResult->remark_id_or_customRemark);
                if ($remark) {
                    $remarkText = $remark->remark_description;
                }
            } else {
                // It's a custom remark string
                $remarkText = $testResult->remark_id_or_customRemark;
            }
        }

        // Generate QR code URL using online service
        $qrCodeUrl = null;
        if (!empty($testResult->nic)) {
            // Using QR Server API (a good alternative to Google Charts API)
            $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=' . urlencode($testResult->nic);
            // Note: Adjusted size to 100x100 for better PDF embedding, you can change it.
        }

        // Prepare data for the view
        $sampleData = [
            'patientName' => $testResult->patient_name,
            'nic' => $testResult->nic,
            'nicQrCode' => $qrCodeUrl, // This will be the URL to the external QR code image
            'age' => $age,
            'gender' => ucfirst(strtolower($testResult->gender)),
            'reportDate' => date('Y-m-d', strtotime($testResult->test_date)),
            'reportId' => $reportId,
            'testName' => $testResult->test_name,
            'specimenType' => $testResult->specimen,
            'testResults' => $formattedResults,
            'remark' => $remarkText // Pass the remark to the download view
        ];

        // Create PDF filename
        $filename = $reportId . '.pdf';

        // Create the PDF using a dedicated download view
        $pdf = PDF::loadView('Users.labReportDownload', [
            'sampleData' => $sampleData,
            'isPdfDownload' => true
        ]);

        // Configure PDF settings
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'isPhpEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true, // Crucial for fetching external QR code image
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

    /**
     * Helper method to get reference table data
     *
     * @param int $categoryId The category ID
     * @return array Reference table data
     */
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



}
