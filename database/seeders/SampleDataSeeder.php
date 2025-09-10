<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ Admin User
        $adminId = DB::table('users')->insertGetId([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2️⃣ Doctor User
        $doctorUserId = DB::table('users')->insertGetId([
            'name' => 'Dr. John Doe',
            'email' => 'doctor@example.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Doctor Profile
        $doctorId = DB::table('doctors')->insertGetId([
            'user_id' => $doctorUserId,
            'specialization_id' => 1, // assumes SpecializationSeeder already ran
            'bio' => 'Experienced physician specializing in cardiology.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3️⃣ Patient User
        $patientId = DB::table('users')->insertGetId([
            'name' => 'Jane Smith',
            'email' => 'patient@example.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4️⃣ Availability for Doctor
        DB::table('availabilities')->insert([
            'doctor_id' => $doctorId,
            'day_of_week' => 'Monday',
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
            'slot_duration' => 30,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 5️⃣ Appointment
        DB::table('appointments')->insert([
            'doctor_id' => $doctorId,
            'patient_id' => $patientId,
            'appointment_date' => now()->addDay()->toDateString(),
            'appointment_time' => '09:30:00',
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
