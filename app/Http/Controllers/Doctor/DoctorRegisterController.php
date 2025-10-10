<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorRegisterController extends Controller
{
    // Show the doctor registration form
    public function create()
    {
        $specializations = Specialization::all();
        return view('auth.doctor-register', compact('specializations'));
    }

    // Handle the form submission
    public function store(Request $request)
    {
        // ✅ Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => ['required', 'regex:/^(\+?\d{10,15})$/'], // Indian or international
            'password' => 'required|confirmed|min:6',
            'specialization_id' => 'required|exists:specializations,id',
            'bio' => 'nullable|string|max:1000',
        ]);

        // ✅ Format phone
        $phone = ltrim($request->phone, '0'); // Remove leading zero
        if (!str_starts_with($phone, '+')) {
            $phone = '+91' . $phone; // Assume Indian number
        }

        // ✅ Save user
        $user = User::create([
            'role' => 'doctor',
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $phone,
            'password' => Hash::make($request->password),
            'status' => 'pending', // Awaiting admin approval
        ]);

        // ✅ Save doctor details
        Doctor::create([
            'user_id' => $user->id,
            'specialization_id' => $request->specialization_id,
            'bio' => $request->bio,
        ]);

        // ✅ Redirect with success message
        return redirect('/')->withSuccess('Doctor registration successful. Please wait for admin approval.');
    }
}
