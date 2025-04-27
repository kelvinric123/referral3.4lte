<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\GP;
use Illuminate\Http\Request;

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
} 