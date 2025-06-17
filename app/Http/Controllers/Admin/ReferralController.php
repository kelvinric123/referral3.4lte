<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultant;
use App\Models\GP;
use App\Models\Hospital;
use App\Models\BookingAgent;
use App\Models\Specialty;
use App\Models\Referral;
use App\Models\ReferralStatusHistory;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReferralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Referral::with(['hospital', 'specialty', 'consultant', 'gp', 'bookingAgent']);
        
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
        
        if ($request->filled('consultant_id')) {
            $query->where('consultant_id', $request->input('consultant_id'));
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
        
        return view('admin.referrals.index', compact('referrals', 'hospitals', 'specialties', 'consultants', 'gps', 'bookingAgents'));
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
            'id_type' => 'required|in:ic,passport',
            'patient_dob' => 'required|date',
            'patient_age' => 'required|integer|min:0|max:150',
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
            'status' => 'required|in:Pending',
            'documents.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        // Ensure patient name is stored in uppercase
        $validated['patient_name'] = strtoupper($validated['patient_name']);
        
        // Ensure the status starts as Pending for new referrals
        $validated['status'] = 'Pending';

        $referral = Referral::create($validated);
        
        // Log the referral creation
        $this->logReferralCreation($referral);
        
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
        $referral->load(['hospital', 'specialty', 'consultant', 'documents', 'statusHistories']);
        
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
        $referral->load(['hospital', 'specialty', 'consultant', 'documents', 'statusHistories']);
        
        if ($referral->referrer_type === 'GP' && $referral->gp_id) {
            $referral->load('gp');
        } elseif ($referral->referrer_type === 'BookingAgent' && $referral->booking_agent_id) {
            $referral->load('bookingAgent');
        }
        
        return view('admin.referrals.edit', compact('referral'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Referral $referral)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_id' => 'required|string|max:30',
            'id_type' => 'required|in:ic,passport',
            'patient_dob' => 'required|date',
            'patient_age' => 'required|integer|min:0|max:150',
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
        
        // Check if the status has changed
        if ($oldStatus !== $referral->status) {
            $this->logStatusChange($referral, $oldStatus, $referral->status);
            $referral->updateLoyaltyPoints();
        }
        
        // Handle document uploads
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $this->storeDocument($file, $referral);
            }
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
     * Update the status of a referral.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Referral  $referral
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Referral $referral)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected,No Show,Completed',
            'notes' => 'nullable|string|max:1000',
        ]);

        $oldStatus = $referral->status;
        $newStatus = $validated['status'];
        
        // Validate status flow
        $isValidTransition = false;
        
        switch ($oldStatus) {
            case 'Pending':
                $isValidTransition = in_array($newStatus, ['Approved', 'Rejected']);
                break;
            case 'Approved':
                $isValidTransition = in_array($newStatus, ['Completed', 'No Show']);
                break;
            case 'Rejected':
            case 'Completed':
            case 'No Show':
                // These are final states, no further transitions allowed
                $isValidTransition = false;
                break;
            default:
                // For any other status, allow transition to Pending, Approved, or Rejected
                $isValidTransition = in_array($newStatus, ['Pending', 'Approved', 'Rejected']);
                break;
        }
        
        if (!$isValidTransition) {
            return redirect()->back()->with('error', "Invalid status transition from {$oldStatus} to {$newStatus}. Please follow the proper status flow.");
        }
        
        // Get the current loyalty points count for this referral
        $initialPointsCount = $referral->loyaltyPoints()->count();
        
        $referral->update(['status' => $newStatus]);
        
        // Log the status change
        $this->logStatusChange($referral, $oldStatus, $newStatus, $validated['notes'] ?? null);
        
        $message = 'Referral status updated to ' . $newStatus . ' successfully.';
        
        // Check if the status has changed and update loyalty points
        if ($oldStatus !== $newStatus) {
            $referral->updateLoyaltyPoints();
            
            // Check if new loyalty points were awarded
            $newPointsCount = $referral->loyaltyPoints()->count();
            
            if ($newPointsCount > $initialPointsCount) {
                $latestPoints = $referral->loyaltyPoints()->latest()->first();
                if ($latestPoints) {
                    $message .= ' ' . $latestPoints->points . ' loyalty points were awarded to the referrer.';
                }
            }
        }

        return redirect()->back()->with('success', $message);
    }
    
    /**
     * Upload documents to a referral
     */
    public function uploadDocuments(Request $request, Referral $referral)
    {
        $request->validate([
            'documents.*' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $uploadedCount = 0;
        
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $this->storeDocument($file, $referral);
                $uploadedCount++;
            }
        }

        $message = $uploadedCount > 0 ? 
            "{$uploadedCount} document(s) uploaded successfully." : 
            "No documents were uploaded.";

        return redirect()->route('admin.referrals.show', $referral->id)
            ->with('success', $message);
    }

    /**
     * Send feedback to GP or Booking Agent
     */
    public function sendFeedback(Request $request, Referral $referral)
    {
        $request->validate([
            'admin_feedback' => 'required|string|max:1000',
        ]);

        $referral->update([
            'admin_feedback' => $request->admin_feedback,
            'feedback_sent_at' => now(),
        ]);

        $referrerType = $referral->referrer_type;
        $referrerName = '';
        
        if ($referral->referrer_type === 'GP' && $referral->gp) {
            $referrerName = $referral->gp->name;
        } elseif ($referral->referrer_type === 'BookingAgent' && $referral->bookingAgent) {
            $referrerName = $referral->bookingAgent->name;
        }

        return redirect()->route('admin.referrals.show', $referral->id)
            ->with('success', "Feedback sent successfully to {$referrerType}: {$referrerName}");
    }

    /**
     * Log status change to referral status history
     */
    private function logStatusChange(Referral $referral, $oldStatus, $newStatus, $notes = null)
    {
        $user = auth()->user();
        
        ReferralStatusHistory::create([
            'referral_id' => $referral->id,
            'status' => $newStatus,
            'previous_status' => $oldStatus,
            'changed_by_type' => 'User',
            'changed_by_id' => $user->id,
            'changed_by_name' => $user->name,
            'notes' => $notes,
        ]);
    }

    /**
     * Log the initial referral creation
     */
    private function logReferralCreation(Referral $referral)
    {
        $referrerName = '';
        $referrerType = '';
        
        if ($referral->referrer_type === 'GP' && $referral->gp) {
            $referrerName = $referral->gp->name;
            $referrerType = 'GP Doctor';
        } elseif ($referral->referrer_type === 'BookingAgent' && $referral->bookingAgent) {
            $referrerName = $referral->bookingAgent->name;
            $referrerType = 'Booking Agent';
        }
        
        ReferralStatusHistory::create([
            'referral_id' => $referral->id,
            'status' => 'Created',
            'previous_status' => null,
            'changed_by_type' => $referrerType,
            'changed_by_id' => $referral->referrer_type === 'GP' ? $referral->gp_id : $referral->booking_agent_id,
            'changed_by_name' => $referrerName,
            'notes' => null,
        ]);
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