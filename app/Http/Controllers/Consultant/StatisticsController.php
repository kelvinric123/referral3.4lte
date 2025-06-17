<?php

namespace App\Http\Controllers\Consultant;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\GP;
use App\Models\Referral;
use App\Models\Consultant;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StatisticsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:consultant,super-admin']);
    }

    /**
     * Show the consultant statistics page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get the current consultant
        $consultantId = Auth::user()->consultant_id ?? Auth::user()->id;
        
        // Debug
        Log::info('Consultant Statistics for consultant ID: ' . $consultantId);
        
        // Get consultant-specific statistics
        $stats = [
            // Total referrals assigned to this consultant
            'my_referrals' => Referral::where('consultant_id', $consultantId)->count(),
            
            // Referrals by status
            'completed_referrals' => Referral::where('consultant_id', $consultantId)
                ->where('status', 'Completed')->count(),
                
            'pending_referrals' => Referral::where('consultant_id', $consultantId)
                ->where('status', 'Pending')->count(),
                
            'in_progress_referrals' => Referral::where('consultant_id', $consultantId)
                ->where('status', 'In Progress')->count(),
                
            'cancelled_referrals' => Referral::where('consultant_id', $consultantId)
                ->whereIn('status', ['Rejected', 'No Show', 'Cancelled'])->count(),
            
            // Unique GPs who have referred to this consultant
            'referring_gps' => GP::whereHas('referrals', function($query) use ($consultantId) {
                $query->where('consultant_id', $consultantId);
            })->count(),
            
            // Unique hospitals that have referred to this consultant
            'referring_hospitals' => Hospital::whereHas('referrals', function($query) use ($consultantId) {
                $query->where('consultant_id', $consultantId);
            })->count(),
            
            // This month's referrals
            'this_month_referrals' => Referral::where('consultant_id', $consultantId)
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count(),
        ];
        
        Log::info('Consultant statistics calculated', $stats);

        // Get monthly referral statistics for this consultant
        $monthlyReferrals = $this->getMonthlyReferrals($consultantId);
        
        // Get performance statistics
        $referralsByStatus = $this->getReferralsByStatus($consultantId);
        $topReferringGPs = $this->getTopReferringGPs($consultantId);
        $topReferringHospitals = $this->getTopReferringHospitals($consultantId);

        // Return the view with data
        return view('consultant.statistics', compact(
            'stats', 
            'monthlyReferrals',
            'referralsByStatus',
            'topReferringGPs',
            'topReferringHospitals'
        ));
    }

    /**
     * Get monthly referral statistics for the current year.
     *
     * @param int $consultantId
     * @return array
     */
    private function getMonthlyReferrals($consultantId)
    {
        $months = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
        ];

        $currentYear = date('Y');
        $result = [];
        
        // Initialize months with zero
        foreach ($months as $num => $name) {
            $result[$name] = 0;
        }

        try {
            // Get actual data from the database
            $referrals = Referral::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->where('consultant_id', $consultantId)
                ->whereRaw('YEAR(created_at) = ?', [$currentYear])
                ->groupBy('month')
                ->get();

            // Fill with actual data
            foreach ($referrals as $referral) {
                $monthName = $months[$referral->month] ?? 'Unknown';
                $result[$monthName] = $referral->count;
            }
        } catch (\Exception $e) {
            Log::error('Error getting monthly referrals: ' . $e->getMessage());
        }

        Log::info('Monthly referrals calculated', $result);
        return $result;
    }
    
    /**
     * Get referrals grouped by status.
     *
     * @param int $consultantId
     * @return array
     */
    private function getReferralsByStatus($consultantId)
    {
        try {
            $referrals = Referral::selectRaw('status, COUNT(*) as count')
                ->where('consultant_id', $consultantId)
                ->groupBy('status')
                ->get();
                
            return $referrals;
        } catch (\Exception $e) {
            Log::error('Error getting referrals by status: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get top referring GPs to this consultant.
     *
     * @param int $consultantId
     * @return array
     */
    private function getTopReferringGPs($consultantId)
    {
        try {
            $gps = GP::select('gps.id', 'gps.name', DB::raw('COUNT(referrals.id) as referral_count'))
                ->join('referrals', 'gps.id', '=', 'referrals.gp_id')
                ->where('referrals.consultant_id', $consultantId)
                ->groupBy('gps.id', 'gps.name')
                ->orderBy('referral_count', 'desc')
                ->limit(10)
                ->get();
                
            return $gps;
        } catch (\Exception $e) {
            Log::error('Error getting top referring GPs: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get top referring hospitals to this consultant.
     *
     * @param int $consultantId
     * @return array
     */
    private function getTopReferringHospitals($consultantId)
    {
        try {
            $hospitals = Hospital::select('hospitals.id', 'hospitals.name', DB::raw('COUNT(referrals.id) as referral_count'))
                ->join('referrals', 'hospitals.id', '=', 'referrals.hospital_id')
                ->where('referrals.consultant_id', $consultantId)
                ->groupBy('hospitals.id', 'hospitals.name')
                ->orderBy('referral_count', 'desc')
                ->limit(10)
                ->get();
                
            return $hospitals;
        } catch (\Exception $e) {
            Log::error('Error getting top referring hospitals: ' . $e->getMessage());
            return [];
        }
    }
} 