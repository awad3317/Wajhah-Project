<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstablishmentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'icon',
    ];

    public function establishments()
    {
        return $this->hasMany(Establishment::class);
    }

    /**
     * الحصول على المسار الكامل (URL) للأيقونة.
     * هذا الـ accessor سيتم استخدامه عندما تطلب 'full_icon_url' من النموذج.
     * ويمكنك استخدامه في استجابات الـ API.
     *
     * @return string|null
     */
    public function getFullIconUrlAttribute(): ?string
    {
        if ($this->icon) {
            return Storage::disk('public')->url($this->icon);
        }
        return null; 
    }
}
