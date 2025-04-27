<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GP extends Model
{
    use HasFactory;
    
    protected $table = 'gps';

    protected $fillable = [
        'name',
        'clinic_id',
        'qualifications',
        'years_experience',
        'email',
        'password',
        'phone',
        'gender',
        'languages',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'languages' => 'array',
    ];

    /**
     * Get the clinic that the GP belongs to.
     */
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
    
    /**
     * Get the GP referral program actions for this GP.
     */
    public function gpReferralProgramActions()
    {
        return $this->hasMany(GPReferralProgramAction::class, 'gp_id');
    }
    
    /**
     * Get the GP referral programs that this GP has participated in.
     */
    public function participatedPrograms()
    {
        return $this->belongsToMany(GPReferralProgram::class, 'gp_referral_program_actions', 'gp_id', 'gp_referral_program_id')
            ->where('action_type', 'participated')
            ->withTimestamps();
    }
    
    /**
     * Get the GP referral programs that this GP has attended.
     */
    public function attendedPrograms()
    {
        return $this->belongsToMany(GPReferralProgram::class, 'gp_referral_program_actions', 'gp_id', 'gp_referral_program_id')
            ->where('action_type', 'attended')
            ->withTimestamps();
    }
    
    /**
     * Get all loyalty points for this GP.
     */
    public function loyaltyPoints()
    {
        return $this->morphMany(LoyaltyPoint::class, 'pointable');
    }
} 