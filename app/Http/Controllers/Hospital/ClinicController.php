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
} 