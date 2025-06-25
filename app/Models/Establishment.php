<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Establishment extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'type_id',
        'region_id',
        'name',
        'description',
        'primary_image',
        'latitude',
        'longitude',
        'is_verified',
        'is_active'
    ];

    // Relationship with owner (User)
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // Relationship with establishment type
    public function type()
    {
        return $this->belongsTo(EstablishmentType::class, 'type_id');
    }

    // Relationship with region
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    // Relationship with images
    public function images()
    {
        return $this->hasMany(EstablishmentImage::class);
    }

    public function features()
    {
        return $this->hasMany(EstablishmentFeature::class);
    }
}
