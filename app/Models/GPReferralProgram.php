<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GPReferralProgram extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gp_referral_programs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'publish_date',
        'youtube_link',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'publish_date' => 'date',
        'is_active' => 'boolean',
    ];
    
    /**
     * Get the actions associated with this GP referral program.
     */
    public function actions()
    {
        return $this->hasMany(GPReferralProgramAction::class, 'gp_referral_program_id');
    }
    
    /**
     * Get the GPs who have participated in this program.
     */
    public function participants()
    {
        return $this->belongsToMany(GP::class, 'gp_referral_program_actions')
            ->where('action_type', 'participated')
            ->withTimestamps();
    }
    
    /**
     * Get the GPs who have attended this program.
     */
    public function attendees()
    {
        return $this->belongsToMany(GP::class, 'gp_referral_program_actions')
            ->where('action_type', 'attended')
            ->withTimestamps();
    }
}
