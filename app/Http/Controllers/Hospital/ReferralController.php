<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
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
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Get referrals for this hospital
        $referrals = Referral::whereHas('consultant', function ($query) use ($hospital) {
            $query->where('hospital_id', $hospital->id);
        })->get();
        
        return view('hospital.referrals.index', compact('referrals', 'hospital'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Referral $referral)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Check if the referral belongs to this hospital's consultant
        if ($referral->consultant->hospital_id !== $hospital->id) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('hospital.referrals.show', compact('referral'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Referral $referral)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Check if the referral belongs to this hospital's consultant
        if ($referral->consultant->hospital_id !== $hospital->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'status' => 'required|string|in:pending,approved,rejected,completed',
            'notes' => 'nullable|string',
        ]);
        
        $referral->update($validated);
        
        return redirect()->route('hospital.referrals.index')
            ->with('success', 'Referral updated successfully.');
    }
} 