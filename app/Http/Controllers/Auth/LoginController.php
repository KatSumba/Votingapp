<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Notifications\OtpNotification;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Responses\LoginResponse as FortifyLoginResponse;


class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        // Check if the user has 2FA enabled
        if ($user->two_factor_secret) {
            // If 2FA is enabled, generate and send OTP
            $user->notify(new OtpNotification);
            // return redirect()->route('two-factor.login');
            return view('auth.two-factor-challenge');
            // return app(LoginResponse::class);
            // return response()->json(['message' => 'Two-factor challenge initiated']);

        }
        
        // Continue with the default authentication logic
        return redirect()->intended($this->redirectPath());
    }
}
