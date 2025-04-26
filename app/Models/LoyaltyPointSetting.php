<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyPointSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'entity_type',
        'referral_status',
        'points',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The attributes that should be unique in combination.
     */
    public static function boot()
    {
        parent::boot();
        
        static::saving(function ($model) {
            // Ensure there's only one active setting per entity type and status
            $model->validateUniqueness();
        });
    }

    /**
     * Validate the uniqueness of entity_type and referral_status.
     */
    private function validateUniqueness()
    {
        $exists = self::where('entity_type', $this->entity_type)
            ->where('referral_status', $this->referral_status)
            ->where('id', '!=', $this->id)
            ->exists();

        if ($exists) {
            // You might want to handle this differently in a real application
            // This is a simple implementation for demonstration
            throw new \Exception('A setting for this entity type and referral status already exists.');
        }
    }
} 