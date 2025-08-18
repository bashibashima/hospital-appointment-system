<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    /**
     * Show all appointments for doctor
     */
    public function index()
    {
        $appointments = Appointment::with('patient')
            ->where('doctor_id', auth()->id())
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('doctor.dashboard', compact('appointments'));
    }

    /**
     * Accept appointment
     */
    public function accept($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->doctor_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $appointment->status = 'accepted';
        $appointment->save();

        return back()->with('success', 'Appointment accepted successfully!');
    }

    /**
     * Reject appointment
     */
    public function reject($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->doctor_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $appointment->status = 'rejected';
        $appointment->save();

        return back()->with('success', 'Appointment rejected successfully!');
    }

    /**
     * Reschedule appointment
     */
    public function reschedule(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->doctor_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
        ]);

        $appointment->appointment_date = $request->date;
        $appointment->appointment_time = $request->time;
        $appointment->status = 'rescheduled';
        $appointment->save();

        return back()->with('success', 'Appointment rescheduled successfully!');
    }
}
