<?php

namespace App\Http\Controllers\Consultant;

use App\Http\Controllers\Controller;
use App\Models\Consultant;
use App\Models\GP;
use App\Models\Hospital;
use App\Models\BookingAgent;
use App\Models\Specialty;
use App\Models\Referral;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:consultant,super-admin']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the current consultant ID from the authenticated user
        $consultantId = $this->getConsultantId();
        
        $query = Referral::with(['hospital', 'specialty', 'consultant', 'gp', 'bookingAgent'])
            ->where('consultant_id', $consultantId);
        
        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        
        if ($request->filled('hospital_id')) {
            $query->where('hospital_id', $request->input('hospital_id'));
        }
        
        if ($request->filled('specialty_id')) {
            $query->where('specialty_id', $request->input('specialty_id'));
        }
        
        if ($request->filled('referrer_type')) {
            $query->where('referrer_type', $request->input('referrer_type'));
            
            // Filter by specific GP or Booking Agent if provided
            if ($request->filled('gp_id') && $request->input('referrer_type') == 'GP') {
                $query->where('gp_id', $request->input('gp_id'));
            }
            
            if ($request->filled('booking_agent_id') && $request->input('referrer_type') == 'BookingAgent') {
                $query->where('booking_agent_id', $request->input('booking_agent_id'));
            }
        }
        
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('patient_name', 'like', "%{$search}%")
                  ->orWhere('patient_id', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }
        
        if ($request->filled('priority')) {
            $query->where('priority', $request->input('priority'));
        }
        
        $referrals = $query->latest()->paginate(10);
        $hospitals = Hospital::where('is_active', true)->get();
        $specialties = Specialty::where('is_active', true)->get();
        $consultants = Consultant::where('is_active', true)->get();
        $gps = GP::where('is_active', true)->get();
        $bookingAgents = BookingAgent::where('is_active', true)->get();
        
        return view('consultant.referrals.index', compact('referrals', 'hospitals', 'specialties', 'consultants', 'gps', 'bookingAgents'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Referral $referral)
    {
        // Check if the referral belongs to the current consultant
        if ($referral->consultant_id != $this->getConsultantId()) {
            abort(403, 'Unauthorized action.');
        }
        
        $referral->load(['hospital', 'specialty', 'consultant', 'documents']);
        
        if ($referral->referrer_type === 'GP' && $referral->gp_id) {
            $referral->load('gp');
        } elseif ($referral->referrer_type === 'BookingAgent' && $referral->booking_agent_id) {
            $referral->load('bookingAgent');
        }
        
        return view('consultant.referrals.show', compact('referral'));
    }

    /**
     * Get the current consultant ID based on the authenticated user.
     */
    private function getConsultantId()
    {
        $user = Auth::user();
        
        // If user is a super-admin, they can potentially impersonate a consultant
        // You might want to add a session/request parameter to handle this
        if ($user->hasRole('super-admin') && request()->has('consultant_id')) {
            return request()->input('consultant_id');
        }
        
        // For actual consultants, we need to find their consultant record
        // Assuming there's a relationship between User and Consultant models
        // You may need to adjust this based on your actual implementation
        $consultant = Consultant::where('email', $user->email)->first();
        
        if (!$consultant) {
            abort(404, 'Consultant profile not found.');
        }
        
        return $consultant->id;
    }
} 