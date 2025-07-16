<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment;

class AdminController extends Controller
{
    /**
     * Display Admin Dashboard Summary.
     */
    public function index()
    {
        $users=User::all();
        $totalUsers = User::count();
        $totalDoctors = User::where('role', 'doctor')->count();
        $totalPatients = User::where('role', 'patient')->count();
        $totalAppointments = Appointment::count();

        return view('admin.dashboard', compact(
            'users',
            'totalUsers',
            'totalDoctors',
            'totalPatients',
            'totalAppointments'
        ));
    }

    /**
     * Show list of pending doctors waiting for approval.
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
}
