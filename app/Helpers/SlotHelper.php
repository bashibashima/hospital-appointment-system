<?php

namespace App\Helpers;

use App\Models\Availability;
use App\Models\GlobalAvailability;
use App\Models\GlobalTimeSlot;
use App\Models\Appointment;
use Carbon\Carbon;

class SlotHelper
{
    // Main function for generating available slots for a doctor on a given date
    public static function generateSlots($doctorId, $date)
    {
        $dayOfWeek = Carbon::parse($date)->format('l'); // e.g., 'Monday'

        // Step 1: Get doctor-specific availability
        $availabilities = Availability::where('doctor_id', $doctorId)
            ->where('day_of_week', $dayOfWeek)
            ->get();

        // Step 2: If doctor has no availability, fallback to GlobalAvailability table
        if ($availabilities->isEmpty()) {
            $availabilities = GlobalAvailability::where('day_of_week', $dayOfWeek)->get();
        }

        // Step 3: Get already booked times
        $bookedSlots = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $date)
            ->pluck('appointment_time')
            ->toArray(); // ['09:15:00', '11:00:00']

        // Step 4: Generate available time slots
        $availableSlots = [];

        foreach ($availabilities as $slot) {
            $start = Carbon::parse($slot->start_time);
            $end = Carbon::parse($slot->end_time);
            $duration = $slot->slot_duration ?? 15;

            while ($start->lt($end)) {
                $time = $start->format('H:i:s');

                if (!in_array($time, $bookedSlots)) {
                    $availableSlots[] = $time;
                }

                $start->addMinutes($duration);
            }
        }

        return $availableSlots;
    }

    // Optional: used by admin's global configuration (single row model)
    public static function generateGlobalSlots($date)
    {
        $day = Carbon::parse($date)->format('l');
        $config = GlobalTimeSlot::first();

        if (!$config) return [];

        $allowedDays = json_decode($config->days ?? '[]');
        if (!in_array($day, $allowedDays)) return [];

        return self::generateTimeSlots(
            $config->start_time,
            $config->end_time,
            $config->slot_duration
        );
    }

    // Utility method for generating raw slot ranges
    public static function generateTimeSlots($startTime, $endTime, $duration = 15)
    {
        $slots = [];
        $start = Carbon::parse($startTime);
        $end = Carbon::parse($endTime);

        while ($start->copy()->addMinutes($duration)->lte($end)) {
            $slots[] = [
                'start' => $start->format('H:i'),
                'end' => $start->copy()->addMinutes($duration)->format('H:i'),
            ];
            $start->addMinutes($duration);
        }

        return $slots;
    }
}
