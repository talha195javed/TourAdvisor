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
        Schema::table('bookings', function (Blueprint $table) {
            // Stripe payment fields
            $table->string('stripe_payment_intent_id')->nullable()->after('transaction_id');
            $table->string('stripe_charge_id')->nullable()->after('stripe_payment_intent_id');
            $table->string('stripe_customer_id')->nullable()->after('stripe_charge_id');
            
            // Payment method type: 'stripe', 'cash', 'personal', 'bank_transfer'
            $table->string('payment_method_type')->nullable()->after('payment_method');
            
            // Payment timing: 'now', 'later'
            $table->string('payment_timing')->default('later')->after('payment_method_type');
            
            // Allow editing before payment
            $table->boolean('can_edit_before_payment')->default(true)->after('payment_timing');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_payment_intent_id',
                'stripe_charge_id',
                'stripe_customer_id',
                'payment_method_type',
                'payment_timing',
                'can_edit_before_payment',
            ]);
        });
    }
};
