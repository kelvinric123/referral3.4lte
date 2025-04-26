<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\GP;
use Illuminate\Http\Request;

class GPController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gps = GP::with('clinic')->get();
        return view('admin.gps.index', compact('gps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clinics = Clinic::where('is_active', true)->get();
        $languages = [
            'English', 'Malay', 'Mandarin', 'Tamil', 'Hindi', 
            'Arabic', 'Japanese', 'Korean', 'French', 'German'
        ];
        
        return view('admin.gps.create', compact('clinics', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'clinic_id' => 'required|exists:clinics,id',
            'qualifications' => 'required|string|max:255',
            'years_experience' => 'required|integer|min:0',
            'email' => 'nullable|email|max:255',
            'password' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:male,female,other',
            'languages' => 'required|array',
            'is_active' => 'sometimes|boolean',
        ]);

        GP::create($validated);

        return redirect()->route('admin.gps.index')
            ->with('success', 'GP created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GP $gp)
    {
        return view('admin.gps.show', compact('gp'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GP $gp)
    {
        $clinics = Clinic::where('is_active', true)->get();
        $languages = [
            'English', 'Malay', 'Mandarin', 'Tamil', 'Hindi', 
            'Arabic', 'Japanese', 'Korean', 'French', 'German'
        ];
        
        return view('admin.gps.edit', compact('gp', 'clinics', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GP $gp)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'clinic_id' => 'required|exists:clinics,id',
            'qualifications' => 'required|string|max:255',
            'years_experience' => 'required|integer|min:0',
            'email' => 'nullable|email|max:255',
            'password' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:male,female,other',
            'languages' => 'required|array',
            'is_active' => 'sometimes|boolean',
        ]);

        $gp->update($validated);

        return redirect()->route('admin.gps.index')
            ->with('success', 'GP updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GP $gp)
    {
        $gp->delete();

        return redirect()->route('admin.gps.index')
            ->with('success', 'GP deleted successfully.');
    }
} 