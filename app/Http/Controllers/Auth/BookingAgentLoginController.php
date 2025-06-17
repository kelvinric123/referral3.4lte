<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\BookingAgent;
use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class BookingAgentLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the booking agent login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.booking-agent-login');
    }

    /**
     * Handle a login request for a booking agent.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Check if a booking agent with this email exists
        $bookingAgent = BookingAgent::where('email', $request->email)->first();

        if (!$bookingAgent) {
            throw ValidationException::withMessages([
                'email' => ['No booking agent account found with this email address.'],
            ]);
        }

        // Check if the password matches (since BookingAgent hashes passwords, we need to check the hash)
        if (!Hash::check($request->password, $bookingAgent->password)) {
            throw ValidationException::withMessages([
                'password' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Check if the booking agent is active
        if (!$bookingAgent->is_active) {
            throw ValidationException::withMessages([
                'email' => ['Your account is inactive. Please contact the administrator.'],
            ]);
        }

        // Find or create a User record for this booking agent
        $user = $this->findOrCreateUserForBookingAgent($bookingAgent);

        // Login the user
        Auth::login($user);

        return redirect()->route('booking.dashboard');
    }

    /**
     * Find or create a User record for a booking agent.
     *
     * @param  \App\Models\BookingAgent  $bookingAgent
     * @return \App\Models\User
     */
    protected function findOrCreateUserForBookingAgent(BookingAgent $bookingAgent)
    {
        // Try to find an existing user with this email
        $user = User::where('email', $bookingAgent->email)->first();

        // If no user exists, create one
        if (!$user) {
            $user = User::create([
                'name' => $bookingAgent->name,
                'email' => $bookingAgent->email,
                'password' => $bookingAgent->password, // Use the already hashed password
                'active' => true,
            ]);

            // Assign booking agent role
            $role = Role::where('slug', 'booking-agent')->first();
            if ($role) {
                $user->roles()->attach($role);
            }
        }

        // Update last login timestamp
        $user->last_login_at = now();
        $user->save();

        return $user;
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }
} 