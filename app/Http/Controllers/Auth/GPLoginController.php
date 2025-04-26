<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\GP;
use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class GPLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the GP login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.gp-login');
    }

    /**
     * Handle a login request for a GP.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Check if a GP with this email exists
        $gp = GP::where('email', $request->email)->first();

        if (!$gp) {
            throw ValidationException::withMessages([
                'email' => ['No GP account found with this email address.'],
            ]);
        }

        // Check if the password matches (plain text comparison since we're not using hashed passwords for GPs)
        if ($gp->password !== $request->password) {
            throw ValidationException::withMessages([
                'password' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Check if the GP is active
        if (!$gp->is_active) {
            throw ValidationException::withMessages([
                'email' => ['Your account is inactive. Please contact the administrator.'],
            ]);
        }

        // Find or create a User record for this GP
        $user = $this->findOrCreateUserForGP($gp);

        // Login the user
        Auth::login($user);

        return redirect()->route('doctor.dashboard');
    }

    /**
     * Find or create a User record for a GP.
     *
     * @param  \App\Models\GP  $gp
     * @return \App\Models\User
     */
    protected function findOrCreateUserForGP(GP $gp)
    {
        // Try to find an existing user with this email
        $user = User::where('email', $gp->email)->first();

        // If no user exists, create one
        if (!$user) {
            $user = User::create([
                'name' => $gp->name,
                'email' => $gp->email,
                'password' => Hash::make($gp->password), // Hash the password for the User model
                'active' => true,
            ]);

            // Assign GP Doctor role
            $role = Role::where('slug', 'gp-doctor')->first();
            if ($role) {
                $user->roles()->attach($role);
            }
        }

        // Update last login timestamp
        $user->last_login_at = now();
        $user->save();

        return $user;
    }
} 