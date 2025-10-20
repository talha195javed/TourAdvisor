<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'package_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_country',
        'customer_address',
        'travel_date',
        'return_date',
        'number_of_adults',
        'number_of_children',
        'number_of_infants',
        'package_price',
        'total_amount',
        'paid_amount',
        'remaining_amount',
        'payment_status',
        'payment_method',
        'transaction_id',
        'status',
        'special_requests',
        'admin_notes',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'return_date' => 'date',
        'package_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
    ];

    // Relationship with Package
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // Generate unique booking reference
    public static function generateBookingReference()
    {
        do {
            $reference = 'BK' . date('Ymd') . strtoupper(substr(uniqid(), -6));
        } while (self::where('booking_reference', $reference)->exists());

        return $reference;
    }

    // Get status badge color
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'cancelled' => 'red',
            'completed' => 'green',
            default => 'gray',
        };
    }

    // Get payment status badge color
    public function getPaymentStatusBadgeColorAttribute()
    {
        return match($this->payment_status) {
            'pending' => 'yellow',
            'partial' => 'orange',
            'paid' => 'green',
            'refunded' => 'red',
            default => 'gray',
        };
    }
}
