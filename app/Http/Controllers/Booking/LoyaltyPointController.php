<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\LoyaltyPoint;
use App\Models\BookingAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoyaltyPointController extends Controller
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
     * Display a listing of the loyalty points.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookingAgent = BookingAgent::where('email', Auth::user()->email)->first();
        
        if (!$bookingAgent) {
            return redirect()->route('booking.dashboard')->with('error', 'Booking agent profile not found.');
        }

        // Get loyalty points for this booking agent with referral details
        $loyaltyPoints = LoyaltyPoint::where('pointable_type', 'App\Models\BookingAgent')
            ->where('pointable_id', $bookingAgent->id)
            ->with(['referral.hospital', 'referral.specialty', 'referral.consultant'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Get current balance (latest balance from most recent record)
        $currentBalance = LoyaltyPoint::where('pointable_type', 'App\Models\BookingAgent')
            ->where('pointable_id', $bookingAgent->id)
            ->orderBy('id', 'desc')
            ->value('balance') ?? 0;

        // Calculate total points earned this month
        $pointsThisMonth = LoyaltyPoint::where('pointable_type', 'App\Models\BookingAgent')
            ->where('pointable_id', $bookingAgent->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('points', '>', 0) // Only count positive points
            ->sum('points');

        // Calculate total completed referrals points
        $completedPoints = LoyaltyPoint::where('pointable_type', 'App\Models\BookingAgent')
            ->where('pointable_id', $bookingAgent->id)
            ->where('status', 'Completed')
            ->where('points', '>', 0) // Only count positive points
            ->sum('points');

        // Calculate total approved referrals points
        $approvedPoints = LoyaltyPoint::where('pointable_type', 'App\Models\BookingAgent')
            ->where('pointable_id', $bookingAgent->id)
            ->where('status', 'Approved')
            ->where('points', '>', 0) // Only count positive points
            ->sum('points');

        // Calculate total pending referrals points
        $pendingPoints = LoyaltyPoint::where('pointable_type', 'App\Models\BookingAgent')
            ->where('pointable_id', $bookingAgent->id)
            ->where('status', 'Pending')
            ->where('points', '>', 0) // Only count positive points
            ->sum('points');

        // Get total referrals count
        $totalReferrals = $bookingAgent->referrals()->count();

        return view('booking.loyalty-points.index', compact(
            'loyaltyPoints', 
            'currentBalance', 
            'pointsThisMonth',
            'completedPoints',
            'approvedPoints',
            'pendingPoints',
            'totalReferrals',
            'bookingAgent'
        ));
    }
} 