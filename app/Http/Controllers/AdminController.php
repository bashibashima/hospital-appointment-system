<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;

class AdminController extends Controller
{
    /**
     * Display Admin Dashboard Summary.
     */
    public function index()
    {
        // Total counts
        $totalUsers = User::count();
        $totalDoctors = User::where('role', 'doctor')->count();
        $totalPatients = User::where('role', 'patient')->count();
        $totalAppointments = Appointment::count();

        // Pending doctors (for approval)
        $pendingDoctors = User::where('role', 'doctor')
            ->where('status', 'pending')
            ->get();

        // Approved doctors for time slot management
        $doctors = Doctor::with('user')
            ->whereHas('user', function ($q) {
                $q->where('status', 'approved');
            })->get();

        // Pending appointments
        $pendingAppointments = Appointment::where('status', 'pending')
            ->with(['doctor', 'patient'])
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalDoctors',
            'totalPatients',
            'totalAppointments',
            'pendingDoctors',
            'pendingAppointments',
            'doctors'
        ));
    }

    /**
     * Show list of pending doctors (optional, if you have a separate page).
     */
    public function showPendingDoctors()
    {
        $pendingDoctors = User::where('role', 'doctor')
            ->where('status', 'pending')
            ->get();

        return view('admin.pending-doctors', compact('pendingDoctors'));
    }

    /**
     * Approve a doctor by ID.
     */
    public function approveDoctor($id)
    {
        $doctor = User::findOrFail($id);

        if ($doctor->role !== 'doctor') {
            return redirect()->back()->with('error', 'Only doctors can be approved.');
        }

        $doctor->status = 'approved';
        $doctor->save();

        return redirect()->back()->with('success', 'Doctor approved successfully!');
    }

    /**
     * Edit a doctor's permission (can_manage_slots).
     */
    public function editDoctor($id)
    {
        $doctor = Doctor::with('user')->findOrFail($id);
        return view('admin.doctors.edit', compact('doctor'));
    }

    /**
     * Update doctor permissions.
     */
    public function updateDoctor(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->can_manage_slots = $request->has('can_manage_slots');
        $doctor->save();

        return redirect()->route('admin.dashboard')->with('success', 'Doctor updated successfully.');
    }
}
