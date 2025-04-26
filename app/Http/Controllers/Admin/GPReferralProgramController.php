<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GPReferralProgram;
use App\Models\GP;
use App\Models\GPReferralProgramAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GPReferralProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programs = GPReferralProgram::orderBy('publish_date', 'desc')->paginate(10);
        return view('admin.gp-referral-programs.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gp-referral-programs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'publish_date' => 'required|date',
            'youtube_link' => 'nullable|string|url|max:255',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        GPReferralProgram::create($request->all());

        return redirect()->route('admin.gp-referral-programs.index')
            ->with('success', 'GP Referral Program created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GPReferralProgram $gpReferralProgram)
    {
        return view('admin.gp-referral-programs.show', compact('gpReferralProgram'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GPReferralProgram $gpReferralProgram)
    {
        $participants = $gpReferralProgram->participants()->get();
        $attendees = $gpReferralProgram->attendees()->get();
        $gps = GP::where('is_active', true)->get();
        
        return view('admin.gp-referral-programs.edit', compact('gpReferralProgram', 'participants', 'attendees', 'gps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GPReferralProgram $gpReferralProgram)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'publish_date' => 'required|date',
            'youtube_link' => 'nullable|string|url|max:255',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $gpReferralProgram->update($request->all());

        return redirect()->route('admin.gp-referral-programs.index')
            ->with('success', 'GP Referral Program updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GPReferralProgram $gpReferralProgram)
    {
        $gpReferralProgram->delete();

        return redirect()->route('admin.gp-referral-programs.index')
            ->with('success', 'GP Referral Program deleted successfully.');
    }

    /**
     * Record GP participation in a program.
     */
    public function recordParticipation(Request $request, GPReferralProgram $gpReferralProgram)
    {
        $validated = $request->validate([
            'gp_ids' => 'required|array',
            'gp_ids.*' => 'exists:gps,id',
        ]);
        
        foreach ($validated['gp_ids'] as $gpId) {
            $action = GPReferralProgramAction::firstOrCreate([
                'gp_id' => $gpId,
                'gp_referral_program_id' => $gpReferralProgram->id,
                'action_type' => 'participated',
            ], [
                'points_awarded' => false,
            ]);
            
            // Award loyalty points
            $action->awardPoints();
        }
        
        return redirect()->route('admin.gp-referral-programs.edit', $gpReferralProgram)
            ->with('success', 'GP participation recorded and loyalty points awarded.');
    }
    
    /**
     * Record GP attendance in a program.
     */
    public function recordAttendance(Request $request, GPReferralProgram $gpReferralProgram)
    {
        $validated = $request->validate([
            'gp_ids' => 'required|array',
            'gp_ids.*' => 'exists:gps,id',
        ]);
        
        foreach ($validated['gp_ids'] as $gpId) {
            // First, ensure the GP is marked as participated
            GPReferralProgramAction::firstOrCreate([
                'gp_id' => $gpId,
                'gp_referral_program_id' => $gpReferralProgram->id,
                'action_type' => 'participated',
            ], [
                'points_awarded' => false,
            ])->awardPoints();
            
            // Then mark them as attended
            $action = GPReferralProgramAction::firstOrCreate([
                'gp_id' => $gpId,
                'gp_referral_program_id' => $gpReferralProgram->id,
                'action_type' => 'attended',
            ], [
                'points_awarded' => false,
            ]);
            
            // Award loyalty points
            $action->awardPoints();
        }
        
        return redirect()->route('admin.gp-referral-programs.edit', $gpReferralProgram)
            ->with('success', 'GP attendance recorded and loyalty points awarded.');
    }
}
