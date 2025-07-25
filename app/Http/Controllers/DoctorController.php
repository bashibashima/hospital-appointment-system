<?php

namespace App\Http\Controllers;
   use App\Models\Appointment;
use Illuminate\Http\Request;


class DoctorController extends Controller
{
    //
    public function index()
    {
          
    $appointments = Appointment::with('patient')
        ->where('doctor_id', auth()->id()) // Get only current doctor's appointments
        ->latest()
        ->get();

    return view('doctor.dashboard', compact('appointments'));

    }

public function dashboard()
{
    $doctor = auth()->user(); // The logged-in doctor

    $appointments = \App\Models\Appointment::with('patient')
        ->where('doctor_id', $doctor->id)
        ->orderBy('appointment_date', 'desc')
        ->get();

    return view('doctor.dashboard', compact('appointments'));
}


public function acceptAppointment($id)
{
    $appointment = Appointment::findOrFail($id);
    $appointment->status = 'accepted';
    $appointment->save();

    return back()->with('success', 'Appointment accepted successfully.');
}

public function rejectAppointment($id)
{
    $appointment = Appointment::findOrFail($id);
    $appointment->status = 'rejected';
    $appointment->save();

    return back()->with('error', 'Appointment rejected.');
}

public function rescheduleAppointment(Request $request, $id)
{
    $request->validate([
        'date' => 'required|date',
        'time' => 'required',
    ]);

    $appointment = Appointment::findOrFail($id);
    $appointment->appointment_date = $request->date;
    $appointment->appointment_time = $request->time;
    $appointment->status = 'rescheduled';
    $appointment->save();

    return back()->with('success', 'Appointment rescheduled.');
}




}