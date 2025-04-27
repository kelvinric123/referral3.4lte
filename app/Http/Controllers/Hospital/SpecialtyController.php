<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpecialtyController extends Controller
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
        
        // Get specialties for this hospital
        $specialties = Specialty::where('hospital_id', $hospital->id)->get();
        
        return view('hospital.specialties.index', compact('specialties', 'hospital'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        return view('hospital.specialties.create', compact('hospital'));
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
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        
        // Add hospital_id to the validated data
        $validated['hospital_id'] = $hospital->id;
        
        Specialty::create($validated);
        
        return redirect()->route('hospital.specialties.index')
            ->with('success', 'Specialty created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialty $specialty)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Check if the specialty belongs to this hospital
        if ($specialty->hospital_id !== $hospital->id) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('hospital.specialties.show', compact('specialty'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialty $specialty)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Check if the specialty belongs to this hospital
        if ($specialty->hospital_id !== $hospital->id) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('hospital.specialties.edit', compact('specialty'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Specialty $specialty)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Check if the specialty belongs to this hospital
        if ($specialty->hospital_id !== $hospital->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        
        $specialty->update($validated);
        
        return redirect()->route('hospital.specialties.index')
            ->with('success', 'Specialty updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialty $specialty)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Check if the specialty belongs to this hospital
        if ($specialty->hospital_id !== $hospital->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $specialty->delete();
        
        return redirect()->route('hospital.specialties.index')
            ->with('success', 'Specialty deleted successfully.');
    }
} 