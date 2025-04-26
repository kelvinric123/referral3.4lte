<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'pointable_id',
        'pointable_type',
        'referral_id',
        'points',
        'status',
        'description',
        'balance',
    ];

    /**
     * Get the parent pointable model (GP or BookingAgent).
     */
    public function pointable()
    {
        return $this->morphTo();
    }

    /**
     * Get the referral associated with the loyalty point transaction.
     */
    public function referral()
    {
        return $this->belongsTo(Referral::class);
    }
} 