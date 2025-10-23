<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'visa_price',
        'duration_days',
        'main_image',
        'images',
        'features',
        'category_id',
        'hotel_id',
        'location',
        'transfer_type',
        'departure_airport',
        'arrival_airport',
        'is_active',
    ];

    // Cast features to array and is_active to boolean
    protected $casts = [
        'features' => 'array',
        'images' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'visa_price' => 'decimal:2',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
