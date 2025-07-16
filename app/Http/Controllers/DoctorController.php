<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoctorController extends Controller
{
    //
    public function index()
    {
        return view('doctor.dashboard');
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
}