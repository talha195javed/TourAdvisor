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
            $table->boolean('visa_required')->default(false)->after('special_requests');
            $table->integer('number_of_visas')->nullable()->after('visa_required');
            $table->decimal('visa_price_per_person', 10, 2)->nullable()->after('number_of_visas');
            $table->decimal('total_visa_amount', 10, 2)->default(0)->after('visa_price_per_person');
            $table->json('passport_images')->nullable()->after('total_visa_amount');
            $table->json('applicant_images')->nullable()->after('passport_images');
            $table->json('emirates_id_images')->nullable()->after('applicant_images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'visa_required',
                'number_of_visas',
                'visa_price_per_person',
                'total_visa_amount',
                'passport_images',
                'applicant_images',
                'emirates_id_images'
            ]);
        });
    }
};
