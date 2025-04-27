<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\GP;
use App\Models\LoyaltyPoint;
use Illuminate\Http\Request;

class GPLoyaltyPointController extends Controller
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
        $gps = GP::with(['clinic'])->get();
        
        // Calculate total loyalty points for each GP
        foreach ($gps as $gp) {
            $gp->totalPoints = LoyaltyPoint::where('pointable_type', 'App\Models\GP')
                ->where('pointable_id', $gp->id)
                ->orderBy('created_at', 'desc')
                ->value('balance') ?? 0;
        }
        
        return view('hospital.gp-loyalty-points.index', compact('gps'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $gp = GP::with(['clinic'])->findOrFail($id);
        
        $loyaltyPoints = LoyaltyPoint::where('pointable_type', 'App\Models\GP')
            ->where('pointable_id', $gp->id)
            ->with('referral')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('hospital.gp-loyalty-points.show', compact('gp', 'loyaltyPoints'));
    }
} 