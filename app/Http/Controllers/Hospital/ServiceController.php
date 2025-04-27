<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
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
        
        // Get services for this hospital
        $services = Service::where('hospital_id', $hospital->id)->get();
        
        return view('hospital.services.index', compact('services', 'hospital'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        return view('hospital.services.create', compact('hospital'));
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
            'cost' => 'nullable|numeric|min:0',
            'duration' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);
        
        // Add hospital_id to the validated data
        $validated['hospital_id'] = $hospital->id;
        
        Service::create($validated);
        
        return redirect()->route('hospital.services.index')
            ->with('success', 'Service created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Check if the service belongs to this hospital
        if ($service->hospital_id !== $hospital->id) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('hospital.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Check if the service belongs to this hospital
        if ($service->hospital_id !== $hospital->id) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('hospital.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Check if the service belongs to this hospital
        if ($service->hospital_id !== $hospital->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'duration' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);
        
        $service->update($validated);
        
        return redirect()->route('hospital.services.index')
            ->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        // Get hospital associated with the logged-in user
        $hospital = Hospital::where('email', Auth::user()->email)->firstOrFail();
        
        // Check if the service belongs to this hospital
        if ($service->hospital_id !== $hospital->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $service->delete();
        
        return redirect()->route('hospital.services.index')
            ->with('success', 'Service deleted successfully.');
    }
} 