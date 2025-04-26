<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\GP;
use App\Models\LoyaltyPoint;
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

        // Get all loyalty points for this GP
        $loyaltyPoints = LoyaltyPoint::where('pointable_type', 'App\Models\GP')
            ->where('pointable_id', $gp->id)
            ->with('referral')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        // Get the latest point balance
        $latestPoint = LoyaltyPoint::where('pointable_type', 'App\Models\GP')
            ->where('pointable_id', $gp->id)
            ->orderBy('created_at', 'desc')
            ->first();
            
        $totalPoints = $latestPoint ? $latestPoint->balance : 0;
        
        // Calculate points by status
        $pointsByStatus = LoyaltyPoint::where('pointable_type', 'App\Models\GP')
            ->where('pointable_id', $gp->id)
            ->get()
            ->groupBy('status')
            ->map(function ($items) {
                return $items->sum('points');
            });
            
        // Monthly points breakdown (last 6 months)
        $monthlyPoints = [];
        for ($i = 0; $i < 6; $i++) {
            $date = now()->subMonths($i);
            $monthlyPoints[$date->format('M Y')] = LoyaltyPoint::where('pointable_type', 'App\Models\GP')
                ->where('pointable_id', $gp->id)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('points');
        }
        
        // Reverse so most recent is at the end (for charts)
        $monthlyPoints = array_reverse($monthlyPoints);

        return view('doctor.loyalty-points.index', compact(
            'gp',
            'loyaltyPoints',
            'totalPoints',
            'pointsByStatus',
            'monthlyPoints'
        ));
    }
} 