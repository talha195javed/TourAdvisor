<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference')->unique();
            
            // Package Information
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            
            // Customer Information
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('customer_country')->nullable();
            $table->text('customer_address')->nullable();
            
            // Booking Details
            $table->date('travel_date');
            $table->date('return_date')->nullable();
            $table->integer('number_of_adults')->default(1);
            $table->integer('number_of_children')->default(0);
            $table->integer('number_of_infants')->default(0);
            
            // Pricing
            $table->decimal('package_price', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('remaining_amount', 10, 2)->default(0);
            
            // Payment Information
            $table->enum('payment_status', ['pending', 'partial', 'paid', 'refunded'])->default('pending');
            $table->enum('payment_method', ['cash', 'card', 'bank_transfer', 'online'])->nullable();
            $table->string('transaction_id')->nullable();
            
            // Booking Status
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            
            // Special Requests
            $table->text('special_requests')->nullable();
            $table->text('admin_notes')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
