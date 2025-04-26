<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GP;
use App\Models\LoyaltyPoint;
use Illuminate\Http\Request;

class GPLoyaltyPointController extends Controller
{
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
        
        return view('admin.gp-loyalty-points.index', compact('gps'));
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
        
        return view('admin.gp-loyalty-points.show', compact('gp', 'loyaltyPoints'));
    }
} 