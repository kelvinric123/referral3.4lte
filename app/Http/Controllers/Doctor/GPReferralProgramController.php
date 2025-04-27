<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\GP;
use App\Models\GPReferralProgram;
use App\Models\GPReferralProgramAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GPReferralProgramController extends Controller
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
        // Get all active programs ordered by publish date
        $programs = GPReferralProgram::where('is_active', true)
            ->orderBy('publish_date', 'desc')
            ->paginate(10);
        
        return view('doctor.gp-referral-programs.index', compact('programs'));
    }

    /**
     * Display the specified resource.
     */
    public function show(GPReferralProgram $gpReferralProgram)
    {
        // Ensure the program is active
        if (!$gpReferralProgram->is_active) {
            return redirect()->route('doctor.gp-referral-programs.index')
                ->with('error', 'The requested program is not available.');
        }
        
        // Get the currently logged-in GP
        $gp = GP::where('email', Auth::user()->email)->first();
        
        if (!$gp) {
            return redirect()->route('doctor.dashboard')
                ->with('error', 'No GP profile found for your account.');
        }
        
        // Check if GP already participated
        $hasParticipated = GPReferralProgramAction::where('gp_id', $gp->id)
            ->where('gp_referral_program_id', $gpReferralProgram->id)
            ->where('action_type', 'participated')
            ->exists();
            
        // Check if GP already attended
        $hasAttended = GPReferralProgramAction::where('gp_id', $gp->id)
            ->where('gp_referral_program_id', $gpReferralProgram->id)
            ->where('action_type', 'attended')
            ->exists();
        
        return view('doctor.gp-referral-programs.show', compact('gpReferralProgram', 'hasParticipated', 'hasAttended'));
    }
    
    /**
     * Mark the GP as participating in the referral program.
     */
    public function participate(GPReferralProgram $gpReferralProgram)
    {
        // Get the currently logged-in GP
        $gp = GP::where('email', Auth::user()->email)->first();
        
        if (!$gp) {
            return redirect()->route('doctor.dashboard')
                ->with('error', 'No GP profile found for your account.');
        }
        
        // Check if already participated
        $action = GPReferralProgramAction::where('gp_id', $gp->id)
            ->where('gp_referral_program_id', $gpReferralProgram->id)
            ->where('action_type', 'participated')
            ->first();
            
        if ($action) {
            return redirect()->route('doctor.gp-referral-programs.show', $gpReferralProgram)
                ->with('info', 'You are already participating in this program.');
        }
        
        // Create participation record
        $action = GPReferralProgramAction::create([
            'gp_id' => $gp->id,
            'gp_referral_program_id' => $gpReferralProgram->id,
            'action_type' => 'participated',
            'points_awarded' => false,
        ]);
        
        // Award the loyalty points
        $action->awardPoints();
        
        return redirect()->route('doctor.gp-referral-programs.show', $gpReferralProgram)
            ->with('success', 'You have successfully registered as a participant in this program and received loyalty points!');
    }
    
    /**
     * Mark the GP as attending the referral program.
     */
    public function attend(GPReferralProgram $gpReferralProgram)
    {
        // Redirect with message explaining that only administrators can mark attendance
        return redirect()->route('doctor.gp-referral-programs.show', $gpReferralProgram)
            ->with('info', 'Attendance can only be recorded by administrators. Please contact them if you attended this program.');
    }
} 