<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GPReferralProgram;
use App\Models\GP;
use App\Models\GPReferralProgramAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GPReferralProgramParticipationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:super-admin']);
    }

    /**
     * Display a listing of the program participations.
     */
    public function index()
    {
        $programs = GPReferralProgram::orderBy('publish_date', 'desc')->get();
        return view('admin.gp-referral-programs.participation.index', compact('programs'));
    }

    /**
     * Display participation details for a specific program.
     */
    public function show(GPReferralProgram $program)
    {
        $participants = $program->participants()->get();
        $attendees = $program->attendees()->get();
        $gps = GP::where('is_active', true)->get();
        
        return view('admin.gp-referral-programs.participation.show', compact('program', 'participants', 'attendees', 'gps'));
    }

    /**
     * Record GP participation in a program.
     */
    public function recordParticipation(Request $request, GPReferralProgram $program)
    {
        $validator = Validator::make($request->all(), [
            'gp_ids' => 'required|array',
            'gp_ids.*' => 'exists:gps,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        foreach ($request->gp_ids as $gpId) {
            // Check if participation already exists
            $existingParticipation = GPReferralProgramAction::where('gp_id', $gpId)
                ->where('gp_referral_program_id', $program->id)
                ->where('action_type', 'participated')
                ->first();
            
            if (!$existingParticipation) {
                GPReferralProgramAction::create([
                    'gp_id' => $gpId,
                    'gp_referral_program_id' => $program->id,
                    'action_type' => 'participated',
                    'points_awarded' => 0, // No points for participation alone
                ]);
            }
        }

        return redirect()->back()
            ->with('success', 'GP participation recorded successfully.');
    }

    /**
     * Record GP attendance in a program.
     */
    public function recordAttendance(Request $request, GPReferralProgram $program)
    {
        $validator = Validator::make($request->all(), [
            'gp_ids' => 'required|array',
            'gp_ids.*' => 'exists:gps,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        foreach ($request->gp_ids as $gpId) {
            // First ensure participation is recorded
            $existingParticipation = GPReferralProgramAction::where('gp_id', $gpId)
                ->where('gp_referral_program_id', $program->id)
                ->where('action_type', 'participated')
                ->first();
            
            if (!$existingParticipation) {
                GPReferralProgramAction::create([
                    'gp_id' => $gpId,
                    'gp_referral_program_id' => $program->id,
                    'action_type' => 'participated',
                    'points_awarded' => 0,
                ]);
            }
            
            // Check if attendance already exists
            $existingAttendance = GPReferralProgramAction::where('gp_id', $gpId)
                ->where('gp_referral_program_id', $program->id)
                ->where('action_type', 'attended')
                ->first();
            
            if (!$existingAttendance) {
                // Award 40 loyalty points for attendance
                GPReferralProgramAction::create([
                    'gp_id' => $gpId,
                    'gp_referral_program_id' => $program->id,
                    'action_type' => 'attended',
                    'points_awarded' => 40,
                ]);
                
                // Update GP's total loyalty points
                $gp = GP::find($gpId);
                $gp->loyalty_points = $gp->loyalty_points + 40;
                $gp->save();
            }
        }

        return redirect()->back()
            ->with('success', 'GP attendance recorded and loyalty points awarded successfully.');
    }
} 