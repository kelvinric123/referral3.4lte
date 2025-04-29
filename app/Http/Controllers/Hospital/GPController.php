<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\GP;
use Illuminate\Http\Request;
use App\Models\Clinic;

class GPController extends Controller
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
        $gps = GP::with('clinic')->get();
        return view('hospital.gps.index', compact('gps'));
    }

    /**
     * Display the specified resource.
     */
    public function show(GP $gp)
    {
        return view('hospital.gps.show', compact('gp'));
    }

    public function create()
    {
        $clinics = Clinic::where('is_active', true)->get();
        return view('hospital.gps.create', compact('clinics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:gps,email',
            'phone' => 'nullable|string|max:20',
            'clinic_id' => 'nullable|exists:clinics,id',
            'years_experience' => 'nullable|integer|min:0',
            'qualifications' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        GP::create($validated);

        return redirect()->route('hospital.gps.index')
            ->with('success', 'GP Doctor created successfully.');
    }
} 