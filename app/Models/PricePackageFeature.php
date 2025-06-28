<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PricePackageFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price_package_id',
    ];

    /**
     * Get the price package that owns the feature.
     */
    public function pricePackage()
    {
        return $this->belongsTo(PricePackage::class);
    }
}
