<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        if (Auth::check()) {
            return redirect()->intended();
        }
    }

    public function index()
    {
        return View('auth.index');
    }

    public function showGEWISLogin()
    {
        // TODO: check if user is logged in already
        return redirect()->to(env('GEWISWEB_AUTH_URL'));
    }

    public function doGEWISLogin(Request $request)
    {
        if (Auth::attempt(['jwt_token' => $request->token])) {
            // Authentication passed...
            return redirect()->intended('/');
        }
        dd("failedATtempt");
        //TODO: return some error
    }

    public function showExternalLogin()
    {
        return View('auth.external-login');
    }

    public function doExternalLogin(Request $request)
    {
        if (Auth::attempt([
            'email' => $request->username,
            'password' => $request->password
        ])) {
            return redirect()->intended('/');
        }

        if (Auth::attempt([
            'user_code' => $request->username,
            'password' => $request->password
        ])) {
            return redirect()->intended('/');
        }

        return View('auth.external-login')->with(['error' => 'Invalid username/password']);
    }
}
