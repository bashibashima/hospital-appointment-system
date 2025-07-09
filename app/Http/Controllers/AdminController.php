<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment;

class AdminController extends Controller
{
    //

    public function index()
{
$totalUsers = User::count();
    $totalDoctors = User::where('role', 'doctor')->count();
    $totalPatients = User::where('role', 'patient')->count();

   $totalAppointments = Appointment::count(); // Make sure you have this model

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalDoctors',
            'totalPatients',
            'totalAppointments'
        ));


}

}
