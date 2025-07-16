<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// class AppointmentController extends Controller
// {
//    public function index()
//     {
//         $appointments = Auth::user()->appointmentsAsPatient()->with('doctor')->get();

//         return view('patient.appointments.index', compact('appointments'));
//     }
// }


use App\Models\Doctor;
use App\Models\Appointment;
class AppointmentController extends Controller
{
public function index()
{
    $appointments = Appointment::where('patient_id', auth()->id())->get();
    return view('patient.appointments.index', compact('appointments'));
}

public function create()
{
    $doctors = Doctor::all();
    return view('patient.appointments.create', compact('doctors'));
}

public function store(Request $request)
{
    $request->validate([
        'doctor_id' => 'required|exists:doctors,id',
        'appointment_date' => 'required|date',
        'appointment_time' => 'required',
    ]);

    Appointment::create([
        'patient_id' => auth()->id(),
        'doctor_id' => $request->doctor_id,
        'appointment_date' => $request->appointment_date,
        'appointment_time' => $request->appointment_time,
        'status' => 'Pending',
    ]);

    return redirect()->route('patient.dashboard')->with('success', 'Appointment booked!');
}
}