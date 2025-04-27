<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HospitalController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:hospital-admin']);
    }

    /**
     * Display the current hospital.
     */
    public function show()
    {
        // Get hospital associated with the logged-in user's email
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        return view('hospital.my-hospital.show', compact('hospital'));
    }

    /**
     * Show the form for editing the hospital.
     */
    public function edit()
    {
        // Get hospital associated with the logged-in user's email
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        return view('hospital.my-hospital.edit', compact('hospital'));
    }

    /**
     * Update the hospital in storage.
     */
    public function update(Request $request)
    {
        // Get hospital associated with the logged-in user's email
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'password' => 'nullable|string|max:255',
        ]);

        // Don't allow changing the email as it's linked to authentication
        unset($validated['email']);
        
        // Keep existing password if not provided
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $hospital->update($validated);

        return redirect()->route('hospital.my-hospital')
            ->with('success', 'Hospital information updated successfully.');
    }
} 