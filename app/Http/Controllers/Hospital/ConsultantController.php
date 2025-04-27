<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Consultant;
use App\Models\Hospital;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultantController extends Controller
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
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Get consultants for this hospital
        $consultants = Consultant::where('hospital_id', $hospital->id)->get();
        
        return view('hospital.consultants.index', compact('consultants', 'hospital'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Get specialties for this hospital
        $specialties = Specialty::where('hospital_id', $hospital->id)->get();
        
        return view('hospital.consultants.create', compact('hospital', 'specialties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialty_id' => 'required|exists:specialties,id',
            'qualification' => 'nullable|string|max:255',
            'years_experience' => 'nullable|integer|min:0',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);
        
        // Verify the specialty belongs to this hospital
        $specialty = Specialty::findOrFail($validated['specialty_id']);
        if ($specialty->hospital_id != $hospital->id) {
            return back()->withErrors(['specialty_id' => 'The selected specialty does not belong to your hospital.']);
        }
        
        // Add hospital_id to the validated data
        $validated['hospital_id'] = $hospital->id;
        
        Consultant::create($validated);
        
        return redirect()->route('hospital.consultants.index')
            ->with('success', 'Consultant created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Consultant $consultant)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Check if the consultant belongs to this hospital
        if ($consultant->hospital_id !== $hospital->id) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('hospital.consultants.show', compact('consultant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consultant $consultant)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Check if the consultant belongs to this hospital
        if ($consultant->hospital_id !== $hospital->id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Get specialties for this hospital
        $specialties = Specialty::where('hospital_id', $hospital->id)->get();
        
        return view('hospital.consultants.edit', compact('consultant', 'specialties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Consultant $consultant)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Check if the consultant belongs to this hospital
        if ($consultant->hospital_id !== $hospital->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialty_id' => 'required|exists:specialties,id',
            'qualification' => 'nullable|string|max:255',
            'years_experience' => 'nullable|integer|min:0',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);
        
        // Verify the specialty belongs to this hospital
        $specialty = Specialty::findOrFail($validated['specialty_id']);
        if ($specialty->hospital_id != $hospital->id) {
            return back()->withErrors(['specialty_id' => 'The selected specialty does not belong to your hospital.']);
        }
        
        $consultant->update($validated);
        
        return redirect()->route('hospital.consultants.index')
            ->with('success', 'Consultant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consultant $consultant)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Check if the consultant belongs to this hospital
        if ($consultant->hospital_id !== $hospital->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $consultant->delete();
        
        return redirect()->route('hospital.consultants.index')
            ->with('success', 'Consultant deleted successfully.');
    }
} 