<?php

namespace App\Http\Controllers\Patient;

use App\Helpers\SlotHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function create()
    {
        $doctors = User::where('role', 'doctor')
            ->where('status', 'approved')
            ->with('doctor.specialization')
            ->get();

        return view('patient.appointments.create', compact('doctors'));
    }

    public function book(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string',
        ]);

        $exists = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->exists();

        if ($exists) {
            return back()->with('error', 'This time slot is already booked.');
        }

        Appointment::create([
            'patient_id' => auth()->id(),
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Appointment booked successfully!');
    }

    public function index()
    {
        $appointments = Appointment::where('patient_id', Auth::id())
            ->with('doctor')
            ->latest()
            ->get();

        return view('patient.appointments.index', compact('appointments'));
    }

    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
        ]);

     //helper is used to generate available time slots based on rules — something that can be reused in multiple places
     
        $slots = SlotHelper::generateSlots($request->doctor_id, $request->appointment_date);

        return response()->json($slots);
    }

    public function showAvailableSlots()
    {
        $availabilities = \App\Models\Availability::whereDate('created_at', '>=', now())
            ->with('doctor.user')
            ->orderBy('day_of_week')
            ->get();

        return view('patient.available-slots', compact('availabilities'));
    }
}
