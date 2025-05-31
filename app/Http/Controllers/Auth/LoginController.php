<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function redirectTo(){
        if(Auth()->user()->role == 1){
            return route('admin.home');
        }elseif(Auth()->user()->role == 0){
            return route('user.home');
        }
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        $identifier = $request->input('identifier');
        $password = $request->input('password');
        $remember = $request->filled('remember');

        // Determine the type of identifier based on its format
        if (preg_match('/^\d{10}$/', $identifier)) {
            // 10-digit number - Mobile number
            return $this->attemptMobileLogin($identifier, $password, $remember, $request);
        } elseif (preg_match('/^(\d{9}[Vv]|\d{12})$/', $identifier)) {
            // NIC format - either 9 digits followed by V/v or 12 digits
            return $this->attemptNicLogin($identifier, $password, $remember, $request);
        } else {
            // Invalid format
            return redirect()->route('login')
                ->withInput($request->only('identifier', 'remember'))
                ->with('message', 'Invalid ID format. Please use a valid NIC or 10-digit mobile number');
        }
    }

    protected function attemptNicLogin($nic, $password, $remember, $request)
    {
        if (auth()->attempt(['nic' => $nic, 'password' => $password], $remember)) {
            return $this->sendLoginResponse($request);
        }

        return redirect()->route('login')
            ->withInput($request->only('identifier', 'remember'))
            ->with('message', 'NIC or Password is Wrong! Try again');
    }

    protected function attemptMobileLogin($mobile, $password, $remember, $request)
    {
        // Find patient with this mobile number
        $patient = Patient::where('mobile', $mobile)->first();

        if (!$patient) {
            return redirect()->route('login')
                ->withInput($request->only('identifier', 'remember'))
                ->with('message', 'No account found with this phone number');
        }

        // Get the user associated with this patient
        $user = \App\Models\User::find($patient->userID);

        if ($user && Hash::check($password, $user->password)) {
            // Login the user manually
            Auth::login($user, $remember);

            return $this->sendLoginResponse($request);
        }

        return redirect()->route('login')
            ->withInput($request->only('identifier', 'remember'))
            ->with('message', 'Phone Number or Password is Wrong! Try again');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        if (auth()->user()->role == 1) {
            return redirect()->route('admin.home');
        } elseif (auth()->user()->role == 0) {
            return redirect()->route('user.home');
        }
    }
}
