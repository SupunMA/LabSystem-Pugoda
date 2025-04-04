<?php

namespace App\Http\Controllers\Home;
use App\Models\AvailableTest;
use App\Models\Doctor;
use App\Models\Patient;
use App\Http\Controllers\Controller;



class homePageController extends Controller
{
    
    
    public function index()
    {
        $availableTcount = AvailableTest::all()->count();
        $Dcount = Doctor::all()->count();
        $Pcount = Patient::all()->count();

        $allAvialableTest = AvailableTest::all();
         //dd($allAvialableTest);
        return view('Home.welcome',compact('availableTcount','Dcount','Pcount','allAvialableTest'));
        
    }

    
    public function register2()
    {
       
        return view('auth.register');
        
    }

   
}