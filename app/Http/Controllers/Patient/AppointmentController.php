<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User; // Doctor users
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // Show the appointment form
    public function create()
    {
        $doctors = User::where('role', 'doctor')
                        ->where('status', 'approved')
                        ->with('doctor.specialization')
                        ->get();

        return view('patient.appointments.create', compact('doctors'));
    }

    // Store the appointment
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'notes' => 'nullable|string|max:1000',
        ]);

        Appointment::create([
            'patient_id' => Auth::id(),
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return redirect()->route('patient.appointments')->with('success', 'Appointment booked successfully!');
    }

    // Optional: View list of appointments
    public function index()
    {
        $appointments = Appointment::where('patient_id', Auth::id())
                            ->with('doctor')
                            ->latest()
                            ->get();

        return view('patient.appointments.index', compact('appointments'));
    }
}
