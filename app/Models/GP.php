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
} 