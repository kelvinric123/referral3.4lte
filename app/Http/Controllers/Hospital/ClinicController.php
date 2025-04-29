<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicController extends Controller
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
        $clinics = Clinic::all();
        return view('hospital.clinics.index', compact('clinics'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Clinic $clinic)
    {
        return view('hospital.clinics.show', compact('clinic'));
    }

    public function create()
    {
        return view('hospital.clinics.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:clinics,email',
            'is_active' => 'boolean'
        ]);

        Clinic::create($validated);

        return redirect()->route('hospital.clinics.index')
            ->with('success', 'Clinic created successfully.');
    }
} 