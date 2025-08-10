<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

class PatientDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Authenticated patient

        // Only eager load 'doctor' because doctor() returns a User model
        $appointments = Appointment::with('doctor')
            ->where('patient_id', $user->id)
            ->latest()
            ->get();

        return view('/patient.dashboard', compact('user', 'appointments'));
    }
}
