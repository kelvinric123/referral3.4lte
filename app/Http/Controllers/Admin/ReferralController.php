<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultant;
use App\Models\GP;
use App\Models\Hospital;
use App\Models\BookingAgent;
use App\Models\Specialty;
use App\Models\Referral;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReferralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $referrals = Referral::with(['hospital', 'specialty', 'consultant'])->paginate(10);
        $hospitals = Hospital::where('is_active', true)->get();
        $specialties = Specialty::where('is_active', true)->get();
        
        return view('admin.referrals.index', compact('referrals', 'hospitals', 'specialties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hospitals = Hospital::where('is_active', true)->get();
        $specialties = Specialty::with('hospital')->where('is_active', true)->get();
        $consultants = Consultant::with(['specialty', 'hospital'])->where('is_active', true)->get();
        $gps = GP::where('is_active', true)->get();
        $bookingAgents = BookingAgent::where('is_active', true)->get();
        
        $statuses = ['Pending', 'Approved', 'Rejected', 'No Show', 'Completed'];
        
        return view('admin.referrals.create', compact(
            'hospitals',
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
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_id' => 'required|string|max:30',
            'patient_dob' => 'required|date',
            'patient_contact' => 'required|string|max:20',
            'hospital_id' => 'required|exists:hospitals,id',
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

        // Ensure patient name is stored in uppercase
        $validated['patient_name'] = strtoupper($validated['patient_name']);

        $referral = Referral::create($validated);
        
        // Handle document uploads
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $this->storeDocument($file, $referral);
            }
        }
        
        // Loyalty points are automatically added via the Referral model's created event

        return redirect()->route('admin.referrals.index')
            ->with('success', 'Referral created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Referral $referral)
    {
        $referral->load(['hospital', 'specialty', 'consultant', 'documents']);
        
        if ($referral->referrer_type === 'GP' && $referral->gp_id) {
            $referral->load('gp');
        } elseif ($referral->referrer_type === 'BookingAgent' && $referral->booking_agent_id) {
            $referral->load('bookingAgent');
        }
        
        return view('admin.referrals.show', compact('referral'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Referral $referral)
    {
        $hospitals = Hospital::where('is_active', true)->get();
        $specialties = Specialty::with('hospital')->where('is_active', true)->get();
        $consultants = Consultant::with(['specialty', 'hospital'])->where('is_active', true)->get();
        $gps = GP::where('is_active', true)->get();
        $bookingAgents = BookingAgent::where('is_active', true)->get();
        
        $statuses = ['Pending', 'Approved', 'Rejected', 'No Show', 'Completed'];
        
        return view('admin.referrals.edit', compact(
            'referral',
            'hospitals',
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
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_id' => 'required|string|max:30',
            'patient_dob' => 'required|date',
            'patient_contact' => 'required|string|max:20',
            'hospital_id' => 'required|exists:hospitals,id',
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

        return redirect()->route('admin.referrals.index')
            ->with('success', 'Referral updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Referral $referral)
    {
        // Delete all associated documents
        foreach ($referral->documents as $document) {
            if (Storage::exists($document->path)) {
                Storage::delete($document->path);
            }
        }
        
        $referral->delete();

        return redirect()->route('admin.referrals.index')
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