<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PricePackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'establishment_id',
        'name',
        'description',
        'icon',
        'price',
        'features',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the establishment that owns the price package.
     */
    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    public function bookings()
    {
        return $this->hasMany(booking::class);
    }
}
