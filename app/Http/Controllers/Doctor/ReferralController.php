<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Consultant;
use App\Models\GP;
use App\Models\Hospital;
use App\Models\Referral;
use App\Models\Specialty;
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
        $this->middleware(['auth', 'role:gp-doctor']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Find the corresponding GP record for the logged-in user
        $gp = GP::where('email', Auth::user()->email)->first();

        if (!$gp) {
            return redirect()->route('doctor.dashboard')
                ->with('error', 'No GP record found associated with your account.');
        }

        // Get all referrals for this GP
        $referrals = Referral::where('referrer_type', 'GP')
            ->where('gp_id', $gp->id)
            ->with(['hospital', 'specialty', 'consultant'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('doctor.referrals.index', compact('referrals', 'gp'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Find the corresponding GP record for the logged-in user
        $gp = GP::where('email', Auth::user()->email)->first();

        if (!$gp) {
            return redirect()->route('doctor.dashboard')
                ->with('error', 'No GP record found associated with your account.');
        }

        $hospitals = Hospital::where('is_active', true)->get();
        $specialties = Specialty::where('is_active', true)->get();
        $consultants = Consultant::where('is_active', true)->get();
        
        return view('doctor.referrals.create', compact(
            'gp',
            'hospitals',
            'specialties',
            'consultants'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Find the corresponding GP record for the logged-in user
        $gp = GP::where('email', Auth::user()->email)->first();

        if (!$gp) {
            return redirect()->route('doctor.dashboard')
                ->with('error', 'No GP record found associated with your account.');
        }

        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_id' => 'required|string|max:30',
            'patient_dob' => 'required|date',
            'patient_contact' => 'required|string|max:20',
            'hospital_id' => 'required|exists:hospitals,id',
            'specialty_id' => 'required|exists:specialties,id',
            'consultant_id' => 'required|exists:consultants,id',
            'preferred_date' => 'required|date',
            'priority' => 'required|in:Normal,Urgent,Emergency',
            'diagnosis' => 'required|string',
            'clinical_history' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        // Add fixed fields
        $validated['referrer_type'] = 'GP';
        $validated['gp_id'] = $gp->id;
        $validated['status'] = 'Pending';

        $referral = Referral::create($validated);

        // Loyalty points are automatically added via the Referral model's created event

        return redirect()->route('doctor.referrals.index')
            ->with('success', 'Referral created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Referral $referral)
    {
        // Find the corresponding GP record for the logged-in user
        $gp = GP::where('email', Auth::user()->email)->first();

        if (!$gp) {
            return redirect()->route('doctor.dashboard')
                ->with('error', 'No GP record found associated with your account.');
        }

        // Ensure the referral belongs to this GP
        if ($referral->referrer_type !== 'GP' || $referral->gp_id !== $gp->id) {
            return redirect()->route('doctor.referrals.index')
                ->with('error', 'You do not have permission to view this referral.');
        }

        $referral->load(['hospital', 'specialty', 'consultant', 'documents']);
        
        return view('doctor.referrals.show', compact('referral', 'gp'));
    }

    /**
     * Send feedback to Hospital/Consultant for the referral.
     */
    public function sendFeedback(Request $request, Referral $referral)
    {
        // Find the corresponding GP record for the logged-in user
        $gp = GP::where('email', Auth::user()->email)->first();

        if (!$gp) {
            return redirect()->route('doctor.dashboard')
                ->with('error', 'No GP record found associated with your account.');
        }

        // Ensure the referral belongs to this GP
        if ($referral->referrer_type !== 'GP' || $referral->gp_id !== $gp->id) {
            return redirect()->route('doctor.referrals.index')
                ->with('error', 'You do not have permission to send feedback for this referral.');
        }

        $request->validate([
            'gp_feedback' => 'required|string|max:1000',
        ]);

        $referral->update([
            'gp_feedback' => $request->gp_feedback,
            'gp_feedback_sent_at' => now(),
        ]);

        $hospitalName = $referral->hospital->name ?? 'Hospital';
        $consultantName = $referral->consultant->name ?? 'Consultant';

        return redirect()->route('doctor.referrals.show', $referral->id)
            ->with('success', "Feedback sent successfully to {$hospitalName} - {$consultantName}");
    }
} 