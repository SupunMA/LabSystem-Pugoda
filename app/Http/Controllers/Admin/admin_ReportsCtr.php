<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Patient;
use App\Models\AvailableTest;
use App\Models\Test;
use App\Models\Report;

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
        //all done test with other tables
        $allReportData = User::join('patients', 'patients.userID', '=', 'users.id')
        ->join('tests', 'tests.pid', '=', 'patients.pid')
        ->join('available_tests', 'available_tests.tlid', '=', 'tests.tlid')
        ->join('reports', 'reports.tid', '=', 'tests.tid')
        ->join('subcategories', 'subcategories.AvailableTestID', '=', 'available_tests.tlid')
        ->select('*')
        ->where('tests.done','=', 1)
        ->get();

// dd($allReportData);

// dd($allReportData);
        return view('Users.Admin.Reports.AllReport',compact('allReportData'));
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




}
