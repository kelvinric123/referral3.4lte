<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoyaltyPointSetting;
use Illuminate\Http\Request;

class LoyaltyPointSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gpSettings = LoyaltyPointSetting::where('entity_type', 'GP')->get();
        $bookingAgentSettings = LoyaltyPointSetting::where('entity_type', 'Booking Agent')->get();
        
        return view('admin.loyalty-points.index', compact('gpSettings', 'bookingAgentSettings'));
    }

    /**
     * Display the form for editing the specified resource.
     */
    public function edit(LoyaltyPointSetting $loyaltyPointSetting)
    {
        $statuses = ['Pending', 'Approved', 'Rejected', 'No Show', 'Completed'];
        $entityTypes = ['GP', 'Booking Agent'];
        
        return view('admin.loyalty-points.edit', compact('loyaltyPointSetting', 'statuses', 'entityTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LoyaltyPointSetting $loyaltyPointSetting)
    {
        $validated = $request->validate([
            'points' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $loyaltyPointSetting->update($validated);

        return redirect()->route('admin.loyalty-point-settings.index')
            ->with('success', 'Loyalty point setting updated successfully.');
    }
} 