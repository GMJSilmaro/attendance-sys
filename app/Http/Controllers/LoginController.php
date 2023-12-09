<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    //
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        // Check if the authenticated user has the role of 4
        if ($user->role == 4) {
            $this->guard()->logout();
            $request->session()->invalidate();

            // Redirect back to login with an error message
            return redirect()->route('login')->withErrors(['error' => 'You are not approved yet to become an officer by the admin.']);
        }

        // Redirect to the intended location or the default location
        return redirect()->intended($this->redirectPath());
    }
}
    // }

    // protected function sendFailedLoginResponse(Request $request)
    // {
    //     // Retrieve the user by the provided username
    //     $user = User::where($this->email(), $request->{$this->email()})->first();

    //     // Check if the user exists and has the role of 4
    //     if ($user && $user->role == 4) {
    //         $this->guard()->logout();
    //         $request->session()->invalidate();

    //         // Pass a variable to indicate a popup should be shown
    //         return redirect()->route('login')->with(['showPopup' => true, 'email' => $request->input($this->email())]);

    //     }

    //     return redirect()->route('login')
    //         ->withInput($request->only($this->email(), 'remember'))
    //         ->withErrors([
    //             $this->email() => trans('auth.failed'),
    //             'error' => 'These credentials do not match our records.',
    //         ]);
    // }

    // protected function attemptLogin(Request $request)
    // {
    //     $credentials = $this->credentials($request);

    //     // Perform the default authentication attempt
    //     $attempt = $this->guard()->attempt(
    //         $credentials,
    //         $request->filled('remember')
    //     );

    //     // Check the user's role and handle accordingly
    //     if ($attempt && Auth::user()->role == 4) {
    //         Auth::logout();
    //         return redirect()->route('login')->with('status', 'You are not approved yet to become an officer by the admin.');
    //     }

    //     return $attempt;
    // }
