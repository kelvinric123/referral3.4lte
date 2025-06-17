<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Specialty;
use App\Models\Consultant;
use App\Models\Service;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:booking-agent,super-admin']);
    }

    /**
     * Show hospital profiles.
     *
     * @return \Illuminate\Http\Response
     */
    public function hospital(Request $request)
    {
        $search = $request->get('search');
        
        $hospitals = Hospital::where('is_active', true)
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                           ->orWhere('address', 'like', "%{$search}%")
                           ->orWhere('city', 'like', "%{$search}%");
            })
            ->with(['specialties', 'consultants', 'services'])
            ->orderBy('name')
            ->paginate(12);

        return view('booking.profile.hospital', compact('hospitals', 'search'));
    }

    /**
     * Show specialty profiles.
     *
     * @return \Illuminate\Http\Response
     */
    public function specialty(Request $request)
    {
        $search = $request->get('search');
        
        $specialties = Specialty::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                           ->orWhere('description', 'like', "%{$search}%");
            })
            ->with(['consultants', 'hospital'])
            ->orderBy('name')
            ->paginate(12);

        return view('booking.profile.specialty', compact('specialties', 'search'));
    }

    /**
     * Show consultant profiles.
     *
     * @return \Illuminate\Http\Response
     */
    public function consultant(Request $request)
    {
        $search = $request->get('search');
        $specialtyId = $request->get('specialty_id');
        $hospitalId = $request->get('hospital_id');
        
        $consultants = Consultant::where('is_active', true)
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                           ->orWhere('qualifications', 'like', "%{$search}%")
                           ->orWhere('bio', 'like', "%{$search}%");
            })
            ->when($specialtyId, function ($query, $specialtyId) {
                return $query->where('specialty_id', $specialtyId);
            })
            ->when($hospitalId, function ($query, $hospitalId) {
                return $query->where('hospital_id', $hospitalId);
            })
            ->with(['specialty', 'hospital'])
            ->orderBy('name')
            ->paginate(12);

        // Get all specialties and hospitals for filter dropdowns
        $specialties = Specialty::orderBy('name')->get();
        $hospitals = Hospital::where('is_active', true)->orderBy('name')->get();

        return view('booking.profile.consultant', compact(
            'consultants', 
            'specialties', 
            'hospitals', 
            'search', 
            'specialtyId', 
            'hospitalId'
        ));
    }
} 