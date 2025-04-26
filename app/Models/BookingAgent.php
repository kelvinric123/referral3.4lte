<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingAgent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_id',
        'email',
        'phone',
        'position',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the company that the booking agent belongs to.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the referrals associated with the booking agent.
     */
    public function referrals()
    {
        return $this->hasMany(Referral::class);
    }

    /**
     * Get the loyalty points for the booking agent.
     */
    public function loyaltyPoints()
    {
        return $this->morphMany(LoyaltyPoint::class, 'pointable');
    }
} 