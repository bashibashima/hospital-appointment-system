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
        //
        Schema::table('availabilities', function (Blueprint $table) {
        if (!Schema::hasColumn('availabilities', 'day_of_week')) {
            $table->enum('day_of_week', [
                'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'
            ])->after('id');
        }

        // Add new columns
        if (!Schema::hasColumn('availabilities', 'start_time')) {
            $table->time('start_time')->nullable()->after('day_of_week');
        }
        if (!Schema::hasColumn('availabilities', 'end_time')) {
            $table->time('end_time')->nullable()->after('start_time');
        }

        // Remove this if you don’t want to drop it:
        if (Schema::hasColumn('availabilities', 'time_slot')) {
            $table->dropColumn('time_slot');
        }
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('availabilities', function (Blueprint $table) {
        $table->dropColumn(['start_time', 'end_time']);
        $table->time('time_slot')->nullable(); // restore if dropped
    });
    }
};
