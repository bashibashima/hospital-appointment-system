<?php

namespace App\Http\Controllers\Patient;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\SlotHelper;
use App\Models\Appointment;
use App\Models\User;
use App\Services\SmsService;

class AppointmentController extends Controller
{
    /**
     * Show all appointments for the logged-in patient
     */
    public function index()
    {
        $appointments = Appointment::where('patient_id', auth()->id())
            ->with(['doctor.doctor.specialization'])
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('patient.appointments.index', compact('appointments'));
    }

    /**
     * Show the appointment booking form
     */
    public function create()
    {
        $doctors = User::where('role', 'doctor')
            ->with('doctor.specialization')
            ->get();

        return view('patient.appointments.create', compact('doctors'));
    }

    /**
     * Fetch available time slots for a selected doctor (AJAX)
     */
   

public function getAvailableSlots(Request $request)
{
    $request->validate([
        'doctor_id' => 'required|exists:users,id',
        'appointment_date' => 'required|date',
    ]);

    $slots = SlotHelper::generateSlots($request->doctor_id, $request->appointment_date);

    // 🕐 Restrict past-time slots for today
    $today = Carbon::today()->format('Y-m-d');
    $selectedDate = $request->appointment_date;

    if ($selectedDate === $today) {
        $currentTime = Carbon::now()->format('H:i');

        // Filter only future slots
        $slots = array_filter($slots, function ($slot) use ($currentTime) {
            return $slot > $currentTime;
        });
    }


     // Optional UX improvement: show message if no slots left
    if (empty($slots)) {
        return response()->json([
            'slots' => [],
            'message' => 'No available slots left for today. Please choose another date.'
        ]);
    }

    // Re-index array (optional)
    $slots = array_values($slots);

    return response()->json(['slots' => $slots]);
}


    /**
     * Book a new appointment and send SMS confirmation
     */
    public function book(Request $request, SmsService $smsService)
    {
        // ✅ Validate booking input
        $request->validate([
            'doctor_id'        => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i:s',
            'notes'            => 'nullable|string',
        ]);

        // ✅ Create appointment (auto-confirmed)
        $appointment = Appointment::create([
            'doctor_id'        => $request->doctor_id,
            'patient_id'       => auth()->id(),
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'notes'            => $request->notes,
            'status'           => 'Confirmed', // 🔥 Auto-confirmed, no doctor approval needed
        ]);

        // ✅ Load doctor and patient relations for SMS
        $appointment->load('doctor', 'patient');

        // ✅ Build confirmation SMS
        $message = "Hello {$appointment->patient->name}, your appointment with Dr. {$appointment->doctor->name} is confirmed on {$appointment->appointment_date} at {$appointment->appointment_time}.";

        // ✅ Send SMS confirmation
        try {
            $smsService->sendSms($appointment->patient->phone, $message);
        } catch (\Exception $e) {
            \Log::error("Twilio SMS failed: " . $e->getMessage());
        }

        // ✅ Redirect back with success message
        return redirect()
            ->route('patient.dashboard')
            ->with('success', 'Appointment booked and SMS sent successfully.');
    }
}
