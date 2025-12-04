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
        'client_id',
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
        'payment_method_type',
        'payment_timing',
        'transaction_id',
        'stripe_payment_intent_id',
        'stripe_charge_id',
        'stripe_customer_id',
        'can_edit_before_payment',
        'status',
        'special_requests',
        'admin_notes',
        'visa_required',
        'number_of_visas',
        'visa_price_per_person',
        'total_visa_amount',
        'passport_images',
        'applicant_images',
        'emirates_id_images',
        // Requirements fields
        'full_name_passport',
        'date_of_birth',
        'gender',
        'nationality',
        'passport_number',
        'passport_expiration',
        'passengers_data',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'return_date' => 'date',
        'package_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'visa_required' => 'boolean',
        'visa_price_per_person' => 'decimal:2',
        'total_visa_amount' => 'decimal:2',
        'passport_images' => 'array',
        'applicant_images' => 'array',
        'emirates_id_images' => 'array',
        'date_of_birth' => 'date',
        'passport_expiration' => 'date',
        'passengers_data' => 'array',
        'can_edit_before_payment' => 'boolean',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public static function generateBookingReference()
    {
        do {
            $reference = 'BK' . date('Ymd') . strtoupper(substr(uniqid(), -6));
        } while (self::where('booking_reference', $reference)->exists());

        return $reference;
    }

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
