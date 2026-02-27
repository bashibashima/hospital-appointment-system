<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\SlotHelper;       
use Carbon\Carbon;
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
     * Fetch available slots (AUTO)
     */
    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',

            'date'      => 'required|date',
        ]);

        $slots = SlotHelper::getAvailableSlots(
            $request->doctor_id,
            $request->date
        );

        if (empty($slots)) {
            return response()->json([
                'status'  => false,
                'message' => 'No available slots for this date',
                'slots'   => [],
            ]);
        }

        return response()->json([
            'status' => true,
            'slots'  => $slots,
        ]);
    }

    /**
     * Book a new appointment and send SMS confirmation
     */
    public function book(Request $request, SmsService $smsService)
{
    $request->validate([
        'doctor_id'        => 'required|exists:users,id',
        'appointment_date' => 'required|date',
        'appointment_time' => 'required|date_format:H:i:s',
        'notes'            => 'nullable|string',
    ]);

    $time = Carbon::createFromFormat('H:i:s', $request->appointment_time)
        ->format('H:i:s');

    $exists = Appointment::where('doctor_id', $request->doctor_id)
        ->where('appointment_date', $request->appointment_date)
        ->where('appointment_time', $time)
        ->exists();

    if ($exists) {
        return back()->withErrors('This slot is already booked.');
    }

    $appointment = Appointment::create([
        'doctor_id'        => $request->doctor_id,
        'patient_id'       => auth()->id(),
        'appointment_date' => $request->appointment_date,
        'appointment_time' => $time, // ✅ FIXED
        'notes'            => $request->notes,
        'status'           => 'Confirmed',
    ]);

    try {
        $appointment->load('doctor', 'patient');
        $message = "Hello {$appointment->patient->name}, your appointment with Dr. {$appointment->doctor->name} is confirmed on {$appointment->appointment_date} at {$appointment->appointment_time}.";
        $smsService->sendSms($appointment->patient->phone, $message);
    } catch (\Exception $e) {
        \Log::error("SMS failed: " . $e->getMessage());
    }

    return redirect()
        ->route('patient.dashboard')
        ->with('success', 'Appointment booked successfully.');
}

}
