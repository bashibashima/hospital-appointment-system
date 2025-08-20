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



    public function updateDoctorData(Request $request, $id)
{
    // Fetch the appointment
    $appointment = Appointment::findOrFail($id);

    // Only the assigned doctor can update
    if (auth()->user()->role !== 'doctor' || $appointment->doctor_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    // Validate inputs
    $request->validate([
        'doctor_symptoms' => 'nullable|string|max:5000',
        'prescriptions'   => 'nullable|string|max:5000',
    ]);

    // Update doctor data
    $appointment->doctor_symptoms = $request->doctor_symptoms;
    $appointment->prescriptions   = $request->prescriptions;

    // Optionally mark as completed
    if ($appointment->status !== 'completed') {
        $appointment->status = 'completed';
    }

    $appointment->save();

    return back()->with('success', 'Doctor symptoms and prescriptions saved successfully.');
}



 

}
