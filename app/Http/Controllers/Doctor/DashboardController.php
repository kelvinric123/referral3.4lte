<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\GP;
use App\Models\LoyaltyPoint;
use App\Models\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:gp-doctor,super-admin']);
    }

    /**
     * Show the GP doctor dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // Find the corresponding GP record for the logged-in user
        $gp = GP::where('email', Auth::user()->email)->first();

        if (!$gp) {
            return view('doctor.dashboard');
        }

        // Get recent referrals for this GP
        $recentReferrals = Referral::where('referrer_type', 'GP')
            ->where('gp_id', $gp->id)
            ->with(['hospital', 'specialty', 'consultant'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get loyalty points summary
        $loyaltyPoints = LoyaltyPoint::where('pointable_type', 'App\Models\GP')
            ->where('pointable_id', $gp->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate points by status
        $pointsByStatus = $loyaltyPoints->groupBy('status')
            ->map(function ($items) {
                return $items->sum('points');
            });

        // Get the last loyalty point record to show total balance
        $latestPoint = $loyaltyPoints->first();
        $loyaltyPointsSum = $latestPoint ? $latestPoint->balance : 0;

        // Calculate points earned this month
        $now = now();
        $loyaltyPointsThisMonth = $loyaltyPoints
            ->filter(function ($point) use ($now) {
                return $point->created_at->month == $now->month && 
                       $point->created_at->year == $now->year;
            })
            ->sum('points');

        // Get points by different status
        $completedPoints = $pointsByStatus['Completed'] ?? 0;
        $approvedPoints = $pointsByStatus['Approved'] ?? 0;
        $pendingPoints = $pointsByStatus['Pending'] ?? 0;

        return view('doctor.dashboard', compact(
            'gp',
            'recentReferrals',
            'loyaltyPointsSum',
            'loyaltyPointsThisMonth',
            'completedPoints',
            'approvedPoints',
            'pendingPoints'
        ));
    }
}
