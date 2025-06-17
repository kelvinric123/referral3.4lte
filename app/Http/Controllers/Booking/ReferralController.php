<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\Hospital;
use App\Models\Specialty;
use App\Models\Consultant;
use App\Models\BookingAgent;
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
        $this->middleware(['auth', 'role:booking-agent,super-admin']);
    }

    /**
     * Display a listing of the referrals.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookingAgent = BookingAgent::where('email', Auth::user()->email)->first();
        
        if (!$bookingAgent) {
            return redirect()->route('booking.dashboard')->with('error', 'Booking agent profile not found.');
        }
        
        $referrals = Referral::where('booking_agent_id', $bookingAgent->id)
            ->with(['hospital', 'specialty', 'consultant'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('booking.referrals.index', compact('referrals'));
    }

    /**
     * Show the form for creating a new referral.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hospitals = Hospital::where('is_active', true)->orderBy('name')->get();
        $specialties = Specialty::orderBy('name')->get();
        $consultants = Consultant::where('is_active', true)->orderBy('name')->get();

        return view('booking.referrals.create', compact('hospitals', 'specialties', 'consultants'));
    }

    /**
     * Store a newly created referral in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_contact' => 'required|string|max:20',
            'patient_email' => 'nullable|email|max:255',
            'patient_dob' => 'required|date',
            'patient_age' => 'required|integer|min:0|max:150',
            'id_type' => 'required|in:ic,passport',
            'patient_id' => 'required|string|max:50',
            'patient_address' => 'nullable|string',
            'hospital_id' => 'required|exists:hospitals,id',
            'specialty_id' => 'required|exists:specialties,id',
            'consultant_id' => 'required|exists:consultants,id',
            'diagnosis' => 'required|string',
            'clinical_history' => 'nullable|string',
            'remarks' => 'nullable|string',
            'preferred_date' => 'nullable|date|after_or_equal:today',
            'priority' => 'required|in:Normal,Urgent,Emergency',
        ]);

        $bookingAgent = BookingAgent::where('email', Auth::user()->email)->first();

        if (!$bookingAgent) {
            return redirect()->route('booking.dashboard')->with('error', 'Booking agent profile not found.');
        }

        $referral = Referral::create([
            'patient_name' => strtoupper($request->patient_name),
            'patient_contact' => $request->patient_contact,
            'patient_email' => $request->patient_email,
            'patient_dob' => $request->patient_dob,
            'patient_age' => $request->patient_age,
            'id_type' => $request->id_type,
            'patient_id' => $request->patient_id,
            'patient_address' => $request->patient_address,
            'hospital_id' => $request->hospital_id,
            'specialty_id' => $request->specialty_id,
            'consultant_id' => $request->consultant_id,
            'referrer_type' => 'BookingAgent',
            'booking_agent_id' => $bookingAgent->id,
            'diagnosis' => $request->diagnosis,
            'clinical_history' => $request->clinical_history,
            'remarks' => $request->remarks,
            'preferred_date' => $request->preferred_date,
            'priority' => $request->priority,
            'status' => 'Pending',
        ]);

        return redirect()->route('booking.referrals.show', $referral)
            ->with('success', 'Referral created successfully!');
    }

    /**
     * Display the specified referral.
     *
     * @param  \App\Models\Referral  $referral
     * @return \Illuminate\Http\Response
     */
    public function show(Referral $referral)
    {
        $bookingAgent = BookingAgent::where('email', Auth::user()->email)->first();
        
        if (!$bookingAgent) {
            return redirect()->route('booking.dashboard')->with('error', 'Booking agent profile not found.');
        }
        
        // Ensure the booking agent can only view their own referrals
        if ($referral->booking_agent_id !== $bookingAgent->id) {
            abort(403, 'Unauthorized action.');
        }

        $referral->load(['hospital', 'specialty', 'consultant', 'documents', 'statusHistories']);

        return view('booking.referrals.show', compact('referral'));
    }

    /**
     * Show the form for editing the specified referral.
     *
     * @param  \App\Models\Referral  $referral
     * @return \Illuminate\Http\Response
     */
    public function edit(Referral $referral)
    {
        $bookingAgent = BookingAgent::where('email', Auth::user()->email)->first();
        
        if (!$bookingAgent) {
            return redirect()->route('booking.dashboard')->with('error', 'Booking agent profile not found.');
        }
        
        // Ensure the booking agent can only edit their own referrals
        if ($referral->booking_agent_id !== $bookingAgent->id) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow editing if status is Pending
        if ($referral->status !== 'Pending') {
            return redirect()->route('booking.referrals.show', $referral)
                ->with('error', 'Only pending referrals can be edited.');
        }

        $hospitals = Hospital::where('is_active', true)->orderBy('name')->get();
        $specialties = Specialty::orderBy('name')->get();
        $consultants = Consultant::where('is_active', true)->orderBy('name')->get();

        return view('booking.referrals.edit', compact('referral', 'hospitals', 'specialties', 'consultants'));
    }

    /**
     * Update the specified referral in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Referral  $referral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Referral $referral)
    {
        $bookingAgent = BookingAgent::where('email', Auth::user()->email)->first();
        
        if (!$bookingAgent) {
            return redirect()->route('booking.dashboard')->with('error', 'Booking agent profile not found.');
        }
        
        // Ensure the booking agent can only update their own referrals
        if ($referral->booking_agent_id !== $bookingAgent->id) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow updating if status is Pending
        if ($referral->status !== 'Pending') {
            return redirect()->route('booking.referrals.show', $referral)
                ->with('error', 'Only pending referrals can be updated.');
        }

        $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_contact' => 'required|string|max:20',
            'patient_email' => 'nullable|email|max:255',
            'patient_dob' => 'required|date',
            'patient_age' => 'required|integer|min:0|max:150',
            'id_type' => 'required|in:ic,passport',
            'patient_id' => 'required|string|max:50',
            'patient_address' => 'nullable|string',
            'hospital_id' => 'required|exists:hospitals,id',
            'specialty_id' => 'required|exists:specialties,id',
            'consultant_id' => 'required|exists:consultants,id',
            'diagnosis' => 'required|string',
            'clinical_history' => 'nullable|string',
            'remarks' => 'nullable|string',
            'preferred_date' => 'nullable|date|after_or_equal:today',
            'priority' => 'required|in:Normal,Urgent,Emergency',
        ]);

        $referral->update([
            'patient_name' => strtoupper($request->patient_name),
            'patient_contact' => $request->patient_contact,
            'patient_email' => $request->patient_email,
            'patient_dob' => $request->patient_dob,
            'patient_age' => $request->patient_age,
            'id_type' => $request->id_type,
            'patient_id' => $request->patient_id,
            'patient_address' => $request->patient_address,
            'hospital_id' => $request->hospital_id,
            'specialty_id' => $request->specialty_id,
            'consultant_id' => $request->consultant_id,
            'diagnosis' => $request->diagnosis,
            'clinical_history' => $request->clinical_history,
            'remarks' => $request->remarks,
            'preferred_date' => $request->preferred_date,
            'priority' => $request->priority,
        ]);

        return redirect()->route('booking.referrals.show', $referral)
            ->with('success', 'Referral updated successfully!');
    }

    /**
     * Cancel the specified referral.
     *
     * @param  \App\Models\Referral  $referral
     * @return \Illuminate\Http\Response
     */
    public function cancel(Referral $referral)
    {
        $bookingAgent = BookingAgent::where('email', Auth::user()->email)->first();
        
        if (!$bookingAgent) {
            return redirect()->route('booking.dashboard')->with('error', 'Booking agent profile not found.');
        }
        
        // Ensure the booking agent can only cancel their own referrals
        if ($referral->booking_agent_id !== $bookingAgent->id) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow cancelling if status is Pending
        if ($referral->status !== 'Pending') {
            return redirect()->route('booking.referrals.show', $referral)
                ->with('error', 'Only pending referrals can be cancelled.');
        }

        $referral->update(['status' => 'Cancelled']);

        return redirect()->route('booking.referrals.index')
            ->with('success', 'Referral cancelled successfully.');
    }
} 