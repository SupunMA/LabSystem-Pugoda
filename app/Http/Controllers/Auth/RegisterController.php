<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use Carbon\Carbon;
use DB;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest','admin');
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'name' => ['required', 'string', 'max:255'],
            // 'email' => ['string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
            // 'address' => ['string'],
            // 'mobile' =>['string'],
            // 'NIC'=>['integer','max:12']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */







    function addingClient(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;

        $user->password = \Hash::make($request->password);
        $user->role = $request->role;

        if( $user->save() ){
            return redirect()->back()->with('message','successful');
        }else{
            return redirect()->back()->with('message','Failed');
        }

    }



    function addingPatient(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'in:M,F,O'],
            'dob' => ['required', 'string', 'date','before:-1 years'],
          'email' => ['nullable', 'email', 'max:255', 'unique:users'],
            'nic' => ['required', 'regex:/^(\d{9}[Vv]|\d{12})$/', 'unique:users','max:15',],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'mobile' =>['string','unique:patients'],
            'address' =>['string']
        ]);


        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->nic = $request->nic;

        $user->password = \Hash::make($request->password);
        $user->role = $request->role;

        $patient = new Patient();
        $patient->mobile = $request->mobile;
       //change the date format
        $formattedDate = Carbon::parse($request->dob)->format('Y-m-d');
        $patient->dob =  $formattedDate;
        $patient->gender = $request->gender;
        $patient->address = $request->address;



            //Getting next Users table ID
            $tableName = 'users';
            $nextId = DB::select("SHOW TABLE STATUS LIKE '$tableName'")[0]->Auto_increment;

            if ($nextId) {
                $patient->userID = $nextId;
            } else {
                return "No users found.";
            }




        if( $user->save() &&  $patient->save()){
            return response()->json(['success' => true, 'message' => 'Patient added successfully']);
        }else{
            //return redirect()->back()->with('message','Failed');
        }

    }




    function addingDoctor(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'in:M,F,O'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'mobile' =>['string','unique:doctors'],
            'clinicName' => ['required', 'string', 'max:255'],
            'clinicAddress' =>['string']
        ]);

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;

        $user->password = \Hash::make($request->password);
        $user->role = $request->role;

        $doctor = new Doctor();
        $doctor->mobile = $request->mobile;
        $doctor->gender = $request->gender;
        $doctor->clinicName = $request->clinicName;
        $doctor->clinicAddress = $request->clinicAddress;

            //Getting next Users table ID
            $tableName = 'users';
            $nextId = DB::select("SHOW TABLE STATUS LIKE '$tableName'")[0]->Auto_increment;

            if ($nextId) {
                $doctor->userID = $nextId;
            } else {
                return "No users found.";
            }



        if( $user->save() &&  $doctor->save()){
            return redirect()->back()->with('message','Doctor was Added Successfully');
        }else{
            //return redirect()->back()->with('message','Failed');
        }
    }
}
