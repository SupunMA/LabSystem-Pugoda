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
    try {
        // Clean the phone number if mobile exists
        if ($request->filled('mobile')) {
            $cleanedMobile = preg_replace('/[^0-9]/', '', $request->mobile);
            $request->merge(['mobile' => $cleanedMobile]);
        }

        // Custom validation for either NIC or mobile
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'in:M,F,O'],
            'dob' => ['required', 'date'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users'],
            'nic' => [
                'required_without:mobile',
                'nullable',
                'regex:/^(\d{9}[Vv]|\d{12})$/',
                'unique:users',
                'max:15'
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'mobile' => [
                'required_without:nic',
                'nullable',
                'string',
                'unique:patients',
                'max:15'
            ],
            'address' => ['nullable', 'string'],
            'role' => ['required', 'string']
        ], [
            'nic.required_without' => 'Either NIC or Mobile number must be provided',
            'nic.regex' => 'NIC format is invalid (9 digits with V or 12 digits)',
        ]);

        // Manually check that at least one field is present
        if (!$request->filled('nic') && !$request->filled('mobile')) {
            $validator->errors()->add('nic', 'Either NIC or Mobile number must be provided');
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $validatedData = $validator->validate();

        DB::beginTransaction();

        // Create user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'] ?? null,
            'nic' => $validatedData['nic'] ?? null,
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role']
        ]);

        // Create patient
        $patient = Patient::create([
            'userID' => $user->id,
            'mobile' => $validatedData['mobile'] ?? null,
            'dob' => Carbon::parse($validatedData['dob'])->format('Y-m-d'),
            'gender' => $validatedData['gender'],
            'address' => $validatedData['address'] ?? null
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Patient added successfully',
            'data' => [
                'user' => $user,
                'patient' => $patient
            ]
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation error',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Failed to add patient',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
