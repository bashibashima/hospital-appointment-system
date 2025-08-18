<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\SlotHelper;
use App\Models\Appointment;
use App\Models\User;

class AppointmentController extends Controller
{



    public function index()
{
    $appointments = Appointment::where('patient_id', auth()->id())
        ->with(['doctor.doctor.specialization'])
        ->orderBy('appointment_date', 'asc')
        ->get();

    return view('patient.appointments.index', compact('appointments'));
}

    // Show booking page
    public function create()
    {
        
$doctors = \App\Models\User::where('role', 'doctor')
    ->with('doctor.specialization')
    ->get();




        return view('patient.appointments.create', compact('doctors'));
    }

    // Fetch available slots (AJAX)
    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
        ]);

        $slots = SlotHelper::generateSlots($request->doctor_id, $request->appointment_date);

        return response()->json(['slots' => $slots]);
    }

    // Store appointment
    public function book(Request $request)
    {
        

        $request->validate([
    'doctor_id'        => 'required|exists:users,id',
    'appointment_date' => 'required|date',
    'appointment_time' => 'required|date_format:H:i:s', // ensure correct format
    'notes'            => 'nullable|string'
]);


        Appointment::create([
            'doctor_id'        => $request->doctor_id,
            'patient_id'       => auth()->id(),
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time, // Stored in 24-hour format
            'notes'            => $request->notes
        ]);

        return redirect()->route('patient.dashboard')->with('success', 'Appointment booked successfully.');
    }
}
