<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultant;
use App\Models\Hospital;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ConsultantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consultants = Consultant::with(['specialty', 'hospital'])->get();
        return view('admin.consultants.index', compact('consultants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hospitals = Hospital::where('is_active', true)->get();
        $specialties = Specialty::where('is_active', true)->get();
        $languages = [
            'English', 'Malay', 'Mandarin', 'Tamil', 'Hindi', 
            'Arabic', 'Japanese', 'Korean', 'French', 'German'
        ];
        
        return view('admin.consultants.create', compact('hospitals', 'specialties', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialty_id' => 'required|exists:specialties,id',
            'hospital_id' => 'required|exists:hospitals,id',
            'gender' => 'required|in:male,female,other',
            'languages' => 'required|array',
            'qualifications' => 'required|string',
            'experience' => 'required|string',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'sometimes|boolean',
        ]);

        // If password is not provided, set the default password
        if (empty($validated['password'])) {
            $validated['password'] = Hash::make('qmed.asia');
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        Consultant::create($validated);

        return redirect()->route('admin.consultants.index')
            ->with('success', 'Consultant created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Consultant $consultant)
    {
        return view('admin.consultants.show', compact('consultant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consultant $consultant)
    {
        $hospitals = Hospital::where('is_active', true)->get();
        $specialties = Specialty::where('is_active', true)->get();
        $languages = [
            'English', 'Malay', 'Mandarin', 'Tamil', 'Hindi', 
            'Arabic', 'Japanese', 'Korean', 'French', 'German'
        ];
        
        return view('admin.consultants.edit', compact('consultant', 'hospitals', 'specialties', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Consultant $consultant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialty_id' => 'required|exists:specialties,id',
            'hospital_id' => 'required|exists:hospitals,id',
            'gender' => 'required|in:male,female,other',
            'languages' => 'required|array',
            'qualifications' => 'required|string',
            'experience' => 'required|string',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'sometimes|boolean',
        ]);

        // If password is provided, hash it, otherwise remove it from the validated data to keep the current password
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $consultant->update($validated);

        return redirect()->route('admin.consultants.index')
            ->with('success', 'Consultant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consultant $consultant)
    {
        $consultant->delete();

        return redirect()->route('admin.consultants.index')
            ->with('success', 'Consultant deleted successfully.');
    }
} 