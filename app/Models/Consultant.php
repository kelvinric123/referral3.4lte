<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'specialty_id',
        'hospital_id',
        'gender',
        'languages',
        'qualifications',
        'experience',
        'bio',
        'email',
        'password',
        'phone',
        'is_active',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'languages' => 'array',
    ];

    /**
     * Get the specialty that the consultant belongs to.
     */
    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    /**
     * Get the hospital that the consultant belongs to.
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
} 