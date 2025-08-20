<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Availability;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        $doctorId = Auth::user()->id;

        // Auto-mark past accepted appointments as completed
        Appointment::where('doctor_id', $doctorId)
            ->where('status', 'accepted')
            ->whereDate('appointment_date', '<', today())
            ->update(['status' => 'completed']);

        // Stats
        $totalAppointments = Appointment::where('doctor_id', $doctorId)->count();
        $pendingAppointments = Appointment::where('doctor_id', $doctorId)->where('status', 'pending')->count();
        $acceptedAppointments = Appointment::where('doctor_id', $doctorId)->where('status', 'accepted')->count();

        // Today's slots
        $todaysSlots = Availability::where('doctor_id', $doctorId)
            ->where('day_of_week', strtolower(now()->format('l')))
            ->get();

        // Today's appointments
        $todaysAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_date', today())
            ->get();

        // Latest 5 appointments
        $latestAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctorId)
            ->orderBy('appointment_date', 'desc')
            ->limit(5)
            ->get();

        // Past appointments
        $pastAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_date', '<', today())
            ->orderBy('appointment_date', 'desc')
            ->get();

            $appointments = Appointment::where('doctor_id', $doctorId)->get();
        return view('doctor.dashboard', compact(
            'totalAppointments',
            'pendingAppointments',
            'acceptedAppointments',
            'todaysSlots',
            'todaysAppointments',
            'latestAppointments',
            'pastAppointments',
             'appointments' 
        ));
    }

 public function patientHistory($id)
{
    $appointments = \App\Models\Appointment::with(['doctor','patient'])
        ->where('patient_id', $id)
        ->orderBy('appointment_date', 'desc')
        ->get();

    $patient = \App\Models\User::findOrFail($id); // assuming User model stores patients

    return view('doctor.patient-history', compact('appointments', 'patient'));
}



}
