<?php 
namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Appointment;

class SlotHelper
{
    public static function getAvailableSlots($doctorId, $date)
    {
        // ❌ Sunday OFF only
        $day = Carbon::parse($date)->format('l');
        if ($day === 'Sunday') {
            return [];
        }

        // ✅ Default timings for all doctors
        $start = Carbon::parse($date . ' 09:00');
        $end   = Carbon::parse($date . ' 17:00');
        $duration = 15; // minutes

        $slots = [];

        while ($start < $end) {
            $slot = $start->format('H:i');

            // remove booked slots
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
?>