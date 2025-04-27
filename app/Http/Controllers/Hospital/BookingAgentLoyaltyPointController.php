<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\BookingAgent;
use App\Models\LoyaltyPoint;
use Illuminate\Http\Request;

class BookingAgentLoyaltyPointController extends Controller
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
        $bookingAgents = BookingAgent::with(['company'])->get();
        
        // Calculate total loyalty points for each booking agent
        foreach ($bookingAgents as $agent) {
            $agent->totalPoints = LoyaltyPoint::where('pointable_type', 'App\Models\BookingAgent')
                ->where('pointable_id', $agent->id)
                ->orderBy('created_at', 'desc')
                ->value('balance') ?? 0;
        }
        
        return view('hospital.booking-agent-loyalty-points.index', compact('bookingAgents'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bookingAgent = BookingAgent::with(['company'])->findOrFail($id);
        
        $loyaltyPoints = LoyaltyPoint::where('pointable_type', 'App\Models\BookingAgent')
            ->where('pointable_id', $bookingAgent->id)
            ->with('referral')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('hospital.booking-agent-loyalty-points.show', compact('bookingAgent', 'loyaltyPoints'));
    }
} 