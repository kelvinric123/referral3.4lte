<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_name',
        'patient_id',
        'patient_dob',
        'patient_contact',
        'hospital_id',
        'specialty_id',
        'consultant_id',
        'referrer_type',
        'gp_id',
        'booking_agent_id',
        'preferred_date',
        'priority',
        'diagnosis',
        'clinical_history',
        'remarks',
        'status',
    ];

    protected $casts = [
        'patient_dob' => 'date',
        'preferred_date' => 'date',
    ];

    /**
     * Get the hospital associated with the referral.
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    /**
     * Get the specialty associated with the referral.
     */
    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    /**
     * Get the consultant associated with the referral.
     */
    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }

    /**
     * Get the GP associated with the referral.
     */
    public function gp()
    {
        return $this->belongsTo(GP::class);
    }

    /**
     * Get the booking agent associated with the referral.
     */
    public function bookingAgent()
    {
        return $this->belongsTo(BookingAgent::class, 'booking_agent_id');
    }

    /**
     * Get the documents associated with the referral.
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get the loyalty points associated with the referral.
     */
    public function loyaltyPoints()
    {
        return $this->hasMany(LoyaltyPoint::class);
    }

    /**
     * Update loyalty points when status changes.
     */
    public function updateLoyaltyPoints()
    {
        // Determine the entity type and ID
        if ($this->referrer_type === 'GP' && $this->gp_id) {
            $entityType = 'GP';
            $pointable = GP::find($this->gp_id);
        } elseif ($this->referrer_type === 'BookingAgent' && $this->booking_agent_id) {
            $entityType = 'Booking Agent';
            $pointable = BookingAgent::find($this->booking_agent_id);
        } else {
            // No valid referrer found
            return;
        }

        if (!$pointable) {
            return;
        }

        // Find the loyalty point setting for this entity type and status
        $setting = LoyaltyPointSetting::where([
            'entity_type' => $entityType,
            'referral_status' => $this->status,
            'is_active' => true,
        ])->first();

        if (!$setting) {
            return;
        }

        // Get the latest balance for this entity
        $latestPoint = LoyaltyPoint::where('pointable_type', get_class($pointable))
            ->where('pointable_id', $pointable->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $currentBalance = $latestPoint ? $latestPoint->balance : 0;
        $newBalance = $currentBalance + $setting->points;

        // Create a new loyalty point record
        LoyaltyPoint::create([
            'pointable_type' => get_class($pointable),
            'pointable_id' => $pointable->id,
            'referral_id' => $this->id,
            'points' => $setting->points,
            'status' => $this->status,
            'description' => "Points for {$this->status} referral ID: {$this->id}",
            'balance' => $newBalance,
        ]);
    }
} 