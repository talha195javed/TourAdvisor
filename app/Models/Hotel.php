<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'image_path',
        'description',
        'is_active',
        'star_rating',
        'contact_email',
        'phone',
        'website',
        'amenities',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'latitude',
        'longitude',
        'room_count',
        'check_in_time',
        'check_out_time'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'star_rating' => 'integer',
        'room_count' => 'integer',
        'check_in_time' => 'datetime:H:i',
        'check_out_time' => 'datetime:H:i',
        'amenities' => 'array', // Cast amenities to array
    ];

    // Relationship: a hotel has many packages
    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}
