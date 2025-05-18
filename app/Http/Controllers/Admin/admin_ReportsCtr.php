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
use Yajra\DataTables\Facades\DataTables;
use DB;

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
        $allTestData = User::join('patients', 'patients.userID', '=', 'users.id')
        ->join('tests', 'tests.pid', '=', 'patients.pid')
        ->join('available_tests', 'available_tests.tlid', '=', 'tests.tlid')
        ->join('subcategories', 'subcategories.AvailableTestID', '=', 'available_tests.tlid')
        ->select('users.*', 'tests.*', 'available_tests.*', 'subcategories.*')
        ->where('tests.done','=', 0)
        ->get();


        // dd($allTestData);
        return view('Users.Admin.Reports.AddNewReport',compact('allTestData'));
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
                'users.name as patient_name',
                'users.nic',
                'patients.dob',
                'requested_tests.test_date',
                'availableTests.name as test_name'
            )
            ->orderBy('requested_tests.test_date', 'desc');

        return DataTables::of($reports)
            ->addColumn('dob_formatted', function ($row) {
                return $row->dob ? date('Y-m-d', strtotime($row->dob)) : 'N/A';
            })
            ->addColumn('test_date_formatted', function ($row) {
                return date('Y-m-d', strtotime($row->test_date));
            })
            ->addColumn('actions', function ($row) {
                $downloadBtn = '<a href="' . route('reports.download', $row->report_id) . '" class="btn btn-sm btn-primary" title="Download Report"><i class="fas fa-download"></i></a>';
                $previewBtn = '<a href="' . route('reports.preview', $row->report_id) . '" target="_blank" class="btn btn-sm btn-info ml-1" title="Preview Report"><i class="fas fa-eye"></i></a>';

                return $downloadBtn . ' ' . $previewBtn;
            })
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



}
