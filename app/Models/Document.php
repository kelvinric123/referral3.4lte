<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'referral_id',
        'name',
        'original_name',
        'path',
        'type',
        'size',
    ];

    /**
     * Get the referral that owns the document.
     */
    public function referral()
    {
        return $this->belongsTo(Referral::class);
    }
}
