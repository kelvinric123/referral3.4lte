<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GPReferralProgramAction extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'g_p_referral_program_actions';

    protected $fillable = [
        'gp_id',
        'gp_referral_program_id',
        'action_type',
        'points_awarded',
    ];

    protected $casts = [
        'points_awarded' => 'boolean',
    ];

    /**
     * Get the GP that performed this action.
     */
    public function gp()
    {
        return $this->belongsTo(GP::class);
    }

    /**
     * Get the GP referral program related to this action.
     */
    public function gpReferralProgram()
    {
        return $this->belongsTo(GPReferralProgram::class);
    }

    /**
     * Award loyalty points to a GP for this action if not already awarded.
     */
    public function awardPoints()
    {
        // If points have already been awarded, don't award them again
        if ($this->points_awarded) {
            return;
        }

        // Find the GP
        $gp = GP::find($this->gp_id);
        if (!$gp) {
            return;
        }

        // Determine the loyalty point status based on action type
        $status = $this->action_type === 'participated' 
            ? 'GP Referral Program Participated' 
            : 'GP Referral Program Attended';

        // Find the loyalty point setting for this status
        $setting = LoyaltyPointSetting::where([
            'entity_type' => 'GP',
            'referral_status' => $status,
            'is_active' => true,
        ])->first();

        if (!$setting) {
            return;
        }

        // Get the latest balance for this GP
        $latestPoint = LoyaltyPoint::where('pointable_type', GP::class)
            ->where('pointable_id', $gp->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $currentBalance = $latestPoint ? $latestPoint->balance : 0;
        $newBalance = $currentBalance + $setting->points;

        // Create a new loyalty point record
        LoyaltyPoint::create([
            'pointable_type' => GP::class,
            'pointable_id' => $gp->id,
            'referral_id' => null, // No referral associated with this
            'points' => $setting->points,
            'status' => $status,
            'description' => $setting->description,
            'balance' => $newBalance,
        ]);

        // Mark points as awarded
        $this->update(['points_awarded' => true]);
    }
}
