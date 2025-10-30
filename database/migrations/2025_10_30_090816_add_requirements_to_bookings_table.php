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
            $table->string('full_name_passport')->nullable()->after('customer_address');
            $table->date('date_of_birth')->nullable()->after('full_name_passport');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('date_of_birth');
            $table->string('nationality')->nullable()->after('gender');
            $table->string('passport_number')->nullable()->after('nationality');
            $table->date('passport_expiration')->nullable()->after('passport_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'full_name_passport',
                'date_of_birth',
                'gender',
                'nationality',
                'passport_number',
                'passport_expiration'
            ]);
        });
    }
};
