<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
   public function index()
    {
        $appointments = Auth::user()->appointmentsAsPatient()->with('doctor')->get();

        return view('patient.appointments.index', compact('appointments'));
    }
}
