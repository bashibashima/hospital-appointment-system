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
        Schema::table('availabilities', function (Blueprint $table) {
            if (!Schema::hasColumn('availabilities', 'day_of_week')) {
                $table->enum('day_of_week', [
                    'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'
                ])->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('availabilities', function (Blueprint $table) {
            if (Schema::hasColumn('availabilities', 'day_of_week')) {
                $table->dropColumn('day_of_week');
            }

            // If you meant to remove a specific column like 'start_time' or 'time_slot', adjust this accordingly:
            // if (Schema::hasColumn('availabilities', 'start_time')) {
            //     $table->dropColumn('start_time');
            // }
        });
    }
};
