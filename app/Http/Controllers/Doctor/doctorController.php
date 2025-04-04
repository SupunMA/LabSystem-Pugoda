<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;




class doctorController extends Controller
{
    public function checkDoctor()
    {

        $userId = Auth::id();

        //Reports count
        $reportCount = User::join('patients', 'patients.userID', '=', 'users.id')
        ->join('tests', 'tests.pid', '=', 'patients.pid')
        ->join('available_tests', 'available_tests.tlid', '=', 'tests.tlid')
        ->join('reports', 'reports.tid', '=', 'tests.tid')
        ->select('users.*', 'tests.*', 'available_tests.*','reports.*')
        ->where('tests.done','=', 1)
        ->count();

        //pending count
        $pendingCount = User::join('patients', 'patients.userID', '=', 'users.id')
        ->join('tests', 'tests.pid', '=', 'patients.pid')
        ->join('available_tests', 'available_tests.tlid', '=', 'tests.tlid')
        ->join('reports', 'reports.tid', '=', 'tests.tid')
        ->select('users.*', 'tests.*', 'available_tests.*','reports.*')
        ->where('tests.done','=', 0)
        ->count();

       //all done test with other tables
    //    $allReportData = User::join('patients', 'patients.userID', '=', 'users.id')
    //    ->join('tests', 'tests.pid', '=', 'patients.pid')
    //    ->join('available_tests', 'available_tests.tlid', '=', 'tests.tlid')
    //    ->join('reports', 'reports.tid', '=', 'tests.tid')
    //    ->select('users.*', 'tests.*', 'available_tests.*','reports.*')
    //    ->where('tests.done','=', 1)

    //    ->get();


       $allReportData = User::join('patients', 'patients.userID', '=', 'users.id')
       ->join('tests', 'tests.pid', '=', 'patients.pid')
       ->join('available_tests', 'available_tests.tlid', '=', 'tests.tlid')
       ->join('reports', 'reports.tid', '=', 'tests.tid')
       ->join('subcategories', 'subcategories.AvailableTestID', '=', 'available_tests.tlid')
       ->select('*')
       ->where('tests.done','=', 1)
       ->get();

       return view('Users.Doctor.home',compact('allReportData','pendingCount','reportCount'));
    }


    public function deleteUser($ID)
    {
        //dd($ID);
        $delete = User::find($ID);
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
        return view('Users.Doctor.invoice-print',compact('viewReportData'));
    }
}
