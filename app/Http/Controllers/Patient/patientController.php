<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Test;
use App\Models\Patient;




class patientController extends Controller
{
    public function checkUser()
    {

        $userId = Auth::id();

        //Reports count
        $reportCount = User::join('patients', 'patients.userID', '=', 'users.id')
        ->join('tests', 'tests.pid', '=', 'patients.pid')
        ->join('available_tests', 'available_tests.tlid', '=', 'tests.tlid')
        ->join('reports', 'reports.tid', '=', 'tests.tid')
        ->select('users.*', 'tests.*', 'available_tests.*','reports.*')
        ->where('tests.done','=', 1)
         ->where('users.id','=', $userId)
        ->count();

        //pending count
        $pendingCount = User::join('patients', 'patients.userID', '=', 'users.id')
        ->join('tests', 'tests.pid', '=', 'patients.pid')
        ->join('available_tests', 'available_tests.tlid', '=', 'tests.tlid')
        ->join('reports', 'reports.tid', '=', 'tests.tid')
        ->select('users.*', 'tests.*', 'available_tests.*','reports.*')
        ->where('tests.done','=', 0)
         ->where('users.id','=', $userId)
        ->count();

       //all done test with other tables
    //    $allReportData = User::join('patients', 'patients.userID', '=', 'users.id')
    //    ->join('tests', 'tests.pid', '=', 'patients.pid')
    //    ->join('available_tests', 'available_tests.tlid', '=', 'tests.tlid')
    //    ->join('reports', 'reports.tid', '=', 'tests.tid')
    //    ->select('users.*', 'tests.*', 'available_tests.*','reports.*')
    //    ->where('tests.done','=', 1)
    //     ->where('users.id','=', $userId)
    //    ->get();


       $allReportData = User::join('patients', 'patients.userID', '=', 'users.id')
       ->join('tests', 'tests.pid', '=', 'patients.pid')
       ->join('available_tests', 'available_tests.tlid', '=', 'tests.tlid')
       ->join('reports', 'reports.tid', '=', 'tests.tid')
       ->join('subcategories', 'subcategories.AvailableTestID', '=', 'available_tests.tlid')
       ->select('*')
       ->where('tests.done','=', 1)
       ->where('users.id','=', $userId)
       ->get();
// dd($allReportData);
       return view('Users.User.home',compact('allReportData','pendingCount','reportCount'));
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
