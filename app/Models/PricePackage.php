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
        'is_active',
    ];

    /**
     * Get the establishment that owns the price package.
     */
    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * Get the features for the price package.
     */
    public function features()
    {
        return $this->hasMany(PricePackageFeature::class);
    }
}
