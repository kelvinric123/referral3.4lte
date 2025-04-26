<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specialties = Specialty::with('hospital')->get();
        return view('admin.specialties.index', compact('specialties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hospitals = Hospital::where('is_active', true)->get();
        return view('admin.specialties.create', compact('hospitals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'hospital_id' => 'required|exists:hospitals,id',
            'is_active' => 'sometimes|boolean',
        ]);

        Specialty::create($validated);

        return redirect()->route('admin.specialties.index')
            ->with('success', 'Specialty created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialty $specialty)
    {
        return view('admin.specialties.show', compact('specialty'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialty $specialty)
    {
        $hospitals = Hospital::where('is_active', true)->get();
        return view('admin.specialties.edit', compact('specialty', 'hospitals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Specialty $specialty)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'hospital_id' => 'required|exists:hospitals,id',
            'is_active' => 'sometimes|boolean',
        ]);

        $specialty->update($validated);

        return redirect()->route('admin.specialties.index')
            ->with('success', 'Specialty updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialty $specialty)
    {
        $specialty->delete();

        return redirect()->route('admin.specialties.index')
            ->with('success', 'Specialty deleted successfully.');
    }
} 