<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    
    public function index()
    {
        $appointments = Auth::user()->appointmentsAsDoctor()->with('doctor')->get();

        return view('doctor.appointments.index', compact('appointments'));
    }
}
