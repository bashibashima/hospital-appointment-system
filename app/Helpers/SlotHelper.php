<?php

namespace App\Helpers;

use App\Models\Appointment;
use Carbon\Carbon;

class SlotHelper
{
    public static function generateSlots($doctorId, $date)
    {
        $start = Carbon::parse($date . ' 09:00:00'); // clinic start time
        $end = Carbon::parse($date . ' 17:00:00');   // clinic end time
        $duration = 30; // slot duration in minutes

        $slots = [];
        $appointments = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $date)
            ->get()
            ->keyBy('appointment_time');

        while ($start->lt($end)) {
            $slotStart = $start->copy();
            $slotEnd = $start->copy()->addMinutes($duration);

            $isBooked = $appointments->has($slotStart->format('H:i:s'));

            $slots[] = [
                'start' => $slotStart->format('H:i:s'),
                'end' => $slotEnd->format('H:i:s'),
                'start_display' => $slotStart->format('g:i A'),
                'end_display' => $slotEnd->format('g:i A'),
                'booked' => $isBooked,
            ];

            $start->addMinutes($duration);
        }

        return $slots;
    }
}
