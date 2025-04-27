<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Consultant;
use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ConsultantLoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/consultant/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the consultant login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.consultant-login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Check if the consultant exists
        $consultant = Consultant::where('email', $request->email)->first();
        
        if (!$consultant) {
            return back()->withErrors([
                'email' => ['These credentials do not match our records.'],
            ]);
        }

        // Check the password
        if (!Hash::check($request->password, $consultant->password)) {
            return back()->withErrors([
                'email' => ['These credentials do not match our records.'],
            ]);
        }

        // Create a user session
        $user = User::where('email', $consultant->email)->first();
        
        if (!$user) {
            // Create a new user if one doesn't exist
            $user = User::create([
                'name' => $consultant->name,
                'email' => $consultant->email,
                'password' => $consultant->password, // Already hashed
                'active' => $consultant->is_active,
            ]);
            
            // Attach the consultant role
            $consultantRole = Role::where('slug', 'consultant')->first();
            if ($consultantRole) {
                $user->roles()->attach($consultantRole->id);
            }
        }

        // Log in the user
        Auth::login($user);
        
        // Update last login timestamp
        $user->update(['last_login_at' => now()]);

        return redirect()->intended($this->redirectTo);
    }
} 