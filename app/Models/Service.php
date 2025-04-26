<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'cost',
        'duration',
        'hospital_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'cost' => 'decimal:2',
    ];

    /**
     * Get the hospital that the service belongs to.
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
} 