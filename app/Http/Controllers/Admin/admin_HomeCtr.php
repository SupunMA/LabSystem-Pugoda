<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User;
use App\Models\Patient;
use App\Models\Test;
use App\Models\AvailableTest;

use Auth;

class admin_HomeCtr extends Controller
{
   //protected $task;


 //Authenticate all Admin routes
    public function __construct()
    {
        $this->middleware('checkAdmin');
       // $this->task = new branches;
    }


//Dashboard
    public function checkAdmin()
    {

        //Cards
        $ClientsCount   =   User::where('users.role',0)->count();
        $TestCount     =   Test::where('tests.done',0)->count();
        $DoctorCount     =   User::where('users.role',2)->count();




        //Report table
        $allReportData = User::join('patients', 'patients.userID', '=', 'users.id')
        ->join('tests', 'tests.pid', '=', 'patients.pid')
        ->join('available_tests', 'available_tests.tlid', '=', 'tests.tlid')
        ->join('reports', 'reports.tid', '=', 'tests.tid')
        ->join('subcategories', 'subcategories.AvailableTestID', '=', 'available_tests.tlid')
        ->select('*')
        ->where('tests.done','=', 1)
        ->get();


        //Get data for pie chart
        $maleP     =   Patient::where('patients.gender','M')->count();
        $femaleP     =   Patient::where('patients.gender','F')->count();
        $otherP     =   Patient::where('patients.gender','O')->count();

        //Get data for Bar chart labels
        $testList = AvailableTest::pluck('AvailableTestName')->toArray();

        $notDoneTestsArray[]=[];
        $DoneTestsArray[]=[];
        //Get data for Bar chart values
        foreach ($testList as $oneTest) {
            $notDoneTest = Test::join('available_tests', 'available_tests.tlid', '=', 'tests.tlid')
            ->select( 'tests.*', 'available_tests.*')
            ->where('tests.done','=', 0)
            ->where('available_tests.AvailableTestName','=', $oneTest)
            ->count();

            $notDoneTestsArray[] = $notDoneTest;

            $DoneTest = Test::join('available_tests', 'available_tests.tlid', '=', 'tests.tlid')
            ->select( 'tests.*', 'available_tests.*')
            ->where('tests.done','=', 1)
            ->where('available_tests.AvailableTestName','=', $oneTest)
            ->count();

            $DoneTestsArray[] = $DoneTest;


        }

        //Get total income
        $total=0;
        foreach ($testList as $oneTest) {
            $allDoneList = Test::join('available_tests', 'available_tests.tlid', '=', 'tests.tlid')
            ->select( 'tests.*', 'available_tests.*')
            ->where('tests.done','=', 1)
            ->where('available_tests.AvailableTestName','=', $oneTest)
            ->get();




            foreach ($allDoneList as $allDoneItem) {
                $total = $total + $allDoneItem->AvailableTestCost;
            }



        }



        return view('Users.Admin.home',compact('ClientsCount','DoctorCount','TestCount','allReportData','testList','maleP','femaleP','otherP','notDoneTestsArray','DoneTestsArray','total'));
    }

}