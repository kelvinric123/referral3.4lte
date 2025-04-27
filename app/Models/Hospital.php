<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'phone',
        'email',
        'website',
        'password',
        'is_active',
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the specialties for the hospital.
     */
    public function specialties()
    {
        return $this->hasMany(Specialty::class);
    }

    /**
     * Get the consultants for the hospital.
     */
    public function consultants()
    {
        return $this->hasMany(Consultant::class);
    }

    /**
     * Get the services for the hospital.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
