<?php

namespace App\Http\Controllers\Home;
use App\Models\AvailableTest_New;
use App\Models\Patient;
use App\Models\RequestedTests;

use App\Http\Controllers\Controller;



class homePageController extends Controller
{


    public function index()
    {

        $reports = RequestedTests::all()->count();
        $availableTcount = AvailableTest_New::all()->count();
        $Pcount = Patient::all()->count();

        $allAvialableTest = AvailableTest_New::all();
         //dd($allAvialableTest);
        return view('Home.welcome',compact('availableTcount','reports','Pcount','allAvialableTest'));

    }


    public function register2()
    {

        return view('auth.register');

    }


}
