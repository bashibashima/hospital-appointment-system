<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Appointment;

class SlotHelper
{
    public static function getAvailableSlots($doctorId, $date)
    {
        // ❌ Sunday OFF
        $day = Carbon::parse($date)->format('l');

        if ($day === 'Sunday') {
            return [];
        }

        // Doctor working hours
        $start = Carbon::parse($date . ' 09:00');
        $end   = Carbon::parse($date . ' 17:00');

        $duration = 15; // minutes
        $slots = [];

        while ($start < $end) {

            // ✅ Use H:i:s format
            $slot = $start->format('H:i:s');

            // Check booked slots
            $isBooked = Appointment::where('doctor_id', $doctorId)
                ->where('appointment_date', $date)
                ->where('appointment_time', $slot)
                ->exists();

            if (!$isBooked) {
                $slots[] = $slot;
            }

            $start->addMinutes($duration);
        }

        return $slots;
    }
}