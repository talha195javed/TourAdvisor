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
        Schema::table('hotels', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('hotels', 'star_rating')) {
                $table->tinyInteger('star_rating')->nullable()->after('description');
            }

            if (!Schema::hasColumn('hotels', 'contact_email')) {
                $table->string('contact_email')->nullable()->after('star_rating');
            }

            if (!Schema::hasColumn('hotels', 'phone')) {
                $table->string('phone')->nullable()->after('contact_email');
            }

            if (!Schema::hasColumn('hotels', 'website')) {
                $table->string('website')->nullable()->after('phone');
            }

            if (!Schema::hasColumn('hotels', 'amenities')) {
                $table->text('amenities')->nullable()->after('website');
            }

            if (!Schema::hasColumn('hotels', 'address')) {
                $table->string('address')->nullable()->after('amenities');
            }

            if (!Schema::hasColumn('hotels', 'city')) {
                $table->string('city')->nullable()->after('address');
            }

            if (!Schema::hasColumn('hotels', 'state')) {
                $table->string('state')->nullable()->after('city');
            }

            if (!Schema::hasColumn('hotels', 'country')) {
                $table->string('country')->nullable()->after('state');
            }

            if (!Schema::hasColumn('hotels', 'postal_code')) {
                $table->string('postal_code')->nullable()->after('country');
            }

            if (!Schema::hasColumn('hotels', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable()->after('postal_code');
            }

            if (!Schema::hasColumn('hotels', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            }

            if (!Schema::hasColumn('hotels', 'room_count')) {
                $table->integer('room_count')->nullable()->after('longitude');
            }

            if (!Schema::hasColumn('hotels', 'check_in_time')) {
                $table->time('check_in_time')->default('14:00:00')->after('room_count');
            }

            if (!Schema::hasColumn('hotels', 'check_out_time')) {
                $table->time('check_out_time')->default('12:00:00')->after('check_in_time');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            // Safe removal - only drop columns that exist
            $columnsToDrop = [
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

            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('hotels', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
