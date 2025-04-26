<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingAgent;
use App\Models\Company;
use Illuminate\Http\Request;

class BookingAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookingAgents = BookingAgent::with('company')->get();
        return view('admin.booking-agents.index', compact('bookingAgents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::where('is_active', true)->pluck('name', 'id');
        return view('admin.booking-agents.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        BookingAgent::create($validated);

        return redirect()->route('admin.booking-agents.index')
            ->with('success', 'Booking Agent created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BookingAgent $bookingAgent)
    {
        $bookingAgent->load('company');
        return view('admin.booking-agents.show', compact('bookingAgent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BookingAgent $bookingAgent)
    {
        $companies = Company::where('is_active', true)->pluck('name', 'id');
        return view('admin.booking-agents.edit', compact('bookingAgent', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookingAgent $bookingAgent)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $bookingAgent->update($validated);

        return redirect()->route('admin.booking-agents.index')
            ->with('success', 'Booking Agent updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookingAgent $bookingAgent)
    {
        $bookingAgent->delete();

        return redirect()->route('admin.booking-agents.index')
            ->with('success', 'Booking Agent deleted successfully.');
    }
} 