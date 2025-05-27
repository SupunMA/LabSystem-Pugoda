<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User;
use App\Models\Patient;
use App\Models\RequestedTests;
use App\Models\AvailableTest_New;

use Auth;
use DB;
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

        // Get total patients count
        $totalPatients = Patient::count();

        // Get available tests count from database
        $availableTests = AvailableTest_New::count();

        $reportsGenerated = RequestedTestS::where(function($query) {
            $query->whereExists(function ($subquery) {
                    $subquery->select(DB::raw(1))
                        ->from('test_results')
                        ->whereRaw('test_results.requested_test_id = requested_tests.id');
                })
                ->orWhereExists(function ($subquery) {
                    $subquery->select(DB::raw(1))
                        ->from('report_paths')
                        ->whereRaw('report_paths.requested_test_id = requested_tests.id');
                });
        })
        ->count();

                // Get tests needing review (tests that don't have results or reports)
        $requestedTests = RequestedTests::whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('test_results')
                      ->whereRaw('test_results.requested_test_id = requested_tests.id');
            })
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('report_paths')
                      ->whereRaw('report_paths.requested_test_id = requested_tests.id');
            })
            ->count();

         // Get gender distribution for pie chart
        $genderData = Patient::select('gender', DB::raw('count(*) as count'))
            ->whereNotNull('gender')
            ->groupBy('gender')
            ->get()
            ->map(function($item) {
                // Convert M, F, O to readable labels
                if ($item->gender == 'M') {
                    $item->gender = 'Male';
                } elseif ($item->gender == 'F') {
                    $item->gender = 'Female';
                } elseif ($item->gender == 'O') {
                    $item->gender = 'Other';
                }
                return $item;
            });



                // Get most requested tests for donut chart
    $mostRequestedTests = RequestedTests::select('availableTests.name', DB::raw('count(*) as count'))
        ->join('availableTests', 'requested_tests.test_id', '=', 'availableTests.id')
        ->groupBy('requested_tests.test_id', 'availableTests.name')
        ->orderBy('count', 'desc')
        ->limit(5) // Show top 5 most requested tests
        ->get();

    // Get count of other tests (not in top 5)
    $totalTestsCount = RequestedTests::count();
    $topTestsCount = $mostRequestedTests->sum('count');

    // If there are more tests than the top 5, add an "Others" category
    if ($totalTestsCount > $topTestsCount) {
        $mostRequestedTests->push([
            'name' => 'Others',
            'count' => $totalTestsCount - $topTestsCount
        ]);
    }

        return view('Users.Admin.home', compact(
            'totalPatients',
            'availableTests',
            'reportsGenerated',
            'requestedTests',
            'genderData',
            'mostRequestedTests'
        ));

    }
}
