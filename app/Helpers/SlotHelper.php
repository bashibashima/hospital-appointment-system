<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Appointment;

class SlotHelper
{
    /**
     * Generate available slots for a doctor on a given date
     */
    public static function getAvailableSlots($doctorId, $date)
{
    $slots = [];

    $startTime = Carbon::createFromTime(9, 0);   // 9:00 AM
    $endTime   = Carbon::createFromTime(17, 0);  // 5:00 PM
    $slotDuration = 15;

    // No Sunday
    if (Carbon::parse($date)->isSunday()) {
        return [];
    }

    // Already booked slots
    $bookedSlots = Appointment::where('doctor_id', $doctorId)
        ->where('appointment_date', $date)
        ->pluck('appointment_time')
        ->toArray();

    $current = $startTime->copy();

    while ($current->lt($endTime)) {

        $slot = $current->format('H:i:s');

        // 🔑 combine DATE + TIME
        $slotDateTime = Carbon::parse($date . ' ' . $slot);

        // Skip booked slots
        if (!in_array($slot, $bookedSlots)) {

            // Skip past datetime (works for today & future)
            if (!$slotDateTime->isPast()) {
                $slots[] = $slot;
            }
        }

        $current->addMinutes($slotDuration);
    }

    return $slots;
}

}
