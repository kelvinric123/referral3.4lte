<?php

namespace App\Http\Controllers\Hospital;

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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReferralController extends Controller
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
    public function index(Request $request)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Query builder for referrals
        $query = Referral::with(['specialty', 'consultant'])
            ->where('hospital_id', $hospital->id);
        
        // Apply filters if any
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('specialty_id')) {
            $query->where('specialty_id', $request->specialty_id);
        }
        
        if ($request->filled('referrer_type')) {
            $query->where('referrer_type', $request->referrer_type);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('patient_name', 'like', "%{$search}%")
                  ->orWhere('patient_id', 'like', "%{$search}%")
                  ->orWhere('diagnosis', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        
        // Get referrals with pagination
        $referrals = $query->paginate(10);
        
        // Get specialties for this hospital for the filter
        $specialties = Specialty::where('hospital_id', $hospital->id)
            ->where('is_active', true)
            ->get();
        
        return view('hospital.referrals.index', compact('referrals', 'hospital', 'specialties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Get resources related to this hospital
        $specialties = Specialty::where('hospital_id', $hospital->id)
            ->where('is_active', true)
            ->get();
            
        $consultants = Consultant::where('hospital_id', $hospital->id)
            ->where('is_active', true)
            ->get();
            
        $gps = GP::where('is_active', true)->get();
        $bookingAgents = BookingAgent::where('is_active', true)->get();
        
        $statuses = ['Pending', 'Approved', 'Rejected', 'No Show', 'Completed'];
        
        return view('hospital.referrals.create', compact(
            'hospital',
            'specialties',
            'consultants',
            'gps',
            'bookingAgents',
            'statuses'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_id' => 'required|string|max:30',
            'patient_dob' => 'required|date',
            'patient_contact' => 'required|string|max:20',
            'specialty_id' => 'required|exists:specialties,id',
            'consultant_id' => 'required|exists:consultants,id',
            'referrer_type' => 'required|in:GP,BookingAgent',
            'gp_id' => 'required_if:referrer_type,GP|exists:gps,id|nullable',
            'booking_agent_id' => 'required_if:referrer_type,BookingAgent|exists:booking_agents,id|nullable',
            'preferred_date' => 'required|date',
            'priority' => 'required|in:Normal,Urgent,Emergency',
            'diagnosis' => 'required|string',
            'clinical_history' => 'nullable|string',
            'remarks' => 'nullable|string',
            'status' => 'required|in:Pending,Approved,Rejected,No Show,Completed',
            'documents.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        // Set the hospital ID to the authenticated hospital admin's hospital
        $validated['hospital_id'] = $hospital->id;
        
        // Ensure patient name is stored in uppercase
        $validated['patient_name'] = strtoupper($validated['patient_name']);

        $referral = Referral::create($validated);
        
        // Handle document uploads
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $this->storeDocument($file, $referral);
            }
        }
        
        return redirect()->route('hospital.referrals.index')
            ->with('success', 'Referral created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Referral $referral)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Check if the referral belongs to this hospital
        if ($referral->hospital_id !== $hospital->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $referral->load(['hospital', 'specialty', 'consultant', 'documents']);
        
        if ($referral->referrer_type === 'GP' && $referral->gp_id) {
            $referral->load('gp');
        } elseif ($referral->referrer_type === 'BookingAgent' && $referral->booking_agent_id) {
            $referral->load('bookingAgent');
        }
        
        return view('hospital.referrals.show', compact('referral', 'hospital'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Referral $referral)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Check if the referral belongs to this hospital
        if ($referral->hospital_id !== $hospital->id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Get resources related to this hospital
        $specialties = Specialty::where('hospital_id', $hospital->id)
            ->where('is_active', true)
            ->get();
            
        $consultants = Consultant::where('hospital_id', $hospital->id)
            ->where('is_active', true)
            ->get();
            
        $gps = GP::where('is_active', true)->get();
        $bookingAgents = BookingAgent::where('is_active', true)->get();
        
        $statuses = ['Pending', 'Approved', 'Rejected', 'No Show', 'Completed'];
        
        return view('hospital.referrals.edit', compact(
            'referral',
            'hospital',
            'specialties',
            'consultants',
            'gps',
            'bookingAgents',
            'statuses'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Referral $referral)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Check if the referral belongs to this hospital
        if ($referral->hospital_id !== $hospital->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_id' => 'required|string|max:30',
            'patient_dob' => 'required|date',
            'patient_contact' => 'required|string|max:20',
            'specialty_id' => 'required|exists:specialties,id',
            'consultant_id' => 'required|exists:consultants,id',
            'referrer_type' => 'required|in:GP,BookingAgent',
            'gp_id' => 'required_if:referrer_type,GP|exists:gps,id|nullable',
            'booking_agent_id' => 'required_if:referrer_type,BookingAgent|exists:booking_agents,id|nullable',
            'preferred_date' => 'required|date',
            'priority' => 'required|in:Normal,Urgent,Emergency',
            'diagnosis' => 'required|string',
            'clinical_history' => 'nullable|string',
            'remarks' => 'nullable|string',
            'status' => 'required|in:Pending,Approved,Rejected,No Show,Completed',
            'documents.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        // Set the hospital ID to the authenticated hospital admin's hospital
        $validated['hospital_id'] = $hospital->id;
        
        // Ensure patient name is stored in uppercase
        $validated['patient_name'] = strtoupper($validated['patient_name']);

        $oldStatus = $referral->status;
        $referral->update($validated);
        
        // Handle document uploads
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $this->storeDocument($file, $referral);
            }
        }
        
        // Check if the status has changed
        if ($oldStatus !== $referral->status) {
            $referral->updateLoyaltyPoints();
        }

        return redirect()->route('hospital.referrals.index')
            ->with('success', 'Referral updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Referral $referral)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Check if the referral belongs to this hospital
        if ($referral->hospital_id !== $hospital->id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Delete all associated documents
        foreach ($referral->documents as $document) {
            if (Storage::exists($document->path)) {
                Storage::delete($document->path);
            }
        }
        
        $referral->delete();

        return redirect()->route('hospital.referrals.index')
            ->with('success', 'Referral deleted successfully.');
    }
    
    /**
     * Store a document for a referral.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  \App\Models\Referral  $referral
     * @return \App\Models\Document
     */
    private function storeDocument($file, Referral $referral)
    {
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $type = $file->getMimeType();
        $size = $file->getSize();
        
        // Generate a unique filename
        $name = Str::uuid() . '.' . $extension;
        
        // Store the file
        $path = $file->storeAs('referral_documents', $name, 'public');
        
        // Create a document record
        return Document::create([
            'referral_id' => $referral->id,
            'name' => $name,
            'original_name' => $originalName,
            'path' => $path,
            'type' => $type,
            'size' => $size,
        ]);
    }
} 