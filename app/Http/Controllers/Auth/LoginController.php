<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request) {
        $credentials = $this->credentials($request);

        // Check if user exists and is active before attempting login
        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if ($user && $user->isInactive()) {
            throw ValidationException::withMessages([
                'email' => ['Your account has been deactivated. Please contact administrator.'],
            ]);
        }

        return $this->guard()->attempt(
            $credentials,
            $request->boolean('remember')
        );
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLoginResponse(Request $request) {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        // Update last login time
        if (Auth::check()) {
            DB::table('users')->where('id', Auth::id())->update(['last_login_at' => now()]);
        }

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }
}
