<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Hospital;
use App\Models\Specialty;
use App\Models\Consultant;
use App\Models\User;

/**
 * Controller for GP doctors to view profiles of hospitals, specialties, and consultants
 * before making referrals.
 */
class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:gp-doctor');
    }

    /**
     * Show hospital profiles to GP doctors for referral purposes.
     *
     * @return \Illuminate\Http\Response
     */
    public function hospital()
    {
        // Retrieve all hospitals from the database for GPs to browse
        $hospitals = Hospital::all();
        $user = Auth::user();
        $hospital = $user->hospital; // GP's current hospital
        
        return view('doctor.profile.hospital', compact('hospitals', 'hospital'));
    }

    /**
     * Show specialty profiles to GP doctors for referral purposes.
     *
     * @return \Illuminate\Http\Response
     */
    public function specialty()
    {
        // Retrieve all specialties from the database for GPs to browse
        $specialties = Specialty::with('hospital')->get();
        $user = Auth::user();
        $specialty = $user->specialty; // GP's current specialty
        
        return view('doctor.profile.specialty', compact('specialties', 'specialty'));
    }

    /**
     * Show consultant profiles to GP doctors for referral purposes.
     *
     * @return \Illuminate\Http\Response
     */
    public function consultant()
    {
        // Retrieve consultants with their related hospital and specialty data
        $consultants = Consultant::with(['hospital', 'specialty'])->get();
        
        return view('doctor.profile.consultant', [
            'consultants' => $consultants,
            'consultant' => $consultants->first() // Default to first one for single view
        ]);
    }
} 