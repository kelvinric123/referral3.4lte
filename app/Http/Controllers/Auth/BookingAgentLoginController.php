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

        // Check if a booking agent user exists with this email
        $user = User::where('email', $request->email)->first();

        if (!$user || !$user->hasRole('booking-agent')) {
            throw ValidationException::withMessages([
                'email' => ['No booking agent account found with this email address.'],
            ]);
        }

        // Check if the booking agent is active
        $bookingAgent = BookingAgent::where('email', $request->email)->first();
        if ($bookingAgent && !$bookingAgent->is_active) {
            throw ValidationException::withMessages([
                'email' => ['Your booking agent account is inactive. Please contact the administrator.'],
            ]);
        }

        // Check if the credentials are valid
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            throw ValidationException::withMessages([
                'password' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Update last login timestamp
        $user->last_login_at = now();
        $user->save();

        return redirect()->route('booking.dashboard');
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