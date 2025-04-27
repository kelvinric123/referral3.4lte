<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\LoyaltyPointSetting;
use Illuminate\Http\Request;

class LoyaltyPointController extends Controller
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
     * Display a listing of the loyalty point settings.
     */
    public function index()
    {
        $gpSettings = LoyaltyPointSetting::where('entity_type', 'GP')->get();
        $bookingAgentSettings = LoyaltyPointSetting::where('entity_type', 'Booking Agent')->get();
        
        return view('hospital.loyalty-points.index', compact('gpSettings', 'bookingAgentSettings'));
    }
} 