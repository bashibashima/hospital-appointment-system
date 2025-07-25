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
        Schema::table('appointments', function (Blueprint $table) {
        $table->unsignedBigInteger('patient_id')->nullable()->after('id');
        $table->unsignedBigInteger('doctor_id')->nullable()->after('patient_id');
        $table->date('appointment_date')->nullable()->after('doctor_id');
        $table->time('appointment_time')->nullable()->after('appointment_date');
        $table->text('notes')->nullable()->after('status');

        $table->foreign('patient_id')->references('id')->on('users')->onDelete('set null');
        $table->foreign('doctor_id')->references('id')->on('users')->onDelete('set null');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
