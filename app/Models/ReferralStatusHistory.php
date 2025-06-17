<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'referral_id',
        'status',
        'previous_status',
        'changed_by_type',
        'changed_by_id',
        'changed_by_name',
        'notes',
    ];

    /**
     * Get the referral that this status history belongs to.
     */
    public function referral()
    {
        return $this->belongsTo(Referral::class);
    }

    /**
     * Get the status icon based on the status
     */
    public function getStatusIconAttribute()
    {
        return match($this->status) {
            'Pending' => 'fas fa-clock',
            'Approved' => 'fas fa-check-circle',
            'Rejected' => 'fas fa-times-circle',
            'No Show' => 'fas fa-exclamation-triangle',
            'Completed' => 'fas fa-check-double',
            default => 'fas fa-circle'
        };
    }

    /**
     * Get the status color based on the status
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'Pending' => 'secondary',
            'Approved' => 'success',
            'Rejected' => 'danger',
            'No Show' => 'warning',
            'Completed' => 'primary',
            default => 'secondary'
        };
    }
}
